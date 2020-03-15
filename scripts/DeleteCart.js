function deleteInfo(target, id){
    if(confirm("Вы уверены?")){
        $.post('modules/cart.php', { id : id }).done(function(data) {
            if(data == 'REFRESH'){
                document.location.reload();
            }
            else{
                try{
                    locate = JSON.parse(data);
                    document.location = locate['location'];
                }
                catch{
                    $('p.error-str').html(data);
                }
            }
        });
    }
}