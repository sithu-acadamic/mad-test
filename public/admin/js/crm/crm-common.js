function addAddress(click_row){
    var $tr    = $(click_row).closest('.trClone');
    var $clone = $tr.clone();
    var v=parseInt($('#noRow').val());
    var n=v+1;

    $clone.find("#rowIndex_"+v).attr("id","rowIndex_"+n);
    $clone.find("#rowIndex_"+n).html(n);

    $clone.find(':input[id=com_address_'+v+']').val("");
    $clone.find(':input[id=com_address_'+v+']').attr("id","com_address_"+n);

    $clone.find(':input[id=com_location_'+v+']').attr("type","text");
    $clone.find(':input[id=com_location_'+v+']').val("");
    $clone.find(':input[id=com_location_'+v+']').attr("id","com_location_"+n);

    $clone.find("#actBtn_"+v).attr("id","actBtn_"+n);
    $clone.find("#deleteBtn_"+v).html('');
    $clone.find("#deleteBtn_"+v).attr("id","deleteBtn_"+n);

    $tr.after($clone);
    $('#noRow').val(n);
    for(var k=1;k<parseFloat(n);k++){
        $("#actBtn_"+k).html('');
    }
    $("#actBtn_"+n).html('<span class="btn btn-success fa fa-plus btn-xs clon-btn" role="button" onclick="addAddress(this);"></span><span class="btn btn-danger fa fa-minus btn-xs" role="button" onclick="removeAddress(this);"></span>');
}

function removeAddress(click_row){
    var $tr= $(click_row).closest('.trClone');
    var v=parseInt($('#noRow').val());
    var n=v-1;

    if(n>1){
        $("#actBtn_"+n).html('<span class="btn btn-success fa fa-plus btn-xs clon-btn" role="button" onclick="addAddress(this);"></span><span class="btn btn-danger fa fa-minus btn-xs" role="button" onclick="removeAddress(this);"></span>');
    }
    else{
        $("#actBtn_"+n).html('<span class="btn btn-success fa fa-plus btn-xs clon-btn" role="button" onclick="addAddress(this);"></span>');
    }

    $tr.closest('tr').remove();
    $('#noRow').val(parseFloat(n));
}
