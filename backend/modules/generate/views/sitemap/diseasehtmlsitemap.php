
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站地图</title>
<meta name="keywords" content="" />
<meta name="Description" content="" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Cache" content="no-cache">
<link href="/map/css/layout_v1.0.css?v=2015090710" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/map/js/sitemap.js?v=2015090610"></script>
<!--[if lte IE 6]>
<script src="sitemap/js/DD_belatedPNG_0.0.8a.js?v=20150906.10" type="text/javascript"></script>
<script type="text/javascript">        
    DD_belatedPNG.fix('div, ul, img, li, input, a, span, i, p, b');    
</script>
<![endif]-->
<script type="text/javascript">
function loadFollowSiderBar() {

    var advisory_inner = '';

    document.write('<div class="right_share_ico">');
    document.write('    <a href="" title="意见反馈" target="_blank"><p class="ico_feedback"></p></a><a href="javascript:void(0);" target="_self" class="J_gotop" style="display:none;"><p class="ico_top"></p></a>');
    document.write('</div>');

    if($.browser.msie && $.browser.version == 6) { 
        $('.right_share_ico').css({'position':'absolute'});
        var win_height = $(window).height();
        var obj_height = $('.right_share_ico').height();
        var mintop = parseInt(win_height) - parseInt(obj_height);
        scroll_Div('.right_share_ico', mintop);
    }   

    //回到顶部
    $('.J_gotop').bind('click', function() {
        $("html, body").animate({scrollTop: 0}, 200);
    });

    var backToTopFunc = function() {
        var st = $(document).scrollTop(), winh = $(window).height();
        if (st > 0) {
            $('.J_gotop').show();
        } else {
            $('.J_gotop').hide();
        }
    }

    $(window).bind("scroll", backToTopFunc);
}
</script>
<base target="_blank">
</head>
<body>

<div class="shortcut">

    <div class="jm-w site-nav">

        <ul class="fr">

            <script src="http://www.9939.com/9939/js/login.js" type="text/javascript" charset="utf-8"></script>

<form name="name" action="#" target="_blank" method="post"><li class="login-form"><span>用户名</span><input type="text" class="site-text" name="username" value="" id="l-name"><span>密码</span><input type="password" class="site-text" name="password" value="" id="l-psw"></li><li class="login-btn"><input type="submit" value="登录" class="l-sub" onclick="return dologin();"></li>  <li class="reg-btn"><a href="http://www.9939.com/register" target="_blank" class="l-reg">注册</a></li></form><script>var member_nickname=null;</script>

            <li><a href="javascript:void(0)" onclick="SetHome(this,window.location)" target="_self">设为首页</a></li>

            <li><a target="_top" onclick="javascript:AddFavorite('http://www.9939.com/Company', '健康资讯网');return false;" style="cursor:pointer;">加入收藏</a></li>

        </ul>

    </div>

</div>

<div class="j-hd">
    <div class="jm-w j-hdbox1 zoom">
        <h1 class="j-logo"><a href="/">WWW.9939.COM久久健康网</a></h1>
        <ul class="j-health">
            <li class="j-lth1"><a target="_blank" href="http://www.9939.com" rel="nofollow">健康生活</a></li>
            <li class="j-lth2"><a target="_blank" href="http://jb.9939.com" rel="nofollow">健康管理</a></li>
            <li class="j-lth3"><a target="_blank" href="http://yisheng.9939.com" rel="nofollow">健康导航</a></li>
            <li class="j-lth4"><a target="_blank" href="http://ask.9939.com" rel="nofollow">健康护航</a></li>
            <li class="j-lth5"><a target="_blank" href="http://www.9939.net/" rel="nofollow">健康商城</a></li>
        </ul>
    </div>

    <div class="jm-w">
        <ul class="j-nav clearfix">
            <li class="current"><a href="http://www.9939.com/Company/index.shtml" rel="nofollow">HOME</a></li>
            <li><a href="http://www.9939.com/Company/wzjj.shtml" rel="nofollow">网站介绍</a></li>
            <li><a href="http://www.9939.com/sitemap">网站地图</a></li>
            <li><a href="http://www.9939.com/Company/tdjg.shtml" rel="nofollow">团队架构</a></li>
            <li><a href="http://www.9939.com/Company/wzdt.php" rel="nofollow">网站动态</a></li>
            <li><a href="http://www.9939.com/Company/cpfw.shtml" rel="nofollow">产品与服务</a></li>
            <li><a href="http://www.9939.com/Company/zlhz.shtml">战略合作</a></li>
            <li><a href="http://www.9939.com/Company/careers.php" rel="nofollow">诚聘英才</a></li>
            <li><a href="http://www.9939.com/Company/lxwm.shtml" rel="nofollow">联系我们</a></li>
        </ul>
    </div>


</div>

