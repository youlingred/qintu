// JavaScript Document
$(function(){
	$('#form-need').bootstrapValidator({
　　　　　　　　message: 'This value is not valid',
            　feedbackIcons: {
                　　　　　　　　valid: 'glyphicon glyphicon-ok',
                　　　　　　　　invalid: 'glyphicon glyphicon-remove',
                　　　　　　　　validating: 'glyphicon glyphicon-refresh'
            　　　　　　　　   },
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
            	if(result){
            		$('#need-success').modal('show');
					//window.location.reload();
            	}else{
            		layer.alert("提交失败,请稍候重试");
            	}
            	
            }, 'json');
        });
   	$('#go_on_need').click(function(){
 	$('#need-success').modal('hide');
   });
});
