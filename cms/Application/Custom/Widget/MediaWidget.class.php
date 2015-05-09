<?php
namespace Custom\Widget;
use Think\Controller;
class MediaWidget extends Controller {
    public function edit($page_id){
    	$this->page_id = $page_id;
        $this->theme(mc_option('theme'))->display("Public:media_edit");
    }
    public function play($page_id){
    	$this->page_id = $page_id;
    	$this->theme(mc_option('theme'))->display("Public:media_play");
    }
}