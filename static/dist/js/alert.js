//自动关闭提示框
function Alert(str) {   
    var div = document.getElementById("alertbgDiv");
    if(div!=null){
        closewin();
    }
    var msgw,msgh,bordercolor;    
    msgw=350;//提示窗口的宽度    
    msgh=80;//提示窗口的高度    
    titleheight=35; //提示窗口标题高度    
    bordercolor="#336699";//提示窗口的边框颜色    
    titlecolor="#99CCFF";//提示窗口的标题颜色    
    var sWidth,sHeight;    
    //获取当前窗口尺寸    
    // sWidth = document.body.offsetWidth;    
    // sHeight = document.body.offsetHeight; 
    sWidth = window.screen.availWidth;    
    sHeight = window.screen.availHeight;     
    //背景div    
    var bgObj=document.createElement("div");    
    bgObj.setAttribute('id','alertbgDiv');    
    bgObj.style.position="fixed";    
    bgObj.style.top="0";    
    bgObj.style.background="#E8E8E8";    
    bgObj.style.filter="progid:DXImageTransform.Microsoft.Alpha(style=3,opacity=25,finishOpacity=75";    
    bgObj.style.opacity="0.6";    
    bgObj.style.left="0";    
    bgObj.style.width = sWidth + "px";    
    bgObj.style.height = sHeight + "px";    
    bgObj.style.zIndex = "10000";    
    document.body.appendChild(bgObj);    
    //创建提示窗口的div    
    var msgObj = document.createElement("div")    
    msgObj.setAttribute("id","alertmsgDiv");    
    msgObj.setAttribute("align","center");    
    msgObj.style.background="white";    
    msgObj.style.border="1px solid " + bordercolor;    
    msgObj.style.position = "fixed";    
    msgObj.style.left = "50%";    
    msgObj.style.font="14px/1.6em Verdana, Geneva, Arial, Helvetica, sans-serif";    
    //窗口距离左侧和顶端的距离     
    msgObj.style.marginLeft = "-225px";    
    //窗口被卷去的高+（屏幕可用工作区高/2）-150    
    msgObj.style.top = document.body.scrollTop+(window.screen.availHeight/2)-150 +"px";    
    msgObj.style.width = msgw + "px";    
    msgObj.style.height = msgh + "px";    
    msgObj.style.textAlign = "center";    
    msgObj.style.lineHeight ="25px";    
    msgObj.style.zIndex = "10001";    
    document.body.appendChild(msgObj);    
    //提示信息标题    
    var title=document.createElement("h4");    
    title.setAttribute("id","alertmsgTitle");    
    title.setAttribute("align","left");    
    title.style.margin="0";    
    title.style.padding="3px";    
    title.style.background = bordercolor;    
    title.style.filter="progid:DXImageTransform.Microsoft.Alpha(startX=20, startY=20, finishX=100, finishY=100,style=1,opacity=75,finishOpacity=100);";    
    title.style.opacity="0.75";    
    title.style.border="1px solid " + bordercolor;    
    title.style.height="26px";    
    title.style.font="14px Verdana, Geneva, Arial, Helvetica, sans-serif";    
    title.style.color="white";    
    title.innerHTML="提示信息";    
    document.getElementById("alertmsgDiv").appendChild(title);    
    //提示信息    
    var txt = document.createElement("p");    
    txt.setAttribute("id","msgTxt");    
    txt.style.margin="16px 0";    
    txt.innerHTML = str;    
    document.getElementById("alertmsgDiv").appendChild(txt);    
    //设置关闭时间    
    window.setTimeout("closewin()",2000);     
}    
function closewin() {    
    document.body.removeChild(document.getElementById("alertbgDiv"));    
    document.getElementById("alertmsgDiv").removeChild(document.getElementById("alertmsgTitle"));    
    document.body.removeChild(document.getElementById("alertmsgDiv"));    
}  

//dom加载完成后执行的js
;$(function(){  

    //ajax get请求
    $('.ajax-get').click(function(){
        var target;
        var that = this;
        if ( $(this).hasClass('confirm') ) {
            if(!confirm('确认要执行该操作吗?')){
                return false;
            }
        }
        if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
            $.get(target).success(function(data){
                if (data.code==1) {
                    if (data.url) {
                        ZENG.msgbox.show(data.msg + ' 页面即将自动跳转~',4);
                    }else{
                        ZENG.msgbox.show(data.msg,4);
                    }
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else if( $(that).hasClass('no-refresh')){
                            $('#top-alert').find('button').click();
                        }else{
                            location.reload();
                        }
                    },1500);
                }else{
                    ZENG.msgbox.show(data.msg,5);
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else{
                            $('#top-alert').find('button').click();
                        }
                    },1500);
                }
            });

        }
        return false;
    });

    //ajax post submit请求
    $('.ajax-post').click(function(){
        var target,query,form;
        var target_form = $(this).attr('target-form');
        var that = this;
        var nead_confirm=false;
        if( ($(this).attr('type')=='submit') || (target = $(this).attr('href')) || (target = $(this).attr('url')) ){
            form = $('.'+target_form);
            target = $(this).attr('url');
            if ($(this).attr('hide-data') === 'true'){//无数据时也可以使用的功能
                form = $('.hide-data');
                query = form.serialize();
            }else if (form.get(0)==undefined){
                return false;
            }else if ( form.get(0).nodeName=='FORM' ){
                if ( $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                if($(this).attr('url') !== undefined){
                    target = $(this).attr('url');
                }else{
                    target = form.get(0).action;
                }
                query = form.serialize();
            }else if( form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA') {
                form.each(function(k,v){
                    if(v.type=='checkbox' && v.checked==true){
                        nead_confirm = true;
                    }
                })
                if ( nead_confirm && $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                query = form.serialize();                
            }else{
                if ( $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                query = form.find('input,select,textarea').serialize();
            }
            $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
            $.post(target,query).success(function(data){
                if (data.code==1) {
                    if (data.url) {
                        ZENG.msgbox.show(data.msg + ' 页面即将自动跳转~',4);
                    }else{
                        ZENG.msgbox.show(data.msg,4);
                    }
                    setTimeout(function(){
                        $(that).removeClass('disabled').prop('disabled',false);
                        if (data.url) {
                            location.href=data.url;
                        }else if( $(that).hasClass('no-refresh')){
                            $('#top-alert').find('button').click();
                        }else{
                            location.reload();
                        }
                    },1500);
                }else{
                    ZENG.msgbox.show(data.msg,5);
                    setTimeout(function(){
                        $(that).removeClass('disabled').prop('disabled',false);
                        if (data.url) {
                            location.href=data.url;
                        }else{
                            $('#top-alert').find('button').click();
                        }
                    },1500);
                }
            });
        }
        return false;
    });    

});
