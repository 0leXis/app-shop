$('button[name="to_cart"]').click(function(e){
    let params = { id: this.dataset.id }
    $.post("modules/to_cart.php", params).done(function(data){
        if(data == "ADDED")
            alert("Успешно добавлено!");
        else
        if(data == "ALREDY")
            alert("Товар уже в корзине");
        else
        if(data == "OUT")
            alert("Нет на складе");
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
});

$('form[name="order"]').submit(function(e){
    e.preventDefault();
    let params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            let a = e.split('=');
            p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
            return p;
        },
        {}
    );
    params = { id: params['id'], count: $('input[name="count"]').val()};

    $.post("modules/to_cart.php", params).done(function(data){
        if(data == "ADDED")
            alert("Успешно добавлено!");
        else
        if(data == "ALREDY")
            alert("Товар уже в корзине");
        else
        if(data == "OUT")
            alert("Нет на складе");
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
});