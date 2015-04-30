<?php
namespace Custom\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function add_pro(){
        if(mc_is_admin() || mc_is_bianji()) {
	        $this->theme(mc_option('theme'))->display('Publish/add_pro');
	    } else {
	        $this->success('请先登陆',U('User/login/index'));
	    };
    }
    public function add_article(){
        if(mc_is_admin() || mc_is_bianji()) {
	        $this->theme(mc_option('theme'))->display('Publish/add_article');
	    } else {
		    $this->success('请先登陆',U('User/login/index'));
	    };
    }
    public function edit($id){
        if(is_numeric($id)) {
        	if(mc_is_admin() || mc_is_bianji() || mc_author_id($id)==mc_user_id()) {
	        	$this->page = M('page')->where("id='$id'")->order('id desc')->select();
	        	if(mc_get_page_field($id,'type')=='pro') {
		        	$this->theme(mc_option('theme'))->display('Publish/edit_pro');
	        	} elseif(mc_get_page_field($id,'type')=='article') {
		        	$this->theme(mc_option('theme'))->display('Publish/edit_article');
	        	} else {
		        	$this->error('哥们，你放弃治疗了吗?',U('home/index/index'));
	        	}
		    } else {
			    $this->error('哥们，你放弃治疗了吗?',U('home/index/index'));
		    };
        } else {
	        $this->error('哥们，你放弃治疗了吗?',U('home/index/index'));
        }
    }
}