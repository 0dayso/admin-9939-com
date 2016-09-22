	
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
		<tbody class="ddf" id = "reldis_tbody">
		<?php
		if (isset($reldiseaseArr) && !empty($reldiseaseArr)) {
			foreach ($reldiseaseArr as $key => $reldisease){
				?>
				<tr>
					<td><input type="checkbox" value="<?php echo $reldisease['id'];?>" data-name = "<?php echo $reldisease['name'];?>"/></td>
					<td><?php echo $key + 1;?></td>
					<td><?php echo $reldisease['id'];?></td>
					<td><a href=""><?php echo $reldisease['name'];?></a></td>
				</tr>
				<?php
			}
		}
		?>
		</tbody>
	</table>
	<!--表格 结束-->
	<div class="d-kodrl">
		<a href="javascript:;" class="d-save-elec" id = "reldis_save">保存选择</a>
		<a href="javascript:;" class="d-sr-elec" id = "reldis_cancel">取消选择</a>
	</div>
	<div class="paget" id="paget">
		<?php echo $pageHTML; ?>
	</div>
	</div>
