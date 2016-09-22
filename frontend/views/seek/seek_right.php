<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<div class="rw298 fr">
		 <?php
			echo $this->render("ads_right_top");
		 ?>
		<?PHP
			echo $this->render("seek_attention");
		?>
            <div class="build two">
           <h4 class="gre-arrow">热门关注</h4>
            <div class="two-block btline mT18">
              <div class="ls-hot"><img src="/images/ls-hot.gif"/></div>
			  <?php
					$latestFucus1 = array_slice($latestFucus,0,1);
					foreach($latestFucus1 as $k=>$val){
				?>
					<div class="hocdes">
						<a href="<?php echo $val[0]['url'];?>" class="hot-pic fl">
							<img  src="/images/gxy.jpg" style="width:80px;height:70px;"/>
						</a>
						<div class="w172 fl">
							<h4><a href="<?php echo $val[0]['url'];?>" title="高血压">高血压</a></h4>
							<p class="hmol cor666">
								<?php 
									$content = Html::encode($val[0]['description']);
									echo String::cutString($content, 20, '...');
								?><a href="<?php echo $val[0]['url'];?>">[详细]</a>
							</p>
						</div>
					</div>
				<?php
						}
				?>
				<?php
					$latestFucus3 = array_slice($latestFucus,1,1);
					foreach($latestFucus3 as $k2=>$val2){
				?>
					<div class="hocdes mT20">
						<a href="<?php echo $val2[0]['url'];?>" class="hot-pic fl">
							<img  src="/images/xzb.png" style="width:80px;height:70px;"/>
						</a>
						<div class="w172 fl">
							<h4><a href="<?php echo $val2[0]['url'];?>" title="心脏病">心脏病</a></h4>
							<p class="hmol cor666">
								<?php 
									$content = Html::encode($val2[0]['description']);
									echo String::cutString($content, 20, '...');
								?><a href="<?php echo $val2[0]['url'];?>">[详细]</a>
							</p>
						</div>
					</div>
				<?php
						}
				?>
                <ul class="spul er_news">
				<!--循环热门关注-->

					<?php
						$latestFucus2 = array_slice($latestFucus,2);	
						foreach($latestFucus2 as $k1=>$val1){
					?>
                    <li>
						<span><a href="<?php echo $val1[0]['url'];?>" title="<?php echo $k1;?>">[<?php echo $k1;?>]</a></span>
						<a href="<?php echo $val1[0]['url'];?>" title="<?php echo $val1[0]['title'];?>">
							<?php 
								$content = Html::encode($val1[0]['title']);
								echo String::cutString($content, 12, '...');
							?>
						</a>
					</li>
					<?php
						}	
					?>
               </ul>
            </div>
        </div>
           <?php
				echo $this->render('seek_zhuanti');					
		   ?>
            <div class="clumn">
				<?php
					echo $this->render('ads_right_center');					
			   ?>
			</div>
            <div class="build four">
            <h4 class="gre-arrow intho"><a href="http://hospital.9939.com">更多&gt;&gt;</a>找医院</h4>
            <div class="four-block two-block btline mT18 clearfix">
                 <ul class="hospul">
                     <li><a href="http://hospital.9939.com/hosp/272446/index.shtml" title="北京协和医院北院">北京协和医院北院</a>|<span>三级甲等</span></li>
                     <li><a href="http://hospital.9939.com/hosp/20461/index.shtml" title="北京仁和医院">北京仁和医院</a>|<span>二级甲等</span></li>
                     <li><a href="http://hospital.9939.com/hosp/19879/index.shtml" title="武警北京市总队第二医院">武警北京市总队第二医院</a>|<span>三级甲等</span></li>
                     <li><a href="http://hospital.9939.com/hosp/19925/index.shtml" title="北京大学人民医院">北京大学人民医院</a>|<span>三级甲等</span></li>
                     <li><a href="http://hospital.9939.com/hosp/19931/index.shtml" title="北京市肛肠医院">北京市肛肠医院</a>|<span>二级甲等</span></li>
                     <li><a href="http://hospital.9939.com/hosp/20362/index.shtml" title="武警总医院">武警总医院</a>|<span>三级甲等</span></li>
                     <li><a href="http://hospital.9939.com/hosp/20425/index.shtml" title="北京回龙观医院">北京回龙观医院</a>|<span>三级甲等</span></li>
                     <li><a href="http://hospital.9939.com/hosp/20430/index.shtml" title="北京民康医院">北京民康医院</a>|<span>二级甲等</span></li>
					 <li><a href="http://hospital.9939.com/hosp/20413/index.shtml" title="北京民康医院">北京民康医院</a>|<span>二级甲等</span></li>
					 <li><a href="http://hospital.9939.com/hosp/20430/index.shtml" title="北京市房山区第一医院">北京市房山区第一医院</a>|<span>二级甲等</span></li>
               </ul>
               
            </div>
        </div>
            <div class="build five">
            <h4 class="gre-arrow intho"><a href="http://yisheng.9939.com/">更多&gt;&gt;</a>找医生</h4>
            <div class="five-block two-block btline mT18 clearfix">
               <ul class="spul er_news amar">
                    <li>
						<span>
							<a href="http://ask.9939.com/classid/32/" title="内科">[内科]</a>
						</span>
						<a href="http://ask.9939.com/classid/33/" title="心血管内科">心血管内科</a>
						<a href="http://ask.9939.com/classid/69/" title="神经内科">神经内科</a>
						<a href="http://ask.9939.com/classid/77/" title="呼吸内科">呼吸内科</a>
					</li>
					
                     <li>
						<span>
							<a href="http://ask.9939.com/classid/102/" title="外科">[外科]</a>
						</span>
						<a href="http://ask.9939.com/classid/103/" title="骨科">骨科</a>
						<a href="http://ask.9939.com/classid/118/" title="泌尿外科">泌尿外科</a>
						<a href="http://ask.9939.com/classid/149/" title="肛肠科">肛肠科</a>
					</li>

                    <li>
						<span><a href="http://ask.9939.com/classid/220/" title="男科">[男科]</a></span>
						<a href="http://ask.9939.com/classid/221/" title="性功能科">性功能科</a>
						<a href="http://ask.9939.com/classid/232/" title="前列腺科">前列腺科</a> 
					</li> 
					
                     <li>
						<span><a href="http://ask.9939.com/classid/193/" title="妇产科">[妇产科]</a></span>
						<a href="http://ask.9939.com/classid/194/" title="妇科">妇科</a>
						<a href="http://ask.9939.com/classid/208/" title="产科">产科</a>
						<a href="http://ask.9939.com/classid/219/" title="避免流产">避免流产</a>
					</li> 

                    <li>
						<span><a href="http://ask.9939.com/classid/523/" title="皮肤性病科">[皮肤性病科]</a></span>
						<a href="http://ask.9939.com/classid/339/" title="皮肤科">皮肤科</a>
						<a href="http://ask.9939.com/classid/331/" title="性病科">性病科</a> 
					</li> 
                    <li>
						<span><a href="http://ask.9939.com/classid/236/" title="儿科">[儿科]</a></span>
						<a href="http://ask.9939.com/classid/237/" title="小儿内科">小儿内科</a>
						<a href="http://ask.9939.com/classid/256/" title="小儿外科">小儿外科</a>
						<a href="http://ask.9939.com/classid/264/" title="新生儿科">新生儿科</a>
					</li> 

                    <li>
						<span><a href="http://ask.9939.com/classid/276/" title="五官科">[五官科]</a></span>
						<a href="http://ask.9939.com/classid/277/" title="眼科">眼科</a><a href="http://ask.9939.com/classid/284/" title="耳鼻喉科">耳鼻喉科</a>
						<a href="http://ask.9939.com/classid/291/" title="口腔科">口腔科</a>
					</li>      
                    <li>
						<span><a href="http://ask.9939.com/classid/428/" title="中医科">[中医科]</a></span>
						<a href="http://ask.9939.com/classid/429/" title="中医内科">中医内科</a>
						<a href="http://ask.9939.com/classid/430/" title="中医外科">中医外科</a>
						<a href="http://ask.9939.com/classid/431/" title="妇科">妇科</a>
					</li> 
					 
                    <li>
						<span><a href="http://ask.9939.com/classid/324/" title="传染病科">[传染病科]</a></span>
						<a href="http://ask.9939.com/classid/325/" title="肝病">肝病</a>
						<a href="http://ask.9939.com/classid/364/" title="寄生虫">寄生虫</a>
						<a href="http://ask.9939.com/classid/350/" title="传染病">传染病</a>
					</li>   
					 
                    <li>
						<span><a href="http://ask.9939.com/classid/371/" title="肿瘤科">[肿瘤科]</a></span>
						<a href="http://ask.9939.com/classid/375/" title="化疗">化疗</a>
						<a href="http://ask.9939.com/classid/374/" title="肿瘤放疗">肿瘤放疗</a>
						<a href="http://ask.9939.com/classid/372/" title="肿瘤介入">肿瘤介入</a>
					</li>    

                    <li>
						<span><a href="http://ask.9939.com/classid/299/" title="整形美容">[整形美容]</a></span>
						<a href="http://ask.9939.com/classid/315/" title="全身">全身</a>
						<a href="http://ask.9939.com/classid/307/" title="头部">头部</a>
						<a href="http://ask.9939.com/classid/302/" title="皮肤">皮肤</a>
					</li>   

                    <li>
						<span><a href="http://ask.9939.com/classid/525/" title="心理科">[心理科]</a></span>
						<a href="http://ask.9939.com/classid/525/" title="心理咨询">心理咨询</a>
						<a href="http://ask.9939.com/classid/248/" title="小儿心理">小儿心理</a><a href="http://ask.9939.com/classid/9/">职业病</a>
					</li> 

                    <li>
						<span><a href="http://ask.9939.com/classid/3/" title="健康专区">[健康专区]</a></span>
						<a href="http://ask.9939.com/classid/22/" title="亚健康">亚健康</a>
						<a href="http://ask.9939.com/classid/11/" title="母婴">母婴</a>
						<a href="http://ask.9939.com/classid/8/" title="饮食营养">饮食营养</a>
					</li>       
               </ul>
            </div>
        </div>
            <div class="build six">
            <h4 class="gre-arrow">猜你喜欢</h4>
             <div class="clumn btline mT18">
				 <?php
					echo $this->render("ads_right_bottom");
				 ?>
			 </div>
        </div>
      </div>