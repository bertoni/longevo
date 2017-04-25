$(document).ready(function(){
    
    $('#form form').submit(function(){
        
        var form   = $(this);
        var url    = form.attr('action');
        var method = form.attr('method');
        var dados  = form.serialize();
        
        $.ajax({
            method: method,
            url: url,
            data: dados,
            dataType: 'json',
            success: function(data) {
                alert(data.message);
                location.reload();
            },
            error: function(data){
                data = JSON.parse(data.responseText);
                alert(data.message);
            }
        });
        
        return false;
    });
    
    $('.pagination').click(function(e){
        e.preventDefault();
        $('#form-filter').find('input[type="hidden"][name="pagina"]').val($(this).attr('href'));
        $('#form-filter').submit();
    });
    
});