$('button[name="pay_button"]').click(function(e){
    let params = $('.delivery-form').serializeArray();
    $.post("modules/pay.php", params).done(function(data){
        try{
            locate = JSON.parse(data);
            document.location = locate['location'];
        }
        catch(e){
            $('p.error-str').html(data);
        }
    });
});