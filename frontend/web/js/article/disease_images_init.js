/**
 * Created by Administrator on 2016/3/28.
 */

$(function(){
    $('.nexim,.preim,.lef_01,.lef_02').click(function(){

        var $cuim=$('.picsh img').length;
        var $inde=$('.picsh img.cusri').index();

        var $cuim_01=0;
        $('.patrn a').each(function () {
            var atitle = $(this).attr('title');
            if (atitle != '上一页' && atitle != '下一页'){
                $cuim_01 += 1;
            }
        });
        var $inde_01=$('.patrn a.cupat').index();

        if($(this).attr('class')=='nexim'||$(this).attr('class')=='lef_02'){
            $('.picsh').find('img').removeClass('cusri');
            $('.patrn').find('a').removeClass('cupat');

            if($cuim==($inde+1)||$cuim_01==($inde_01+1)){
                $('.picsh img').eq(0).addClass('cusri');
                $('.patrn a').eq(0).addClass('cupat');
            }
            else{
                $('.picsh img').eq($inde+1).addClass('cusri');
                $('.patrn a').eq($inde_01+1).addClass('cupat');
            }
        }
        else{
            $('.picsh').find('img').removeClass('cusri');
            $('.patrn').find('a').removeClass('cupat');
            if($cuim==0||$cuim_01==0){
                $('.picsh img').eq($cuim-1).addClass('cusri');
                $('.patrn a').eq($cuim_01-1).addClass('cupat');
            }
            else{
                $('.picsh img').eq($inde-1).addClass('cusri');
                $('.patrn a').eq($inde_01-1).addClass('cupat');
            }
        }
    });
});
