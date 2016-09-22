<?php
use yii\helpers\Url;
$this->title = "添加疾病";
?>

<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/js/uploadify/uploadify.css')?>"/>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/uploadify/jquery.uploadify.min.js')?>"></script>

<div class="dis-bread">
	<a href="<?php echo Url::to('@domain');?>">首页</a>>
    <a href="<?php echo Url::to(['/basedata/default/index']) ?>">基础数据</a>>
    <a href="<?php echo Url::to(['/basedata/disease/'])?>">疾病管理</a>>
	<a href="javascript:;" class="bolde">添加疾病</a>
</div>

<div class="dis-main">
	<div class="d-titr">
		<a href="<?php echo Url::to(['/basedata/disease/'])?>">返回</a>
		<h3>添加疾病</h3>
	</div>
	<form class="edito" action="<?php echo Url::to(['/basedata/disease/insert']);?>" method="post" id = "addDis">
		<div>
			<label><span>*</span>疾病名称：</label>
			<input type="text" class="txco" name="disease[name]"  data-require = "true" data-label = "疾病名称" id = "diseaseName"><b>注：文章长度不得长于25个字</b>
		</div>
		<div>
			<label><span style="color: #fff;">*</span>疾病别名：</label>
			<input type="text" class="txco" name="disease[alias]">
			<!-- <a class="add">添加</a> -->
		</div>
		
		<!-- 科室部分 Start -->
		<div class="visla">
			<label><span>*</span>所属科室：</label>
			<div class="clasfi">
				<input type="text" class="selec" value="一级科室"><a class="dome"></a>
				<div class="specs" style="overflow: visible;">
					<div class="s_titl">
						<b>请选择科室</b>（选择科室专家能更快为您解答）
					</div>
					<div class="choho">
						<div class="brasho">
							您选择的科室：
								<a href="javascript:;" data-id = "0" id = "class_level1a"></a> 
								<a>></a> 
								<a href="javascript:;" data-id = "0" id = "class_level2a"></a>
						</div>
						<ul class="fihou">
							<li id = "class_level1">
								<dl>
									<dt>一级科室</dt>
									<?php 
										if (isset($class_level1s) && !empty($class_level1s)) {
											foreach ($class_level1s as $class_level1){
									?>
									<dd>
										<a data-id = "<?php echo $class_level1['id'];?>" ><?php echo $class_level1['name'];?></a>
									</dd>
									<?php 			
											}
										}
									?>
								</dl>
							</li>
							<li id = "class_level2">
								<dl>
								</dl>
							</li>
						</ul>
						<div class="other">
							<a href="javascript:;" id = "sureClass">确 定</a>
						</div>
					</div>
					<a class="closb"></a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div>
			<label><span style="color:#fff;">*</span>已选科室：</label>
			<div class="hasad blood" id = "selectedDep"></div>
		</div>
		<input type="hidden" name="diseaseDepartment" id = "diseaseDepartment" value=""  data-require = "true" data-label = "所属科室"   />
		<!-- 科室部分 End -->
		
		<div>
			<label><span>*</span>相关疾病：</label>
			<a class="add admale d-pop-dow" id = "addReldisease">添加</a>
			<b class="lema">注：添加相关疾病内容</b>
		</div>
    	<div class="hasad" id = "reldis_selects"></div>
		<input type="hidden" name="diseaseDisease" id="diseaseDisease" value="" data-require = "true" data-label = "相关疾病"  />
        <input type="hidden" name="disease[rel_disease]" id="diseaseForDisease" value="" data-require = "true" data-label = "相关疾病"  />
		
		<div>
			<label><span>*</span>相关症状：</label>
			<a class="add admale d-pop-up" id="addRelsymptom">添加</a>
			<b class="lema">注：添加相关症状内容</b>
		</div>
    	<div class="hasad" id = "relsym_selects"></div>
		<input type="hidden" name="diseaseSymptom" id="diseaseSymptom" value="" data-require = "true" data-label = "相关症状"  />
		<input type="hidden" name="disease[typical_symptom]" id="diseaseForSymptom" value="" data-require = "true" data-label = "相关症状"  />
		
		<!-- 上传图片 Start -->
		<div class="scal">
			<label><span>*</span>疾病图集：</label>
			<input type="file" name="file_upload" id="file_upload" />
			<b class="conc" style="position:absolute; top:0px; left:150px;">注：选中图为头图，图片不能大于1M</b>
			<input type="hidden" value="1215154" name="tmpdir" id="id_file">
			<ul class="imop" id = "selectedImages">
				<?php 
				if (isset($diseaseAndRel['diseaseImage']) && !empty($diseaseAndRel['diseaseImage'])) {
					foreach ($diseaseAndRel['diseaseImage'] as $image){
						$name = strstr($image['name'], ".", true);
				?>
				<li>
					<input type="checkbox" value="<?php echo $image['name'];?>">
					<img src="<?php echo Url::to('@domain/uploads/' . $image['name']);?>" alt="<?php echo $image['name'];?>">
					<b id="<?php echo $name;?>" data-id = "<?php echo $image['name'];?>"></b>
				</li>
				<?php 		
					}
				}
				?>
			</ul>
			<div class="clear"></div>
		</div>
		<input type="hidden" name="diseaseImage" id = "diseaseImage" value="" data-require = "true" data-label = "疾病图集" ><br/>
		<input type="hidden" name="files" id="files" value="" />
		<!-- 上传图片 End -->
		
		<div>
			<label><span style="color: #fff;">*</span>就诊科室：</label>
			<input type="text" class="txco" id = "diseaseTreatIn">
			<a href="javascript:;" class="add" id = "diseaseTreatAdd">添加</a>
		</div>
		<div class="hasad" id = "diseaseTreatSeleted"></div>
		<input type="hidden" name="disease[treat_department]" id="diseaseTreat" value="" />
		
		<div>
			<label class="desc"><span>*</span>概<em></em>述：</label>
			<textarea class="txtar" name="disease[description]" data-require = "true" data-label = "概述" ></textarea>
		</div>
		<div>
			<label class="desc"><span>*</span>描述内容：</label>
			<textarea class="txtar" name="diseaseContent[content]" data-require = "true" data-label = "描述内容" ></textarea>
		</div>
		<div>
			<label class="desc"><span>*</span>原<em></em>因：</label>
			<textarea class="txtar" name="diseaseContent[cause]" data-require = "true" data-label = "原因" ></textarea>
		</div>
		<div>
			<label class="desc"><span>*</span>症<em></em>状：</label>
			<textarea class="txtar" name="diseaseContent[symptom]" data-require = "true" data-label = "症状" ></textarea>
		</div>
		<div>
			<label class="desc"><span>*</span>饮<em></em>食：</label>
			<textarea class="txtar" name="diseaseContent[food]" data-require = "true" data-label = "饮食" ></textarea>
		</div>
		<div>
			<label class="desc"><span>*</span>预<em></em>防：</label>
			<textarea class="txtar" name="diseaseContent[prevent]" data-require = "true" data-label = "预防" ></textarea>
		</div>
		<div>
			<label class="desc"><span>*</span>治疗内容：</label>
			<textarea class="txtar" name="diseaseContent[treat]" data-require = "true" data-label = "治疗内容" ></textarea>
		</div>
		<div>
			<label class="desc"><span>*</span>检 查 项：</label>
			<textarea class="txtar" name="diseaseContent[inspect_item]" data-require = "true" data-label = "检查项" ></textarea>
		</div>
		<div>
			<label class="desc"><span>*</span>检查内容：</label>
			<textarea class="txtar" name="diseaseContent[inspect]" data-require = "true" data-label = "检查内容" ></textarea>
		</div>
		<div>
			<label><span>*</span>诊断鉴别：</label>
			<textarea class="txtar" name="diseaseContent[diagnosis]" data-require = "true" data-label = "诊断鉴别" ></textarea>
		</div>
		<div>
			<label><span>*</span>常用药物：</label>
			<textarea class="txtar" name="diseaseContent[medicine]" data-require = "true" data-label = "常用药物" ></textarea>
		</div>
		<div>
			<label><span>*</span>并 发 症：</label>
			<textarea class="txtar" name="diseaseContent[neopathy]" data-require = "true" data-label = "并发症" ></textarea>
		</div>
		<div>
			<label><span>*</span>易感人群：</label>
			<textarea class="txtar" name="diseaseContent[yiganrenqun]" data-require = "true" data-label = "易感人群" ></textarea>
		</div>
		<div>
			<label><span>*</span>传染方式：</label>
			<textarea class="txtar" name="diseaseContent[chuanranfangshi]" data-require = "true" data-label = "传染方式" ></textarea>
		</div>
		<div>
			<label><span>*</span>治疗方式：</label>
			<textarea class="txtar" name="diseaseContent[treatment]" data-require = "true" data-label = "治疗方式" ></textarea>
		</div>

		<input type="hidden" name="saveDisease" value="" id = "saveDisease"/>
	</form>

	<div class="savea">
		<a href="javascript:;" id="save">保存</a>
		<a href="javascript:;" class="sagai" id="generate">保存并生成</a>
	</div>

</div>

<!-- 相关疾病弹出 Start-->
<div class="qbwrt qbwrt_shn" style="display: none;" id = "reldiseaseBlock"></div>
<!-- 相关疾病弹出 End-->

<!-- 相关症状弹出 Start-->
<div class="qbwrt qbwrt_sh" style=" display:none;" id = "relsymptomBlock"></div>
<!-- 相关症状弹出 End-->

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script>
    <?php $sign = \Yii::$app->params['uploadPath']['disease']['api_id']; ?>
    img_upload_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/index/','category'=>'disease', 'sign'=>$sign]);?>';
    img_delete_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/delete/','category'=>'disease', 'sign'=>$sign]);?>';
</script>

<script type="text/javascript" src="<?php echo Url::to('@domain/js/disease/upload.js')?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/disease/add.js')?>"></script>

