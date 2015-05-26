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

var amazon_book = function(){
  var book_meta_map = {
    "Age Range":"适读",
    "Hardcover":"页数",
    "Publisher":"出版社",
    "Language":"语种",
    "ISBN-13":"isbn"
  };

  var book_meta = function(){
    var title = $("#booksTitle #title #productTitle").text();
    var author = $("#byline .author .contributorNameID").text();
    var image = $("#main-image-container #img-canvas img").attr("src").trim();
    var content = $("#bookDescription_feature_div noscript").text().trim();
    var book = {"title":title, "fmimg":image, "作者":author, "content":content};
    var detail = $("#detail-bullets #productDetailsTable .content li").each(function(){
      var texts = $(this).text().split(":");
      if($.isArray(texts)){
        var meta_name = book_meta_map[texts[0].trim()];
        if(meta_name){
          book[meta_name] = texts[1].trim();
        }
      }
    });
    if(book["isbn"]){
      book["isbn"] = book["isbn"].replace("-","");
    }
    if(book["适读"]){
      book["适读"] = book["适读"].replace("years","岁");
    }
    return book;    
  }

  return {"book_meta":book_meta};
}();

var grab_book = function(){
  var submit_book = function(book){
    setTimeout(function(){
      bgp_call("grab_book.submit_book", book, null);
    }, 500);
  }

  var grab_this = function(check){
    var url_map = [{
      "url": "http://www.amazon.com/dp/",
      "mkt": "amazon"
    }, {
      "url": "http://book.douban.com/subject/",
      "mkt": "douban"
    }
    ];
    var this_url = window.location.href;
    var this_mkt = null;
    for (var i = 0; i < url_map.length; i++) {
      var map = url_map[i];
      if (this_url.startsWith(map.url)) {
        this_mkt = map.mkt;
      }
    }
    var book = null;
    if(this_mkt=="amazon"){
      console.log("[Grabook]grab from amazon.");
      book = amazon_book.book_meta();
      console.log("[Grabook]book meta:",book);
    }
    if(!book){
      return;
    }

    if(check){
      bgp_call("grab_book.get_grabing", null, function(isbn) {
        if(book["isbn"]==isbn) {
          submit_book(book);
        }
      });
    }else{
      submit_book(book);
    }
  }

  return {"grab_this":grab_this};
}();

var page_timeout = false;
var page_timer = setTimeout(function(){
  page_timeout = true;
  grab_book.grab_this(true);
}, 5000);
$(function(){
  console.log("[Grabook]grab_book.js loaded.");
  if(!page_timeout){
    clearTimeout(page_timer);
    grab_book.grab_this(true);
  }
});

function bgp_call(func, arg, callback) {
  if (typeof chrome.extension == "undefined") {
    console.log("[Grabook]please check environment.");
    return;
  }
  chrome.runtime.sendMessage({"call" : func, "arg" : arg}, callback);
}
var tab_api = {
  "grab_book":grab_book
}
chrome.runtime.onMessage.addListener(function(request, sender, response){
  var src = (sender.tab ? sender.tab.url : "extension");
  var call = request.call.split(".");
  if (typeof tab_api[call[0]][call[1]] == "function") {
    ret = tab_api[call[0]][call[1]](request.arg, response);
    if(typeof ret != "undefined" && typeof response == "function"){
      response(ret);
    }
    console.log("[Grabook]tab_api",call[0],call[1],"called from",src);
  } else {
    console.log("[Grabook]unknown msg:",request,"from",src);
  }
});