<?php

//过滤字符
function bt_magic_in($content) {
	if(get_magic_quotes_gpc()){ 
	    $val = $content;
	} else {
	   	$val = addslashes($content);
	};
	return $val;
};
function bt_magic_out($content) {
	$content1 = str_replace('\r\n', ' ', $content);
	$val = stripslashes($content1);
	return $val;
};

function bt_user_id() {
	$user_name = cookie('user_name');
	$page_id = M('meta')->where(array('meta_key'=>'user_name', 'meta_value'=>bt_magic_in($user_name), 'type'=>'user'))->getField('page_id');
	$user_pass_true = M('meta')->where(array('page_id'=>$page_id,'meta_key'=>'user_pass','type'=>'user'))->getField('meta_value');
	if(cookie('user_name') && cookie('user_pass') && cookie('user_pass') == $user_pass_true) {
		return $page_id;
	}
}
function bt_is_admin() {
	$uid = bt_user_id();
	$ulevel = M('meta')->where(array('page_id'=>$uid,'meta_key'=>'user_level','type'=>'user'))->getField('meta_value');
	if($ulevel=='10') {
		return true;
	} else {
		return false;
	}
};

//列表页循环
function bt_pagenavi($count,$page_now,$size=20) {
	$page_count = ceil($count/$size);
	$init=1;
	$page_len=7;
	$max_p=$page_count;
	$pages=$page_count;

	//判断当前页码
	if(empty($page_now)||$page_now<0){
		$page=1;
	}else {
		$page=$page_now;
	};
	$offset = $size*($page-1);
	$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数
	$pageoffset = ($page_len-1)/2;//页码个数左右偏移量

	$key='<ul class="pagination">';
	$key.="<li class='disabled'><a href='#'>$page/$pages</a></li>"; //第几页,共几页

	$page_url_on = U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
	if(C('URL_MODEL')==0) {
		if($_GET['id']) {
			$page_url = $page_url_on."&id=".$_GET['id']."&";
		} elseif($_GET['keyword']) {
			$page_url = $page_url_on."&keyword=".$_GET['keyword']."&";
		} else {
			$page_url = $page_url_on."&";
		};
	} else {
		if($_GET['id']) {
			$page_url = $page_url_on."?id=".$_GET['id']."&";
		} elseif($_GET['keyword']) {
			$page_url = $page_url_on."?keyword=".$_GET['keyword']."&";
		} else {
			$page_url = $page_url_on."?";
		};
	};

	if($page!=1){
		$key.="<li><a href=\"".$page_url."page=1\">&laquo;</a></li>"; //第一页
		$key.="<li class='prev'><a href=\"".$page_url."page=".($page-1)."\">&lsaquo;</a></li>"; //上一页
	}else {
		$key.="<li class='disabled'><a href='#'>&laquo;</a></li>";//第一页
		$key.="<li class='disabled'><a href='#'>&lsaquo;</a></li>"; //上一页
	}
	if($pages>$page_len){
		//如果当前页小于等于左偏移
		if($page<=$pageoffset){
			$init=1;
			$max_p = $page_len;
		}else{//如果当前页大于左偏移
			//如果当前页码右偏移超出最大分页数
			if($page+$pageoffset>=$pages+1){
				$init = $pages-$page_len+1;
			}else{
				//左右偏移都存在时的计算
				$init = $page-$pageoffset;
				$max_p = $page+$pageoffset;
			}
		}
	}
	for($i=$init;$i<=$max_p;$i++){
		if($i==$page){
			$key.='<li class="active"><a href="#">'.$i.'</a></li>';
		} else {
			$key.="<li><a href=\"".$page_url."page=".$i."\">".$i."</a></li>";
		}
	}
	if($page!=$pages){
		$key.="<li class='next'><a href=\"".$page_url."page=".($page+1)."\">&rsaquo;</a>";//下一页
		$key.="<li><a href=\"".$page_url."page={$pages}\">&raquo;</a></li>"; //最后一页
	}else {
		$key.='<li class="disabled"><a href="#">&rsaquo;</a></li>';//下一页
		$key.='<li class="disabled"><a href="#">&raquo;</a></li>'; //最后一页
	}
	$key.='</ul>';

	if($count>$size) {
		return $key;
	}
};

?>