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

var grab_book = function(){
  var _isbn_list = null;
  var _isbn_grabing = null;
  var _timer = null;
  var _stat = {"all":0, "done":0, "fail":0};

  var _set_progress = function(isbn, st, msg){
    var this_isbn = $("#isbn-"+isbn);
    if(!this_isbn || this_isbn.length<1){
      var this_isbn = $("#task-progress li:first-child").clone().attr({id:"isbn-"+isbn}).appendTo("#task-progress").show();
      $(".isbn-span", this_isbn).text(isbn);
    }
    $(".grab-st", this_isbn).hide();
    $(".grab-st-"+st, this_isbn).show();
    $(".msg-span", this_isbn).text(msg);
    if(st=="doing"){
      _timer = setTimeout(_grab_timeout, 5000);
      _isbn_grabing = isbn;
    }else if(st=="done" || st=="fail"){
      if(_timer){
        clearTimeout(_timer);
        _timer = null;
      }
      if(st=="done"){
        _stat.done++;
      }else if(st=="fail"){
        _stat.fail++;
      }
    }
  }

  var _grab_timeout = function(){
    on_grab_event({"isbn":_isbn_grabing, "st":"fail", "msg":"抓取超时"});
  }

  var start_grab = function(isbn_list){
	  $("#global-status").text("开始抓取...");
	  if(!$.isArray(isbn_list)){
	    $("#global-status").text("请填入有效ISBN列表");
	    return;
	  }
		bgp_call("grab_book.bind_grab_event", "on_grab_event", function(ret){
		  if(ret){
		    _stat = {"all":isbn_list.length, "done":0, "fail":0};
	      _isbn_list = isbn_list;
	      grab_next();
		  }else{
		    $("#global-status").text("启动失败");
		  }
		});
	};

	var grab_next = function(){
	  $("#global-status").text("正在抓取...");
	  if(_isbn_list.length<1){
	    $("#global-status").text("抓取结束, 共:" + _stat.all + ", 成功:" + _stat.done + ", 失败:" + _stat.fail);
	    return;
	  }
	  var isbn = _isbn_list.pop();
	  if ((isbn.length!=10 && isbn.length!=13) || !$.isNumeric(isbn)){
	    _set_progress(isbn, "fail", "不是有效的ISBN");
	    grab_next();
	    return;
	  }
	  bgp_call("grab_book.grab_by_isbn", isbn, function(ret){
	    if(ret){
        _set_progress(isbn, "doing", "抓取中...");
	    }else{
        _set_progress(isbn, "fail", ret.msg);
        grab_next();
	    }
	  });
	};

	var on_grab_event = function(evt){
	  if(evt.isbn){
	    _set_progress(evt.isbn, evt.st, evt.msg);
	  }
	  if(evt.st=="done" || evt.st=="fail"){
	    grab_next();
	  }
	}

	var submit_book = function(book){
	  if(book){
	    $("#add-pro-form input[name='fmimg[]']").val(book["fmimg"]);
	    $("#add-pro-form input[name='title']").val(book["title"]);
	    $("#add-pro-form input[name='isbn']").val(book["isbn"]);
      $("#add-pro-form input[name='content']").val(book["content"]);
      $("#add-pro-form input[name='keywords']").val(book["title"]+","+book["isbn"]+",Picture Book,原版绘本,分级读物,英语启蒙,英文耳朵,听出英语力,纸板书,手掌书");
      $("#add-pro-form input[name='description']").val(book["title"]+",作者 "+book["作者"]+"。奇宝书屋，发现和分享最好的儿童读物，专注于英语原版绘本的进口、零售和社区，为0-12岁儿童英语启蒙分享优质绘本资源，培养孩子的英文耳朵，轻松听出英语力。");
      $("#add-pro-form input.input-para").each(function(){
        var para_name = $(this).attr("data-para");
        var para_val = book[para_name];
        $(this).val(para_val);
      });
      var url = $("#add-pro-form").attr("action");
      $.post(url, $("#add-pro-form").serialize(), function(data){
        if(data && data.ret){
          on_grab_event({"isbn":book["isbn"], "st":"done", "msg":"抓取成功"});
        }else{
          on_grab_event({"isbn":book["isbn"], "st":"fail", "msg":data.msg});
        }
      });
	  }
	}

	return {
	  "start_grab":start_grab,
	  "grab_next":grab_next,
	  "on_grab_event":on_grab_event,
	  "submit_book":submit_book
	}
}();

$(function(){
  console.log("[Grabook]grab_start.js loaded.");
  $("#if-no-plugin").hide();
  $("#start-grab").click(function(){
    var isbns = $("#isbn-batch").val();
    if(isbns){
      grab_book.start_grab(isbns.split("."));
    }
  });
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