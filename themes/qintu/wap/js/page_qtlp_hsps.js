$(function() {
	$('#qrcode').qrcode({
		render: "canvas",
		width: 138,
		height: 138,
		text: window.location.href
	})
	$('#notice_btn').click(function() {
		layer.open({
        type: 1
        ,title:  ['套餐介绍', 'font-size:18px;font-weight:bold;text-align:center'] //不显示标题栏
       
        ,area: ['80%', '90%']
        ,shade: 0.6
        ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
        ,btn: ['离开此页']
        ,moveType: 1 //拖拽模式，0或者1
        ,content:$('#notice_content')
        ,success: function(layero){
          var btn = layero.find('.layui-layer-btn');
          btn.css('text-align', 'center');
        }
      });
	})
	$('#share_btn').mouseover(function() {
		$('.m-pop-up').css('display', 'block')
	})
	$('#share_btn').mouseout(function() {
		$('.m-pop-up').css('display', 'none')
	})
	$('#form-need').bootstrapValidator({　　　　　　　　
			message: 'This value is not valid',
			　feedbackIcons: {　　　　　　　　 valid: 'glyphicon glyphicon-ok', 　　　　　　　　invalid: 'glyphicon glyphicon-remove', 　　　　　　　　validating: 'glyphicon glyphicon-refresh'　　　　　　　　 },
			fields: {
				name: {
					validators: {
						stringLength: {
							max: 30,
							message: '姓名过长'
						},
						notEmpty: {
							message: '姓名不能为空'
						},
					}
				},
				mobile: {
					validators: {
						notEmpty: {
							message: '手机号不能为空'
						},
						regexp: {
							regexp: /^(0|86)?(1[0-9][0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/,
							message: '手机号错误'
						}
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
					$('#need-success').modal('show');
				} else {
					layer.alert("提交失败,请稍候重试");
				}

			}, 'json');
		});
	$('#go_on_need').click(function() {
		$('#need-success').modal('hide');
	});
	$('.zoomify').zoomify();
});