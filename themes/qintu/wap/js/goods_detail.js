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
//	$('#addOrder_btn').click(function(){
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
	$('#addOrder_btn').click(function(){
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
});
//鼠标经过预览图片函数
function preview(img){
	$("#preview img").attr("src",$(img).attr("src"));
}
