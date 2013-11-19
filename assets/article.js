jQuery(document).ready(function() {
    $('input[type=checkbox]').click(function() {
        var companie = this.value;
        var companies = $('#companies_id')[0].value;
        var companies_array = companies.split(";");
        for (var i = 0; i < companies_array.length; i++) {
            if (companies_array[i] == "") {         
                companies_array.splice(i, 1);
                i--;
            }
        }
        var check = 1;
        if(companies_array.length>0){
            for (var i = 0; i < companies_array.length; i++){
                if(companies_array[i]==companie){
                    companies_array.splice(i, 1);
                    if(companies_array.length==1){
                        $('#companies_id')[0].value = companies_array.join(";") + ';';    
                        var check = 0;
                    }else{
                        $('#companies_id')[0].value = companies_array.join(";") + ';';    
                        var check = 0;
                    }
                }
            }
            if(check == 1){
                $('#companies_id')[0].value = companies + companie + ';';
            }
        }else{
            $('#companies_id')[0].value = $('#companies_id')[0].value + companie + ";";
        }
    });
    
});