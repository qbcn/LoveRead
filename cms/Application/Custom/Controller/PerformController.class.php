<?php
namespace Custom\Controller;
use Think\Controller;
class PerformController extends Controller {
	private function add_meta_in($page_id, $meta_key, $in_key){
		$val = I($in_key);
		if ($val) {
			mc_add_meta($page_id, $meta_key, $val);
		}
	}
	private function update_meta_in($page_id, $meta_key, $in_key){
		$val = I($in_key);
		if ($val) {
			mc_update_meta($page_id, $meta_key, $val);
		}
	}
	private function save_media($page_id, $update=false){
		if ($update) {
			M('meta')->where("page_id='".$page_id."' AND meta_key='media'")->delete();
		}
		if($_POST['media-list']) {
			$medias = I('post.media-list');
			$num = 0;
			foreach($medias as $media){
				if(strpos($media['url'], 'http://')===0 && $media['title'] != ''){
					$val = array('url'=>$media['url'], 'title'=>$media['title'], 'type'=>'mp3');
					$json = json_encode($val);
					mc_add_meta($page_id, 'media', $json);
					$num++;
				}
				if (num > 20){
					break;
				}
			}
		}
	}
	private function save_links($page_id, $update=false){
		if ($update) {
			M('meta')->where("page_id='".$page_id."' AND meta_key='link'")->delete();
		}
		if($_POST['pro-links']) {
			$links = I('post.pro-links');
			$num = 0;
			foreach($links as $link){
				if(strpos($link['url'], 'http://')===0 && $link['title'] != ''){
					$type = $link['type'];
					if($type != 'play' && $type != 'buy'){
						$type = 'article';
					}
					$val = array('url'=>$link['url'], 'title'=>$link['title'], 'type'=>$type);
					$json = json_encode($val);
					mc_add_meta($page_id, 'link', $json);
					$num++;
				}
				if (num > 10){
					break;
				}
			}
		}
	}
	private function save_proparms($page_id, $update=false){
		if ($update){
			M('meta')->where("page_id='".$page_id."' AND type = 'parameter'")->delete();
			M('meta')->where("page_id='".$page_id."' AND type = 'price'")->delete();
			M('meta')->where("page_id='".$page_id."' AND type = 'kucun'")->delete();
		}
		if($_POST['pro-parameter']) {
			$parameter = I('post.pro-parameter');
			foreach($parameter as $par_id=>$vals) {
				foreach($vals as $val) {
					$name = $val['name'];
					if($name!='') {
						mc_add_meta($page_id,$par_id,$name,'parameter');
					}
				}
			}
		}
	}

	public function publish_pro(){
    	if(mc_is_admin() || mc_is_bianji()) {
    		$page_title = I('post.title');
	    	if($page_title && $_POST['content'] && is_numeric($_POST['price'])) {
	    		$page['title'] = $page_title;
	    		$page['content'] = mc_magic_in(mc_str_replace_base64($_POST['content']));
	    		$page['type'] = 'pro';
	    		$page['date'] = strtotime("now");
	    		$result = M('page')->data($page)->add();
		    	if($result) {
		    		if($_POST['fmimg']) {
		    			foreach($_POST['fmimg'] as $val) {
		    				mc_add_meta($result,'fmimg',mc_save_img_base64($val,true));
		    			}
		    		};
		    		$this->save_proparms($result);
		    		$this->save_links($result);
		    		$this->add_meta_in($result, 'term', 'post.term');
		    		$this->add_meta_in($result, 'kucun', 'post.kucun');
		    		$this->add_meta_in($result, 'tb_name', 'post.tb_name');
		    		$this->add_meta_in($result, 'tb_url', 'post.tb_url');
		    		$this->add_meta_in($result, 'keywords', 'post.keywords');
		    		$this->add_meta_in($result, 'description', 'post.description');
		    		$this->add_meta_in($result, 'price', 'post.price');
		    		mc_add_meta($result,'author',mc_user_id());
		    		do_go('publish_pro_end',$result);
		    		$this->success('发布成功',U('pro/index/single?id='.$result));
	    		} else {
		    		$this->error('发布失败！');
	    		}
	    	} else {
	    		$this->error('请填写标题和内容');
	    	};
	    } else {
		    $this->error('哥们，你放弃治疗了吗?',U('home/index/index'));
	    };
    }

