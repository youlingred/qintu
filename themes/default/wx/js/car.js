var carArray = new Array();
var productName  = "无"; //产品名称
var productPrice = 0; //产品单价
var productId    = "0"; //产品id
var layer_index  ="";  //登录弹窗id
! function(a) {

	a.fly = function(b, c, i) {
		
		var d = {
				version: "1.0.0",
				autoPlay: !0,
				vertex_Rtop: 20,
				speed: 1.2,
				start: {},
				end: {},
				onEnd: a.noop
			},
			e = this,
			f = a(b);
		e.init = function(a) {
			this.setOptions(a), !!this.settings.autoPlay && this.play()
		}, e.setOptions = function(b) {
			this.settings = a.extend(!0, {}, d, b);
			var c = this.settings,
				e = c.start,
				g = c.end;
			f.css({
				marginTop: "0px",
				marginLeft: "0px",
				position: "fixed"
			}).appendTo("body"), null != g.width && null != g.height && a.extend(!0, e, {
				width: f.width(),
				height: f.height()
			});
			var h = Math.min(e.top, g.top) - Math.abs(e.left - g.left) / 3;
			h < c.vertex_Rtop && (h = Math.min(c.vertex_Rtop, Math.min(e.top, g.top)));
			var i = Math.sqrt(Math.pow(e.top - g.top, 2) + Math.pow(e.left - g.left, 2)),
				j = Math.ceil(Math.min(Math.max(Math.log(i) / .05 - 75, 30), 100) / c.speed),
				k = e.top == h ? 0 : -Math.sqrt((g.top - h) / (e.top - h)),
				l = (k * e.left - g.left) / (k - 1),
				m = g.left == l ? 0 : (g.top - h) / Math.pow(g.left - l, 2);
			a.extend(!0, c, {
				count: -1,
				steps: j,
				vertex_left: l,
				vertex_top: h,
				curvature: m
			})
		}, e.play = function() {
			this.move()
		}, e.move = function() {
			var b = this.settings,
				c = b.start,
				d = b.count,
				e = b.steps,
				g = b.end,
				h = c.left + (g.left - c.left) * d / e,
				i = 0 == b.curvature ? c.top + (g.top - c.top) * d / e : b.curvature * Math.pow(h - b.vertex_left, 2) + b.vertex_top;
			if (null != g.width && null != g.height) {
				var j = e / 2,
					k = g.width - (g.width - c.width) * Math.cos(j > d ? 0 : (d - j) / (e - j) * Math.PI / 2),
					l = g.height - (g.height - c.height) * Math.cos(j > d ? 0 : (d - j) / (e - j) * Math.PI / 2);
				f.css({
					width: k + "px",
					height: l + "px",
					"font-size": Math.min(k, l) + "px"
				})
			}
			f.css({
				left: h + "px",
				top: i + "px"
			}), b.count++;
			var m = window.requestAnimationFrame(a.proxy(this.move, this));
			d == e && (window.cancelAnimationFrame(m), b.onEnd.apply(this),flyEnd(f))
		}, e.destory = function() {
			f.remove()
		}, e.init(c)
	}, a.fn.fly = function(b) {
		return this.each(function() {
			void 0 == a(this).data("fly") && a(this).data("fly", new a.fly(this, b))
		})
	}

	
	

}(jQuery);

function flyEnd(f){
	//删除动画
	f.remove();
	//购物车图标
  	if($('.mui-badge').is(":hidden")){
  		$('.mui-badge').css('display','inline');
  	}else{
  		num = $('.mui-badge').text();
  		num++;
  		$('.mui-badge').text(num);
  	}
  	//添加列表
  	addList();
}

function clear(){
	carArray = []; //清空数组
	$.cookie("mini_car", '', { expires: -1, path: "/" });
	$('.car-header table').html('<tr><td width="55%" style="text-align:left;padding-left:4px">名称</td><td width="15%" style="color:red">单价</td><td width="30%">数量</td></tr>');
	$('#money').text('0.00');
	$('.mui-badge').text(1);
	$('.mui-badge').css('display','none');
	//列表页结构
	if(($('.num').parent('span').prev('img').attr('src'))){
		$('.num').parent('span').css('display','none');
		$('.num').parent('span').prev('img').css('display','inline');
		$('.num').text(1);
	}else{ //详情页结果
		$('.num').text(0);
	}
	
}

//添加商品列表
function addList(){
	var tempArray = [];
	var money = parseFloat($('#money').text());
	var new_money = (money+productPrice).toFixed(2);
	var num_val = $("#num_"+productId+" .num").text();
	if(num_val){
		num_val = parseInt(num_val)+1;
		$("#num_"+productId+" .num").text(num_val);
		addArray(productId,num_val);
		$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" });
	}else{
		$('.car-header table').append('<tr id="num_'+productId+'"><td width="55%" style="text-align:left;padding-left:4px">'+productName+'</td><td width="15%" style="color:red">￥<b>'+productPrice+'</b></td><td width="30%"><span class="minus" onclick="sub('+productId+')">-</span><span class="num">1</span><span class="plus" onclick="add('+productId+')">+</span></td></tr>');
		tempArray.push(productId); // 商品id
		tempArray.push(productName);//商品名称
		tempArray.push(productPrice);//商品价格
		tempArray.push(1); //商品数量
		carArray.push(tempArray);
		//保存到cookie1天
		$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" }); 
		$('.car-wap').scrollTop += 30;
	}
	$('#money').text(new_money);

}


