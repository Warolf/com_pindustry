jQuery(document).ready(function() {
    $('#add').click(function() {
        if($('#businessarea')[0].value>1){
            window.location = window.location+'&area='+$('#businessarea')[0].value;
        }
    });
});

function deletearea(area){
    window.location = window.location+'&deletearea='+area;
}