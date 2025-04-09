function getExcelData(route) {
    let excelFile = $('#excel_file').val();

    if(excelFile){
        saveExcelData(route);
    }else{
        $('#excel_file_error').html('Select Excel File');
    }
}
function saveExcelData(route) {
    const modelTitle = 'Confirmation';
    const actionMsg = 'Are you sure want to import this Excel details?';

    let formDataImport = new FormData($('#excel-import')[0]);
    const ajaxBefore = function () {
        $('#btn-import').hide();
    };
    const ajaxSuccess = function (message) {
        $('#modal_msg').html(message.success);
        $('#action_refresh').show();
        $('#btn-import').show();
        $('#excel_file').val('');
    };
    const ajaxError = function (errorData) {
        $('#err_action_refresh').show();
        $('#modal_msg').html(errorData.responseJSON.message);
        $('#submit-button').show();
    };

    const actionFunction = function () {
        ajaxCall(route, formDataImport, ajaxSuccess, ajaxError, ajaxBefore);
    };

    confirmAction(modelTitle, actionMsg, 1, actionFunction, function () {
    }, function () {
    }, '');

    $(document).on('click', '#action_refresh', function() {
        window.location.reload();
        return false;
    });
}