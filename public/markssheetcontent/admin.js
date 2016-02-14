
/**
 * Admin
 *
 * for admin pages
 */
var Admin = {};
var scms_jSIdVal = 10;//initial val;

/**
 * Navigation
 *
 * @return void
 */

Admin.navigation = function() {
    $('ul.sf-menu').supersubs({
        minWidth: 12,
        maxWidth: 27,
        extraWidth: 1
    }).superfish({
        delay: 200,
        animation: {
            opacity:'show',
            height:'show'
        },
        speed: 'fast',
        autoArrows: true,
        dropShadows: false,
        disableHI: true
    });
}


/**
 * Forms
 *
 * @return void
 */
Admin.form = function() {
    $("input[type=text][rel], select[rel]").not(":hidden").each(function() {
        var sd = $(this).attr('rel');
        $(this).after("<span class=\"description\">"+sd+"</span>");
    });

    $("textarea[rel]").not(":hidden").each(function() {
        var sd = $(this).attr('rel');
        if (sd != '') {
            $(this).after("<br /><span class=\"description nospace\">"+sd+"</span>");
        }
    });
}

Admin.processLink = function(el) {
    var checkbox = $(el.attributes["href"].value);
    var form = checkbox.get(0).form;
    $('input[type=checkbox]', form).prop('checked', false);
    checkbox.prop("checked", true);
    $('.bulk-actions select', form).val('delete');
    form.submit();
    return false;
}


/**
 * Extra stuff
 *
 * rounded corners, striped table rows, etc
 *
 * @return void
 */
Admin.extra = function() {
    $("table tr:nth-child(odd)").not('.controller-row').addClass("striped");
    $("div.message").addClass("notice");
    $('#loading p').addClass('ui-corner-bl ui-corner-br');
}


function calNum(obj,col){
    var percent = parseInt($('#per'+col).val());
    var label = $(obj).prev();
    if(isNaN(percent)){
        alert('Please Insert the %');
        return false;
    }
	
    if($(obj).val() != ''){
        var subNum = ($('#per'+col).attr('alt')).split("-");
        var gotNum = parseInt($(obj).val());
		
        number = Math.round((gotNum * percent)/100) ;
        if(number<=subNum[1]){
            $(obj).val(number);
            $(obj).css("background-color","#C9EEBF");
        /*$(obj).focus(function(){
				this.select();
			})*/
        }
        else {
            alert('Calculated Value is - '+number+' and total number is  - '+subNum[1]);
            $(obj).css("background-color","#E7B7B7");
        }
        label.css({
            "font-size":"15px", 
            "margin-right":"3px", 
            "margin-top":"3px", 
            "border":"1px dotted #000", 
            "background-color":"#98ff8c",
            "padding":"2px",
            "float":"right"
        });
        label.html(gotNum);
    }
    else { 
        $(obj).css("background-color","#fff");
        return false;
    }
    // START TOTAL NUMBER
    var subtotal = 0;
    $(obj).closest('tr').find('input:text')
    .each(function() {
        if($(this).val() != '')
            subtotal = subtotal + parseInt($(this).val());	
    });		
    $(obj).closest('tr').find('.totalMark').html(subtotal);
	
    if($.inArray(subtotal,[16,30,31,32,39,49,59,69,79]) != -1) {
        $(obj).closest('tr').find('.totalMark').css({
            "background-color":"#f6ff71"
        });
    }
    else{
        $(obj).closest('tr').find('.totalMark').css({
            "background-color":"#fff"
        });
    }
// END TOTAL NUMBER
	
}



function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true;
    }      
}

function isInsetPrev(obj){ 
    $(obj).val('');	
}

$(function() {
    $( "#datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
    
$(function() {
    $( "#datepicker1" ).datepicker({
        dateFormat: 'yy-mm-dd'
    });
});

function admission_result_sms(row){
   
    $('#ajximg').show();
    alert(row);
    $.ajax({                   
        url: '/admissions/admit_sms_result/' + escape(row),
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        success: function (admissionResult) {
            //var strs = clients.split("#");
            //$('#admissionResult').html(admissionResult); 
            //$('#ajximg').hide();
            //$('#clients').show();
            if(admissionResult==1000)
                alert('all sent');
            else {
                alert(admissionResult);
                admission_result_sms(admissionResult);
            }
        }
    });
    
}
//$("#extra_fees").change(function(){
//    
//    var extra = Number($(this).val());
//    var fees = $('#total_fees').val();
//
//    var total = extra + fees;
//    $("#total_fees").val(total);
//});
// function fees_cal(){
//    $("#extra_fees").val(val);
//    $("#extra_fees").trigger('change');
//};

function fees_cal(col)
{
    var extra = parseInt($('#extra_fees'+col).val());
    var fees = parseInt($('#total_fees'+col).val()); 
    var total = extra + fees;
    //var total = total.toFixed(2);
    $('#total_fees'+col).val(total);
}
$(document).on("change, keyup", "#extra_fees", fees_cal);

/**
 * Document ready
 *
 * @return void
 */
$(document).ready(function() {
    Admin.navigation();
    Admin.form();
    Admin.extra();

    $('.tabs').tabs();
    $('a.tooltip').tipsy({
        gravity: 's', 
        html: false
    });
    $('textarea').not('.content').elastic();
	
	
    //Added bY Reza:
    $('#UserRoleId').change(function(){
        if( $(this).val()==scms_jSIdVal )
            $('#capabilityCont').slideDown('slow');
        else
            $('#capabilityCont').slideUp('slow');
    });
});

$(document).ready(function(){
    $("#type").change(function(){
        $( "select option:selected").each(function(){
            if($(this).attr("value")=="Student"){
                $("#other").hide();
                $("#staff").hide();
                $("#student").show();
            }
            if($(this).attr("value")=="Staff"){
                $("#other").hide();
                $("#student").hide();
                $("#staff").show();
            }
            if($(this).attr("value")=="Other"){
                $("#student").hide();
                $("#staff").hide();
                $("#other").show();
            }
        });
    }).change();
});
    
function getStudentInfo() {
    var date=$('#datepicker').val().split('-');
    var session=date[0];
    var std = document.getElementById("sid").value;
    $("#ajximg").show();
    $.ajax({    
                
        url: '/credits/std_session_ajax' ,
        cache: false,
        type: 'GET',
        dataType: 'HTML',
        data : {
            "sid" :  std, 
            "session": session
        },
        success: function (data) {
            $('#stdCycle').html(data); 
            $("#ajximg").hide();
        }
                
    });
       
};

$(function() {
    $( "#reason").change(function(event) {
        var e = document.getElementById("reason");
        var res = e.options[e.selectedIndex].value;
        $("#ajximg").show();
        $.ajax({    
                
            url: '/purposes/reason_purpose_ajax' ,
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data : {
                "reason" :  res
            },
            success: function (purId) {
                $('#purpose').html(purId); 
                $("#ajximg").hide();
            }
                
        });
       
    });
});


