<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>图书比价</title>
    <link href="http://cdn.qibaowu.cn/assets/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdn.qibaowu.cn/assets/js/jquery.min.js"></script>
    <script src="http://cdn.qibaowu.cn/assets/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.qibaowu.cn/assets/js/html5shiv.min.js"></script>
    <script src="http://cdn.qibaowu.cn/assets/js/respond.min.js"></script>
    <![endif]-->
<style>
.ml-10 {margin-left:10px;}
.ml-5 {margin-left:5px;}
div.price-diff-item {border-top:1px solid #ccc;}
</style>
    </head>
  <body>

<div class="container">
<button id="btn-add-item" type="button" class="btn btn-primary" data-toggle="modal" data-target="#set-price-item"><i class="glyphicon glyphicon-plus"></i>新增比价</button>
<div class="row">
	<div class="col-sm-4"><b>比价源</b></div>
	<div class="col-sm-1"><b>源价</b></div>
	<div class="col-sm-4"><b>比价参考</b></div>
	<div class="col-sm-1"><b>参考价</b></div>
	<div class="col-sm-2"><b>操作</b></div>
</div>
<?php foreach($items as $item): $src_url=$item['meta_key'];$sid=substr($surl,-8); ?>
<div class="row price-diff-item">
	<div class="col-sm-4"><a id="<?php echo $sid; ?>" class="src-url" href="<?php echo $src_url; ?>"><?php echo $src_url; ?></a></div>
	<div class="col-sm-1"><span id="price-<?php echo $sid; ?>" class="price src-price">&nbsp;</span></div>
	<div class="col-sm-4">
	<?php $dst_urls=json_decode($item['meta_value'],true);foreach($dst_urls as $url): $did = substr($url, -8); ?>
		<a id="<?php echo $did; ?>" class="dst-url" href="<?php echo $url; ?>"><?php echo $url; ?></a><br>
	<?php endforeach; ?>
	</div>
	<div class="col-sm-1">
	<?php $dst_urls=json_decode($item['$meta_value'],true);foreach($dst_urls as $url): $did = substr($url, -8); ?>
		<span id="price-<?php echo $did; ?>" class="price dst-price">&nbsp;</span><br>
	<?php endforeach; ?>
	</div>
	<div class="col-sm-2">
		<a class="set-this-item" href="javacript:;"><i class="glyphicon glyphicon-edit"></i></a>
		<a class="del-this-item ml-5" href="javacript:;"><i class="glyphicon glyphicon-remove"></i></a>
		<a class="diff-this-item ml-5" href="javacript:;"><i class="glyphicon glyphicon-usd"></i></a>
	</div>
</div>
<?php endforeach; ?>
<?php bt_pagenavi($count, $cpage); ?>
</div>

<!-- Modal -->
<div class="modal fade" id="set-price-item" tabindex="-1" role="dialog" aria-labelledby="priceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="priceModalLabel">设置比价</h4>
      </div>
      <div class="modal-body">
        <form id="price-items-from" action="<?php echo U('Price/set_urls'); ?>">
        	<div class="from-group">
        		<label>比价源链接</label>
        		<input id="src-price-item" class="form-control price-url" type="text" name="surl" placeholder="http://">
        	</div>
        	<div class="form-group" id="dst-price-items">
        		<label>
        			<span>比价参考链接</span>
        			<a id="add-price-item" class="ml-10" href="javacript:;"><i class="glyphicon glyphicon-plus"></i></a>
        		</label>
        		<div class="input-group">
        			<input class="form-control price-url" type="text" name="durls[1]" placeholder="http://">
        			<span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>
        		</div>
        	</div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="submit-price-items" type="button" class="btn btn-primary">保存比价</button>
      </div>
    </div>
  </div>
</div>
<script>
if (typeof String.prototype.startsWith != 'function') {
  String.prototype.startsWith = function (str){
    return this.substr(0, str.length) == str;
  };
}
$(function(){
  var dst_num = 0;
  var set_price_modal = function(price_diff){
    if(price_diff.src_url){
      $('input#src-price-item').val(price_diff.src_url);
    }
    $('div#dst-price-items .input-group').remove();
    dst_num = 0;
    if(price_diff.dst_urls){
      for(var i in price_diff.dst_urls){
        dst_num++;
        var dst_url = price_diff.dst_urls[i];
        var html = '<div class="input-group">';
        html += '<input class="form-control price-url" type="text" name="durls[' + dst_num + ']" placeholder="http://" value="' + dst_url + '">';
        html += '<span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span></div>';
        $(html).appendTo('div#dst-price-items');
      }
    }
  }

  $('#btn-add-item').click(function(){
    set_price_modal({'src_url':'', 'dst_urls':['']});
  });

  $('#submit-price-items').click(function(){
    var url = $('form#price-items-from').attr('action');
    $.post(url, $('form#price-items-from').serialize(), function(data){
      if(data && data.ret){
        alert('设置成功');
      }else{
        alert('设置失败:'+data.msg);
      }
      $('#set-price-item').modal('toggle');
      window.location.reload();
    });
  });

  $('a.set-this-item').click(function(){
    var parent = $(this).parents('div.price-diff-item');
    var src_url = $('a.src-url', parent).attr('href');
    var dst_url = $('a.dst-url', parent).attr('href');
    if($.isArray(dst_url)){
      var dst_urls = dst_url;
    }else{
      var dst_urls = new Array();
      dst_urls[0] = dst_url
    }
    set_price_modal({'src_url':src_url, 'dst_urls':dst_urls});
    $('#set-price-item').modal('show');
  });

  var del_action = "<?php echo U('Price/del_urls'); ?>";
  $('a.del-this-item').click(function(){
    var ret = confirm("确认删除?");
    if(!ret){
      return;
    }
    var parent = $(this).parents('div.price-diff-item');
    var src_url = $('a.src-url', parent).attr('href');
    $.get(del_action, {'surl':src_url}, function(data){
      if(data && data.ret){
        alert('删除成功');
        parent.remove();
      }else{
        alert('删除失败:'+data.msg);
      }
      window.location.reload();
    });
  });

  $("#add-price-item").click(function(){
    dst_num++
    var html = '<div class="input-group">';
    html += '<input class="form-control" type="text" name="durls[' + dst_num + ']" placeholder="http://">';
    html += '<span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span></div>';
    $(html).appendTo('div#dst-price-items');
  });

  $("#dst-price-items").delegate(".input-group .input-group-addon", "click", function(){
    $(this).parents("div.input-group").remove();
    if(dst_num>0){
      dst_num--;
    }
  });

  $("#price-items-from").delegate("input.price-url", "blur", function(){
    var url = $(this).val();
    var matches = url.match(/id=([^&^#]+)/);
    if(matches){
      var id = matches[1];
      if(url.startsWith('http://item.taobao.com/')){
        url = 'http://item.taobao.com/item.htm?id=' + id;
      }else if(url.startsWith('http://detail.tmall.com/')){
        url = 'http://detail.tmall.com/item.htm?id=' + id;
      }
      $(this).val(url);
    }
  });
});
</script>

  </body>
</html>