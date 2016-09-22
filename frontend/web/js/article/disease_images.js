/**
 * Created by Administrator on 2016/3/28.
 */

$(function(){
    /*
     * 1、获取到当前页 page
     * 2、点击 preim 的时候， window.location.href = http://frontend.9939.com/byxxgy20/tuji_(page - 1)/
     * 3、点击 preim 的时候， window.location.href = http://frontend.9939.com/byxxgy20/tuji_(page + 1)/
     * 4、lef_01,.lef_02 同理
     */
    function paging(cpage, page, max, classname) {
        //第一页的时候，不能操作【上一页】
        if (cpage == 1 && (classname == 'preim' || classname == 'lef_01')){
            return ;
        }
        //最后一页的时候，不能操作【下一页】
        if (cpage == max && (classname == 'nexim' || classname == 'lef_02')){
            return ;
        }
        $('.' + classname).click(function(){
            var domain = window.location.hostname;
            window.location.href = window.location.protocol + "//" + domain + '/' + $("#tujiPYInitial").val() + '/tuji_' + page + '/';
        });
    }

    var curPageStr = $('.patrn a[class="cupat"]').text();
    if (curPageStr == '' || curPageStr == null || curPageStr == undefined){
        curPageStr = 1;
    }
    var currentPage = parseInt(curPageStr);

    var max = parseInt($("#tujiTotal").val());
    if (max == 0){
        max = 1;
    }
    paging(currentPage, currentPage + 1, max, 'nexim');
    paging(currentPage, currentPage - 1, max, 'preim');
    paging(currentPage, currentPage -1, max, 'lef_01');
    paging(currentPage ,currentPage +1, max, 'lef_02');

});
