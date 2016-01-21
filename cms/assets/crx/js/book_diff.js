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

var price_diff = function(r){
  var row_diff = function(row){
    var item_l = $('td:eq(3)', row);
    var item_r = $('td:eq(5)', row);
    var price_l = $('[name=itemPrice]', item_l).text();
    var price_r = $('[name=providerItemPrice]', item_r).text();
    var diff = price_l - price_r;
    if (diff < -3 || diff > 3){
      $('td:eq(2) img[name=providerItemPriceChangedImg]', row).show();
    }
  }

  if (undefined != r){
    row_diff(r);
    return;
  }
  var rows = $("#relatedItemDt tbody tr:visible");
  for (var i=1; i<rows.length; i++){
    row_diff(jQuery(rows[i]));
  }
}

$(function(){
  price_diff();
  $("#relatedItemDt tbody").bind('DOMNodeInserted', function(){
    price_diff($('tr:last', $(this)));
  });
});

function bgp_call(func, arg, callback) {
  if (typeof chrome.extension == "undefined") {
    console.log("[booktool]please check environment.");
    return;
  }
  chrome.runtime.sendMessage({"call" : func, "arg" : arg}, callback);
}
var tab_api = {
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