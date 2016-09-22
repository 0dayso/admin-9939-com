<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$this->title['title'] =  $top['title'];
$this->title['keywords'] =  $top['keywords'];
$this->title['description'] =  $top['description'];

//主导航
echo $this->render("seek_main_nav");
?>
<!--左侧右侧-->
<?php
	echo $this->render("/include/rightFloat");
?>
<div class="content bocon">
	<div class="art_s"> 您所在的位置：<a href="http://www.9939.com/" target="_blank">久久健康网</a>><a href="<?php echo Url::home(true); ?>" target="_blank">疾病百科</a>><a><b>疾病症状</b></a></div>
</div>
<!--ends-->
    <div class="conter">
     <div class="mol">
         <div class="lw678 fl">
             <div class="filtrate" id="cond">
              <div class="condition clearfix"><a href="<?php echo Url::to('@jb_domain/jbzz/' , true)?>" target="_self" class="chose fr cor666">重置筛选条件 >></a><b class="nostle cor666 fl">筛选条件：</b>
				<div class="selected fl">
				<?php 
					if(!empty($key)){
				?>
					<span>关键词：<i><?php echo $key;?></i><a target="_self" href='<?php echo Url::to('@jb_domain/jbzz/', true) ?>'></a></span>
				<?php
					}
				?>
				<?php 
					if(!empty($partKey)){

				?>
					<span>部位：<i><?php echo $partKeyName;?></i><a target="_self" href='<?php echo Url::to('@jb_domain/jbzz/'.$departmentKey , true) ?>'></a></span>
				<?php
					}
				?>
				<?php 
					if(!empty($departmentKey)){

				?>
					<span>科室：<i><?php echo $departmentKeyName?></i><a target="_self" href='<?php echo Url::to('@jb_domain/jbzz/'.$partKey  , true) ?>'></a></span>
				<?php
					}
				?>
					<!--<span>科室：<i>五官科</i><a href=""></a></span>-->
				</div>
			  </div>
              <div class="one-floor part clearfix" style="z-index: 3">
                 <b class="mT10 fl">部 位：</b><span class="mT10 cor666 fl" <?php if($partKey==""){echo'style="color:#ff6600;font-weight:bold;"';}?>>不限</span>
                   <div class="allwords">
                     <div class="part-list part-list1  clearfix fl">
					<!--循环查询到的部位数据-->
					<?php
						foreach($part as $k =>$val){
							//判断是否有子集部位，如果有说明是查询的所有一级二级部位，否则是根据科室查询的关联部位
							if(!empty($val['level2'])){
								//判断当前是否有子集
								if($val['child']=='1'){
					 ?>
							<dl class="cur_mean  <?php if($partKey == $val['pinyin']){echo 'cur_on';}else if(!empty($keyList['partlevel1Id'])){ if($keyList['partlevel1Id'] == $val['id']){echo 'cur_on'; }}?> "><dt><a href="<?php if(!empty($departmentKey)){echo Url::to('@jb_domain/jbzz/' . $val['pinyin'] .'/'.$departmentKey , true);}else{echo Url::to('@jb_domain/jbzz/' . $val['pinyin'].'/' , true);} ?>" target="_self"><?php echo $val['name']?></a></dt>
							<dd style="z-index:100;">
							<!--循环一级分类下的二级分类-->
							<?php
								foreach($val['level2'] as $k1 =>$val1){
							?>
							<a href='<?php if(!empty($departmentKey)){echo Url::to('@jb_domain/jbzz/' . $val1['pinyin'] .'/'.$departmentKey.'/' , true);}else{echo Url::to('@jb_domain/jbzz/' . $val1['pinyin'].'/' , true);} ?>' target="_self"><?php echo $val1['name']?></a>
							<?php
								}
							?>
						</dd>
                    </dl>
					<?php
							}else{
					?>
						<div class="smeo <?php if($partKey == $val['pinyin']){echo 'cur_on';}?>"><a href="<?php if(!empty($departmentKey)){echo Url::to('@jb_domain/jbzz/' . $val['pinyin'] .'/'.$departmentKey.'/' , true);}else{echo Url::to('@jb_domain/jbzz/' . $val['pinyin'].'/' , true);} ?>" target="_self"><?php echo $val['name']?></a></div>
					<?php
							}
								}else{
					?>
							<div class="smeo <?php if($partKey == $val['pinyin']){echo 'cur_on';}?>"><a href="<?php if(!empty($departmentKey)){echo Url::to('@jb_domain/jbzz/' . $val['pinyin'] .'/'.$departmentKey.'/' , true);}else{echo Url::to('@jb_domain/jbzz/' . $val['pinyin'].'/' , true);} ?>" target="_self"><?php echo $val['name']?></a></div>
					<?php
								}
						}
					?>
                     <a class="point_more point_more3" href="javascript:void(0)" target="_self" hidefocus="true" onclick="point_more(this,1)" title="展开/收起" id="fold1"></a>
                 </div>
                   <div class="clear"></div>
                     
						<?php 
							if(!empty($keyList['partLevelList'])){
						?>
						<div class="obtained">
                          <b><?php if(!empty($keyList['firstClassData'])){ echo $keyList['firstClassData']['name'];}else{ echo $partKeyName;}?>：</b>
					    <?php
							foreach($keyList['partLevelList'] as $k =>$part){
								if($part['pinyin'] == $partKey){
					    ?>
                            <strong><?php echo $part['name'];?></strong> 
						<?php
								}else{
						?>
								<a href="<?php if(!empty($departmentKey)){echo Url::to('@jb_domain/jbzz/' . $part['pinyin'] .'/'.$departmentKey.'/' , true);}else{echo Url::to('@jb_domain/jbzz/' . $part['pinyin'].'/' , true);} ?>" target="_self"><?php echo $part['name']?></a>   
						<?php
								}
							}
						?>
						</div>
						<?php
							}
						?>
                      
                    </div>
                 </div>
              <div class="one-floor part clearfix" style="z-index: 3">
                 <b class="mT10 fl">科室：</b><span class="mT10 cor666 fl" <?php if($departmentKey==""){echo'style="color:#ff6600;font-weight:bold;"';}?>>不限</span>
                   <div class="allwords">
                     <div class="part-list part-list2  clearfix fl">
					<?php
						foreach($department as $k =>$val){
							if(!empty($val['level2'])){
								if($val['child']=='1'){
					?>
							<dl class="cur_mean  <?php if($departmentKey == $val['pinyin']){echo 'cur_on';}else if(!empty($keyList['partlevel1Id'])){ if($keyList['partlevel1Id'] == $val['id']){echo 'cur_on'; }}?> "><dt><a href="<?php if(!empty($partKey)){echo Url::to('@jb_domain/jbzz/' . $partKey .'/'.$val['pinyin'].'/' , true);}else{echo Url::to('@jb_domain/jbzz/' . $val['pinyin'].'/' , true);} ?>" target="_self"><?php echo $val['name']?></a></dt>
								<dd style="z-index:100;">
					<?php
							foreach($val['level2'] as $k1 =>$val1){
					?>
								<a href='<?php if(!empty($partKey)){echo Url::to('@jb_domain/jbzz/' . $partKey .'/'.$val['pinyin'].'/' , true);}else{echo Url::to('@jb_domain/jbzz/' . $val1['pinyin'].'/' , true);} ?>' target="_self"><?php echo $val1['name']?></a>
					<?php
							}
					?>
								</dd>
							</dl>
					<?php
							}else{
					?>
						<div class="smeo <?php if($departmentKey == $val['pinyin']){echo 'cur_on';}?>"><a href="<?php if(!empty($partKey)){echo Url::to('@jb_domain/jbzz/' . $partKey .'/'.$val['pinyin'].'/' , true);}else{echo Url::to('@jb_domain/jbzz/' . $val['pinyin'].'/' , true);} ?>" target="_self"><?php echo $val['name']?></a></div>
					<?php
								}
							}else{
					?>
						<div class="smeo <?php if($departmentKey == $val['pinyin']){echo 'cur_on';}?>"><a href="<?php if(!empty($partKey)){echo Url::to('@jb_domain/jbzz/' . $partKey .'/'.$val['pinyin'].'/' , true);}else{echo Url::to('@jb_domain/jbzz/' . $val['pinyin'].'/' , true);} ?>" target="_self"><?php echo $val['name']?></a></div>
					<?php
							}
						}
					?>
                     <a class="point_more point_more4" href="javascript:void(0)" target="_self" hidefocus="true" onclick="point_more(this,1)" title="展开/收起" id="fold1"></a>
                 </div>
                   <div class="clear"></div>
                     <?php 
							if(!empty($keyList['departementLevelList'])){
						?>
						<div class="obtained">
                          <b><?php if(!empty($keyList['firstClassData'])){ echo $keyList['firstClassData']['name'];}else{ echo $departmentKeyName;}?>：</b>
					    <?php
							foreach($keyList['departementLevelList'] as $k =>$depart){
								if($depart['pinyin'] == $departmentKey){
					    ?>
                            <strong><?php echo $depart['name'];?></strong> 
						<?php
								}else{
						?>
								<a href="<?php if(!empty($partKey)){echo Url::to('@jb_domain/jbzz/' . $partKey .'/'.$depart['pinyin'].'/' , true);}else{echo Url::to('@jb_domain/jbzz/' . $depart['pinyin'].'/' , true);} ?>" target="_self"><?php echo $depart['name']?></a>   
						<?php
								}
							}
						?>
						</div>
						<?php
							}
						?>
                    </div>
                 </div>
                 <div class="four-floor part online clearfix"><b class="fl">关键词：</b>
					<div class="fl">
						<form method="get" id='myform'  action="<?php echo Url::to('@jb_domain/jbzz/', true);?>">
							<input type="text" id='key' name="key" value="<?php echo $key;?>"  class="w229 fl" />
							
							<a class="tofind fl" id="soso" >查&nbsp;找</a>
							<div class="rcuro fl"></div></div></div>
						</form>
					
           </div>                                
             <div class="probsolv">
                  <ul class="catetab backb">
				  <li <?php if($typeId == ''){ echo 'class="current"';}?>>
					<a target="_self"  href="<?php  
								if(!empty($departmentKey)){
									if(!empty($partKey)){ 
										echo Url::to('@jb_domain/jbzz/' . $partKey . '/'.$departmentKey.'' , true); 
									}else{
										echo Url::to('@jb_domain/jbzz/'.$departmentKey.'' , true); 
									}
								}else if(!empty($partKey)){
									echo Url::to('@jb_domain/jbzz/'.$partKey , true); 
								}else if(!empty($key)){
									echo Url::to('@jb_domain/jbzz/?key='.$key , true); 
								}else{
									echo Url::to('@jb_domain/jbzz/' , true); 
								}
							  ?>">综 合</a>
				  
				  </li>
				  <li <?php if($typeId == 't1'){ echo 'class="current"';}?>>
					<a target="_self"  href="<?php  
								if(!empty($departmentKey)){
									if(!empty($partKey)){ 
										echo Url::to('@jb_domain/jbzz/' . $partKey . '/'.$departmentKey.'_t1/' , true); 
									}else{
										echo Url::to('@jb_domain/jbzz/'.$departmentKey.'_t1/' , true); 
									}
								}else if(!empty($key)){
									echo Url::to('@jb_domain/jbzz_t1/?key='.$key , true); 
								}else if(!empty($partKey)){
									echo Url::to('@jb_domain/jbzz/'.$partKey.'_t1/' , true); 
								}else{
									echo Url::to('@jb_domain/jbzz_t1/' , true); 
								}
							  ?>">疾 病
					</a>
				  </li>
				  <li <?php if($typeId == 't2'){ echo 'class="current"';}?>>
					<a target="_self" href="<?php  
								if(!empty($departmentKey)){
									if(!empty($partKey)){ 
										echo Url::to('@jb_domain/jbzz/' . $partKey . '/'.$departmentKey.'_t2/' , true); 
									}else{
										echo Url::to('@jb_domain/jbzz/'.$departmentKey.'_t2/' , true); 
									}
								}else if(!empty($key)){
									echo Url::to('@jb_domain/jbzz_t2/?key='.$key , true); 
								}else if(!empty($partKey)){
									echo Url::to('@jb_domain/jbzz/'.$partKey.'_t2/' , true); 
								}else{
									echo Url::to('@jb_domain/jbzz_t2/' , true); 
								}
							  ?>
							">症 状</a>
				  </li>
				</ul>
             <div id="tagContent">
               <div class="sbox">
			   <?php
				if(!empty($keyList['list'])){
						foreach($keyList['list'] as $k =>$val){
							if($val['source_flag']=='1'){
				?>
					 <div class="doc_anwer disline">
                   <div class="subtit dyh">
						<ul class="cor666 dst fr clearfix">
							<li><a href="<?php echo Url::to('@jb_domain/'.$val['pinyin_initial'].'/by/' , true);?>">病因</a></li>
							<li><span>|</span></li>
							<li><a href="<?php echo Url::to('@jb_domain/'.$val['pinyin_initial'].'/zz/' , true);?>">症状</a></li>
							<li><span>|</span></li>
							<li><a href="<?php echo Url::to('@jb_domain/'.$val['pinyin_initial'].'/lcjc/' , true);?>">检查</a></li>
							<li><span>|</span></li>
							<li><a href="<?php echo Url::to('@jb_domain/'.$val['pinyin_initial'].'/zl/' , true);?>">治疗</a></li>
							<li class="hostal" ><a href="http://hospital.9939.com/" >找医院</a></li>
							<li class="indoc"><a href="http://ask.9939.com/Asking/index/" >问医生</a></li>
						</ul>
                        <div class="cation fl">
							<h3 class="mr11 fl">
								<a href="<?php echo Url::to('@jb_domain/'.$val['pinyin_initial'].'/' , true);?>" title="<?php echo $val['name'];?>">
									<?php
										if(!empty($keyList['explain_words'])){
											echo $short_title = preg_replace("'({$keyList['explain_words']})'","<font style='color:red;'>$0</font>",$val['name']);	
										}else{
											echo $val['name'];
										}
									?>
								</a>
							</h3>
							<span class="lookwik  deisk fl">疾病</span>
						</div>
                   </div>
                   <div class="drawall">
                      <div class="doctext">
                        <p class="dst  f14m">		
                            <i></i><?php  
                                        $content = Html::encode($val['description']);
                                        echo String::cutString($content, 70, '...');
                                ?><a href="<?php echo Url::to('@jb_domain/'.$val['pinyin_initial'].'/' , true);?>">[详细]</a>
                        </p>
                      <div class="h20 mT19">
                        <div class="xgtag mT10 fl">
							<a class="txtno cor999">相关症状：</a>
							<?php
								foreach($val['relevance'] as $k1 =>$val1){
							?>
								<a href="<?php echo Url::to('@jb_domain/zhengzhuang/'.$val1['pinyin_initial'].'/' , true);?>" title="<?php echo $val1['name'];?>"><?php echo $val1['name'];?></a>|
							<?php
								}
							?>
						</div>
                       </div>  
                    </div>
                 </div>
                  <div class="clear"></div>
                 </div>
				 <?php
					}else{
				 ?>
				 <div class="doc_anwer disline">
                   <div class="subtit dyh">
						<ul class="cor666 dst fr clearfix">
							<li><a href="<?php echo Url::to('@jb_domain/zhengzhuang/'.$val['pinyin_initial'].'/zzqy/' , true);?>">病因</a></li>
							<li><span>|</span></li>
							<li><a href="<?php echo Url::to('@jb_domain/zhengzhuang/'.$val['pinyin_initial'].'/yufang/' , true);?>">预防</a></li>
							<li><span>|</span></li>
							<li><a href="<?php echo Url::to('@jb_domain/zhengzhuang/'.$val['pinyin_initial'].'/jiancha/' , true);?>">检查</a></li>
							<li><span>|</span></li>
							<li><a href="<?php echo Url::to('@jb_domain/zhengzhuang/'.$val['pinyin_initial'].'/shiliao/' , true);?>">食疗</a></li>
							<li class="hostal" ><a href="http://hospital.9939.com/" >找医院</a></li>
							<li class="indoc"><a href="http://ask.9939.com/Asking/index/" >问医生</a></li>
						</ul>
                        <div class="cation fl">
							<h3 class="mr11 fl">
								<a href="<?php echo Url::to('@jb_domain/zhengzhuang/'.$val['pinyin_initial'].'/' , true);?>" title="<?php echo $val['name'];?>">
                                                                    <?php 
                                                                        if(!empty($keyList['explain_words'])){
                                                                            echo $short_title = preg_replace("'({$keyList['explain_words']})'","<font style='color:red;'>$0</font>",$val['name']);	
                                                                        }else{
                                                                            echo $val['name'];
                                                                        }
                                                                    ?>
                                                                </a>
							</h3>
							<span class="lookwik fl">症状</span>
						</div>
                   </div>
                   <div class="drawall">
                      <div class="doctext">
                        <p class="dst  f14m">
							<i></i><?php  
										$content = Html::encode($val['description']);
										echo String::cutString($content, 70, '...');
									?><a href="<?php echo Url::to('@jb_domain/zhengzhuang/'.$val['pinyin_initial'].'/' , true);?>">[详细]</a>
						</p>
                      <div class="h20 mT19">
                        <div class="xgtag mT10 fl">
							<a class="txtno cor999">相关疾病:</a>
							<?php
								foreach($val['relevance'] as $k1 =>$val1){
							?>
								<a href="<?php echo Url::to('@jb_domain/'.$val1['pinyin_initial'].'/' , true);?>" title="<?php echo $val1['name'];?>"><?php echo $val1['name'];?></a>|
							<?php
								}
							?>
						</div>
                       </div>  
                    </div>
                 </div>
                  <div class="clear"></div>
                 </div>
				<?php
						}
					}
					
				}else{
				?>
				  <div id="tagContent">
				   <div class="sbox">
					<div class="noresult"><p>很抱歉，暂未找到符合条件的信息，请<a href="<?php echo Url::to('@jb_domain/jbzz/', true); ?>" class="submol">重置筛选条件</a></p></div>
				  </div></div>
				<?php
				}
				?>
                 <div class="paget paint"><?php $paging->view_2($partKey,$departmentKey,$typeId); ?></div>

              </div>
			<!--循环结束 end-->
              </div>

              </div>
           </div>
         <?php
		echo $this->render("/seek/seek_right",['latestFucus' => $latestFucus]);
	?>
     <div class="clear"></div>
    </div>
