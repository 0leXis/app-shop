$('.shop-pagesbuttons button').click(function(e){
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
    let page = parseInt(this.innerText, 10);
    if(Number.isInteger(page)){
        params['page'] = page;
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
    }
});