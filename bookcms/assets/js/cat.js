$(document).ready(function(){
	$('#pub-imgadd .pr').hover(function(){
		$('i',this).fadeIn();
		$('span',this).fadeIn();
	},function(){
		$('i',this).fadeOut();
		$('span',this).fadeOut();
	});
	$('#searchform .input-group-addon').click(function(){
		$('#searchform').submit();
	});
	$('#home-main-2 .thumbnail').hover(function(){
		$('.caption',this).fadeIn();
	},function(){
		$('.caption',this).fadeOut();
	});
	$("input.password").focus(function(){
		$(this).attr('type','password');
	});
	$("input.password").blur(function(){
		var val = $(this).val();
		if(val=='') {
			$(this).attr('type','text');
		}
	});
});

//搜索
function search_type(type,text) {
	$('#search-type').val(type);
	$('#search-type-text').text(text);
	return false;
};

//列表图片剧中
function imgresize() {
	// IMAGE RESIZE
    $('.img-div').each(function() {
        var width = $(this).width();
        var height = $(this).height();
        var img_width = $('img',this).width();
        var img_height = $('img',this).height();
     
        if(height > img_height){
            ratio = height / img_height;
            ratio1 = width * ratio;
            $('img',this).css("height", height);
            $('img',this).css("width", ratio1);
            ratio2 = width - ratio1;
            ratio3 = ratio2 / 2;
            $('img',this).css("margin-left", ratio3);
        } else {
	        martop = (img_height - height)/2;
	        $('img',this).css("margin-top", -martop);
        }
    });
};
$(window).bind("load", function() {
    imgresize();
});

//内容页导航
$(function(){
	$.fn.scrollToTop2=function(){
		var scrollDiv2=$(this);
		var height = $(window).height()-50;
		$(window).scroll(function(){
			if($(window).scrollTop()<height){
				$(scrollDiv2).removeClass("fixed-top")
			}else{
				$(scrollDiv2).addClass("fixed-top")
			}
		});
	}
});
$(function() {
	$("#topnav").scrollToTop2();
});

//平滑滚动到锚点
$("a.goto").click(function() {
    var gotop = $($(this).attr("href")).offset().top-76;
    $("html, body").animate({
        scrollTop: gotop + "px"
    }, {
        duration: 500,
        easing: "swing"
    });
    return false;
});

var is_weixin= function(){
  if(navigator.userAgent.match(/MicroMessenger/i)) {
    return true;
  }else{
    return false;
  }
}();

var nav4 =(function(){
  bindClick = function(els, mask){
    if(!els || !els.length){return;}
    var isMobile = "ontouchstart" in window;
    for(var i=0,ci; ci = els[i]; i++){
      ci.addEventListener(isMobile?"touchstart":"click", evtFn, false);
    }
    mask.addEventListener(isMobile?"touchstart":"click", evtFn, false);
    function evtFn(evt, ci){
      ci =this;
      for(var j=0,cj; cj = els[j]; j++){
        if(cj != ci){
          cj.classList.remove("on");
        }
      }
      if(ci == mask){mask.classList.remove("on");return;}
      var on = ci.classList.toggle("on");
      mask.classList[on?"add":"remove"]("on");
    }
  }
  return {"bindClick":bindClick};
})();