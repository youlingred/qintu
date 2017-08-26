// JavaScript Document
$(function() {
	$.fn.totop=function(opt){
		var scrolling=false;
		return this.each(function(){
			var $this=$(this);
			$(window).scroll(function(){
				if(!scrolling){
					var sd=$(window).scrollTop();
					if(sd>100){
						$this.fadeIn();
					}else{
						$this.fadeOut();
					}
				}
			});
			
			$this.click(function(){
				scrolling=true;
				$('html, body').animate({
					scrollTop : 0
				}, 500,function(){
					scrolling=false;
					$this.fadeOut();
				});
			});
		});
	};
	$("#backtotop").totop();
	if($.session.get('rememberMe')) {
		$("#key").attr("value", $.session.get('key'));
		$("#password").attr("value", $.session.get('password'));
		$("#rememberMe").attr("checked", true);
	}
	//登录表单验证
	$('#form-login').bootstrapValidator({　　　　　　　　
			message: 'This value is not valid',
			　feedbackIcons: {　　　　　　　　 valid: 'glyphicon glyphicon-ok', 　　　　　　　　invalid: 'glyphicon glyphicon-remove', 　　　　　　　　validating: 'glyphicon glyphicon-refresh'　　　　　　　　 },
			fields: {
				mobile: {
					validators: {
						notEmpty: {
							message: '手机号不能为空'
						},
						regexp: {
							regexp: /^(0|86)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/,
							message: '手机号错误'
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: '密码不能为空'
						}
					}
				}
			}
		})
		.on('success.form.bv', function(e) {
			// Prevent submit form
			e.preventDefault();
			rememberMe($("input[name='rememberMe']").is(":checked"));
			var $form = $(e.target);

			// Get the BootstrapValidator instance
			var bv = $form.data('bootstrapValidator');

			// Use Ajax to submit form data
			$.post($form.attr('action'), $form.serialize(), function(result) {
				//              console.log(result);
				switch(result.code) {
					case 1:
						window.location.reload();
						break;
					default:
						layer.alert(result.msg);
						break;
				}
			}, 'json');
		});
	//注册表单验证
	$('#form-reg').bootstrapValidator({　　　　　　　　
		message: 'This value is not valid',
		　feedbackIcons: {　　　　　　　　 valid: 'glyphicon glyphicon-ok', 　　　　　　　　invalid: 'glyphicon glyphicon-remove', 　　　　　　　　validating: 'glyphicon glyphicon-refresh'　　　　　　　　 },
		fields: {
			mobile: {
				validators: {
					notEmpty: {
						message: '手机号不能为空'
					},
					regexp: {
						regexp: /^(0|86)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/,
						message: '手机号错误'
					}
				}
			},
			mobile: {
				validators: {
					notEmpty: {
						message: '昵称不能为空'
					},
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: '密码不能为空'
					}
				}
			},
			repassword: {
				validators: {
					notEmpty: {
						message: '确认密码不能为空'
					},
					identical: {
						field: 'password',
						message: '两次输入密码不一致'
					}
				}
			}
		}
	}).on('success.form.bv', function(e) {
		// Prevent submit form
		e.preventDefault();
		rememberMe($("input[name='rememberMe']").is(":checked"));
		var $form = $(e.target);

		// Get the BootstrapValidator instance
		var bv = $form.data('bootstrapValidator');

		// Use Ajax to submit form data
		$.post($form.attr('action'), $form.serialize(), function(result) {
			//              console.log(result);
			switch(result.code) {
				case 1:
					window.location.reload();
					break;
				default:
					layer.alert(result.msg);
					break;
			}
		}, 'json');
	});
});
//日期格式化
function dateFormat(date, format) {
	var o = {
		"M+": date.getMonth() + 1, //month
		"d+": date.getDate(), //day
		"h+": date.getHours(), //hour
		"m+": date.getMinutes(), //minute
		"s+": date.getSeconds(), //second
		"q+": Math.floor((date.getMonth() + 3) / 3), //quarter
		"S": date.getMilliseconds() //millisecond
	}
	if(/(y+)/.test(format)) format = format.replace(RegExp.$1,
		(date.getFullYear() + "").substr(4 - RegExp.$1.length));
	for(var k in o)
		if(new RegExp("(" + k + ")").test(format))
			format = format.replace(RegExp.$1,
				RegExp.$1.length == 1 ? o[k] :
				("00" + o[k]).substr(("" + o[k]).length));
	return format;
}

function rememberMe(rm_flag) {
	if(rm_flag) {
		$.session.set('key', $("input[name='key']").val());
		$.session.set('password', $("input[name='password']").val());
		$.session.set('rememberMe', 1);
	} else {
		$.session.remove('key');
		$.session.remove('password');
		$.session.remove('rememberMe');
	}
}

