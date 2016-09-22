
/**
 * 添加疾病---相关疾病 部分
 */
 
$(document).ready(function(){
	
	//选择一级科室，级联显示二级科室
	$("#relsym_part_level1").on('change', function(){
		
		var part_level1_id = $(this).val();

		if(part_level1_id != undefined && part_level1_id != '' && part_level1_id != '0'){
			$.ajax({
				  type:"GET",
				  url: "/basedata/disease/getpartlevel2",
				  data: "part_level1=" + part_level1_id,
				  dataType: 'json',
				  success: function(msg){
					if(msg != undefined && msg != null){
						var content = '<option value="0">二级部位</option>';
						var len = msg.length;
						for(var i = 0; i < len;i++){
							content += '<option value="'+ msg[i]['id'] +'">'+ msg[i]['name'] +'</option>';
						}
					    $("#relsym_part_level2").html(content);
					}
				  }
			});
		}
	}); 

	//搜索操作
	function relsymSearch(){
		$.ajax({
			type:"POST",
			url: "/basedata/disease/getrelsymptoms",
			data: {
				"part_level1" : $("#relsym_part_level1").val(),
				"part_level2" : $("#relsym_part_level2").val(),
				"symptomName" : $("#relsym_symptomName").val()
			},
			dataType: 'html',
			success: function(msg){
				$("#rel_symptom_data").html(msg);
			}
		});
	}

	$("#relsym_search").on('click', function(){
		relsymSearch();
	});

	//添加【回车】搜索功能
	$("#relsymForm").keydown(function(event){
		if (event.keyCode == 13){
			relsymSearch();
		}
	});

	//保存操作
	$(document).on('click', "#relsym_save", function(){
		//保存选择后的值：疾病id -- 疾病name
		$("#relsym_tbody tr td input:checked").each(function(){
			var content = '<a data-id = "'+ $(this).val() +'">'+ $(this).attr('data-name') +'<b></b></a>';
			$("#relsym_selects").append(content);
		});
		//绑定删除的操作
		$('.hasad a b,.imop li b').click(function(){
			var lent=$(this).parent();
			lent.remove();
		});
		$("#relsymptomBlock").hide();
		$("#relsymptomBlock").html("");
	});
	//取消操作
	$(document).on('click', "#relsym_cancel", function(){
		$("#relsymptomBlock").hide();
	});
	//取消操作
	$("#relsym_close").on('click', function(){
		$("#relsymptomBlock").hide();
	});
	
	//绑定复选框(全选或者取消选择)
	$(document).on('click', '#relsym_head input[data-type="checkbox"]', function() {
		//判断当前是否已经选中：
		var checked = $(this).prop('checked');
		if (checked) {
			//全选操作：
			$("#relsym_tbody input[type=checkbox]").prop("checked", true);
		}else {
			//取消操作：
			$("#relsym_tbody input[type=checkbox]").prop("checked", false);
		}
	});

	//checkbox 选中操作
	$(document).on('click', "#relsym_tbody tr td input[type='checkbox']", function(){
		var checked = $(this).prop('checked');
		if (checked) {
			$(this).prop("checked", true);
		}else {
			//判断是否已经 【全选】，如果【全选】，取消全选的操作
			if($('#relsym_head input[data-type="checkbox"]').prop('checked')){
				$('#relsym_head input[data-type="checkbox"]').prop('checked', false);
			}

			//取消操作：
			$(this).prop("checked", false);
		}
	});

	/******************************分页部分 Start *********************************/
		//分页操作
	$(document).on('click',"#paget a[data-id='page']", function(){
		var page = $(this).text();
		paging(page);
	});

	//上一页
	$(document).on('click', "#paget a[data-id='pre']", function(){
		//判断当前页是否等于 1，如果等于 1 ，则该操作不可用
		var page = $("#paget a[class='curt']").text();
		page = parseInt(page);
		if (page == '1'){
			return ;
		}
		paging(page - 1);
	});

	//下一页
	$(document).on('click', "#paget a[data-id='next']", function(){
		//判断当前页是否等于 最后一页，如果是 最后一页 ，则该操作不可用
		var page = $("#paget a[class='curt']").text();
		page = parseInt(page);
		var next = page + 1;
		var end = $("#paget a[data-value='end']").text();
		end = parseInt(end);
		if (page == end){
			return ;
		}
		paging(next);
	});

	/**
	 * 分页操作
	 * @param page 当前页
	 */
	function paging(page){
		$.ajax({
			type:"POST",
			url: "/basedata/disease/getrelsymptoms",
			data: {
				"part_level1" : $("#relsym_part_level1").val(),
				"part_level2" : $("#relsym_part_level2").val(),
				"symptomName" : $("#relsym_symptomName").val(),
				"page" : page
			},
			dataType: 'html',
			success: function(msg){
				$("#rel_symptom_data").html(msg);
			}
		});
	}
	/******************************分页部分 End *********************************/
	
});
