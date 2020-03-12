$(".products-sidebar-categories li").click(function(e){
    let li = this;
    $.post("modules/index_product_block.php", { id : li.dataset.id }).done(function(data){
        if(data[0] == "<"){
            $(li.parentNode.parentNode.parentNode).find(".products-block-products").html("");
            $(li.parentNode.parentNode.parentNode).find(".products-block-products").html(data);
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
});