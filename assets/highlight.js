jQuery(document).ready(function() {
    $('#jform_company_id').change(function() {
        //document.adminForm.submit();
        window.location = window.location+'&company_id='+$('#jform_company_id')[0].value;
    });
});