function addOrder(product) {
	$.ajax({
		url: $login_url,
		success: function(msg) {
			if(!msg) {
				$('#user-login').modal('show');
			} else {
				addOrder_end(product)
			}
		}
	});
}

function addOrder_end(product) {
	$.ajax({
		type: "POST",
		url: $addCart_url,
		data: product,
		success: function(msg) {
			//console.log(msg);
			if(msg) {
				switch(msg.code) {
					case 1:
						refreshOrdersNum();
						$('#add-success').modal('show');
						break;
					default:
						alert("添加心愿单失败！");
						break;
				}
			}
		}
	});
}
function postOrder(product) {
	$.ajax({
		url: $login_url,
		success: function(msg) {
			if(!msg) {
				$('#user-login').modal('show');
			} else {
				postOrder_end(product)
			}
		}
	});
}
function postOrder_end(product) {
	$.ajax({
		type: "POST",
		url: $addCart_url,
		data: product,
		success: function(msg) {
			//console.log(msg);
			if(msg) {
				switch(msg.code) {
					case 1:
						postCarts([msg.data]);
						break;
					default:
						alert("预约失败！");
						break;
				}
			}
		}
	});
}
function postCarts(cart_list) {
	var $data={
		cart:cart_list
	}
	$.ajax({
		type: "POST",
		url: $postCart_url,
		data: $data,
		success: function(result) {
			if(result.code) {
				switch(result.code) {
					case 1:
					$('#need-success').modal('show');
					break;
					default:
						layer.alert(result.msg);
						break;
				}
			}
		}
	});
}

function gotoOrderList() {
	$.ajax({
		url: $login_url,
		success: function(msg) {
			if(!msg) {
				$('#user-login').modal('show');
			} else {
				location.href = $orders_url;
			}
		}
	});
}

function delCart(element,cart) {
	$.ajax({
		type: "POST",
		url: $cartDel_url,
		data: cart,
		success: function(result) {
			console.log(result);
			if(result.code == 1) {
				//delParent.remove(del);
				window.location.reload();
			} else {
				layer.alert(result.msg);
			}
		}
	});
}
function delOrder(element,order) {
	//var del=element.parent().parent().parent().parent().parent();
	//var delParent=element.parent().parent().parent().parent().parent().parent();
	$.ajax({
		type: "POST",
		url: $orderDel_url,
		data: order,
		success: function(result) {
			console.log(result);
			if(result.code == 1) {
				//delParent.remove(del);
				window.location.reload();
			} else {
				layer.alert(result.msg);
			}
		}
	});
}

function refreshOrdersNum() {
	$.ajax({
		url: $login_url,
		success: function(msg) {
			if(!msg) {
				$("#car_num").text(0);
				return;
			} else {
				refreshOrdersNum_hander();
			}
		}
	});
}

function refreshOrdersNum_hander() {
	$.ajax({
		url: $orderNum_url,
		success: function(msg) {
			if(!msg) {
				$("#car_num").text(0);
				return;
			} else {
				$("#car_num").text(msg);
			}
		}
	});
}
var $tooltip_order_none_html = '您的心愿单是空的请在<span class="txt-red">轻定制</span>与<span class="txt-red">达人私导</span>里添加您想玩的内容加入心愿单';
var $tooltip_price_help_html = '6人以内（含6人)3500元人民币,7-12人(含12人)5500人民币,高于12人价格另行协商,所有体验/景点均按照实际价格代订,并无虚增.';
var $tooltip_quan_help_html = '您预览的项目含折扣券.';
var $tooltip_zhong_help_html = '当您预订成功后有会中文手册发送至邮箱.';
var $tooltip_dai_help_html = '您预览的项目支持线下的代订服务.';

function showTipCar($elem) {
	var $num = Number($elem.text());
	if($num == 0) {
		showTip($elem, $tooltip_order_none_html);
	} else {
		showTip($elem, '您有<span class="txt-red">' + $num + '条</span>未提交心愿单,可进入<span class="txt-red">我的旅行中</span>提交全部心愿!我们会在<span class="txt-red">24小时内</span>与您联系.');
	}

}

function showTipPriceHelp($elem) {
	showTip($elem, $tooltip_price_help_html);
}
function showTipPriceRMB($elem) {
	showTip($elem, '约合人民币<span class="txt-red">'+$($elem).attr('data-rmb')+'</span>元');
}
function showTipQuanHelp($elem) {
	switch($elem.text()){
		case '券':
		showTip($elem, $tooltip_quan_help_html);
		break;
		case '中':
		showTip($elem, $tooltip_zhong_help_html);
		break;
		case '代':
		showTip($elem, $tooltip_dai_help_html);
		break;
		default:
		break;
	}
	
}
function showTip($element, $text) {
	layer.tips($text, $element, {
		tips: [4, '#fff']
	});
	$element.mouseout(function() {
		layer.closeAll();
	});
};