<!--疾病症状页底部广告位-->
  <div class="picture clearfix">
		<?php
			echo $this->render("ads_bottom");
		?>
  </div>
    </div>
    <script type="text/javascript">
	 var li = document.getElementById('cond').getElementsByTagName('dl');
     for (var i = 0; i < li.length; i++) {
        li[i].onmouseover = function () { this.className = this.className + ' cur_mosw' + ((this.offsetLeft <350) ? '' : ' cur_mosw2'); };
        li[i].onmouseout = function () { var _class = this.className.replace(/ ?cur_mosw2?/g, ''); this.className = _class; };
    };
</script>
<script>
	$('#soso').click(function(){
		var key = $("#key").val()
		var myReg = /^[\u4e00-\u9fa5]+$/;
		if(key==""){
			return false;
		}else{
			//if (myReg.test(key)) {
				
			 //}
			$('#myform').submit();
		}
	});
	/*document.onkeydown = function(event) {  
            var target, code, tag;  
            if (!event) {  
                event = window.event; //针对ie浏览器  
                target = event.srcElement;  
                code = event.keyCode;  
                if (code == 13) {  
                    tag = target.tagName;  
                    if (tag == "TEXTAREA") { return true; }  
                    else { return false; }  
                }  
            }  
            else {  
                target = event.target; //针对遵循w3c标准的浏览器，如Firefox  
                code = event.keyCode;  
                if (code == 13) {  
                    tag = target.tagName;  
                    if (tag == "INPUT") { return false; }  
                    else { return true; }  
                }  
            }  
        };  */
</script>