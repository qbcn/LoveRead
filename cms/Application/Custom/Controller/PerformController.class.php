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
			$medias = I('param.media-list');
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
			$links = I('param.pro-links');
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
		    		if($_POST['pro-parameter']) {
		    			$parameter = I('param.pro-parameter');
		    			foreach($parameter as $par_id=>$vals) {
			    			foreach($vals as $val) {
			    				$name = mc_magic_in($val['name']);
			    				if($name!='') {
			    					mc_add_meta($result,$par_id,$name,'parameter');
			    				}
			    			}
		    			}
		    		};
		    		$this->save_links($result);
		    		add_meta_in($result, 'term', 'post.term');
		    		add_meta_in($result, 'kucun', 'post.kucun');
		    		add_meta_in($result, 'tb_name', 'post.tb_name');
		    		add_meta_in($result, 'tb_url', 'post.tb_url');
		    		add_meta_in($result, 'keywords', 'post.keywords');
		    		add_meta_in($result, 'description', 'post.description');
		    		add_meta_in($result, 'price', 'post.price');
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
    				if(I('param.tags')) {
    					$tags = explode(' ',I('param.tags'));
    					foreach($tags as $tag) :
    					if($tag) :
    					mc_add_meta($result,'tag',$tag);
    					endif;
    					endforeach;
    				};
    				$this->save_links($result);
    				$this->save_media($result);
    				add_meta_in($result, 'term', 'post.term');
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
	    			M('meta')->where("page_id='".$_POST['id']."' AND type = 'parameter'")->delete();
					M('meta')->where("page_id='".$_POST['id']."' AND type = 'price'")->delete();
					M('meta')->where("page_id='".$_POST['id']."' AND type = 'kucun'")->delete();
					if($_POST['pro-parameter']) {
		    			$parameter = $_POST['pro-parameter'];
		    			foreach($parameter as $par_id=>$vals) {
			    			foreach($vals as $val) {
			    				$name = mc_magic_in($val['name']);
			    				if($name!='') {
			    					mc_add_meta($_POST['id'],$par_id,$name,'parameter');
			    				}
			    			}
		    			}
		    		};
		    		$this->save_links($_POST['id'], true);
	    			update_meta_in($_POST['id'], 'term', 'post.term');
	    			update_meta_in($_POST['id'], 'price', 'post.price');
	    			update_meta_in($_POST['id'], 'kucun', 'post.kucun');
	    			update_meta_in($_POST['id'], 'tb_name', 'post.tb_name');
	    			update_meta_in($_POST['id'], 'tb_url', 'post.tb_url');
	    			update_meta_in($_POST['id'], 'keywords', 'post.keywords');
	    			update_meta_in($_POST['id'], 'description', 'post.description');
	    		} elseif ($page_type=='article') {
	    			mc_update_meta($_POST['id'],'fmimg',mc_magic_in(mc_save_img_base64($_POST['fmimg'])));
		    		if(I('param.tags')) {
			    		mc_delete_meta($_POST['id'],'tag');
			    		$tags = explode(' ',I('param.tags'));
			    		foreach($tags as $tag) :
			    			if($tag) :
			    				mc_add_meta($_POST['id'],'tag',$tag);
			    			endif;
			    		endforeach;
		    		};
	    			$this->save_links($_POST['id'], true);
	    			$this->save_media($_POST['id'], true);
		    		update_meta_in($_POST['id'], 'term', 'post.term');;
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
}