<div id="page">
    <div class="dh" id="sitemap_topbar">
        <div class="dh_left">
            <ul>
            <li><a class="check" href="javascript:;" target="_self" id="dis_center" goto="dis_center">科室查询</a></li>
            <li><a href="javascript:;" target="_self" target="_self" id="life_channel" goto="life_channel">疾病查询</a></li>
            <li><a href="javascript:;" target="_self" id="dazhong" goto="dazhong">部位查询</a></li>
            <li><a href="javascript:;" target="_self" id="app_centre" goto="app_centre">症状查询</a></li>
                                
            </ul>
        </div>
        <script language="javascript" type="text/javascript">
        var T = 42, statu1 = 0, t = 0, navVar = false, topbar = jQuery('#sitemap_topbar'), ie6 = false;
        var fangxiang = false;
        ie6 = $.browser.msie && $.browser.version == 6 ? true : false;
        
        $(window).scroll(function (){
                         
            var t = $(window).scrollTop();
            var w = $(window).width();
            var tw = topbar.width(); 
            var left = (w-tw)/2;
            if (!ie6) {
                if (t < 2100) {
                    // $(".check").removeClass("check");
                    // $("#dis_center").addClass("check");
                }
                else if (t > 2100 && t < 3578) {
                    // $(".check").removeClass("check");
                    // $("#life_channel").addClass("check");
                }
                else if (t > 3578 && t < 5102) {
                    // $(".check").removeClass("check");
                    // $("#dazhong").addClass("check");
                }
                else if (t > 5102 & t < 5950) {
                    // $(".check").removeClass("check");
                    // $("#app_centre").addClass("check");
                }
                else if (t > 5950) {
                    // $(".check").removeClass("check");
                    // $("#hot").addClass("check");
                }
                if (t < 90) {
                        jQuery('#sitemap_topbar').css({'position' : ''});
                    }else {
                        jQuery('#sitemap_topbar').css({'position' : 'fixed', 'left':left+'px' , 'top':'0px'});
                }
            }
        
        });     
        
        loadFollowSiderBar();
        </script>
        <div class="l_search">
            <form target="_blank" id="" name="" method="get" action="">
                <label><input type="text" class="search_text" value="热门新闻搜索" onfocus="javascript:if(this.value=='热门新闻搜索'){this.value='';this.style.color='#000'}" onblur="javascript:if(this.value==''){this.value='热门新闻搜索';this.style.color='#dcdcdc'}" id="ytsearch_input" name="q" autocomplete="off" /><input type="hidden" name="s" value="" /><input type="hidden" name="nsid" id="nsid" value="1" /></label>
                <input type="submit" class="search_btn" value="" title="搜索" onclick="javascript:var input=document.getElementById('ytsearch_input');if(input.value=='热门新闻搜索'){input.value='';input.focus();input.style.color='#000';return false;} return true;" />
            </form>
        </div>
    </div>
    
    <div class="life" name="dis_center">
        <h1><a href="http://jb.9939.com/" target="_blank">科室查询</a></h1>
        <div class="life_con">
            <ul>
                <?php
                foreach($model['departments'] as $k=>$v){
                    $level1Name = $v['level1']['name'];
                    $level1Url = "http://jb.9939.com/jbzz/".$v['level1']['pinyin']."/";
                ?>
                <li class="cc">
                    <span class="ks_left"><a href="<?php echo $level1Url?>" target="_blank" title="<?php echo $level1Name?>"><?php echo $level1Name?></a></span>
                    <span class="ks_right ks_fi">
                        <?php
                        if(isset($v['level2'])){
                            foreach($v['level2'] as $kk=>$vv){
                                $level2Name = $vv['name'];
                                $level2Url = "http://jb.9939.com/jbzz/".$vv['pinyin']."/";
                        ?>
                                <a href="<?php echo $level2Url?>" target="_blank" title="<?php echo $level2Name?>"><?php echo $level2Name?></a>
                        <?php  
                            }
                        }else{
                        ?>
                                <a href="<?php echo $level1Url?>" target="_blank" title="<?php echo $level1Name?>"><?php echo $level1Name?></a>
                        <?php
                        }
                        ?>
                    </span>
                </li>
                <?php
                }
                ?>
                                
            </ul>
        </div>
    </div>
    
    <div class="life" name="life_channel">
        <h1><a href="http://jb.9939.com/jbzz_t1/" target="_blank">疾病查询</a></h1>
        <div class="life_con">
            <ul>
            <?php
            foreach($model['disease'] as $k=>$v){
                $departmentName = $v['department']['name'];
                $departmentUrl = "http://jb.9939.com/jbzz/".$v['department']['pinyin']."_t1/";
            ?>
                <li class="cc">
                    <span class="ks_left"><a href="<?php echo $departmentUrl?>" target="_blank" title="<?php echo $departmentName?>"><?php echo $departmentName?></a></span>
                    <span class="ks_right ks_fi">
                        <?php
                        $disease1 = array_splice($v['disease'], 0, 6);
                        foreach($disease1 as $kk=>$vv){
                            $diseaseName = $vv['name'];
                            $diseaseUrl = "http://jb.9939.com/".$vv['pinyin_initial']."/";
                        ?>
                            <a href="<?php echo $diseaseUrl?>" target="_blank" title="<?php echo $diseaseName?>"><?php echo $diseaseName?></a>
                        <?php
                        }
                        ?>
                            <a class="more" data_c="0"></a>
                    </span>
                    <span class="ks_right ks_ro">
                        <?php
                        foreach($v['disease'] as $kk=>$vv){
                            $diseaseName = $vv['name'];
                            $diseaseUrl = "http://jb.9939.com/".$vv['pinyin_initial']."/";
                        ?>
                            <a href="<?php echo $diseaseUrl?>" target="_blank" title="<?php echo $diseaseName?>"><?php echo $diseaseName?></a>
                        <?php
                        }
                        ?>
                        <a class="more" data_c="1"></a>
                    </span>
                </li>
            <?php
            }
            ?>                   
            </ul>
        </div>
    </div>
    <div class="life" name="dazhong">
        <h1><a href="http://jb.9939.com/jbzz/" target="_blank">部位查询</a></h1>
        <div class="life_con">
            <ul>
                <?php
                foreach($model['parts'] as $k=>$v){
                    $level1Name = $v['level1']['name'];
                    $level1Url = "http://jb.9939.com/jbzz/".$v['level1']['pinyin']."/";
                ?>
                <li class="cc">
                    <span class="ks_left"><a href="<?php echo $level1Url?>" target="_blank" title="<?php echo $level1Name?>"><?php echo $level1Name?></a></span>
                    <span class="ks_right ks_fi">
                        <?php
                        if(isset($v['level2'])){
                            foreach($v['level2'] as $kk=>$vv){
                                $level2Name = $vv['name'];
                                $level2Url = "http://jb.9939.com/jbzz/".$vv['pinyin']."/";
                        ?>
                                <a href="<?php echo $level2Url?>" target="_blank" title="<?php echo $level2Name?>"><?php echo $level2Name?></a>
                        <?php  
                            }
                        }else{
                        ?>
                                <a href="<?php echo $level1Url?>" target="_blank" title="<?php echo $level1Name?>"><?php echo $level1Name?></a>
                        <?php
                        }
                        ?>
                    </span>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="life" name="app_centre">
        <h1><a href="http://jb.9939.com/jbzz_t2/">症状查询</a></h1>
        <div class="life_con">
            <ul>
            <?php
            foreach($model['symptom'] as $k=>$v){
                $partName = $v['part']['name'];
                $partUrl = "http://jb.9939.com/jbzz/".$v['part']['pinyin']."_t2/";
            ?>
                <li class="cc">
                    <span class="ks_left"><a href="<?php echo $partUrl?>" target="_blank" title="<?php echo $partName?>"><?php echo $partName?></a></span>
                    <span class="ks_right ks_fi">
                        <?php
                        $symptom1 = array_splice($v['symptom'], 0, 8);
                        foreach($symptom1 as $kk=>$vv){
                            $symptomName = $vv['name'];
                            $symptomUrl = "http://jb.9939.com/zhengzhuang/".$vv['pinyin_initial']."/";
                        ?>
                            <a href="<?php echo $symptomUrl?>" target="_blank" title="<?php echo $symptomName?>"><?php echo $symptomName?></a>
                        <?php
                        }
                        ?>
                            <a class="more" data_c="0"></a>
                    </span>
                    <span class="ks_right ks_ro">
                        <?php
                        foreach($v['symptom'] as $kk=>$vv){
                            $symptomName = $vv['name'];
                            $symptomUrl = "http://jb.9939.com/zhengzhuang/".$vv['pinyin_initial']."/";
                        ?>
                            <a href="<?php echo $symptomUrl?>" target="_blank" title="<?php echo $symptomName?>"><?php echo $symptomName?></a>
                        <?php
                        }
                        ?>
                        <a class="more" data_c="1"></a>
                    </span>
                </li>
            <?php
            }
            ?> 
            </ul>
        </div>
    </div>
    
    <script language="javascript" type="text/javascript">
    //跳到指定区块
    var initTop = 0;
    var fx;
    jQuery('.dh_left').find('a').bind('click', function(){
        
        var name = jQuery(this).attr('goto');
        var barScrollTop = jQuery('.dh_left').offset().top
        var top = parseInt(jQuery("div[name='"+ name +"']").offset().top);
        var scrollTop = $(window).scrollTop();
        
        jQuery('.dh_left').find('a').removeClass('check');
        jQuery(this).addClass('check');
        top = scrollTop <= 96 ? top - 116 : top - 48;
        if (name == 'dis_center') top = 0;
                
        
        jQuery("html,body").animate({scrollTop: top}, 400); 
    })
    
    </script>
</div>
<div class="foot">
    <div class="newfoot cc"> 
        <div class="foot_logo"></div>
        <div class="foot_right">
            <p><a href="" target="_blank">网站地图</a>|<a href="" target="_blank">广告合作</a>|<a href="" target="_blank">网站简介</a>|<a href="" target="_blank">友情链接</a>|<a href="" target="_blank">联系我们</a>|<a href="" target="_blank">免责声明</a></p> 
            <script language='javascript' src="http://www.9939.com/9939/res/sitemap/js/nfoot.js?v=20150906.10" type="text/javascript"></script>
        </div>
    </div>  
</div>
</body>
</html>
