$('.date_pick').datepicker({autoclose: true, format:'yyyy-mm-dd'});


var etd = $( "#etd" )
.datepicker({autoclose: true, format: 'yyyy-mm-dd'})
.on( "changeDate", function (e) {
    $(this).valid();
    eta.datepicker('setStartDate', e.format());
}),

eta = $("#eta")
.datepicker({autoclose: true, format: 'yyyy-mm-dd'})
.on( "changeDate", function (e) {
    $(this).valid();
    etd.datepicker('setEndDate', e.format());
});
var atd = $( "#atd" )
.datepicker({autoclose: true, format: 'yyyy-mm-dd'})
.on( "changeDate", function (e) {
    $(this).valid();
    ata.datepicker('setStartDate', e.format());
}),

ata = $("#ata")
.datepicker({autoclose: true, format: 'yyyy-mm-dd'})
.on( "changeDate", function (e) {
    $(this).valid();
    atd.datepicker('setEndDate', e.format());
});

$('#bond').change(function () {
planedClearDate();
});

$("#etd").change(function (){
planedClearDate();
});

$("#eta").change(function (){
planedClearDate();
});

function planedClearDate() {
    eta = $('#eta').val();
        if (eta != "") {
            if ($('#bond').val() == 'bond') {
                noOfDaysToAdd = 2;
            }
            else {
                noOfDaysToAdd = 4;
            }
            startDate = new Date(eta);
            var endDate = "", count = 0;
            while (count < noOfDaysToAdd) {
                endDate = new Date(startDate.setDate(startDate.getDate() + 1));
                if (endDate.getDay() != 0 && endDate.getDay() != 6) {
                    count++;
                }
            }
            var ed = new Date(endDate);
            mnt=ed.getMonth()+1;
            dd=ed.getDate();
            if((mnt.toString()).length==1){
                mnt='0'+mnt.toString();
            }

            if((dd.toString()).length==1){
                dd='0'+dd.toString();
            }
            $('#planned_cleared_date').val(ed.getFullYear() + '-' + mnt + '-' + dd);
        }
}


 //load shipper
    //loadSelect2Data('shipper_id','SELECT SHIPPER','{{route("list.crm","shipper")}}',false);
    //     $('#shipper_id').change(function (e) {
    //     $('#shipper_name').val($("#shipper_id option:selected").text());
    // });

    // load consignee
    // loadSelect2Data('consignee','SELECT CONSIGNEE','{{route("list.crm","consignee")}}',false);
    //     $('#consignee').change(function (e) {
    //     $('#consignee_name').val($("#consignee option:selected").text());
    // });

    // PKG CODE
    // loadSelect2Data('pckge_type','SELECT PACKAGE','',false);
    //     $('#pckge_type').change(function (e) {
    //     $('#pckge_type_name').val($("#pckge_type option:selected").text());
    // });

//COUNTRY

//loadSelect2Data('inv_cur','SELECT CURRENCY TYPE','',false);


var $w4finish = $('#w4').find('ul.pager li.finish'),
$w4validator = $("#w4 form").validate({
    highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        $(element).closest('.form-group').removeClass('has-error');
        $(element).remove();
    },
    errorPlacement: function( error, element ) {
        element.parent().append( error );
    }
});

