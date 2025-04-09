function showDetails(rq_type,route,refid,title){
    $.ajax({
        type: rq_type,
        url: route,
        data: {rid: refid},
        success: function( data ) {
            Swal.fire({
                title: title,
                html: data,
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonColor:'red',
                cancelButtonText:'CLOSE',
                customClass: {
                    popup: 'panel panel-primary swal2-min-wide',
                    header: 'panel-heading swal2-head prompt-head',
                    title: 'panel-heading swal2-title-left',
                    actions: 'actions-class swal-act-right',
                }
            })
        },
        beforeSend:function () {
            Swal.showLoading();
        }
    });
}

function loadContent(url, params={}, method='POST', title, action, callback){
    $('#sysModal').modal({backdrop:'static'});
    $.ajax({
        type: method,
        url: url,
        data: params,
        success: function( data ) {

            $('#modal_title').html(title);
            $('#modal_body').html(data);

            if(action!='VIEW'){
                $('#btn_modal').show().html(action);
            }

            callback();
        }
    });
}

function formSubmit(url, params={}, method='POST', title, callback){
    $('#btn_modal').hide();
    $('#modal_title').html(title);

    $.ajax({
        type: method,
        url:  url,
        data: params,
        cache: false,
        beforeSend:function () { 
            $('#modal_body').html('<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
        },
        success: function(data) {
            $('#modal_body').html('<span style="font-size:14px">'+data.message+'</span>');
            callback();
        },
        error: function (data) {
            var error = data.responseJSON;
            
            if(error.errors!== undefined){ 
                var response = '';
                $.each(error.errors,function (k,v) {
                    response = response.concat(v[0]+'</br>');
                });
                error = response;
            }
            
            $('#modal_title').html('<span style="color:red">ERROR</span>');
            $('#modal_body').html('<span style="font-size:14px">'+error+'</span>');
            callback();
        }
    });
}
