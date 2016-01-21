if (typeof String.prototype.startsWith != 'function') {
  String.prototype.startsWith = function(str) {
    return this.substr(0, str.length) == str;
  };
}
if (typeof String.prototype.endsWith != 'function') {
  String.prototype.endsWith = function(str) {
    return this.substr(-str.length) == str;
  };
}

var app_config = function() {
  var _config_url = "http://www.qibaowu.cn/assets/crx/appconfig.json";
  var _config = null;

  var load_config = function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", _config_url, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        _config = JSON.parse(xhr.responseText);
        console.log('[booktool]get config ok.');
      }
    }
    xhr.send();
  }
  var debug_config = function() {
    console.log('[booktool]app config:' + _config);
  }
  var version_compare = function(stra, strb) {
    var straArr = stra.split('.');
    var strbArr = strb.split('.');
    var maxLen = Math.max(straArr.length, strbArr.length);
    var result, sa, sb;
    for (var i = 0; i < maxLen; i++) {
      sa = ~~straArr[i];
      sb = ~~strbArr[i];
      if (sa > sb) {
        result = 1;
      } else if (sa < sb) {
        result = -1;
      } else {
        result = 0;
      }
      if (result !== 0) { return result; }
    }
    return result;
  }
  var check_update = function(this_version) {
    if (_config == null || typeof this_version != "string") { return false; }
    var result = version_compare(_config.update_version, this_version);
    if (result > 0) {
      return true;
    } else {
      return false;
    }
  }
  var get_menuconfig = function() {
    return _config.menu_config;
  }
  var get_pagescripts = function(page_url) {
    if (_config == null) { return null; }
    var items = _config.page_scripts;
    for ( var i in items) {
      var matches = items[i].matches;
      for ( var j in matches) {
        if (page_url.startsWith(matches[j])) { return items[i].scripts; }
      }
    }
    return null;
  }
  var get_searchurl = function(mkt){
    return _config.search_urls[mkt];
  }
  var get_simple_config = function(name){
    return _config[name].
  }

  load_config();
  return {
    "check_update": check_update,
    "get_menuconfig": get_menuconfig,
    "get_pagescripts": get_pagescripts,
    "get_searchurl" : get_searchurl,
    "get_simple_config" : get_simple_config,
    "debug_config": debug_config
  };
}();

var base_api = function() {
  var load_url = function(url, response, tabid) {
    if (isNaN(tabid) || tabid<1) {
      chrome.tabs.create({"url":url}, function(tab){
        if(typeof response == "function"){
          response(tab);
        }
      });
    } else {
      chrome.tabs.update(tabid, {"url":url}, function(tab){
        if(typeof response == "function"){
          response(tab);
        }
      });
    }
    return true;
  }

  var get_json = function(url, response) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        response(xhr.responseText);
        console.log('[booktool]get json ok.');
      }
    }
    xhr.send();
  }

  var grab_this = function() {
    chrome.tabs.getSelected(function(tab) {
      tab_call(tab.id, "grab_book.grab_this", false, null);
    });
    return true;
  }

  return {
    "load_url": load_url,
    "get_json": get_json,
    "grab_this": grab_this
  }
}();

var grab_book = function() {
  var _grab_book_tab = -1;
  var _grab_bind_tab = -1;
  var _grab_bind_evt = null;
  var _isbn_grabing;

  var get_grabing = function(){
    return _isbn_grabing;
  }

  var bind_grab_event = function(bind_evt){
    _grab_bind_evt = bind_evt;
    _grab_bind_tab = arguments[2];
    return true;
  }

  var grab_by_isbn = function(isbn) {
    _isbn_grabing = isbn;
    var search_url = app_config.get_searchurl("amazon");
    if(search_url){
      base_api.load_url(search_url+isbn, function(tab){
        _grab_book_tab = tab.id;
      }, _grab_book_tab);
      return true;
    }else{
      return {"ret":"FAIL", "msg":"no search."};
    }
  }

  var on_grab_event = function(evt){
    if(_grab_bind_tab>0){
      tab_call(_grab_bind_tab, _grab_bind_evt, evt, null);
    }
    return true;
  }

  var submit_book = function(book){
    if(_grab_bind_tab>0){
      tab_call(_grab_bind_tab, "grab_book.submit_book", book, null);
    }
    return true;
  }

  return {
    "get_grabing": get_grabing,
    "bind_grab_event": bind_grab_event,
    "grab_by_isbn": grab_by_isbn,
    "on_grab_event": on_grab_event,
    "submit_book": submit_book
  }
}();

var price_diff = function(){
  var _price_fg_tab = -1;
  var _price_fg_evt = null;
  var _price_urls = null;

  var report_url = function(){
    return app_config.get_simple_config('price_report');
  }

  var bind_price_event = function(bind_evt){
    _price_fg_evt = bind_evt;
    _price_fg_tab = arguments[2];
    return true;
  }

  var on_price_event = function(evt){
    var tabid = arguments[2];
    if(_price_fg_tab>0){
      tab_call(_price_fg_tab, _price_fg_evt, evt, null);
    }
    tab_mgr.sched_job(tabid);
    return true;
  }

  var start_diff = function(urls){
    if($.isArray(urls)){
      _price_urls = urls;
      tab_mgr.start({'get_next_url':get_next_url, 'url_timeout':null}, 3000);
      return {'ret':true, 'msg':'开始比价...'};
    }else{
      return {'ret':true, 'msg':'参数非法'};
    }
  }

  var get_next_url = function(){
    return _price_urls.pop();
  }

  return {
    'report_url':report_url
  }
}();

