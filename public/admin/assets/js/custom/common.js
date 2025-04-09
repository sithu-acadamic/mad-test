var loading_div='<div id="loading_div" class="text-center"><img src="/plugins/images/loading.gif"/></div>';
var REC_PER_PAGE=50;

//Show Validation Errors
function errorDisplay(data){
    if( data.status === 422 ) {
        const err = data.responseJSON.errors;
        $('.err-msg').remove();
        $(".remove-class").removeClass("is-invalid");
        $.each(err, function (key, val) {
            var id_arr=key.split('.');
            var inc=1;
            if(id_arr.length>1){
                console.log(id_arr[2]);
                inc=parseInt(inc)+parseInt(id_arr[1]);
                let field_name = id_arr[2].replace("_"," ");
                let mssage = val[0].replace(key, field_name);
                if($('#' + id_arr[2] +'_'+inc).parent().hasClass('input-group')){
                    $('#' + id_arr[2] +'_'+inc).parent().after('<div class="err-msg text-danger">' + mssage + '</div>');
                }else{
                    $('#'+ id_arr[2] +'_'+inc).after('<div class="err-msg text-danger">' + mssage + '</div>');
                }
                $('#'+ id_arr[2] +'_'+inc).closest( 'td' ).addClass('is-invalid remove-class');
            }
            else{
                $('#'+ key).after('<div class="err-msg text-danger">' + val[0] + '</div>');
                $('#'+ key).closest( 'div' ).addClass('is-invalid remove-class');
            }
        });
    }
}

//confirmation box
function confirmAction(title,msg,act_btn=1,yes_func,no_func,refresh_func,modal_sufx='_sm'){

    var heading='<div class="modal-header'+modal_sufx+'"><h4 class="modal-title">'+title+'</h4></div>';
    var body='<div class="modal-body" id="modal_msg'+modal_sufx+'">'+msg+'</div>';
    var footer='<div class="modal-footer">';

    if(act_btn==1){
        footer+='<button type="button" class="btn btn-soft-primary waves-effect waves-light btn_yn'+modal_sufx+' btn-sm" id="action_yes'+modal_sufx+'">Yes</button>';
    }
    footer+='<button type="button" class="btn btn-soft-danger waves-effect btn_yn'+modal_sufx+' btn-sm" id="action_no'+modal_sufx+'">No</button>';
    footer+='<button type="button" class="btn btn-danger waves-effect" id="action_refresh'+modal_sufx+'" style="display: none;">Close</button>';
    footer+='<button type="button" class="btn btn-danger waves-effect" id="err_action_refresh'+modal_sufx+'" style="display: none;">Close</button></div>';

    $('#modal_res_div'+modal_sufx).html(heading+body+footer);
    $('#mod_loading'+modal_sufx).hide();
    $('#sys_prompt'+modal_sufx).modal('show');
    $('#sys_modal'+modal_sufx).modal('show');

    $('#action_yes'+modal_sufx).click(function () {
        $('.btn_yn'+modal_sufx).hide();
        $('#mod_loading'+modal_sufx).show();
        yes_func();
    });

    $('#action_no'+modal_sufx).click(function () {
        $('#modal_res_div'+modal_sufx).html('');
        $('#mod_loading'+modal_sufx).show();
        $('#sys_prompt'+modal_sufx).modal('hide');
        $('#sys_modal'+modal_sufx).modal('hide');
        no_func();
    });

    $('#err_action_refresh'+modal_sufx).click(function () {
        $('#modal_res_div'+modal_sufx).html('');
        $('#mod_loading'+modal_sufx).show();
        $('#sys_prompt'+modal_sufx).modal('hide');
        $('#sys_modal'+modal_sufx).modal('hide');
    });

    $('#action_refresh'+modal_sufx).click(function () {
        $('#modal_res_div'+modal_sufx).html('');
        $('#mod_loading'+modal_sufx).show();
        $('#sys_prompt'+modal_sufx).modal('hide');
        $('#sys_modal'+modal_sufx).modal('hide');
        refresh_func();
    });
}

