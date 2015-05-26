<?php
	$medias = array();
	if (is_array($page_id)) {
		foreach($page_id as $id) {
			//$vals = mc_get_meta($id,'media',false,'media');
			$vals = M('meta')->where(array('page_id'=>$id, 'meta_key'=>'media', 'type'=>'media'))->order('id')->getField('meta_value',true);
			foreach($vals as $val) {
				$medias[] = $val;
			}
		}
	} else {
		//$medias = mc_get_meta($page_id,'media', false,'media');
		$medias = M('meta')->where(array('page_id'=>$page_id, 'meta_key'=>'media', 'type'=>'media'))->order('id')->getField('meta_value',true);
	}
	if($medias): 
?>
<link rel="stylesheet" href="<?php echo C('APP_ASSETS_URL'); ?>/css/jplayer.blue.monday.min.css">
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/jquery.jplayer.min.js"></script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/jplayer.playlist.min.js"></script>
<style>
@media (max-width: 420px) {
	.jp-audio {width:auto;}
	.jp-audio .jp-controls {width:auto;}
}
.jp-audio .jp-type-playlist .jp-progress {left:128px;width:168px;}
.jp-audio .jp-type-playlist .jp-time-holder {left:128px;width:168px;}
.jp-audio .jp-type-playlist .jp-toggles {width:25px;margin: 0 auto;position:relative;left:auto;top:auto;}
.jp-next, .jp-previous, .jp-stop {padding:0};
</style>
<div class="home-main mb-10">
	<h4 class="title mb-10">
		<i class="glyphicon glyphicon-play-circle"></i> 音频播放
	</h4>
	<div class="row">
		<?php $medias_num=sizeof($medias); if($medias_num==1): $media = json_decode($medias[0], true); ?>
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<div id="jp_container_1" class="jp-audio center-block" role="application" aria-label="media player">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<div class="jp-controls">
						<button class="jp-play" role="button" tabindex="0">play</button>
						<!-- button class="jp-stop" role="button" tabindex="0">stop</button -->
					</div>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<!-- div class="jp-volume-controls">
						<button class="jp-mute" role="button" tabindex="0">mute</button>
						<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div -->
					<div class="jp-time-holder">
						<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
						<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
						<div class="jp-toggles">
							<button class="jp-repeat" role="button" tabindex="0">repeat</button>
						</div>
					</div>
				</div>
				<div class="jp-details">
					<div class="jp-title" aria-label="title">&nbsp;</div>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>
		<script>
		$(function(){
			var android = navigator.userAgent.match(/Android/i);
			var media = {<?php
				echo 'title:"'.$media['title'].'",';
				echo $media['type'].':"'.$media['url'].'"';
				if($media['type']=='m3u8a'){
					$mp3_url = str_replace('.m3u8','.MP3',$media['url']);
					echo ',mp3:"'.$mp3_url.'"';
				}
			?>};
			var supply = "mp3";
			if(!android && media.m3u8a){
				supply = "m3u8a,mp3";
			}
			$("#jquery_jplayer_1").jPlayer({
				ready: function (event) {
					$(this).jPlayer("setMedia", media);
				},
				swfPath: "<?php echo C('APP_ASSETS_URL'); ?>/js",
				supplied: supply,
				volume: "1",
				wmode: "window",
				useStateClassSkin: true,
				autoBlur: false,
				smoothPlayBar: true,
				keyEnabled: false
			});
			$("#shoucang-playlist").show();
		});
		</script>
		<?php elseif ($medias_num>1): ?>
		<div>
			<div id="jquery_jplayer_1" class="jp-jplayer"></div>
			<div id="jp_container_1" class="jp-audio center-block" role="application" aria-label="media player">
				<div class="jp-type-playlist">
					<div class="jp-gui jp-interface">
						<div class="jp-controls">
							<button class="jp-previous" role="button" tabindex="0">previous</button>
							<button class="jp-play" role="button" tabindex="0">play</button>
							<button class="jp-next" role="button" tabindex="0">next</button>
							<!-- button class="jp-stop" role="button" tabindex="0">stop</button -->
						</div>
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
						<!-- div class="jp-volume-controls">
							<button class="jp-mute" role="button" tabindex="0">mute</button>
							<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
						</div -->
						<div class="jp-time-holder">
							<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
							<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
							<div class="jp-toggles">
								<button class="jp-repeat" role="button" tabindex="0">repeat</button>
								<!-- button class="jp-shuffle" role="button" tabindex="0">shuffle</button -->
							</div>
						</div>
					</div>
					<div class="jp-playlist">
						<ul>
							<li>&nbsp;</li>
						</ul>
					</div>
					<div class="jp-no-solution">
						<span>Update Required</span>
						To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
					</div>
				</div>
			</div>
		</div>
		<script>
		$(function(){
			var android = navigator.userAgent.match(/Android/i);
			var medias = [
				<?php for($i=0;$i<$medias_num;$i++): $media=json_decode($medias[$i], true); ?>{<?php
					echo 'title:"'.$media['title'].'",';
					echo $media['type'].':"'.$media['url'].'"';
					if($media['type']=='m3u8a'){
						$mp3_url = str_replace('.m3u8','.MP3',$media['url']);
						echo ',mp3:"'.$mp3_url.'"';
					}
				?>},
				<?php endfor; ?>];
			var supply = "mp3";
			if(!android){
			  for(media in medias){
				if(media.m3u8a){
				  supply = "m3u8a,mp3";
				}
			  }
			}
		new jPlayerPlaylist({
				jPlayer: "#jquery_jplayer_1",
				cssSelectorAncestor: "#jp_container_1"
			},medias,
			{
				swfPath: "<?php echo C('APP_ASSETS_URL'); ?>/js",
				supplied: supply,
				volume: "1",
				wmode: "window",
				useStateClassSkin: true,
				autoBlur: false,
				smoothPlayBar: true,
				keyEnabled: false
			});
			$("#shoucang-playlist").show();
		});
		</script>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
