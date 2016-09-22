
		var img_id_upload=new Array();//初始化数组，存储已经上传的图片名
		var i=0;//初始化数组下标
		$(function() {
		    $('#file_upload').uploadify({
		    	//'removeTimeout' : 1,//文件队列上传完成1秒后删除
		        'swf'      : '/js/uploadify/uploadify.swf',
		        'uploader' : '/basedata/disease/upload',
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
				'itemTemplate':'<li id="${fileID}" class="uploadify-queue-item">\
        							<div><span class="data"></span></div>\
    								<div class="uploadify-progress">\
    									<div class="uploadify-progress-bar"><!--Progress Bar--></div>\
    								</div>\
            					</li>',
		        'onUploadSuccess' : function(file, data, response) { //每次成功上传后执行的回调函数，从服务端返回数据到前端
						$('#file_upload').uploadify('settings','removeTimeout', '99999');	//设置进度条窗口不关闭
						$(".uploadify-progress").remove();									//执行成功后，删除下面的进度条

		              	var dataObj=eval("("+data+")");//转换为json对象 
						$('#' + file.id).find('.data').html(
								'<input type="checkbox" data-type = "checkbox" value = "' + dataObj['fileName'] +'" data-value = "0" onclick="bindCheck(this)" >' +
								'<img src="'+ dataObj['domain'] + "/" + dataObj['path'] + dataObj['fileName'] +'" alt="'+ dataObj['fileName'] +'">' +
								'<b id = "'+ dataObj['name'] +'" data-id = "'+ dataObj['fileName'] +'"></b>'
						);

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

		//绑定复选框
		function bindCheck(param){
			if($(param).attr('data-value') == '1'){
				$(param).removeAttr('checked');
				$(param).attr('data-value', '0');
			}else{
				$('input[data-type="checkbox"]:checked').each(function(){
					$(this).removeAttr('checked');
					$(this).attr('data-value', '0');
				});
				$(param).attr('checked', 'checked');
				$(param).attr('data-value', '1');
			}
		}