$('#job_type').change(function () {
    if($(this).val()=='FCL'){
        $('#cntr_msg_div').hide();
    }
    else{
        $('#cntr_msg_div').show();
    }
});
$('.wgt_fld').change(function () {
    $("#gross_weight").attr('min','0.01');
    $("#net_weight").attr('min','0.01');
    $("#gross_weight").removeAttr('max');
    $("#net_weight").removeAttr('max');

    if($(this).attr('id')=='gross_weight'){
        if($(this).val()>0){
            $("#net_weight").attr('max',$(this).val());
        }
        else{
            //$("#nweight").attr('max','0.01');
        }
    }
    else{
        if($(this).val()>0) {
            $("#gross_weight").attr('min', $(this).val());
        }
        else{
            //$("#gweight").attr('min','0.01');
        }
    }
});
    $('#w4').bootstrapWizard({
    tabClass: 'wizard-steps',
    nextSelector: 'ul.pager li.next',
    previousSelector: 'ul.pager li.previous',
    firstSelector: null,
    lastSelector: null,
    onNext: function( tab, navigation, index, newindex ) {
        var validated = $('#w4 form').valid();
        if( !validated ) {
            $w4validator.focusInvalid();
            return false;
        }


        var type =  $("#job_type :selected").text();
        if(type=='FCL'){
            var container_count = $("#noRow").val();
        }
        else{
            var container_count=1;
        }
        if(index==4 || newindex==4){
            var gw_sum=0.00;
            var cbm_sum=0.00;
			var  pkg = 0;
		 if (container_count>0) {
			 for (var i = 1; i <= container_count; i++) {
			 	 $("#cntr_seal_no_"+i).attr('required', 'required');

				 $("#cntr_gross_weight_"+i).attr('min', '0.01');
                 $("#cntr_gross_weight_"+i).attr('required', 'required');

                 $("#cntr_cbm_"+i).attr('min', '0.01');
                 $("#cntr_cbm"+i).attr('required', 'required');

                 $("#cntr_no_pkg_"+i).attr('min', '1');
                 $("#cntr_no_pkg_"+i).attr('required', 'required');

                 gw_sum=parseFloat(gw_sum)+parseFloat($("#cntr_gross_weight_"+i).val());
                 cbm_sum=parseFloat(cbm_sum)+parseFloat($("#cntr_cbm_"+i).val());
				 pkg=parseInt(pkg)+parseInt($("#cntr_no_pkg_"+i).val());

             }
             $('#cntr_errmsg_div').html('');
	     if (gw_sum.toFixed(4) != parseFloat($('#gross_weight').val()).toFixed(4)){
             console.log($('#gross_weight').val());
                 $('#cntr_errmsg_div').html('GROSS WEIGHT TOTAL IS SHOULD BE '+parseFloat($('#gross_weight').val()));
                 return false;
             }
             else if (cbm_sum != parseFloat($('#cbm').val())) {
                 $('#cntr_errmsg_div').html('CBM TOTAL IS SHOULD BE '+parseFloat($('#cbm').val()));
                 return false;
             }else if (pkg != parseInt($('#no_pkg').val())) {
                     $('#cntr_errmsg_div').html('NUMBER OF PACKAGES TOTAL IS SHOULD BE '+parseFloat($('#no_pkg').val()));
                     return false;
             }
         }
	 }
        $.validator.addMethod('checkPO', function(value) {
            return checkCharacters($('#po_number').text(),"^[A-Za-z0-9, ]*$");
        }, "You cannot use special characters for PO Number");

        $.validator.addMethod('checkInv', function(value) {
            return checkCharacters($('#inv_number').text(),"^[A-Za-z0-9,-/ ]*$");
        }, "You cannot use special characters for Invoice Number/s");
    },
    onTabClick: function( tab, navigation, index, newindex ) {
        if ( newindex == index + 1 ) {
            return this.onNext( tab, navigation, index, newindex);
        } else if ( newindex > index + 1 ) {
            return false;
        } else {
            return true;
        }
    },
    onTabChange: function( tab, navigation, index, newindex ) {
        var $total = navigation.find('li').size() - 1;
        $w4finish[ newindex != $total ? 'addClass' : 'removeClass' ]( 'hidden' );
        $('#w4').find(this.nextSelector)[ newindex == $total ? 'addClass' : 'removeClass' ]( 'hidden' );
    },
    onTabShow: function( tab, navigation, index ) {
        var $total = navigation.find('li').length - 1;
        var $current = index;
        var $percent = Math.floor(( $current / $total ) * 100);
        $('#w4').find('.progress-indicator').css({ 'width': $percent + '%' });
        tab.prevAll().addClass('completed');
        tab.nextAll().removeClass('completed');
    }
});




function newContainer(click_row) {
    var $tr    = $(click_row).closest('.trClone');
    var $clone = $tr.clone();
    var v=parseInt($('#noRow').val());
    var n=v+1;

    $clone.find("#rowIndex_"+v).attr("id","rowIndex_"+n);
    $clone.find("#rowIndex_"+n).html(n);

    $clone.find(':text[id=cntr_no_'+v+']').val("");
    $clone.find(':text[id=cntr_no_'+v+']').attr("id","cntr_no_"+parseFloat(n));

    $clone.find('select[id=cntr_size_'+v+']').attr("id","cntr_size_"+parseFloat(n));

    $clone.find('select[id=cntr_type_'+v+']').attr("id","cntr_type_"+parseFloat(n));

    $clone.find(':text[id=cntr_seal_no_'+v+']').val("");
    $clone.find(':text[id=cntr_seal_no_'+v+']').attr("id","cntr_seal_no_"+parseFloat(n));

    $clone.find(':text[id=cntr_gross_weight_'+v+']').val("");
    $clone.find(':text[id=cntr_gross_weight_'+v+']').attr("id","cntr_gross_weight_"+parseFloat(n));

    $clone.find(':text[id=cntr_cbm_'+v+']').val("");
    $clone.find(':text[id=cntr_cbm_'+v+']').attr("id","cntr_cbm_"+parseFloat(n));

    $clone.find(':text[id=cntr_no_pkg_'+v+']').val("");
    $clone.find(':text[id=cntr_no_pkg_'+v+']').attr("id","cntr_no_pkg_"+parseFloat(n));

    $clone.find("#actBtn_"+v).attr("id","actBtn_"+n);
    $tr.after($clone);
    $('#noRow').val(parseFloat(n));
    for(var k=1;k<parseFloat(n);k++){
        $("#actBtn_"+k).html('');
    }
    $("#actBtn_"+n).html('<span class="btn btn-success fa fa-plus btn-xs clon-btn" role="button" onclick="newContainer(this);"></span><span class="btn btn-danger fa fa-minus btn-xs" role="button" onclick="delContainer(this);"></span>');
}


