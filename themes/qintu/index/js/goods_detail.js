// JavaScript Document
$(function(){	
	refreshOrdersNum();
	$('.form_date').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
  	});
  	//设置日期为10天后日期
  	var m_date = new Date(); 
	m_date.setDate(m_date.getDate()+10);
	m_date=dateFormat(m_date,'yyyy-MM-dd');
	$("#departure_time").val(m_date);
	
	$('#lookOrder').click(function(){
      gotoOrderList();
   });
   $('#lookOrder_1').click(function(){
      gotoOrderList();
   });
   $('#car_container').click(function(){
      gotoOrderList();
   });
   $('#go_on').click(function(){
     $('#add-success').modal('hide');
   });
   $('#go_on_need').click(function(){
     $('#need-success').modal('hide');
   });
//	$('#addOrder').click(function(){
//		var stringTime = $("#departure_time").val();
//		if(stringTime==0){
//			layer.alert("请选择日期！");
//			return;
//		}
//		var timestamp2 = Date.parse(new Date(stringTime));
//		timestamp2 = timestamp2 / 1000;
//		var $product={
//			departure_time	:timestamp2,
//			man_num			:$('#man_num').val(),
//			child_num		:$('#child_num').val(),
//			name			:$("#addOrder").attr('dataname'),
//			goods_id		:$("#addOrder").attr('dataid'),
//		}
//    	addOrder($product)
//  });
	$('#addOrder').click(function(){
			var stringTime = $("#departure_time").val();
			if(stringTime==0){
				layer.alert("请选择日期！");
				return;
			}
			var timestamp2 = Date.parse(new Date(stringTime));
			timestamp2 = timestamp2 / 1000;
			var $product={
				departure_time	:timestamp2,
				man_num			:$('#man_num').val(),
				child_num		:$('#child_num').val(),
				name			:$("#addOrder").attr('dataname'),
				goods_id		:$("#addOrder").attr('dataid'),
			}
	      	postOrder($product)
	    });
    $('#postOrder').click(function(){
		var stringTime = $("#departure_time").val();
		if(stringTime==0){
			layer.alert("请选择日期！");
			return;
		}
		var timestamp2 = Date.parse(new Date(stringTime));
		timestamp2 = timestamp2 / 1000;
		var $product={
			departure_time	:timestamp2,
			man_num			:$('#man_num').val(),
			child_num		:$('#child_num').val(),
			name			:$("#addOrder").attr('dataname'),
			goods_id		:$("#addOrder").attr('dataid'),
		}
      	postOrder($product)
    });
	$('#car_container').mouseover(function (){  
        showTipCar($(this)); 
   });
   $('#price_help').mouseover(function (){  
        showTipPriceHelp($(this)); 
    })
   $('#quan_help').each(function (index,domEle){
	   	$(domEle).mouseover(function (){  
	        showTipQuanHelp($(this)); 
	    })
	});
	$('#price_txt').mouseover(function (){  
        //showTipPriceRMB($(this));
   })
	$('#qrcode').qrcode({
		render:"canvas",
		width:138,
		height:138,
		text:window.location.href
	})
	$('#share_btn').mouseover(function(){
		$('.m-pop-up').css('display','block')
	})
	$('#share_btn').mouseout(function(){
		$('.m-pop-up').css('display','none')
	})
	$('#msg_btn').click(function(){
		$.ajax({
			url: $login_url,
			success: function(msg) {
				if(!msg) {
					$('#user-login').modal('show');
				} else {
					$('#msg-dialog').modal('show');
				}
			}
		});
	})
	$('#msg-dialog').bootstrapValidator({　　　　　　　　
			message: 'This value is not valid',
			　feedbackIcons: {
				valid: 'glyphicon glyphicon-ok', 
				invalid: 'glyphicon glyphicon-remove', 　
				validating: 'glyphicon glyphicon-refresh'　
				},
			fields: {
				description: {
					validators: {
						notEmpty: {
							message: '留言不能为空'
						},
					}
				}
			}
		})
		.on('success.form.bv', function(e) {
			e.preventDefault();
			var $form = $(e.target);
			var bv = $form.data('bootstrapValidator');
			$.post($form.attr('action'), $form.serialize(), function(result) {
				if(result) {
					$('#msg-dialog').modal('hide');
					layer.alert("发送成功");
				} else {
					//layer.alert("提交失败,请稍候重试");
					$('#msg-dialog').modal('hide');
					layer.alert("发送成功");
				}

			}, 'json');
		});
});
//鼠标经过预览图片函数
function preview(img){
	$("#preview img").attr("src",$(img).attr("src"));
}
