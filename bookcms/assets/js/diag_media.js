$(function(){
  $('#jquery_jplayer_1').bind($.jPlayer.event.loadstart + '.qibao', function(event){
    alert('loadstart:' + $('#jquery_jplayer_1 audio').attr('src'));
  });
  $('#jquery_jplayer_1').bind($.jPlayer.event.error + '.qibao', function(event){
    alert('error! type:' + event.jPlayer.error.type + ', message:' + event.jPlayer.error.message + ', hint:' + event.jPlayer.error.hint + ', context:' + event.jPlayer.error.context);
  });
  $('#jquery_jplayer_1').bind($.jPlayer.event.warning + '.qibao', function(event){
    alert('warning! type:' + event.jPlayer.warning.type + ', message:' + event.jPlayer.warning.message + ', hint:' + event.jPlayer.warning.hint + ', context:' + event.jPlayer.warning.context);
  });
});