    public function publish_article(){
    	if(mc_is_admin() || mc_is_bianji()) {
    		$page_title = I('post.title');
    		if($page_title && $_POST['content']) {
    			$page['title'] = $page_title;
    			$page['content'] = mc_magic_in(mc_str_replace_base64($_POST['content']));
    			$page['type'] = 'article';
    			$page['date'] = strtotime("now");
    			$result = M('page')->data($page)->add();
    			if($result) {
    				if($_POST['fmimg']) {
    					mc_add_meta($result,'fmimg',mc_magic_in(mc_save_img_base64($_POST['fmimg'])));
    				};
    				$tags_str = I('post.tags');
    				if($tags_str) {
    					$tags = explode(' ',$tags_str);
    					foreach($tags as $tag) :
    					if($tag) :
    					mc_add_meta($result,'tag',$tag);
    					endif;
    					endforeach;
    				};
    				$this->save_links($result);
    				$this->save_media($result);
    				$this->add_meta_in($result, 'term', 'post.term');
    				mc_add_meta($result,'author',mc_user_id());
    				do_go('publish_article_end',$result);
    				$this->success('发布成功！',U('article/index/single?id='.$result));
    			} else {
    				$this->error('发布失败！');
    			}
    		} else {
    			$this->error('请填写标题和内容');
    		};
    	} else {
    		$this->error('哥们，你放弃治疗了吗?',U('home/index/index'));
    	};
    }

    public function edit(){
    	if(mc_is_admin() || mc_is_bianji() || mc_author_id($_POST['id'])==mc_user_id()) {
    		$page_title = I('post.title');
	    	if($page_title && $_POST['content'] && is_numeric($_POST['id'])) {
    			$page_type = mc_get_page_field($_POST['id'],'type');
	    		if($page_type=='pro') {
		    		if($_POST['fmimg']) {
		    			mc_delete_meta($_POST['id'],'fmimg');
		    			foreach($_POST['fmimg'] as $val) {
		    				mc_add_meta($_POST['id'],'fmimg',mc_save_img_base64($val,true));
		    			}
		    		} else {
		    			$this->error('请设置商品图片！');
		    		};
	    			$this->save_proparms($_POST['id'], true);
		    		$this->save_links($_POST['id'], true);
	    			$this->update_meta_in($_POST['id'], 'term', 'post.term');
	    			$this->update_meta_in($_POST['id'], 'price', 'post.price');
	    			$this->update_meta_in($_POST['id'], 'kucun', 'post.kucun');
	    			$this->update_meta_in($_POST['id'], 'tb_name', 'post.tb_name');
	    			$this->update_meta_in($_POST['id'], 'tb_url', 'post.tb_url');
	    			$this->update_meta_in($_POST['id'], 'keywords', 'post.keywords');
	    			$this->update_meta_in($_POST['id'], 'description', 'post.description');
	    		} elseif ($page_type=='article') {
	    			mc_update_meta($_POST['id'],'fmimg',mc_magic_in(mc_save_img_base64($_POST['fmimg'])));
	    			$tags_str = I('post.tags');
		    		if($tags_str) {
			    		mc_delete_meta($_POST['id'],'tag');
			    		$tags = explode(' ',$tags_str);
			    		foreach($tags as $tag) :
			    			if($tag) :
			    				mc_add_meta($_POST['id'],'tag',$tag);
			    			endif;
			    		endforeach;
		    		};
	    			$this->save_links($_POST['id'], true);
	    			$this->save_media($_POST['id'], true);
		    		$this->update_meta_in($_POST['id'], 'term', 'post.term');;
	    		};
	    		$page['title'] = $page_title;
	    		$page['content'] = mc_magic_in(mc_str_replace_base64($_POST['content']));
	    		M('page')->where("id='".$_POST['id']."'")->save($page);
	    		if($page_type=='pro') {
		        	$this->success('编辑成功',U('pro/index/single?id='.$_POST['id']));
	        	} elseif($page_type=='article') {
		        	$this->success('编辑成功',U('article/index/single?id='.$_POST['id']));
	        	} else {
		        	$this->error('未知的Page类型',U('home/index/index'));
	        	}
	    	} else {
		    	$this->error('请完整填写信息！');
	    	}
	    } else {
		    $this->error('哥们，你放弃治疗了吗?',U('home/index/index'));
	    };
    }

    public function delete_pro($id){
        if(is_numeric($id)) {
	        if(mc_is_admin()) {
		        if(mc_get_meta($id,'user_level',true,'user')!=10) {
		         	$type = mc_get_page_field($id,'type');
		         	if($type=='pro_recycle') {
		         		mc_delete_page($id);
						$this->success('删除成功',U('custom/admin/pro_recycle'));
		         	} else {
		         		$this->error('哥们，请不要放弃治疗！',U('custom/admin/pro_recycle'));
		         	}
		        } else {
			        $this->error('请不要伤害管理员');
		        };
	        } else {
	        	$this->error('哥们，请不要放弃治疗！',U('Home/index/index'));
	        }
        } else {
	        $this->error('参数错误！');
        }
    }
}