function delContainer(cur_tr){
    var cl_tr = $(cur_tr).closest('.trClone');
    var v=parseInt($('#noRow').val());
    var n=v-1;

        if(n>1){
            $("#actBtn_"+n).html('<span class="btn btn-success fa fa-plus btn-xs clon-btn" role="button" onclick="newContainer(this);"></span><span class="btn btn-danger fa fa-minus btn-xs" role="button"  onclick="delContainer(this);"></span>');
        }
        else{
            $("#actBtn_"+n).html('<span class="btn btn-success fa fa-plus btn-xs clon-btn" role="button" onclick="newContainer(this);"></span>');
        }

    cl_tr.closest('tr').remove();
    $('#noRow').val(parseFloat(n));
}


   //Displaying summery after filling fields
   $("#conTab").click(function(e){

    $("#shipper_tab").text($("#shipper_id").text());
    $("#consignee_tab").text($("#consignee").text());
    $("#vessel_tab").text($("#vessel").val());
    $("#voyage_tab").text($("#vessel").val());
    $("#etd_tab").text($("#etd").val());
    $("#eta_tab").text($("#eta").val());
    $("#atd_tab").text($("#atd").val());
    $("#ata_tab").text($("#ata").val());
    $("#hbl_tab").text($("#hbl").val());
    $("#cbm_tab").text($("#cbm").val());
    $("#pol_tab").text($("#pol :selected").text());
    $("#pod_tab").text($("#pod :selected").text());
    $("#main_liner_tab").text($("#main_liner_tab :selected").text());
    $("#no_of_pkg_tab").text($("#no_of_pkgs").text());

});

$("#nxt").click(function(e){

    $("#shipper_tab").text($("#shipper_id").text());
    $("#consignee_tab").text($("#consignee").text());
    $("#vessel_tab").text($("#vessel").val());
    $("#voyage_tab").text($("#voyage").val());
    $("#etd_tab").text($("#etd").val());
    $("#eta_tab").text($("#etd").val());
    $("#ata_tab").text($("#ata").val());
    $("#hbl_tab").text($("#hbl").val());
    $("#cbm_tab").text($("#cbm").val());
    $("#atd_tab").text($("#atd").val());
    $("#pol_tab").text($("#pol_code :selected").text());
    $("#pod_tab").text($("#pod :selected").text());
    $("#main_liner_tab").text($("#main_liner_tab :selected").text());
    $("#no_of_pkg_tab").text($("#no_pkg").val());

});
// $("#shipper_id").change(function(e){
//     console.log($(this).val());
//     getaddress($(this).val(),0,'dropdown','shp_address_id','shp_address',0);
// });



// $("#consignee").change(function(e){
//    getaddress($(this).val(), 0, 'dropdown', 'cons_address_id', 'cons_address',0);
// });

//get company address
// function getaddress(com_id,loc_id,type,fld_adrs_id,fld_adrs_txt,cus_add){
// 	$.ajax({
// 		url: '',
// 		type: 'post',
// 		data: { "req_type": type, "cmp_id": com_id, "loc_id": loc_id },
// 		success: function( data, textStatus, jQxhr ){

// 			if(type=='dropdown'){
// 				var res=JSON.parse(data);
// 				$('#'+fld_adrs_id).html(res.option);
// 				if(cus_add==0){
// 					$('#'+fld_adrs_txt).html(res.address);
// 				}

// 			}
// 			else{
// 				$('#'+fld_adrs_txt).html(data);
// 			}

// 		},
// 		error: function( jqXhr, textStatus, errorThrown ){
// 			console.log( errorThrown );
// 		}
// 	});
// }
