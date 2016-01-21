if (typeof String.prototype.startsWith != 'function') {
  String.prototype.startsWith = function (str){
    return this.substr(0, str.length) == str;
  };
}
if (typeof String.prototype.endsWith != 'function') {
  String.prototype.endsWith = function (str){
    return this.substr(-str.length) == str;
  };
}
if (typeof String.prototype.format != 'function') {
  String.prototype.format = function(args) {
    var result = this;
    if (arguments.length < 1) {
      return result;
    }

    var data = arguments;
    if (arguments.length == 1 && typeof (args) == "object") {
      data = args;
    }
    for (var key in data) {
      var value = data[key];
      if (undefined != value) {
        result = result.replace("{" + key + "}", value);
      }
    }
    return result;
  }
}

var PRICE_DIFF_WARN = 3;

var price_diff = function(){
  var batch_diff = function(){
    if(typeof page_api.get_price_urls == 'function'){
      var urls = page_api.get_price_urls();
    }else{
      var urls = null;
      return {'ret':false, 'msg':'暂不支持.'}
    }
    if(urls){
      setTimeout(function(){
        start_diff(urls);
      }, 100);
    }
  }
  
  var on_price_evt = function(evt){
    var url = evt.url;
    var price = evt.price;
    if(url && price && typeof page_api.update_price == 'function'){
      page_api.update_price(url, price);
      return true;
    }else{
      return false;
    }
  }

  var start_diff = function(urls){
    bgp_call('price_diff.bind_price_event', on_price_evt, function(){
      bgp_call('price_diff.start_diff', urls, null);
    });
  }

  return {
    'start_diff':start_diff
  }
}();

var qibao_diff = function(){
  $('a.diff-this-item').click(function(){
    var parent = $(this).parents('div.price-diff-item');
    var src_url = $('a.src-url', parent).attr('href');
    var dst_url = $('a.dst-url', parent).attr('href');
    var urls = new Array();
    urls = urls.concat(src_url, dst_url);
    price_diff.start_diff(urls);
  });

  var get_price_urls = function(){
    var src_urls = $('a.src-url').attr('href');
    var dst_urls = $('a.dst-url').attr('href');
    var ret = new Array();
    return ret.concat(src_urls, dst_urls);
  }
  
  var update_price = function(url, price){
    var id = 'price-' + url.substr(-8);
    $('span#'+id).text(price);
    var parent = $('span#'+id).parents('div.price-diff-item');
    var prices = $('span.price', parent).text();
    if(!$.isArray(prices)){
      return;
    }
    var min = 9999, max = 0, updated = 0;
    for(var i in prices){
      var val = parseFloat(prices[i]);
      if (val > 0){
        updated++;
        if(val < min){
          min = val;
        }
        if(val > max){
          max = val
        }
      }
    }
    var diff = max - min;
    if(diff > PRICE_DIFF_WARN){
      $('i.diff-status', parent).show();
    }else{
      if(updated == prices.length){
        $('i.diff-status', parent).hide();
        diff = 0;
      }else{
        diff = -1;
      }
    }
    if(diff >= 0){
      bgp_call('price_diff.report_url', null, function(url){
        $.post(url, {'url':url, 'diff':diff}, function(data){
          if(data && data.ret){
          }else{
            alert('比价汇报出错' + (data ? data.msg : ''));
          }
        })
      })
    }
  }

  return {
    'get_price_urls':get_price_urls,
    'update_price':update_price
  }
}

var taobao_diff = function(){
  var get_price_urls = function(){
    return;
  }

  return {
    'get_price_urls':get_price_urls
  }
}

var youzan_diff = function(){
  var get_price_urls = function(){
    return;
  }

  return {
    'get_price_urls':get_price_urls
  }
}

var page_api;
$(function(){
  console.log("[booktool]price_diff.js loaded.");
  var url_map = [
    {'url':'booktool/index.php/home-price-index.html', 'api':qibao_diff},
    {'url':'http://sell.taobao.com/auction/merchandise/auction_list.htm', 'api':taobao_diff},
    {'url':'http://koudaitong.com/v2/showcase/goods', 'api':youzan_diff}
  ];
  var this_url = window.location.href;
  var this_api;
  for(var i=0; i<url_map.length; i++){
    var map = url_map[i];
    if(this_url.indexOf(map.url) >= 0){
      this_api = map.api;
      break;
    }
  }
  if(typeof this_api == 'function'){
    page_api = this_api();
  }
});

function bgp_call(func, arg, callback) {
  if (typeof chrome.extension == "undefined") {
    console.log("[booktool]please check environment.");
    return;
  }
  chrome.runtime.sendMessage({"call" : func, "arg" : arg}, callback);
}
var tab_api = {
  "price_diff":price_diff
}
chrome.runtime.onMessage.addListener(function(request, sender, response){
  var src = (sender.tab ? sender.tab.url : "extension");
  var call = request.call.split(".");
  if (typeof tab_api[call[0]][call[1]] == "function") {
    ret = tab_api[call[0]][call[1]](request.arg, response);
    if(typeof ret != "undefined" && typeof response == "function"){
      response(ret);
    }
    console.log("[booktool]tab_api",call[0],call[1],"called from",src);
  } else {
    console.log("[booktool]unknown msg:",request,"from",src);
  }
});