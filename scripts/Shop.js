$("#category-list li").click(function(e){
    let params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            let a = e.split('=');
            let key = decodeURIComponent(a[0]);
            let value = decodeURIComponent(a[1]);
            if(key.includes('[]')){
                if(p[key] == undefined)
                    p[key] = new Array();
                p[key].push(value);
            }
            else
                p[key] = decodeURIComponent(value);
            return p;
        },
        {}
    );

    params["category"] = this.dataset.id;
    delete params["page"];

    let url = document.location.pathname + '?';
    for(let key in params){
        if(key != ""){
            if(Array.isArray(params[key])){
                while(params[key].length > 0)
                    url += key + '=' + params[key].shift() + '&';
            }
            else
                url += key + '=' + params[key] + '&';
        }
    }
    url = url.slice(0, -1);
    document.location = url;
});

$("#manufacturer-list li").click(function(e){
    let params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            let a = e.split('=');
            let key = decodeURIComponent(a[0]);
            let value = decodeURIComponent(a[1]);
            if(key.includes('[]')){
                if(p[key] == undefined)
                    p[key] = new Array();
                p[key].push(value);
            }
            else
                p[key] = decodeURIComponent(value);
            return p;
        },
        {}
    );
    if(params["manufacturer[]"] == undefined){
        params["manufacturer[]"] = new Array();
        params["manufacturer[]"].push(this.dataset.id);
    }
    else
    if(params["manufacturer[]"].includes(this.dataset.id)){
        params["manufacturer[]"].splice(params["manufacturer[]"].indexOf(this.dataset.id), 1);
    }
    else
        params["manufacturer[]"].push(this.dataset.id);
    delete params["page"];

    let url = document.location.pathname + '?';
    for(let key in params){
        if(key != ""){
            if(Array.isArray(params[key])){
                while(params[key].length > 0)
                    url += key + '=' + params[key].shift() + '&';
            }
            else
                url += key + '=' + params[key] + '&';
        }
    }
    url = url.slice(0, -1);
    document.location = url;
});

$('input[name="min_price"]').focusout(function(e){
    let params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            let a = e.split('=');
            let key = decodeURIComponent(a[0]);
            let value = decodeURIComponent(a[1]);
            if(key.includes('[]')){
                if(p[key] == undefined)
                    p[key] = new Array();
                p[key].push(value);
            }
            else
                p[key] = decodeURIComponent(value);
            return p;
        },
        {}
    );

    let value = $(this).val();
    if(value == ""){
        if(params["min_price"] != undefined)
            delete params["min_price"];
    }
    else{
        params["min_price"] = value;
    }
    delete params["page"];

    let url = document.location.pathname + '?';
    for(let key in params){
        if(key != ""){
            if(Array.isArray(params[key])){
                while(params[key].length > 0)
                    url += key + '=' + params[key].shift() + '&';
            }
            else
                url += key + '=' + params[key] + '&';
        }
    }
    url = url.slice(0, -1);
    document.location = url;
});

$('input[name="max_price"]').focusout(function(e){
    let params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            let a = e.split('=');
            let key = decodeURIComponent(a[0]);
            let value = decodeURIComponent(a[1]);
            if(key.includes('[]')){
                if(p[key] == undefined)
                    p[key] = new Array();
                p[key].push(value);
            }
            else
                p[key] = decodeURIComponent(value);
            return p;
        },
        {}
    );

    let value = $(this).val();
    if(value == ""){
        if(params["max_price"] != undefined)
            delete params["max_price"];
    }
    else{
        params["max_price"] = value;
    }
    delete params["page"];

    let url = document.location.pathname + '?';
    for(let key in params){
        if(key != ""){
            if(Array.isArray(params[key])){
                while(params[key].length > 0)
                    url += key + '=' + params[key].shift() + '&';
            }
            else
                url += key + '=' + params[key] + '&';
        }
    }
    url = url.slice(0, -1);
    document.location = url;
});

$('input[name="min_price"]').on("keyup", function(e) {
    if (e.keyCode == 13) {
        $(this).trigger("focusout");
    }
});

$('input[name="max_price"]').on("keyup", function(e) {
    if (e.keyCode == 13) {
        $(this).trigger("focusout");
    }
});

$('select[name="item-count"]').change(function(e) {
    let params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            let a = e.split('=');
            let key = decodeURIComponent(a[0]);
            let value = decodeURIComponent(a[1]);
            if(key.includes('[]')){
                if(p[key] == undefined)
                    p[key] = new Array();
                p[key].push(value);
            }
            else
                p[key] = decodeURIComponent(value);
            return p;
        },
        {}
    );

    params["item_count"] = $(this).val();
    delete params["page"];

    let url = document.location.pathname + '?';
    for(let key in params){
        if(key != ""){
            if(Array.isArray(params[key])){
                while(params[key].length > 0)
                    url += key + '=' + params[key].shift() + '&';
            }
            else
                url += key + '=' + params[key] + '&';
        }
    }
    url = url.slice(0, -1);
    document.location = url;
});

$('select[name="sort-type"]').change(function(e) {
    let params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            let a = e.split('=');
            let key = decodeURIComponent(a[0]);
            let value = decodeURIComponent(a[1]);
            if(key.includes('[]')){
                if(p[key] == undefined)
                    p[key] = new Array();
                p[key].push(value);
            }
            else
                p[key] = decodeURIComponent(value);
            return p;
        },
        {}
    );

    params["sort_type"] = $(this).val();
    delete params["page"];
    
    let url = document.location.pathname + '?';
    for(let key in params){
        if(key != ""){
            if(Array.isArray(params[key])){
                while(params[key].length > 0)
                    url += key + '=' + params[key].shift() + '&';
            }
            else
                url += key + '=' + params[key] + '&';
        }
    }
    url = url.slice(0, -1);
    document.location = url;
});

$('#reset-filters').click(function(e){
    document.location = document.location.origin + document.location.pathname;
});