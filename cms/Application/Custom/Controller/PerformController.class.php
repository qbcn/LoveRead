<?php
namespace Custom\Controller;
use Think\Controller;
class PerformController extends Controller {
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
					if($type != 'audio'){
						$type = 'article';
					}
					$val = array('url'=>$link['url'], 'title'=>$link['title'], 'type'=>$type);
					$json = json_encode($val);
					mc_add_meta($page_id,'link', $json);
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
	    	if($_POST['title'] && $_POST['content'] && is_numeric($_POST['price'])) {
	    		$page['title'] = mc_magic_in($_POST['title']);
	    		$page['content'] = mc_magic_in(mc_str_replace_base64($_POST['content']));
	    		$page['type'] = 'pro';
	    		$page['date'] = strtotime("now");
	    		$result = M('page')->data($page)->add();
		    	if($result) {
		    		mc_add_meta($result,'term',mc_magic_in($_POST['term']));
		    		if($_POST['fmimg']) {
		    			foreach($_POST['fmimg'] as $val) {
		    				mc_add_meta($result,'fmimg',mc_save_img_base64($val,true));
		    			}
		    		};
		    		if($_POST['kucun']>0) {
		    			mc_add_meta($_POST['id'],'kucun',$_POST['kucun']);
		    		};
		    		if($_POST['pro-parameter']) {
		    			$parameter = I('param.pro-parameter');
		    			foreach($parameter as $key=>$val) {
			    			foreach($val as $vals) {
			    				if($vals['name']!='') {
			    					mc_add_meta($result,$key,$vals['name'],'parameter');
			    				}
			    			}
		    			}
		    		};
		    		$this->save_links($result);
		    		if($_POST['tb_name']) {
		    			mc_add_meta($result,'tb_name',$_POST['tb_name']);
		    		};
		    		if($_POST['tb_url']) {
		    			mc_add_meta($result,'tb_url',$_POST['tb_url']);
		    		};
		    		if($_POST['keywords']) {
		    			mc_add_meta($result,'keywords',$_POST['keywords']);
		    		};
		    		if($_POST['description']) {
		    			mc_add_meta($result,'description',$_POST['description']);
		    		};
		    		if($_POST['price']>0) {
		    			mc_add_meta($result,'price',mc_magic_in($_POST['price']));
		    		};
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
    		if($_POST['title'] && $_POST['content']) {
    			$page['title'] = mc_magic_in($_POST['title']);
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
    				mc_add_meta($result,'term',mc_magic_in($_POST['term']));
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
	    	if(mc_remove_html($_POST['title'],'all') && $_POST['content'] && is_numeric($_POST['id'])) {
	    		if(mc_get_page_field($_POST['id'],'type')=='pro') {
	    			if($_POST['term']) {
		    			mc_update_meta($_POST['id'],'term',mc_magic_in($_POST['term']));
		    		} else {
		    			$this->error('请设置分类！');
		    		};
	    			if($_POST['price']>0) {
	    				mc_update_meta($_POST['id'],'price',mc_magic_in($_POST['price']));
	    			} else {
						$this->error('请填写价格！');
					};
		    		if(is_numeric($_POST['kucun'])) {
		    			mc_update_meta($_POST['id'],'kucun',$_POST['kucun']);
		    		};
					M('meta')->where("page_id='".$_POST['id']."' AND type = 'parameter'")->delete();
					M('meta')->where("page_id='".$_POST['id']."' AND type = 'price'")->delete();
					M('meta')->where("page_id='".$_POST['id']."' AND type = 'kucun'")->delete();
					if($_POST['pro-parameter']) {
		    			$parameter = $_POST['pro-parameter'];
		    			foreach($parameter as $key=>$val) {
			    			$val = array_reverse($val);
			    			foreach($val as $vals) {
			    				if($vals['name']!='') {
			    					mc_add_meta($_POST['id'],$key,$vals['name'],'parameter');
			    				}
			    			}
		    			}
		    		};
		    		$this->save_links($_POST['id'], true);
		    		if($_POST['fmimg']) {
		    			mc_delete_meta($_POST['id'],'fmimg');
		    			foreach($_POST['fmimg'] as $val) {
		    				mc_add_meta($_POST['id'],'fmimg',mc_save_img_base64($val,true));
		    			}
		    		} else {
		    			$this->error('请设置商品图片！');
		    		};
		    		if($_POST['tb_name']) {
		    			mc_update_meta($_POST['id'],'tb_name',$_POST['tb_name']);
		    		};
		    		if($_POST['tb_url']) {
		    			mc_update_meta($_POST['id'],'tb_url',$_POST['tb_url']);
		    		};
		    		if($_POST['keywords']) {
		    			mc_update_meta($_POST['id'],'keywords',$_POST['keywords']);
		    		};
		    		if($_POST['description']) {
		    			mc_update_meta($_POST['id'],'description',$_POST['description']);
		    		};
	    		} elseif (mc_get_page_field($_POST['id'],'type')=='article') {
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
		    		if($_POST['term']) {
		    			mc_update_meta($_POST['id'],'term',mc_magic_in($_POST['term']));
		    		} else {
		    			$this->error('请设置分类！');
		    		};
	    		};
	    		$page['title'] = mc_magic_in(mc_remove_html($_POST['title'],'all'));
	    		$page['content'] = mc_magic_in(mc_remove_html(mc_str_replace_base64($_POST['content'])));
	    		M('page')->where("id='".$_POST['id']."'")->save($page);
	    		if(mc_get_page_field($_POST['id'],'type')=='pro') {
		        	$this->success('编辑成功',U('pro/index/single?id='.$_POST['id']));
	        	} elseif(mc_get_page_field($_POST['id'],'type')=='article') {
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