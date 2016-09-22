<?php
use yii\helpers\Html;
use yii\helpers\Url;

echo $this->render("feedback_main_nav");
?>
<!--左侧右侧-->
<?php
	echo $this->render("/include/rightFloat");
?>
<!--ends-->
<div class="content bocon">
	<div class="art_s"> 您所在的位置：<a href="http://www.9939.com" target="_blank">久久健康网</a>><a href="http://qt.server.9939.com/" target="_blank">疾病百科</a>><a><b>疾病症状</b></a></div>
</div>
<!--ends-->
<div class="conter">
     <h3 class="surgt">提交建议</h3>
     <div class="maind">
      <div class="reommend">
       <!--<form onsubmit="return write_all();" action="<?php echo Url::to('@jb_domain/jianyi/', true)?>"  method="post"  enctype="multipart/form-data">-->
         <ul class="jyplate clearfix">
           <li><b class="fl">建议页面链接:</b><input type=" text" name="url" id='url' value="" class="inpt kols fl"/></li>
           <li><b class="fl">建议内容关于:</b><div class="fourlid  fl"><label><input type="radio" class="w14" id="surget" name="surget" value="1">内容有误</label>
           <label><input type="radio"  class="w14" name="surget" id="surget" value="2">界面视觉</label>
           <label><input name="surget" class="w14" type="radio"  id="surget" value="3">页面出错</label>
           <label><input type="radio" class="w14" name="surget"  id="surget" value="4" />其他</label></div></li>
            <li><b class="fl">反馈内容:</b> 
          <div class="textbox fl"><textarea type="text" id="content" name="content"  value="" class="inpt heokl"></textarea><p class="num">5/100</p> </div>
        </li>
            <li><b class="fl">上传图片:</b><p class="cond cor666 fl"> <INPUT TYPE="file" id="file_upload" name="file_upload" /> 请上传本地图片，大小不超过1M，<i>格式为jpg、gif、png或bmp</i>。</p></li>
			<li id="selectedImages" style="margin-left:100px;">
				<b></b>
			</li>
			
			<input type="hidden" name="diseaseImage" id = "diseaseImage" value="" data-require = "true" data-label = "" ><br/>
			<input type="hidden" name="files" id="files" value="" />
            <li><b class="fl">联系方式:</b><input type="text" id="contact" name="contact" value=""  class="inpt w197 cor666 fl"/><p class="cond cor666 fl">您可以留下E-mail、QQ或电话号码，方便我们与您进一步沟通</p></li>
            <li><b class="fl"></b><button type="submit" id="tijiao" class="subbut fl" onclick="tijiao()"  value="提交"/>提&nbsp;交</button></li>
       </ul>
      <!--</form>-->
     
     </div>
    </div>
</div>
<!--弹框 开始-->
            <div class="qbwrt" id="qbwrt" style="display:none">
            <div class="askboun wnome">
             <div class="choks"><p class="ple_ks">提示</p><div class="xlerr"><a><img src="/images/xlerr.png"></a></div></div>
                 <p class="fiz20 cl999">提交成功，感谢您的建议！</p>
              </div>
             </div>
         <!--弹框 结束-->
	<div class="qbwrt" id="qbwrt1" style="display:none">
		<div class="askboun wnome">
		 <div class="choks"><p class="ple_ks">提示</p><div class="xlerr" id="xlerr"><a><img src="/images/xlerr.png"></a></div></div>
			 <p class="fiz20 cl999">提交失败，请重新提交！</p>
		  </div>
		 </div>

<script type="text/javascript">
$('.xlerr a').click(function(){
		$('.qbwrt').hide();	
		window.location.href='<?php echo Url::to("@jb_domain/jianyi/", true)?>';
	});
	$('#xlerr a').click(function(){
		$('.qbwrt').hide();	
	});
	function tijiao(){
		var url = document.getElementById("url").value;
		var surget=document.getElementsByName("surget");
		var content = document.getElementById("content").value;
		var contact = document.getElementById("contact").value;
		var uploads=document.getElementsByName("uploads");
		var ajax_dom="0";
		for (i=0;i<surget.length;i++){  //遍历Radio  
			if(surget[i].checked){
				var surgets = surget[i].value;//获取surget的值
			}
		}
		//获取上传文件名称
		var uploads = "";
		$("#selectedImages span").each(function(){
			var fileName = $(this).find('.img_data').find("img").attr("alt");
			if(uploads==""){
				uploads =fileName;
			}else{
				uploads += ","+fileName;
			}
		});
		if(url==""){
			alert("系统提示：\n\n请输入链接!");
			return false;
		}
                regu =/^(http|https):\/\/([\w-]+\.)+[\w-]+(\/[\w-./?%&=]*)?$/;
                if(!regu.test(url)){
                    alert("系统提示：\n\n请输入正确的url链接地址!");
                    return false;
                }
                
		if(!surgets){
			alert("系统提示：\n\n请选择建议内容!");
			return false;
		}
		if(content==""){
			alert("系统提示：\n\n反馈内容不能为空!");
			return false;
		}
		if(contact==""){
			alert("系统提示：\n\n请输入联系方式!");
			return false;
		}
		tel = /^[1][3578][0-9]{9}/;
		email = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
		qq = /^\d{5,10}$/;
		if(!tel.test(contact)){
			if(!email.test(contact)){
				if(!qq.test(contact)){
					alert("系统提示：\n\n请输入正确的联系方式!");
					return false;
				}
			}
		}
		$("#tijiao").attr("disabled","disabled");
		if(ajax_dom==0){
			ajax_dom='1';
			$.ajax({url:'<?php echo Url::to("@jb_domain/jianyi/", true) ?>', 
			type: 'POST',
			data:{url:url,surgets:surgets,content:content,contact:contact,uploads:uploads},
			dataType: 'html', 
			timeout: 50000, 
				error: function(){
					ajax_dom=0;
					alert("请求失败，网络服务器链接超时！");
				},
				beforeSend:function(){
					ajax_dom=1;
				},
				success:function(result){
					result=result.replace(/(^\s*)|(\s*$)/g,"");
					ajax_dom='0';
					if(result=='1'){
						$("#qbwrt").css({"display":"block"});
					}else{
						$("#qbwrt1").css({"display":"block"});
					}
				}
			});
		}else{
			alert("还有修改请求正在进行中，请耐心等待会...");	
		}
	}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@jb_domain/js/uploadify/uploadify.css')?>" />