var TAB_MAX_NUM = 3;
var tab_mgr = function(){
  var _tab_list = new Array();
  var _timeout;
  var _job_cb;

  /* job_cb: {'get_next_url':xxx, 'url_timeout':xxx} */
  var start = function(job_cb, timeout){
    console.log('[booktool] tab_job.start_job');

    if(typeof job_cb.get_next_url != 'function'){
      console.log('[booktool] tab_job.start_job fail: invalid job_cb');
      return false;
    }

    stop_job(0);
    for(var i=0; i<TAB_MAX_NUM, i++){
      _tab_list[i] = {'tabid':0, 'timer':0, 'url':null};
    }
    if(timeout){
      _timeout = timeout;
    }else{
      _timeout = 3000;
    }
    _job_cb = job_cb;

    sched_job(0);
    return true;
  }

  //tabid=0 to schedule all
  var sched_job = function(tabid){
    console.log('[booktool] tab_job.stop_job', tabid);

    var _tab_timeout = function(i){
      _tab_list[i].timer = 0;
      var tabid = _tab_list[i].tabid;
      var url = _tab_list[i].url;
      if(typeof _job_cb.url_timeout == 'function'){
        _job_cb.url_timeout(url);
      }
      _sched_job(i);
    }

    var _sched_job = function(i){
      if(_tab_list[i].timer > 0){
        clearTimeout(_tab_list[i].timer);
        _tab_list[i].timer = 0;
      }

      var tabid = _tab_list[i].tabid;
      var url = _job_cb.get_next_url();
      if(!url || !url.startsWith('http://')){
        return ;
      }
      _tab_list[i].url = url;
      if (tabid<1) {
        chrome.tabs.create({"url":url}, function(tab){
          _tab_list[i].tabid = tab.id;
          _tab_list[i].timer = setTimeout(function(){
            _tab_timeout(i);
          }, _timeout);
        });
      } else {
        chrome.tabs.update(tabid, {"url":url}, function(tab){
          _tab_list[i].timer = setTimeout(function(){
            _tab_timeout(i);
          }, _timeout);
        });
      }
    }

    if(tabid){
      //schedule single
      for(var i=0; i<_tab_list.length, i++){
        if(_tab_list[i].tabid == tabid){
          _sched_job(i);
        }
      }
    }else{
      for(var i=0; i<_tab_list.length, i++){
        tabid = _tab_list[i].tabid;
        if(_tab_list[i].tabid<1 || !_tab_list[i].url==null){
          _sched_job(i);
        }
      }
    }
  }

  //tabid=0 to stop all
  var stop_job = function(tabid){
    console.log('[booktool] tab_job.stop_job', tabid);

    var _stop_job = function(i){
      if(_tab_list[i].tabid > 0){
        chrome.tab.remove(_tab_list[i].tabid);
      }
      if(_tab_list[i].timer > 0){
        clearTimeout(_tab_list[i].timer);
      }
      _tab_list[i] = {'tabid':0, 'timer':0, 'url':null};
    }

    if(tabid){
      //stop single
      for(var i=0; i<_tab_list.length, i++){
        if(_tab_list[i].tabid == tabid){
          _stop_job(i);
        }
      }
    }else{
      //stop all
      for(var i=0; i<_tab_list.length, i++){
        _stop_job(i);
      }
    }
  }

  return {
    'start':start,
    'sched_job':sched_job,
    'stop_job':stop_job
  }
}

var tab_events = function() {
  var insert_script = function(tabid, scripts, index) {
    if (scripts != null && index < scripts.length) {
      var script = scripts[index];
      if (script.startsWith("http://")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", script, true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4) {
            console.log('[booktool]excute script:', tabid, script);
            chrome.tabs.executeScript(tabid, {code: xhr.responseText}, function(){
              console.log('[booktool]excute finish:', tabid, script);
              insert_script(tabid, scripts, index + 1);
            });
          }
        }
        xhr.send();
        console.log('[booktool]load script:', tabid, script);
      } else {
        console.log('[booktool]excute script:', tabid, script);
        chrome.tabs.executeScript(tabid, {file: script}, function(){
          console.log('[booktool]excute finish:', tabid, script);
          insert_script(tabid, scripts, index + 1);
        });
      }
    }
  }
  var insert_scripts = function(tab) {
    var scripts = app_config.get_pagescripts(tab.url);
    insert_script(tab.id, scripts, 0);
  }

  var on_tabcreated = function(tab) {
    console.log('[booktool]tab created:', tab.id, tab.url);
  }
  var on_tabupdated = function(tabId, changeInfo, tab) {
    if (changeInfo.status == "loading") {
      console.log('[booktool]tab loading:', tab.id, tab.url);
      insert_scripts(tab);
    }
  }

  return {
    "on_tabcreated": on_tabcreated,
    "on_tabupdated": on_tabupdated
  }
}();
chrome.tabs.onUpdated.addListener(tab_events.on_tabupdated);

function tab_call(tabid, func, arg, callback) {
  chrome.tabs.sendMessage(tabid, {"call":func,"arg":arg}, callback);
}
//api参数顺序: arg_data, callback, tabid
var bgp_api = {
  "base_api":base_api,
  "grab_book":grab_book,
  "price_diff":price_diff
}
chrome.runtime.onMessage.addListener(function(request, sender, response) {
  var src = (sender.tab ? sender.tab.url : "extension");
  var call = request.call.split(".");
  if (typeof bgp_api[call[0]][call[1]] == "function") {
    ret = bgp_api[call[0]][call[1]](request.arg, response, sender.tab.id);
    if(typeof ret != "undefined" && typeof response == "function"){
      response(ret);
    }
    console.log("[booktool]bgp_api",call[0],call[1],"called from",src);
  } else {
    console.log("[booktool]unknown msg:",request,"from",src);
  }
});