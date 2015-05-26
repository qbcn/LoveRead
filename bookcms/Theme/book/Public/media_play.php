<?php
	$medias = array();
	if (is_array($page_id)) {
		foreach($page_id as $id) {
			$vals = mc_get_meta($id,'media',false,'media');
			foreach($vals as $val) {
				$medias[] = $val;
			}
		}
	} else {
		$medias = mc_get_meta($page_id,'media', false,'media');
	}
	if($medias): 
?>
<link rel="stylesheet" href="<?php echo C('APP_ASSETS_URL'); ?>/css/jplayer.blue.monday.min.css">
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/jquery.jplayer.min.js"></script>
<script src="<?php echo C('APP_ASSETS_URL'); ?>/js/jplayer.playlist.min.js"></script>
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
						<button class="jp-stop" role="button" tabindex="0">stop</button>
					</div>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-controls">
						<button class="jp-mute" role="button" tabindex="0">mute</button>
						<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
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
			$("#jquery_jplayer_1").jPlayer({
				ready: function (event) {
					$(this).jPlayer("setMedia", {
						title:"<?php echo $media['title']; ?>",
						mp3:"<?php echo $media['url']; ?>"
					});
				},
				swfPath: "<?php echo C('APP_ASSETS_URL'); ?>/js",
				supplied: "mp3",
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
							<button class="jp-stop" role="button" tabindex="0">stop</button>
						</div>
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
						<div class="jp-volume-controls">
							<button class="jp-mute" role="button" tabindex="0">mute</button>
							<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
						</div>
						<div class="jp-time-holder">
							<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
							<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
						</div>
						<div class="jp-toggles">
							<button class="jp-repeat" role="button" tabindex="0">repeat</button>
							<button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
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
			new jPlayerPlaylist({
				jPlayer: "#jquery_jplayer_1",
				cssSelectorAncestor: "#jp_container_1"
			}, 
			[<?php $medias = array_reverse($medias);for($i=0;$i<$medias_num;$i++): $media=json_decode($medias[$i], true); ?>
				{title:"<?php echo $media['title']; ?>", mp3:"<?php echo $media['url']; ?>"},
			<?php endfor; ?>
			], 
			{
				swfPath: "<?php echo $site_url; ?>/Theme/default/js",
				supplied: "mp3",
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