//添加产品
function addProduct(event) {
  productName = $(this).attr('dataname');
  productPrice = parseFloat($(this).attr('dataprice'));
  productId = $(this).attr('dataid');

  // 判断添加按钮是否隐藏
  	if($(this).attr('src')){
  		$(this).css('display','none');
	 	$(this).next('span').css('display','inline');
  	}else{
  		num = $(this).next('span').text();
  		num++;
  		$(this).next('span').text(num);
  	}
  	
  	  var height = $(window).height();
	  var width = $(window).width();
	  flyer = $('<img class="u-flyer" src="'+car_path+'shopping_cart_big.png"/>');
	  flyer.fly({
	      start: {
	          left: event.clientX,
	          top: event.clientY
	      },
	      end: {
	          left: $('#car-logo').offset().left,
	          top: $('#car-logo').offset().top,
	          
	      },
	  });
}

//详情页添加商品
function addProductDetail(event) {
	productName = $(this).attr('dataname');
	productPrice = parseFloat($(this).attr('dataprice'));
	productId = $(this).attr('dataid');


	num = $("#list_"+productId).text();
	num++;
	$("#list_"+productId).text(num);

  	
  	  var height = $(window).height();
	  var width = $(window).width();
	  flyer = $('<img class="u-flyer" src="'+car_path+'shopping_cart_big.png"/>');
	  flyer.fly({
	      start: {
	          left: event.clientX,
	          top: event.clientY
	      },
	      end: {
	          left: $('#car-logo').offset().left,
	          top: $('#car-logo').offset().top,
	          
	      },
	  });
}

//点击加号
function add(id){
	//当前列表数量
	num = $('#list_'+id).text();
	num++;
	$('#list_'+id).text(num);
	//购物车数量
	badge = $('.mui-badge').text();
	badge++;
	$('.mui-badge').text(badge);

	var money = parseFloat($('#money').text());
	var num_val = $("#num_"+id+" .num").text();
	num_val++;
	if(num_val>99){
		num_val = 99;
	}
	$("#num_"+id+" .num").text(num_val);
	addArray(id,num_val);
	$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" }); 
	var price = parseFloat($("#num_"+id+" b").text());
	var new_money = (money+price).toFixed(2);
	$('#money').text(new_money);
} 
//点击减号
function sub(id){
	//当前列表数量
	num = $('#list_'+id).text();
	if(num){
		num--;
	}
	if(num<0){
		num = 0;
	}else{
		if(num){
			$('#list_'+id).text(num);
		}
		//购物车数量
		badge = $('.mui-badge').text();
		badge--;
		if(badge<1){
			badge = 1;
			$('.mui-badge').css('display','none');
		}
		$('.mui-badge').text(badge);
		var money = parseFloat($('#money').text());
		if(money>0){
			var num_val = $("#num_"+id+" .num").text();
			num_val--;
			var price = parseFloat($("#num_"+id+" b").text());
			var new_money = (money-price).toFixed(2);
			if(num_val==0){
				$("#num_"+id).remove();
			}else{
				$("#num_"+id+" .num").text(num_val);	
			}
			addArray(id,num_val);
			$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" }); 
			$('#money').text(new_money);
		}
	}


	
}

//向数组中插入指定数据
function addArray(id,num){
	for(var key in carArray){
    	if(carArray[key][0]==id){
    		if(num==0){
    			carArray.splice(key,1);  //删除数组
    		}else{
    			carArray[key].pop();
    			carArray[key].push(num);
    		}
    	}
    }
}

//检测列表数据
function hasList(){
	array = $.cookie('mini_car'); // 读取 cookie
	total = 0 ; //商品总数 
	if(array){
		array = $.parseJSON(array);
		if(array.length>0){
			carArray = array;
			new_money = 0;
			for(var key in array){

	 			$('.car-header table').append('<tr id="num_'+array[key][0]+'"><td width="55%" style="text-align:left;padding-left:4px">'+array[key][1]+'</td><td width="15%" style="color:red">￥<b>'+array[key][2]+'</b></td><td width="30%"><span class="minus" onclick="sub('+array[key][0]+')">-</span><span class="num">'+array[key][3]+'</span><span class="plus" onclick="add('+array[key][0]+')">+</span></td></tr>');
				// $('#table').append('<tr id="num_'+array[key][0]+'"><td class="car-list-product">'+array[key][1]+'</td><td class="car-list-num"><span onclick="sub('+array[key][0]+')">-</span><input type="text" value="'+array[key][3]+'" onchange="inputChange(this.value,'+array[key][3]+')"><span onclick="add('+array[key][0]+')">+</span></td><td class="car-list-price">￥<b>'+array[key][2]+'</b></td></tr>');
		    	new_money += array[key][2]*array[key][3];
		    	total = total + array[key][3];
		    	$('#list_'+array[key][0]).text(array[key][3]);
		    	$('#list_'+array[key][0]).parent('span').css('display','inline');
				$('#list_'+array[key][0]).parent('span').prev('img').css('display','none');
		    }
		    // $('.car-header').slideToggle();
		    $('#money').text(new_money);
		    $('.mui-badge').text(total);
			$('.mui-badge').css('display','inline');
		}
		
	}
}

//立即购买
function buyNow(url,buy){
	productName = buy.attr('dataname');
	productPrice = parseFloat(buy.attr('dataprice'));
	productId = buy.attr('dataid');
	array = $.cookie('mini_car');
	if(array){
		array = $.parseJSON(array);
	}
	

	var num = 0;
	for(var key in array){
    	if(array[key][0]==productId){
    		num = array[key][3];
    	}
    }
    if(num == 0){
    	var tempArray = [];
		tempArray.push(productId); // 商品id
		tempArray.push(productName);//商品名称
		tempArray.push(productPrice);//商品价格
		tempArray.push(1); //商品数量
		carArray.push(tempArray);
    }else{
    	addArray(productId,num);
    }

	//alert(JSON.stringify(carArray));
	//保存到cookie1天
	$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" }); 
	location.href = url;

}