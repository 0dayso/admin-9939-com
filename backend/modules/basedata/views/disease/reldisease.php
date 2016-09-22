<?php
use yii\helpers\Url;
?>
<!--疾病弹出 开始-->
	<div class="d-list-form">
		<div class="d-titr  d-grew">
			<a href="javascript:;" class="d-errtu" id = "reldis_close">
			<img src="<?php echo Url::to('@domain/images/d-wor.png')?>" /></a>
			<h3>疾病分类管理——编辑疾病——相关疾病</h3>
		</div>

		<form class="disin fosub infc" action="" method="post" id="reldisForm">
			<label>一级科室：</label>
			<select class="level" name="reldis_class_level1" id = "reldis_class_level1">
				<option value="0">一级科室</option>
				<?php 
				if (isset($class_level1s) && !empty($class_level1s)) {
					foreach ($class_level1s as $class_level1){
				?>
				<option value="<?php echo $class_level1['id'];?>"><?php echo $class_level1['name'];?></option>
				<?php 		
					}
				}
				?>
			</select> 
			<label>二级科室：</label>
			<select class="level" name="reldis_class_level2" id="reldis_class_level2"></select> 
			<label>疾病名称：</label>
			<input type="text" value="" class="dina dindex" name="dis_name" id = "reldis_diseaseName">
			<a href="javascript:;" id = "reldis_search">搜索</a>
		</form>

		<!-- 新增部分 ajax Start -->
		<div id="rel_disease_data">
			<!--表格 开始-->
			<table width="990" border="1" cellspacing="0">
				<thead class="ells-four" id = "reldis_head" >
				<tr>
					<th>全部<input class="d-asrl" type="checkbox" data-type = "checkbox" /></th>
					<th>序号</th>
					<th>ID</th>
					<th>疾病名称</th>
				</tr>
				</thead>
				<tbody class="ddf" id = "reldis_tbody"></tbody>
			</table>
			<!--表格 结束-->
			<div class="d-kodrl">
				<a href="javascript:;" class="d-save-elec" id = "reldis_save">保存选择</a>
				<a href="javascript:;" class="d-sr-elec" id = "reldis_cancel">取消选择</a>
			</div>
			<div class="paget" id="reldis_paget">
				<?php echo $pageHTML; ?>
			</div>
		</div>
		<!-- 新增部分 ajax End -->
	</div>
	

<script type="text/javascript" src="<?php echo Url::to('@domain/js/disease/add_reldis.js')?>"></script>
