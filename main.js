$("form").on('click', '.btn', function (){
    $.ajax({
        type : 'POST',
        url : 'test.php',
        data : $("form").serializeArray(),
        success : function(response) { 
            error = JSON.parse(response).error;
            if (error != ''){ alert(error); }
        }        
    });
});

