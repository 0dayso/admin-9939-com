	
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

		<tbody class="ddf" id = "relsym_tbody">
		<?php
		if (isset($relsymptomArr) && !empty($relsymptomArr)) {
			foreach ($relsymptomArr as $key => $relsymptom){
				?>
				<tr>
					<td><input type="checkbox" value="<?php echo $relsymptom['id'];?>" data-name = "<?php echo $relsymptom['name'];?>"/></td>
					<td><?php echo $key + 1;?></td>
					<td><?php echo $relsymptom['id'];?></td>
					<td><a href=""><?php echo $relsymptom['name'];?></a></td>
				</tr>
				<?php
			}
		}
		?>
		</tbody>
	</table>
	<!--表格 结束-->

	<div class="d-kodrl">
		<a href="javascript:;" class="d-save-elec" id = "relsym_save">保存选择</a>
		<a href="javascript:;" class="d-sr-elec" id = "relsym_cancel">取消选择</a>
	</div>

	<div class="paget" id="paget">
		<?php echo $pageHTML; ?>
	</div>