//Loading Select2 Ajax Data
function loadSelect2Data(elmid, label, url, tag, parent_div, selectorType = 'div', tempSelectionFunction = function (data) {
}) {
    let element = '';
    if (selectorType === 'div') {
        element = '#' + elmid;
    } else {
        element = '.' + elmid;
    }
    $(element).prepend('<option></option>').select2({
        ajax: {
            url: url,
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (text) {
            return text.toUpperCase();
        },
        placeholder: label,
        tags: tag,
        dropdownParent: $('#' + parent_div),
        templateResult: function (data) {
            return data.text;
        },
        templateSelection: function (data) {
            tempSelectionFunction(data);
            return data.text;
        },
        minimumInputLength: 2
    });
}

//Load ajax content view
function ajaxLoadView(action_url,parameters={},loading_id,method="POST",res_div,res_class,render_to="html",addon_html,callback){
    //e.preventDefault();
    $('div').removeClass('has-error');
    $('.err-msg').remove();
    $.ajax({
        type: method,
        url: action_url,
        data: parameters,
        success: function(data) {
            $('#'+loading_id).hide();
            var res_data='<div class="'+res_class+'">'+data+'</div>';
            if(render_to=='html'){
                $('#'+res_div).html(res_data+addon_html);
            }
            else if(render_to=='append'){
                $('#'+res_div).append(res_data);
            }
            else if(render_to=='prepend'){
                $('#'+res_div).prepend(res_data);
            }
            callback();
        },
        beforeSend:function () {
            $('#'+loading_id).show();
            if(render_to=='html'){
                $('#'+res_div).html("");
            }
            else if(render_to=='append'){
                $('#'+res_div).append("");
            }
            else if(render_to=='prepend'){
                $('#'+res_div).prepend("");
            }
        },
        error: function() {
            $('#'+loading_id).hide();
        }
    });
}

//form Submit Ajax Function
function ajaxFormSubmit(btn_id,action_url,form_array,loading_id,method="POST",form_type,callback){
    //e.preventDefault();
    $('#'+btn_id).hide();
    $('div').removeClass('has-error');
    $('.err-msg').remove();
    $.ajax({
        type: method,
        url: action_url,
        data: form_array,
        success: function( data ) {

            $('#'+loading_id).hide();
            //messageDisplay("Done",form_type+" Data Successfully Saved !",'bottom-right','success');
            callback();
        },
        beforeSend:function () {
            $('#'+loading_id).show();
        },
        error: function(data) {
            $('#'+loading_id).hide();
            $('#'+btn_id).show();
            //messageDisplay("Error",data.responseJSON.message,'bottom-right','error');
            //console.log(data.responseJSON);
            errorDisplay(data);
        }
    });
}

//Cloning New Table Row
function cloneRow(cur_tr,prfx,before_callback={},after_callback={},update_clone_element={}) {
    before_callback();
    var cl_tr    = $(cur_tr).closest('.trclone');
    var new_tr = cl_tr.clone();

    var v=parseInt($('#'+prfx+'rec_count').val());
    update_clone_element(new_tr,v);
    var n=v+1;
    new_tr.find('.clone-elem').each (function() {
        var id=$(this).attr('id');
        var lastIndex = id.lastIndexOf("_");

        var id_prfix = id.substring(0, lastIndex); //after this s1="Text1, Text2, Text"
        var id_count = id.substring(lastIndex + 1);


        // do your cool stuff
        if($(this).is("input")){
            if($(this).hasClass( "clone-text" )){

            }
            else{
                $(this).val("");
            }
            $(this).attr("id",id_prfix+"_"+n);
        }
        else if($(this).is("select")){
            $(this).attr("id",id_prfix+"_"+n);
        }
    });
    new_tr.find('#'+prfx+'row_lbl_'+v).html(parseFloat(n));
    new_tr.find('#'+prfx+'row_lbl_'+v).attr("id",prfx+"row_lbl_"+parseFloat(n));
    $('#'+prfx+'rec_count').val(parseFloat(n));
    cl_tr.after(new_tr);
    after_callback();
}

//Delete unsaved Table row
function delRow(cur_tr,prfx,before_callback={},after_callback={}, delete_save_record = false){
    var cl_tr    = $(cur_tr).closest('.trclone');
    before_callback();
    var v=parseInt($('#'+prfx+'rec_count').val());
    var sv=parseInt($('#saved_'+prfx+'rec_count').val());
    var n=v-1;

    if (delete_save_record === true){
        cl_tr.closest('tr').remove();
        $('#'+prfx+'rec_count').val(parseFloat(n));
    }else {
        if(v>sv){
        cl_tr.closest('tr').remove();
        $('#'+prfx+'rec_count').val(parseFloat(n));
        }
    }

    after_callback();

}

//Local Charge
function localCharge(section,url,parameters){

    $("."+section+"_port").remove();

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        delay: 250,
        data: parameters,
        success: function(charges) {

            $("#"+section+"-table-body").html(charges.table_body);

        }
    });
}

function ajaxCall (url, data, callBackSuccess = function (message) {}, callBackError = function (errors) {}, callBackBefore = function () {})
{
    let options = {
        method: 'POST',
        url: url,
        data: data,
        beforeSend: function () {
            callBackBefore();
        },
        success: function (message) {
            $('#mod_loading').hide();
            callBackSuccess(message);
        },
        error: function (errors) {
            $('#mod_loading').hide();
            callBackError(errors);
        }
    };

    // Check if data is an instance of FormData and adjust options
    if (data instanceof FormData) {
        options.contentType = false;
        options.processData = false;
    }

    $.ajax(options);
}
