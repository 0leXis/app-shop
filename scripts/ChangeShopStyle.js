function clearShopStyle(){
    let button = document.getElementsByName("shop_gridstyle_btn")[0];
    button.classList.remove("released");
    button.classList.remove("pressed");
    button = document.getElementsByName("shop_liststyle_btn")[0];
    button.classList.remove("released");
    button.classList.remove("pressed");
    let shop_element = document.getElementsByName("shop_2styles")[0];
    shop_element.classList.remove("shop-items-grid");
    shop_element.classList.remove("shop-items-list");
}

function setListStyle(sender){
    if(sender.classList.contains("released")){
        clearShopStyle();
        document.getElementsByName("shop_gridstyle_btn")[0].classList.add("released");
        sender.classList.add("pressed");
        document.getElementsByName("shop_2styles")[0].classList.add("shop-items-list");
    }
}

function setGridStyle(sender){
    if(sender.classList.contains("released")){
        clearShopStyle();
        document.getElementsByName("shop_liststyle_btn")[0].classList.add("released");
        sender.classList.add("pressed");
        document.getElementsByName("shop_2styles")[0].classList.add("shop-items-grid");
    }
}