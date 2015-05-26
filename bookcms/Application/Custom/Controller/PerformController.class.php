<?php
namespace Custom\Controller;
use Think\Controller;
class PerformController extends Controller {
	private function save_basic_meta($page_id, $meta_key, $input_key, $update=false){
		if($update){
			mc_delete_meta($page_id, $meta_key);
		}
		$vals = I($input_key);
		if (is_array($vals)){
			foreach($vals as $val){
				mc_add_meta($page_id, $meta_key, $val);
			}
		}elseif ($vals){
			mc_add_meta($page_id, $meta_key, $vals);
		}
	}
	private function save_media($page_id, $update=false){
		if($update) {
			if($_POST['media-changed']=='false'){
				return;
			}
			M('meta')->where("page_id='".$page_id."' AND meta_key='media'")->delete();
		}
		if($_POST['media-list']) {
			$medias = I('post.media-list');
			$num = 0;
			foreach($medias as $media){
				if(strpos($media['url'], 'http://')===0 && $media['title'] != ''){
					if(strpos($media['url'], '.m3u8')!==false){
						$type="m3u8a";
					}else{
						$type="mp3";
					}
					$val = array('url'=>$media['url'], 'title'=>$media['title'], 'type'=>$type);
					$json = json_encode($val);
					mc_add_meta($page_id, 'media', $json, 'media');
					$num++;
				}
				if (num > 20){
					break;
				}
			}
		}
	}
	private function save_links($page_id, $update=false){
		if($update) {
			if($_POST['links-changed']=='false'){
				return;
			}
			M('meta')->where("page_id='".$page_id."' AND meta_key='link'")->delete();
		}
		$link_type = array('play','page','wxbuy','otherbuy');
		if($_POST['pro-links']) {
			$links = I('post.pro-links');
			$num = 0;
			foreach($links as $link){
				if(strpos($link['url'], 'http://')===0 && $link['title'] != ''){
					$type = $link['type'];
					if(!in_array($type, $link_type)){
						$type = 'page';
					}
					$val = array('url'=>$link['url'], 'title'=>$link['title'], 'type'=>$type);
					$json = json_encode($val);
					mc_add_meta($page_id, 'link', $json, $type.'link');
					$num++;
				}
				if ($num > 10){
					break;
				}
			}
		}
	}
	private function save_buyurl($page_id, $update=false){
		if($update) {
			M('meta')->where("page_id='".$page_id."' AND meta_key='buyurl'")->delete();
		}
		if($_POST['goto-buy']) {
			$buyurls = I('post.goto-buy');
			$num = 0;
			foreach($buyurls as $buyurl){
				$ch_types = array('wx_url','tb_url','tm_url', 'az_url');
				if(strpos($buyurl['url'], 'http://')===0 && in_array($buyurl['ch'], $ch_types)){
					mc_add_meta($page_id, 'buyurl', $buyurl['url'], $buyurl['ch']);
					$num++;
				}
				if ($num > 2){
					break;
				}
			}
		}
	}
	private function save_proparms($page_id, $update=false){
		if($update){
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
	private function save_pro(){
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
				}
				$this->save_proparms($result);
				$this->save_links($result);
				$this->save_buyurl($result);
				$this->save_basic_meta($result, 'isbn', 'post.isbn');
				$this->save_basic_meta($result, 'price', 'post.price');
				$this->save_basic_meta($result, 'kucun', 'post.kucun');
				$this->save_basic_meta($result, 'term', 'post.term');
				$this->save_basic_meta($result, 'keywords', 'post.keywords');
				$this->save_basic_meta($result, 'description', 'post.description');
				mc_add_meta($result,'author',mc_user_id());
				do_go('publish_pro_end',$result);
				return array('ret'=>true,'msg'=>$result);
			} else {
				return array('ret'=>false,'msg'=>'发布失败！');
			}
		} else {
			return array('ret'=>false,'msg'=>'请填写标题和内容');
		}
	}
	private function update_pro($page_id, $page_title){
		if($_POST['fmimg']) {
			mc_delete_meta($page_id,'fmimg');
			foreach($_POST['fmimg'] as $val) {
				mc_add_meta($page_id,'fmimg',mc_save_img_base64($val,true));
			}
		} else {
			return array('ret'=>false,'msg'=>'请设置商品图片！');
		}
		$this->save_proparms($page_id, true);
		$this->save_links($page_id, true);
		$this->save_buyurl($page_id, true);
		$this->save_basic_meta($page_id, 'isbn', 'post.isbn', true);
		$this->save_basic_meta($page_id, 'price', 'post.price', true);
		$this->save_basic_meta($page_id, 'kucun', 'post.kucun', true);
		$this->save_basic_meta($page_id, 'term', 'post.term', true);
		$this->save_basic_meta($page_id, 'keywords', 'post.keywords', true);
		$this->save_basic_meta($page_id, 'description', 'post.description', true);
		$page['title'] = $page_title;
		$page['content'] = mc_magic_in(mc_str_replace_base64($_POST['content']));
		M('page')->where(array('id'=>$page_id))->save($page);
		return array('ret'=>true,'msg'=>'更新成功');
	}

	public function publish_pro_ajax(){
    	if(mc_is_admin() || mc_is_bianji()) {
    		$isbn = I('post.isbn');
    		$page_id = M('meta')->where(array('meta_key'=>'isbn', 'meta_value'=>$isbn))->getField('page_id');
    		if($page_id){
    			$page_title = I('post.title');
    			if($page_title && $_POST['content']){
    				$result = $this->update_pro($page_id, $page_title);
    			}else{
    				$result= array('ret'=>false,'msg'=>'请填写标题和内容');
    			}
    		}else{
    			$result = $this->save_pro();
    		}
	    } else {
		    $result = array('ret'=>false,'msg'=>'没有权限');
	    }
	    $this->ajaxReturn($result);
    }

	public function publish_pro(){
    	if(mc_is_admin() || mc_is_bianji()) {
    	 	$result = $this->save_pro();
    	 	if($result['ret']){
    	 		$this->success('发布成功',U('pro/index/single?id='.$result['msg']));
    	 	}else{
    	 		$this->error($result['msg']);
    	 	}
	    } else {
		    $this->error('哥们，你放弃治疗了吗?',U('home/index/index'));
	    }
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
    				}
    				$tags_str = I('post.tags');
    				if($tags_str) {
    					$tags = explode(' ',$tags_str);
    					foreach($tags as $tag) :
    					if($tag) :
    					mc_add_meta($result,'tag',$tag);
    					endif;
    					endforeach;
    				}
    				$this->save_links($result);
    				$this->save_media($result);
    				$this->save_basic_meta($result, 'term', 'post.term');
    				mc_add_meta($result,'author',mc_user_id());
    				do_go('publish_article_end',$result);
    				$this->success('发布成功！',U('article/index/single?id='.$result));
    			} else {
    				$this->error('发布失败！');
    			}
    		} else {
    			$this->error('请填写标题和内容');
    		}
    	} else {
    		$this->error('哥们，你放弃治疗了吗?',U('home/index/index'));
    	}
    }

    public function edit(){
    	if(mc_is_admin() || mc_is_bianji() || mc_author_id($_POST['id'])==mc_user_id()) {
    		$page_title = I('post.title');
	    	if($page_title && $_POST['content'] && is_numeric($_POST['id'])) {
    			$page_type = mc_get_page_field($_POST['id'],'type');
	    		if($page_type=='pro') {
	    			$result = $this->update_pro($_POST['id'],$page_title);
	    			if(!$result['ret']){
	    				$this->error($result['msg']);
	    			}
	    		} elseif ($page_type=='article') {
	    			if($_POST['fmimg']){
	    				mc_update_meta($_POST['id'],'fmimg',mc_magic_in(mc_save_img_base64($_POST['fmimg'])));
	    			}
	    			$tags_str = I('post.tags');
		    		if($tags_str) {
			    		mc_delete_meta($_POST['id'],'tag');
			    		$tags = explode(' ',$tags_str);
			    		foreach($tags as $tag) :
			    			if($tag) :
			    				mc_add_meta($_POST['id'],'tag',$tag);
			    			endif;
			    		endforeach;
		    		}
	    			$this->save_links($_POST['id'], true);
	    			$this->save_media($_POST['id'], true);
		    		$this->save_basic_meta($_POST['id'], 'term', 'post.term', true);;
		    		$page['title'] = $page_title;
		    		$page['content'] = mc_magic_in(mc_str_replace_base64($_POST['content']));
		    		M('page')->where(array('id'=>$_POST['id']))->save($page);
	    		}
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
	    }
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
		        }
	        } else {
	        	$this->error('哥们，请不要放弃治疗！',U('Home/index/index'));
	        }
        } else {
	        $this->error('参数错误！');
        }
    }
    public function delete_img($id){
        if(is_numeric($id)) {
	        if(mc_is_admin()) {
	         	$src = M('attached')->where("id='$id'")->getField('src');
		        M('attached')->where("id='$id'")->delete();
		        mc_del_img($src);
		        $this->success('删除成功');
	        } else {
	        	$this->error('哥们，请不要放弃治疗！',U('Home/index/index'));
	        }
        } else {
	        $this->error('参数错误！');
        }
    }
}