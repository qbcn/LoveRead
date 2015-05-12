<?php mc_template_part('header_admin'); ?>

<div class="row">
	<p><?php echo $msg;?></p>
	<p>URL_PATHINFO_DEPR:<?php echo C('URL_PATHINFO_DEPR'); ?></p>
	<p><?php echo U('pro/index/index'); ?></p>
</div>

<?php mc_template_part('footer_admin'); ?>