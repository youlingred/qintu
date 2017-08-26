/*! fly - v1.0.0 - 2014-12-22
 * https://github.com/amibug/fly
 * Copyright (c) 2014 wuyuedong; Licensed MIT */
var carArray = new Array();
var productName  = "无"; //产品名称
var productPrice = 0; //产品单价
var productId    = "0"; //产品id
var layer_index  ="";  //登录弹窗id
! function(a) {

	//检测是否有列表数据
	hasList();

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
				// i = c.info?c.info:"";
				// alert(c.info.name);
				// alert(c.info.price);
				// productName = i.name?i.name:"无";
				// productPrice = i.price?i.price:0;
				// productId = i.id?i.id:0;
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

	//清空购物车
	$('#car-clear').click(function(){
		carArray = []; //清空数组
		$.cookie("mini_car", '', { expires: -1, path: "/" });
		$('#table').html('<tr class="th"><td class="car-list-product">产品</td><td class="car-list-num">数量</td><td class="car-list-price th">单价</td></tr>');
		$('#money').text('0.00');
	})

	//显示隐藏购物车
	$('#car-icon').click(function(){
	  $('.car-wap').slideToggle();
	})

	//是否登录
	$('#go').click(function(){
		if(uid){
			return true;
		}else{
			layer_index=layer.open({
			  type: 2,
			  title:'请先登录',
			  skin: 'layui-layer-demo', //样式类名
			  closeBtn: 1, //不显示关闭按钮
			  shift: 2,
			  shadeClose: true, //开启遮罩关闭
			  content: 'layerLogin',
			  area: ['400px', '400px'],
			});
			return false;
		}
	})
	

}(jQuery);


function flyEnd(f){
	//删除动画
	f.remove();
  	//添加列表
  	addList();
}

//添加商品列表
function addList(){
	var tempArray = [];
	var money = parseFloat($('#money').text());
	var new_money = (money+productPrice).toFixed(2);
	var num_val = $("#num_"+productId+" input").val();
	if(num_val){
		num_val = parseInt(num_val)+1;
		$("#num_"+productId+" input").val(num_val);
		addArray(productId,num_val);
		$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" });
	}else{
		$('#table').append('<tr id="num_'+productId+'"><td class="car-list-product">'+productName+'</td><td class="car-list-num"><span onclick="sub('+productId+')">-</span><input type="text" value="1" onchange="inputChange(this.value,'+productId+')"><span onclick="add('+productId+')">+</span></td><td class="car-list-price">￥<b>'+productPrice+'</b></td></tr>');
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

//点击加号
function add(id){
	var money = parseFloat($('#money').text());
	var num_val = $("#num_"+id+" input").val();
	num_val++;
	if(num_val>99){
		num_val = 99;
	}
	$("#num_"+id+" input").val(num_val);
	addArray(id,num_val);
	$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" }); 
	var price = parseFloat($("#num_"+id+" b").text());
	var new_money = (money+price).toFixed(2);
	$('#money').text(new_money);
}  
//点击减号
function sub(id){
	var money = parseFloat($('#money').text());
	var num_val = $("#num_"+id+" input").val();
	num_val--;
	var price = parseFloat($("#num_"+id+" b").text());
	var new_money = (money-price).toFixed(2);
	if(num_val==0){
		$("#num_"+id).remove();
	}else{
		$("#num_"+id+" input").val(num_val);	
	}
	addArray(id,num_val);
	$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" }); 
	$('#money').text(new_money);
}

//检测input改变
function inputChange(num,id){
    if(!isNaN(num)){
    	num = parseInt(num);
    	if(parseInt(num)>99){
    		num = 99;
    	}
    	if(parseInt(num)<1){
    		num = 1;
    	}
    	$(this).val(num);
    	$("#num_"+id+" input").val(num);
    	addArray(id,num);
    	$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" }); 
    }else{
    	$("#num_"+id+" input").val(1);
    	addArray(id,1);
    	$.cookie("mini_car", JSON.stringify(carArray),{expires:1, path: "/" }); 
    }
    new_money = 0;
    for(var key in carArray){
    	new_money += carArray[key][2]*carArray[key][3];
    }
    $('#money').text(new_money);
}

//添加产品
function addProduct(event) {
  productName = $(this).attr('dataname');
  productPrice = parseFloat($(this).attr('dataprice'));
  productId = $(this).attr('dataid');
  isHidden =$(".car-wap").is(":hidden");
  if(isHidden){
  	$('.car-wap').slideToggle();
  }
  if(FuckInternetExplorer()){
  	  var height = $(window).height();
	  var width = $(window).width();
	  flyer = $('<img class="u-flyer" src="'+car_path+'/shopping_cart_big.png"/>');
	  flyer.fly({
	      start: {
	          left: event.clientX,
	          top: event.clientY
	      },
	      end: {
	          left: width-270,
	          top: height-10,
	          width: 20,
	          height: 20
	      },
	  });
  }else{
  	  addList();
  }
  
}

//检测列表数据
function hasList(){
	array = $.cookie('mini_car'); // 读取 cookie 
	if(array){
		array = $.parseJSON(array);
		if(array.length>0){
			carArray = array;
			new_money = 0;
			for(var key in array){
				$('#table').append('<tr id="num_'+array[key][0]+'"><td class="car-list-product">'+array[key][1]+'</td><td class="car-list-num"><span onclick="sub('+array[key][0]+')">-</span><input type="text" value="'+array[key][3]+'" onchange="inputChange(this.value,'+array[key][3]+')"><span onclick="add('+array[key][0]+')">+</span></td><td class="car-list-price">￥<b>'+array[key][2]+'</b></td></tr>');
		    	new_money += array[key][2]*array[key][3];
		    }
		    $('.car-wap').slideToggle();
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

//检测浏览器版本
function FuckInternetExplorer() {
    var browser = navigator.appName;
    var b_version = navigator.appVersion;
    var version = b_version.split(";");
  	if (version.length > 1) {
        var trim_Version = parseInt(version[1].replace(/[ ]/g, "").replace(/MSIE/g, ""));
        if (trim_Version < 9) {
            return false;
        }
    }
    return true;
}

//关闭登录弹窗并执行登录
function closeLayer(data){
	layer.close(layer_index) ;
	index = layer.load(1, {
		offset: ['50%', '50%'],
		shade: [0.1,'#fff'] //0.1透明度的白色背景
	});
  	$.ajax({
        cache:true,
        type :"POST",
        url  :login_url,
        data :data,
        async:false,
           success:function(data){
           	layer.close(index) ;
            if(data.code){
              alert(data.msg);
              location.reload();
            } else {
              alert(data.msg);
            }
           },
           error:function(request){
           	layer.close(index) ;
            alert("页面错误");
           }
    });   
}

//忘记密码或注册
function closeToAction(type){
	layer.close(layer_index) ;
	if(type=="reg"){
		location.href = reg_url;
	}else{
		location.href = forget_url;
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
