$("form").on('click', '.btn', function (){
    $.ajax({
        type : 'POST',
        url : 'test.php',
        data : $("form").serializeArray()
        //success : function(response) { alert(response); }        
    });

    alert('ok');
});

