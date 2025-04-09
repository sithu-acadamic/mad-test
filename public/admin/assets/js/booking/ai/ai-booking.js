$('.datetime_pick').datetimepicker({
    format: 'Y-m-d H:i',
    step: 15,
    onSelectTime: function (date) {
    //OnChangeCheckbox(id,'insert',ind)
    }
});
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


$(".flight_time").each(function() {
    $(this).timepicker();
});


function addNewFlight(click_row) {

    var $tr    = $(click_row).closest('.trClone');
    var $clone = $tr.clone();
    var v=parseInt($('#noRow').val());
    var n=v+1;

    $clone.find("#rowIndex_"+v).attr("id","rowIndex_"+n);
    $clone.find("#rowIndex_"+n).html(n);

    $clone.find(':text[id=fcode_'+v+']').val("");
    $clone.find(':text[id=fcode_'+v+']').attr("id","fcode_"+parseFloat(n));

    $clone.find(':text[id=fno_'+v+']').val("");
    $clone.find(':text[id=fno_'+v+']').attr("id","fno_"+parseFloat(n));

    $clone.find(':text[id=fdate_'+v+']').val("");
    $clone.find(':text[id=fdate_'+v+']').attr("id","fdate_"+parseFloat(n));
    $clone.find(':text[id=fdate_'+v+']').attr("class","date_pick");

    $clone.find(':text[id=ftime_'+v+']').val("");
    $clone.find(':text[id=ftime_'+v+']').attr("id","ftime_"+parseFloat(n));

    $clone.find('select[class=ap_from_'+v+']').attr("class","ap_from_"+parseFloat(n));

    $clone.find('select[class=ap_to_'+v+']').attr("class","ap_to_"+parseFloat(n));

    $clone.find("#actBtn_"+v).attr("id","actBtn_"+n);
    $tr.after($clone);
    $('#noRow').val(parseFloat(n));
    for(var k=1;k<parseFloat(n);k++){
        $("#actBtn_"+k).html('');
    }

    $("#actBtn_"+n).html('<span class="btn btn-success fa fa-plus btn-xs clon-btn" role="button" onclick="addNewFlight(this);"></span><span class="btn btn-danger fa fa-minus btn-xs" role="button" onclick="delFlight(this);"></span>');

    $(".flight_time").each(function() {
        $(this).timepicker();
    });

    $('.date_pick').datepicker({autoclose: true, format:'yyyy-mm-dd'});
}

function delFlight(cur_tr){
    var cl_tr = $(cur_tr).closest('.trClone');
    var v=parseInt($('#noRow').val());
    var n=v-1;

        if(n>1){
            $("#actBtn_"+n).html('<span class="btn btn-success fa fa-plus btn-xs clon-btn" role="button" onclick="addNewFlight(this);"></span><span class="btn btn-danger fa fa-minus btn-xs" role="button"  onclick="delFlight(this);"></span>');
        }
        else{
            $("#actBtn_"+n).html('<span class="btn btn-success fa fa-plus btn-xs clon-btn" role="button" onclick="addNewFlight(this);"></span>');
        }

    cl_tr.closest('tr').remove();
    $('#noRow').val(parseFloat(n));
}
    //Displaying summery after filling fields
    $("#flightTab").click(function(e){
        $("#shipper_span").text($("#shipper_id :selected").text());
        $("#consignee_span").text($("#consignee_id :selected").text());

        $("#lpagent_span").text($("#lpagent :selected").text());
        $("#apol_span").text($("#airport_of_loading :selected").text());
        $("#apod_span").text($("#destination_code :selected").text());
        $("#airline_span").text($("#airline_id :selected").text());
        $("#flight_no_span").text($("#flight_no").val());

        $("#etd_span").text($("#etd").val());
        $("#eta_span").text($("#eta").val());
        $("#atd_span").text($("#atd").val());
        $("#ata_span").text($("#ata").val());

        $("#mbl_span").text($("#mawb_no").val());
        $("#nopackges_span").text($("#no_packege").val());
        $("#gweight_span").text($("#gross_weight").val());
        $("#cweight_span").text($("#crgble_weight").val());

        //from new fields
        $("#hbl_span").text($("#hawb").val());
        $("#po_no_span").text($("#po_number").val());
        $("#inv_nos_span").text($("#invoice_nos").val());
        $("#nweight_span").text($("#net_weight").val());
        $("#cl_date_span").text($("#cl_date").val());
    });

    $("#nxt").click(function(e){
        $("#cargo_ready_span").text($("#cargo_ready_date").val());
        $("#cargo_ho_span").text($("#cargo_ho_date").val());
        $("#shipper_span").text($("#shipper_id").val());
        $("#consignee_span").text($("#consignee_id :selected").text());

        $("#lpagent_span").text($("#lpagent :selected").text());
        $("#apol_span").text($("#airport_of_loading :selected").text());
        $("#apod_span").text($("#destination_code :selected").text());
        $("#airline_span").text($("#airline_id :selected").text());
        $("#flight_no_span").text($("#flight_no").val());

        $("#etd_span").text($("#etd").val());
        $("#eta_span").text($("#eta").val());
        $("#atd_span").text($("#atd").val());
        $("#ata_span").text($("#ata").val());

        $("#mbl_span").text($("#mawb_no").val());
        $("#nopackges_span").text($("#no_packege").val());
        $("#gweight_span").text($("#gross_weight").val());
        $("#cweight_span").text($("#chargable_weight").val());

        //from new fields
        $("#hbl_span").text($("#hawb").val());
        $("#po_no_span").text($("#po_number").val());
        $("#inv_nos_span").text($("#invoice_nos").val());
        $("#nweight_span").text($("#net_weight").val());
        $("#cl_date_span").text($("#cl_date").val());
    });

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

//change shiper name and load shipper address function
    // $("#shipper_id").change(function(e){
    //     console.log($(this).val());
    //     getaddress($(this).val(),0,'dropdown','shipper_loc','shipper_addr',0);
    // });

//change consignee name and load consignee address function
// $("#consignee").change(function(e){
//    getaddress($(this).val(), 0, 'dropdown', 'consignee_loc', 'consignee_addr',0);
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
