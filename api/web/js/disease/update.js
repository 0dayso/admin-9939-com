
/**
 * 编辑疾病 js 文件
 */
 
$(document).ready(function(){
	
	//选择一级科室，级联显示二级科室
	$(document).on('click', "#class_level1 a", function(){

		/*
		 * 1、得到当前选中的一级科室 classLevel1
		 * 2、通过 ajax 的方式，将 classLevel1 传到后台，并查询 classLevel1 所对应的二级科室 classLevel2JSON 
		 * 3、将得到的二级科室 classLevel2JSON 设置到 class_level2 dl 元素中
		 */
		 var class_level1_id = $(this).attr("data-id");
		 $("#class_level1a").attr("data-id", class_level1_id);
		 $("#class_level1a").text($(this).text());
		$('.specs').show();

		if(class_level1_id != undefined && class_level1_id != ''){
			$.ajax({
				  type:"GET",
				  url: "/basedata/disease/getclasslevel2",
				  data: "class_level1=" + class_level1_id,
				  dataType: 'json',
				  success: function(msg){
					if(msg != undefined && msg != null){
						var content = "<dt>二级科室</dt>";
						var len = msg.length;
						for(var i = 0; i < len;i++){
							content += '<dd>'+ '<a data-id = "'+ msg[i]['id'] +'">' + msg[i]['name'] +'</a>' +'</dd>';
						}
					   $("#class_level2 dl").html(content);
					    
						$('#class_level2 a').click(function(){
							$("#class_level2a").attr("data-id", $(this).attr("data-id"));
							$("#class_level2a").text($(this).text());
							
							var neva=$(this).html();
							$(this).parents('.clasfi').find('input').val(neva);
							$('a.dome').attr('data-ctt','0')
						});
					}
				  }
			});
		}
	}); 
	//单击“确定”，隐藏当前窗口
	$('#sureClass').click(function(){
		var class_level = $("#class_level1a").attr("data-id") + "——" + $("#class_level2a").attr("data-id");
		var class_level_name = $("#class_level1a").text() + "——" + $("#class_level2a").text();
		var content = '<p><a data-id = "'+ class_level +'">'+ class_level_name +'<b></b></a></p>';
		$("#selectedDep").append(content);
		$('.specs').hide();	

		//添加移除的操作
		$('.hasad a b,.imop li b').click(function(){
			var lent=$(this).parent();
			lent.remove();
		});
	});
	
	//就诊科室
	$("#diseaseTreatAdd").on('click', function(){
		var diseaseTreatIn = $("#diseaseTreatIn").val();
		if (diseaseTreatIn != null && diseaseTreatIn != '') {
			var content = '<a>'+ diseaseTreatIn +'<b></b></a>';
			$("#diseaseTreatSeleted").append(content);
			
			//添加移除的操作
			$('.hasad a b,.imop li b').click(function(){
				var lent=$(this).parent();
				lent.remove();
			});
		}
	});

	//设置提交时的参数
	$("#save").on('click', function(){
		setUpdateValues();
		//验证数据
		var isSuccess = checkDatas();
		if (!isSuccess) {
			return false;
		}
		$("#saveDisease").val("save");
		
		$("#updateDis").submit();
	});
	//设置提交时的参数
	$("#generate").on('click', function(){
		setUpdateValues();
		//验证数据
		var isSuccess = checkDatas();
		if (!isSuccess) {
			return false;
		}
		$("#saveDisease").val("generate");
		
		$("#updateDis").submit();
	});

	function getRealLen(str) {
		var realLength = 0, len = str.length, charCode = -1;
		for (var i = 0; i < len; i++) {
			charCode = str.charCodeAt(i);
			if (charCode >= 0 && charCode <= 128) realLength += 1;
			else realLength += 2;
		}
		return realLength;
	};

	/**
	 * 弹出框
	 * @param alertMsg 弹出框的提示信息
     */
	function alert(alertMsg){
		$('#dialog').dialogBox({
			width:400,
			hasClose: false,
			effect: 'fade',
			hasBtn: true,
			type: 'correct',
			confirmValue: "确定",  //确定按钮文字内容
			cancelValue: null,  //取消按钮文字内容
			confirm: function(){},
			title: '更新提示',
			content: alertMsg
		});
	}

	$("#diseaseName").on('blur', function(){
		var diseaseName = $("#diseaseName").val();
		var reg = new RegExp("^\\d+$");
		if (reg.test(diseaseName)){
			alert("疾病名称不能全为数字！");
		}
	});

	/**
	 * 检查是否存在
	 * @param string tagName 标签名称
	 * @param array alertMsgArr 提示信息数组集
	 * @returns boolean isSuccess 检查成功（false: 失败；true: 成功）
     */
	function checkRequire(tagName){
		var isSuccess = false;

    	//获取到所有要验证的数据
		$(tagName + '[data-require=true]').each(function(){
			var val = $(this).val();
			val = val.trim();
			if(val == ""){
				var alertMsg = $(this).attr("data-label");
				isSuccess = false;
				alert(alertMsg + " 不能为空！");
				return isSuccess;
			}
			//疾病名称个数不能 > 25
			var diseaseName = $("#diseaseName").val();
			var reg = new RegExp('^\\d+$');
			if (reg.test(diseaseName)){
				alert("疾病名称不能全为数字！");
			}
			if (getRealLen(diseaseName) > 25){
				alert("疾病名称长度不能大于25个字！");
			}
			isSuccess = true;
		});
		return isSuccess;
	}

	/**
	 * 验证数据
	 */
	function checkDatas() {
		var isSuccess = false;

		//检查 input 标签下的数据是否有值
		isSuccess = checkRequire('input');

		if (!isSuccess){
			return isSuccess;
		}
		//检查 texteare 标签下的数据是否有值
		isSuccess = checkRequire('textarea');

		return isSuccess;
	}
	
	function setUpdateValues(){
		//设置科室信息
		setDepartment();
		//设置相关疾病信息
		setReldisease();
		//设置相关症状
		setRelsymptom();
		//设置就诊科室
		setDepTreat();
		//设置图片信息
		setDisImage();
		//设置新增加的图片
		setNewAddImage();
	}

	function setNewAddImage(){
		var files = "";
		$(".uploadify-queue-item div span input").each(function(){
			files += $(this).val() + ",";
		});
		$("#files").val(files);
	}

	function setDisImage() {
		var content = "";
		
		$("#selectedImages li").each(function(){
			var isChecked = 0;
			var fileName = $(this).find("b").attr("data-id");
			var fileChecked = $(this).find("input[checked=checked]");
			
			if (fileChecked != null && fileChecked != undefined && fileChecked.length != 0) {
				isChecked = 1;
			}
			content += '{"name": "'+ fileName +'", "weight": "'+ isChecked +'"}' + "-";
		});
		$("#diseaseImage").val(content);
	}
	
	function setDepTreat(){
		//获取到 diseaseTreatSeleted 下的所有 a 标签的 text() 值，设置到 diseaseTreat 中
		var val = "";
		$("#diseaseTreatSeleted a").each(function(){
			val += $(this).text() + ",";
		});
		$("#diseaseTreat").val(val);
	}

	/**
	 * 设置相关症状信息
	 */
	function setRelsymptom(){
		//获取所有的 relsym_selects 下面的 a 标签
		var seletedRelsymptoms = "";
		var seletedRelsymptomName = "";
		$("#relsym_selects a").each(function(){
			seletedRelsymptoms += $(this).attr("data-id") + ",";
			seletedRelsymptomName += $(this).text() + ",";
		});
		//将得到的所有 a 标签中的 data-id 的值，绑定到 diseaseSymptom 下
		$("#diseaseSymptom").val(seletedRelsymptoms);
		$("#diseaseForSymptom").val(seletedRelsymptomName);
	}
	
	/**
	 * 设置相关疾病信息
	 */
	function setReldisease(){
		//获取所有的 reldis_selects 下面的 a 标签
		var seletedReldiseases = "";
		$("#reldis_selects a").each(function(){
			seletedReldiseases += $(this).attr("data-id") + ",";
		});
		//将得到的所有 a 标签中的 data-id 的值，绑定到 diseaseDisease 下
		$("#diseaseDisease").val(seletedReldiseases);
	}

	/*
	 * 设置科室的信息
	 */
	function setDepartment(){
		var departmentJSON = '';
		
	    $("#selectedDep p a").each(function(){
	    	 var data_id = $(this).attr('data-id'),
			    data_id_arr = data_id.split("——"),
				class_level1 = data_id_arr[0],
				class_level2 = data_id_arr[1],
				departmentid = class_level2;
	    	 
				if(class_level2 == "0"){
					departmentid = class_level1;
				}
				departmentJSON += '{"departmentid" : "'+ departmentid +'", "class_level1" : "'+ class_level1 +'", "class_level2" : "'+ class_level2 +'"}' + '-';
	    });
		$("#diseaseDepartment").val(departmentJSON);
	}

	//添加【相关疾病】操作
	$("#addReldisease").on('click', function(){
		$.ajax({
			  type:"GET",
			  url: "/basedata/disease/reldisease",
			  dataType: 'html',
			  success: function(msg){
				  $("#reldiseaseBlock").html(msg);
			  }
		});
	});
	//添加【相关症状】操作
	$("#addRelsymptom").on('click', function(){
		$.ajax({
			  type:"GET",
			  url: "/basedata/disease/relsymptom",
			  dataType: 'html',
			  success: function(msg){
				  $("#relsymptomBlock").html(msg);
			  }
		});
	});

	/**
	 * 绑定图集的选中操作
	 * @param Object param 要绑定的对象
     */
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

	function setExistDeleteImage(){
		var files = "";
		$(".uploadify-queue-item div span input").each(function(){
			files += $(this).val() + ",";
		});

	}

	//绑定已有图片的删除操作：
	$("#selectedImages li b[data-type='exist']").on('click', function(){
		var deletefiles = $("#deletefiles").val();
		//设置已有图片删除后，图片的相关信息
		deletefiles += $(this).attr("data-id") + ",";
		$("#deletefiles").val(deletefiles);
	});

});
