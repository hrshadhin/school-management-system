var docRoot = '/'; //defined in the layouts;
jQuery(document).ready(function($){
	$('a.close1').click(function(){
		$(this).closest('.formTopWrapper').find('div.displayWrapper').slideToggle();
		$(this).toggleClass('close');
	});
	
	$('input#alterAllChk').change(function(){
		var chkStatus = $(this).is(':checked');
		$(".tblroll .regular-checkbox:checkbox").prop("checked",chkStatus).parent('span').toggleClass('checked',chkStatus);
	});
	
	$('input#chk-guardians').change(function(){
		var chkStatus = $(this).is(':checked');
		$("li .chk-title input:checkbox").prop("checked",chkStatus).parent('span').toggleClass('checked',chkStatus);
	});
	
	$('input#sms-chkr').change(function(){
		if( this.checked ){
			if( !confirm('SMS will be sent to the respective parents and this action can not be undone.') )
				$(this).prop('checked',false);
		}
	});
	
	$('a.close2').click(function(){		
		if(!$(this).hasClass('close')) {
			$('div.rightDisplay').css('display', 'block');
			$('div.rightWraper').animate({width:'22%', padding:'8px .5%'}, 700, function(){
				$('a.close2').addClass('close');
			});
			$('div.left_wrapper').animate({width:'74%'}, 700, function(){});
		} else {
			$('div.rightWraper').animate({width:'4px', padding:'0'}, 700, function(){
				$('a.close2').removeClass('close');
				$('div.rightDisplay').css('display', 'none');
			});
			$('div.left_wrapper').animate({width:'97%'}, 700, function(){});
		}
	});
	
	$("input:file, input:checkbox").uniform();
	
	//alert(1);
	// Country and City
	$('.updateDrops').change(function(e){
		$(this).closest('.input').next('img.ajx-loading').show();
		
		var sData = {
			act : 'get-dpndnc-on',
			obj : e.target.id,
			id : $(e.target).val()
		};
		
		var depends = $.hasData(e.target)? $(this).data('depends').toString():'';
		depends = depends.split(',');
		
		$.each(depends,function(i,el){
			sData[el] = $('#'+el).val();
		});
		
		//console.log(sData);
		
		//alert($.hasData(e.target));
		var belongs = $.hasData(e.target)? $(this).data('belongs').toString():'';
		$(belongs).html('<option value="">--Select--</option>').prop('disabled',true);
		
		
		$.ajax({
			type: 'POST',
			dataType: "json",
			url: docRoot+'ajaxs/',//formUrl,
			data: sData,
			success: function(data,textStatus,xhr){
				//console.log(data);
				var html;
				$.each(data,function(i,fld){
					html = '';
					$.each(fld,function(v,opt){
						html += '<option value='+v+'>'+opt+'</option>';
					});
					$('[id|="scms-'+i+'"]').append(html);
				});
			},
			error: function(xhr,textStatus,error){
				alert(textStatus);
			},
			complete: function(){
				$(e.target).closest('.input').next('img.ajx-loading').hide();
				$(belongs).prop('disabled',false);
			}
		});
		return false;
	});
	
	
	$("textarea#msgText").limit({
		limit: 142,
		id_result: "charcterLength",
		alertClass: "alert"
	});
	
});

(function($){
    $.fn.limit  = function(options) {
        var defaults = {
			limit: 160,
			id_result: false,
			alertClass: false
        },
        options = $.extend(defaults,  options);
		
        return this.each(function() {
            var characters = options.limit;
            if(options.id_result != false){
                $("#"+options.id_result).html("You have <strong>"+  characters+"</strong> characters remaining");
            }
			
            $(this).on('keyup focus',function(){
                if( this.value.length > characters){
                    $(this).val($(this).val().substr(0,characters));
                }
                if(options.id_result != false){
                    var remaining =  characters - $(this).val().length;
                    $("#"+options.id_result).html("You have <strong>"+  remaining+"</strong> characters remaining");
					$("#"+options.id_result).toggleClass(options.alertClass,remaining<=10);
                }
            });
        });
    };
})(jQuery);
