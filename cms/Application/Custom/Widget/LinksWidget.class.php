<?php
namespace Custom\Widget;
use Think\Controller;
class LinksWidget extends Controller {
    public function add(){
        $this->theme(mc_option('theme'))->display("Public:links_add");
    }
    public function edit($page_id){
    	$this->page_id = $page_id;
        $this->theme(mc_option('theme'))->display("Public:links_edit");
    }
    public function showlist($page_id){
    	$this->page_id = $page_id;
    	$this->theme(mc_option('theme'))->display("Public:links_list");
    }
}