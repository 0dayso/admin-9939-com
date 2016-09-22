
var img_id_upload = new Array();//初始化数组，存储已经上传的图片名
var i = 0;//初始化数组下标
$(function() {
    $('#file_upload').uploadify({
//        'removeTimeout'     : 1, //文件队列上传完成1秒后删除
        'swf'               : '/js/uploadify/uploadify.swf',
        'uploader'          : img_upload_url,
        'method'            : 'post', //方法，服务端可以用$_POST数组获取数据
        'buttonClass'       : 'swfBtn', //add admale d-pop-dow
        'buttonText'        : '添加图片', //设置按钮文本
        'width'             : 80, //按钮宽度  
        'height'            : 26, //按钮宽度  
        'buttonCursor'      : 'hand',
        'multi'             : true, //允许同时上传多张图片
        'uploadLimit'       : 10, //总上传多少张
        'fileTypeDesc'      : 'Image Files', //只允许上传图像
        'fileTypeExts'      : '*.gif; *.jpg; *.png', //限制允许上传的图片后缀
        'fileSizeLimit'     : '1024KB', //限制上传的图片
        'queueSizeLimit'    : 5,//每次最多上传多少张
        'queueID'           : 'selectedImages',
        'overrideEvents'    : ['onUploadSuccess', 'onSelectError', 'onQueueComplete', 'onUploadComplete', 'onUploadError'],
        'itemTemplate'      : '\
            <li id="${fileID}" class="uploadify-queue-item">\
                <div class="imgs"></div>\
    		<div class="uploadify-progress">\
                <div class="uploadify-progress-bar"><!--Progress Bar--></div>\
    		</div>\
            </li>',
        
        'onUploadSuccess': function(file, data, response) { //每次成功上传后执行的回调函数，从服务端返回数据到前端
            console.log(data);
//            return false;
            var dataObj = JSON.parse(data);//转换为json对象
            if(dataObj.code==0){
                alert(dataObj.msg);
                return false;
            }
            /*
            $('#' + file.id + ' .imgs').html(
                '<input type="checkbox" data-type="checkbox" value="' + dataObj['fileName'] + dataObj['suffix'] +'" onclick="setImgWeight(this)">' +
                '<a href="'+ dataObj['domain'] + "/" + dataObj['path'] + dataObj['fileName'] + dataObj['suffix'] +'" target="_blank">'+
                '<img src="'+ dataObj['domain'] + "/" + dataObj['path'] + dataObj['fileName'] + dataObj['suffix'] +'"' + 
                ' alt="'+ dataObj['fileName'] + dataObj['suffix'] +'">' +
                '</a>'+
                '<b id="'+ dataObj['fileName'] +'" data-id="'+ dataObj['fileName'] + dataObj['suffix'] +'"></b>'
            );*/
            
            $('#' + file.id + ' .imgs').html(
                '<input type="checkbox" data-type="checkbox" value="' + dataObj['fileName'] +'" onclick="setImgWeight(this)">' +
                '<img src="'+ dataObj['fileUrl'] +'"' + 
                ' alt="'+ dataObj['fileName'] +'" onclick="thumbPreview(this)">' +
                '<b id="'+ dataObj['fileName'] +'" data-id="'+ dataObj['fileName'] +'" onclick="delimg(this)"></b>'
            );
            
        },
        'onQueueComplete': function(queueData) {//上传队列全部完成后执行的回调函数
//            $("#selectedImages")
            //绑定复选框

        },
        'onSelectError': function(file, errorCode, errorMsg) {
            switch (errorCode) {
                case -100:
                    this.queueData.errorMsg = "上传的文件数量已经超出系统限制的" + $('#file_upload').uploadify('settings', 'queueSizeLimit') + "个文件！";
                    break;
                case -110:
                    this.queueData.errorMsg = "文件 [" + file.name + "] 大小超出系统限制的" + $('#file_upload').uploadify('settings', 'fileSizeLimit') + "大小！";
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
        'onUploadComplete':function(file){
            $('#' + file.id).show();
            $("#"+file.id).find('.uploadify-progress-bar').remove();
            $('#' + file.id).find('.data').html('<font color="#3D882D"> 上传完毕</font>');
            $("#fileInput").uploadify("disable", false);
        },
        'onUploadError': function(file, errorCode, errorMsg, errorString) {//上传队列全部完成后执行的回调函数
//            alert(errorObj.info);
            var msgText = "上传失败\n";
            switch (errorCode) {
                case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
                    msgText += "HTTP 错误\n" + errorMsg;
                    break;
                case SWFUpload.UPLOAD_ERROR.MISSING_UPLOAD_URL:
                    msgText += "上传文件丢失，请重新上传";
                    break;
                case SWFUpload.UPLOAD_ERROR.IO_ERROR:
                    msgText += "IO错误";
                    break;
                case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
                    msgText += "安全性错误\n" + errorMsg;
                    break;
                case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
                    msgText += "每次最多上传 " + this.settings.uploadLimit + "个";
                    break;
                case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
                    msgText += errorMsg;
                    break;
                case SWFUpload.UPLOAD_ERROR.SPECIFIED_FILE_ID_NOT_FOUND:
                    msgText += "找不到指定文件，请重新操作";
                    break;
                case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
                    msgText += "参数错误";
                    break;
                default:
                    msgText += "文件:" + file.name + "\n错误码:" + errorCode + "\n"
                            + errorMsg + "\n" + errorString;
            }
//            alert(msgText);
//            $("#selectedImages")
            //绑定复选框

        }
    });
});

/**
 * 删除上传的图片
 * @param {type} ele
 * @returns {undefined}
 */
function delimg(ele){
    var lent = $(ele).parent().parent();
    var fileName = $(ele).attr('data-id');
    $.ajax({
        type: 'post',
        url: img_delete_url,
        data: { "fileName": fileName},
        dataType: 'jsonp',//跨域使用jsonp
        success: function(result) {
            if (result.code == '0') {
                alert(result.msg);
            }else if(result.code == '1'){
                lent.remove();
            }
        }
    });
}


/**
 * 上传完的图片设置主图
 * @param {type} obj
 * @returns {undefined}
 */
function setImgWeight(obj) {
    var that = $(obj);
    var inputNum = $("#selectedImages input").length;
    var iptImg = $(obj).parent().find("b");

    var _weight = iptImg.attr('data-weight');
    if (_weight == 1) {
        for (var n = 0; n < inputNum; n++) {
            $("#selectedImages input").eq(n).attr('checked', false).next().next().attr('data-weight', '0');;
            $("#selectedImages img").eq(n).removeClass('selectImg');
        }

    } else {
        for (var n = 0; n < inputNum; n++) {
            $("#selectedImages input").eq(n).attr('checked', false).next().next().attr('data-weight', '0');
            $("#selectedImages img").eq(n).removeClass('selectImg').parent().removeClass('selectLi');
        }
        that.attr('checked', true).next().addClass('selectImg').next().attr('data-weight', '1');
    }
}