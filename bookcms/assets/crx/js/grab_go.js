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
if (typeof String.prototype.format != 'function') {
  String.prototype.format = function(args) {
    var result = this;
    if (arguments.length < 1) { return result; }

    var data = arguments;
    if (arguments.length == 1 && typeof (args) == "object") {
      data = args;
    }
    for ( var key in data) {
      var value = data[key];
      if (undefined != value) {
        result = result.replace("{" + key + "}", value);
      }
    }
    return result;
  }
}

var amazon_url = function(){
  var detail_url = function(isbn){
    var ret = null;
    $(".s-result-list .s-result-item a.s-access-detail-page").each(function(){
      var url = $(this).attr("href");
      if(url.indexOf(isbn)>0){
        var match = url.match(/\/dp\/(\d+)/);
        if(match){
          ret = "http://www.amazon.com/dp/" + match[1];
          return;
        }
      }
    });
    return ret;
  };
  
  return {"detail_url":detail_url};
}();

var goto_next = function(){
  bgp_call("grab_book.get_grabing", null, function(isbn) {
    var url_map = [{
      "url": "http://www.amazon.com/s/search-alias=stripbooks&field-keywords=",
      "mkt": "amazon",
      "isbn_arg": "field-keywords"
    }, {
      "url": "http://book.douban.com/subject_search?search_text=",
      "mkt": "douban",
      "isbn_arg": "search_text"
    }
    ];
    var get_urlarg = function(key) {
      var reg = new RegExp(key + "=([^&^#]+)");
      var ret = window.location.href.match(reg);
      if (ret != null) { return decodeURIComponent(ret[1]); }
      return null;
    };
    var this_url = window.location.href;
    var this_mkt = null;
    var this_isbn = null;
    for (var i = 0; i < url_map.length; i++) {
      var map = url_map[i];
      if (this_url.startsWith(map.url)) {
        this_isbn = get_urlarg(map.isbn_arg);
        this_mkt = map.mkt;
      }
    }
    var target = null;
    if(this_isbn && this_isbn==isbn){
      if(this_mkt=="amazon"){
        target = amazon_url.detail_url(isbn);
      }
    }
    if(target) {
      window.location.href = target;
    }
  });
}

var page_timeout = false;
var page_timer = setTimeout(function(){
  page_timeout = true;
  goto_next();
}, 5000);
$(function() {
  console.log("[Grabook]grab_go.js loaded.");
  if(!page_timeout){
    clearTimeout(page_timer);
    goto_next();
  }
});

function bgp_call(func, arg, callback) {
  if (typeof chrome.extension == "undefined") {
    console.log("[Grabook]please check environment.");
    return;
  }
  chrome.runtime.sendMessage({"call" : func, "arg" : arg}, callback);
}