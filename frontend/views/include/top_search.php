<?php
use yii\helpers\Url;
?>
	<!-- 头部---问答 Start -->
    
    <div class="my_sec art_fo">
      <div class="my_sec art_fo">
        <div class="zTw a_inq"><a href="http://ask.9939.com/Ask/"><span>免费问医</span></a></div>
        <div class="fosy">
            <div class="list_login art_ser">
              <form id="bdcs-search-form" method="get" action="<?php echo Url::to('@jb_domain',true);?>/jbzz/">
                <!--<input type="hidden" value="17952251780120224976" name="s"/>
                <input type="hidden" value="1" name="entry"/>-->
                <input type="text" onFocus="if(this.value=='请输入疾病、症状名')this.value=''" onBlur="if(this.value=='')this.value='请输入疾病、症状名'" value="请输入疾病、症状名" id="bdcs-search-form-input" class="ztLt a_add" name="key" autocomplete="off"/>
                <input type="submit" value="搜索" id="bdcs-search-form-submit" class="ztRbtn"/>
              </form>
              </div>
          <p>
			<a href="<?php echo Url::to("@jb_domain",true);?>/tnb/">糖尿病</a>
			<a href="<?php echo Url::to("@jb_domain",true);?>/rxzs/">乳腺增生</a>
			<a href="<?php echo Url::to("@jb_domain",true);?>/gxb/">冠心病</a>
			<a href="<?php echo Url::to("@jb_domain",true);?>/xc/">哮喘</a>
			<a href="<?php echo Url::to("@jb_domain",true);?>/gxy/">高血压</a>
			<a href="<?php echo Url::to("@jb_domain",true);?>/szkb/">手足口病</a>
			<a href="<?php echo Url::to("@jb_domain",true);?>/gjml/">宫颈糜烂</a>
		  </p>
        
        </div>
      </div>
    </div>
<script>
	$('#bdcs-search-form-submit').click(function(){
		var key = $("#bdcs-search-form-input").val()
		var myReg = /^[\u4e00-\u9fa5]+$/;
		if(key=="" || key=='请输入疾病、症状名' ){
			return false;
		}else{
			$('#bdcs-search-form').submit();
		}
	});
</script>
    <!-- 头部---问答 End --> 