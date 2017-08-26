$().ready(function(){
	$(".side ul li").hover(function(){
		$(this).find(".sidebox").stop().animate({"width":"124px"},200).css({"opacity":"1","filter":"Alpha(opacity=100)","background":"#ff2d4b","color":"#fff"});
		$(this).find(".kefu-qq").attr('src',theme_path+'/index/images/qq_1.png');
		$(this).find(".kefu-wx").attr('src',theme_path+'/index/images/wx_1.png');
		$(this).find(".kefu-tel").attr('src',theme_path+'/index/images/tel_1.png');
		$(this).find(".kefu-top").attr('src',theme_path+'/index/images/top_1.png');
	},function(){
		$(this).find(".sidebox").stop().animate({"width":"54px"},200).css({"opacity":"0.8","filter":"Alpha(opacity=80)","background":"#fff"});
		$(this).find(".kefu-qq").attr('src',theme_path+'/index/images/qq.png');
		$(this).find(".kefu-wx").attr('src',theme_path+'/index/images/wx.png');
		$(this).find(".kefu-tel").attr('src',theme_path+'/index/images/tel.png');
		$(this).find(".kefu-top").attr('src',theme_path+'/index/images/top.png');
	});
})
// 回到顶部函数
function goTop(){
	$('html,body').animate({'scrollTop':0},300);
}