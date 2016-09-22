<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->context->setLayout('loginmaster');
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
            
<div class="sliban">
    <div id="warp">
        <!-- 滚动图片 -->
        <div id="slides" class="banner">
            <div class="bannerImg">
                <div class="slides_container">
                    <div id="banner_pic_1"  data-bg-color="index_bg01"><a href="javascript:" target="_self"><img alt="" src="<?php echo Url::to('@domain/images/banner01.jpg'); ?>" width="754" height="537"></a></div>
                    <div style="display: none" id="banner_pic_2" data-bg-color="index_bg02"><a href="javascript:" target="_self"><img alt="" src="<?php echo Url::to('@domain/images/banner02.jpg'); ?>" width="754" height="537"></a></div>
                    <div style="display: none" id="banner_pic_3" data-bg-color="index_bg03"><a href="javascript:" target="_self"><img alt="" src="<?php echo Url::to('@domain/images/banner03.jpg'); ?>" width="754" height="537"></a></div>
                </div>
            </div>
        </div>
        <!-- 滚动图片 -->
    </div>
    <div class="urlog">
        <h3>用户登录</h3>
        <form  class="frla"  action="/site/login" method="post">
                <?php echo Html::textInput("LoginForm[username]",$model->username,array('id'=>'username','placeholder'=>'用户名','class'=>'txt'));?>
           
                <?php echo Html::passwordInput('LoginForm[password]',$model->password,array('id'=>'password','placeholder'=>'密码','class'=>'pass'));?>
           
                <?php echo Html::textInput('LoginForm[verifycode]','',array('id'=>'verifycode','placeholder'=>'请输入右侧验证码','class'=>'tchec')); ?>
                <div class="checo verify-code" style="top:156px">
                <?php
                $url = '/site/captcha';
                echo "<a href='javascript:' onclick='javascript:return refreshcode();' >" . Html::img ( $url,  array (
                        'id' => 'img_code',
                        'style' => 'height:35px;' 
                ) ) . "</a>";
                ?>
                </div> 
                <div class="error">
                    <?php 
                        $errors = $model->getFirstErrors();
                        if(count($errors)>0){
                    ?>
                        <p  class="ts">
                            <?php echo $model->getFirstError('username');?>
                            <?php echo $model->getFirstError('password');?>
                            <?php echo $model->getFirstError('verifycode');?>
                        </p>
                    <?php } ?>
                </div>
                <?php echo Html::submitButton('',array('class'=>'subs','value'=>'登录')); ?>
        </form>
        
        <script type="text/javascript" language="javascript">
            $(function () {
                 //保证导航栏背景与图片轮播背景一起显示
                $("#mainbody").removeClass();
                $("#mainbody").addClass("index_bg01");
                //滚动Banner图片的显示
                $('#slides').slides({
                    preload: false,
                    preloadImage: '<?php echo Url::to('@domain/images/loading.gif'); ?>',
                    effect: 'fade',
                    slideSpeed: 400,
                    fadeSpeed: 100,
                    play: 3000,
                    pause: 100,
                    hoverPause: true,
                    animationComplete:function(current){
                        if($("#banner_pic_"+(current)).find("img").length > 0){
                            $("#mainbody").removeClass();
                            var index = current;
                            var banner_index_bg ="index_bg0"+index;
                            $("#mainbody").addClass(banner_index_bg);
                        }
                    }
                });
                $('#js-news').ticker();
            });
            function  refreshcode(){
                var imgObj = $("#img_code");
                var urlArr = $(imgObj).attr("src").split("?");
                var url = urlArr[0]+"?refresh="+Math.random();
                $.ajax({
                     url: url,
                     dataType: 'json',
                     cache: false,
                     success: function(data) {
                         $(imgObj).attr('src', data['url']);
                     }
                });
                return false;
            }   
        </script>
    </div> 
</div>

    