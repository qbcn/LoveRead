<?php
namespace Custom\Widget;
use Think\Controller;
class BuyurlWidget extends Controller {
    public function edit($page_id){
    	$this->page_id = $page_id;
        $this->theme(mc_option('theme'))->display("Public:buyurl_edit");
    }
    public function gotobuy($page_id){
    	$this->page_id = $page_id;
    	$this->theme(mc_option('theme'))->display("Public:buyurl_go");
    }
}