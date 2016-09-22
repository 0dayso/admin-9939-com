<?php
use yii\helpers\Url;
?>

<div class="d-list-form">
	<div class="d-titr  d-grew">
		<a href="javascript:;" class="d-errtu" id = "relsym_close">
		<img src="<?php echo Url::to('@domain/images/d-wor.png')?>" /></a>
		<h3>疾病管理——添加疾病——相关症状</h3>
	</div>

	<form class="disin fosub infc" action="" method="post" id="relsymForm">
		<label>一级部位：</label>
		<select class="level" name="relsym_part_level1" id = "relsym_part_level1">
			<option value="0">一级部位</option>
				<?php
				if (isset($part_level1s) && !empty($part_level1s)) {
					foreach ($part_level1s as $part_level1){
				?>
				<option value="<?php echo $part_level1['id'];?>"><?php echo $part_level1['name'];?></option>
				<?php
					}
				}
				?>
		</select>
		<label>二级部位：</label>
		<select class="level" name="relsym_part_level2" id = "relsym_part_level2"></select>
		<label>症状名称：</label>
		<input type="text" value="" class="dina dindex" name="sym_name" id = "relsym_symptomName">
		<a href="javascript:;" id = "relsym_search">搜索</a>
	</form>

	<!-- 新增部分 ajax Start -->
	<div id="rel_symptom_data">
		<!--表格 开始-->
		<table width="990" border="1" cellspacing="0">
			<thead class="ells-four" id = "relsym_head">
			<tr>
				<th>全部<input class="d-asrl" type="checkbox" data-type="checkbox" /></th>
				<th>序号</th>
				<th>ID</th>
				<th>症状名称</th>
			</tr>
			</thead>

			<tbody class="ddf" id = "relsym_tbody"></tbody>
		</table>
		<!--表格 结束-->

		<div class="d-kodrl">
			<a href="javascript:;" class="d-save-elec" id = "relsym_save">保存选择</a>
			<a href="javascript:;" class="d-sr-elec" id = "relsym_cancel">取消选择</a>
		</div>

		<div class="paget" id="relsym_paget">
			<?php echo $pageHTML; ?>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?php echo Url::to('@domain/js/disease/add_relsym.js')?>"></script>
