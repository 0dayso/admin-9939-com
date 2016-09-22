(function(){
    var map = [];
    map['www.9939.com']='http://m.9939.com/';
    var hostname = String(window.location.hostname).toLowerCase();
    var pathname = String(window.location.pathname).toLowerCase();
    pathname = pathname=="/"?'':pathname;
    var match_url = hostname+pathname;
    match_url = match_url.replace('index.shtml','');
    if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad)/i))){
        if(typeof(map[match_url])!="undefined"){
            window.location=map[match_url];
        }else{
            if(match_url.indexOf('jb.9939.com')>-1){
                var reg = /jb.9939.com\/dis\/(\d+)\//ig;
                if(match_url.indexOf('jb.9939.com/dis/')>-1 && reg.test(match_url) ){
                    var location_url =  match_url.replace(reg, "http://m.9939.com/jb/$1.shtml");
                    window.location=location_url;
                }else{
                    window.location='m.'+match_url;
                }
            }else{
                var arr_location = String(match_url).split('/');
                var domain_name_arr = String(arr_location[0]).split('.');
                var domain_name = domain_name_arr[0];
                if(match_url.indexOf('.shtml')>-1){
                    var curr_page = arr_location[arr_location.length-1];
//                    var newarray = arr_location.slice(0,-3);
//                    var url_key = newarray.join('/')+'/';
                    var location_url = 'http://m.9939.com/'+domain_name+'/'+"article/"+curr_page;
                    window.location=location_url;
                }else{
                    var newarray = arr_location.slice(1,-1); 
                    var url_key = newarray.join('/')+'/';
                    var location_url = 'http://m.9939.com/'+domain_name+'/'+url_key;
                    window.location=location_url;
                }
            }
        }
    }
})();