<script type="text/javascript" src="<?php echo Url::to('@jb_domain/js/uploadify/jquery.uploadify.min.js')?>"></script>
<script type="text/javascript">
$(function() {
	$('#file_upload').uploadify({
		//'removeTimeout' : 1,//文件队列上传完成1秒后删除
		'swf'      : '/js/uploadify/uploadify.swf',
		'uploader' : '<?php echo Url::to("@jb_domain/jianyi/upload/", true) ?>',
		'method'   : 'post',//方法，服务端可以用$_POST数组获取数据
		'buttonClass': 'addc',
		'buttonText' : '<a href="" class="addc" style="margin-left: 0px;">选择</a>',//设置按钮文本
		'wmode': 'transparent',
		checkExisting   : false,
		'width'             : 50, //按钮宽度
		'height'             : 26, //按钮宽度  
		'buttonCursor': 'hand',
		'multi'    : true,//允许同时上传多张图片
		'uploadLimit' : 10,//一次最多只允许上传10张图片
		'fileTypeDesc' : 'Image Files',//只允许上传图像
		'fileTypeExts' : '*.gif; *.jpg; *.png',//限制允许上传的图片后缀
		'fileSizeLimit' : '1MB',	//限制上传的图片
		'queueSizeLimit': 20,
		'queueID' : "selectedImages",
		'overrideEvents': ['onUploadSuccess','onSelectError','onQueueComplete', ],
		'itemTemplate':'<span  id="${fileID}">\
							<b class="img_data">\
								<img alt="" src="" style="width:100px;height:100px;"/>\
							</b>\
						</span>',
		'onUploadSuccess' : function(file, data, response) { //每次成功上传后执行的回调函数，从服务端返回数据到前端
				$('#file_upload').uploadify('settings','removeTimeout', '99999');	//设置进度条窗口不关闭
				$(".uploadify-progress").remove();									//执行成功后，删除下面的进度条
				var dataObj=eval("("+data+")");//转换为json对象 
				$img_url = dataObj['domain'] + "/" + dataObj['path'] + dataObj['fileName'];
				$('#' + file.id).find('.img_data').find('img').attr('src',$img_url);
				$('#' + file.id).find('.img_data').find('img').attr('alt',dataObj['fileName']);
				$('#' + file.id).find('.img_data').find('input').attr('value',dataObj['fileName']);

				//添加删除操作：
				$('#' + dataObj['name']).click(function(){
					var lent=$(this).parent();

					//到数据库中，将 该文件 删除掉：
					var fileName = $(this).attr('data-id');
					$.ajax({
						type: 'get',
						url: '/basedata/disease/deleteimage',
						data: "fileName=" + fileName + "&from=add",
						dataType: 'json',
						success: function(msg){
							if(msg['flag'] == 1){
								lent.remove();
							}
						}
					});
				});
		},
		'onQueueComplete' : function(queueData) {//上传队列全部完成后执行的回调函数
		   
		},
		'onSelectError': function (file, errorCode, errorMsg) {
			var limitSize = $('#file_upload').uploadify('settings', 'fileSizeLimit');
			 switch (errorCode) {
				 case -100:
					 this.queueData.errorMsg = "上传的文件数量已经超出系统限制的" + $('#file_upload').uploadify('settings', 'queueSizeLimit') + "个文件！";
					 break;
				 case -110:
					 this.queueData.errorMsg = "文件 [" + file.name + "] 大小超出系统限制的 " + limitSize + " 大小！";
					 break;
				 case -120:
					 this.queueData.errorMsg = "文件 [" + file.name + "] 大小异常！";
					 break;
				 case -130:
					 this.queueData.errorMsg = "文件 [" + file.name + "] 类型不正确！";
					 break;
				 default:
					 alert(errorMsg, "error");
					 break;
			 }
			$("#fileInput").uploadify("disable", false);
			return false;
		}, 
	});
});
</script>


