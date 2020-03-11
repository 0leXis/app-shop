$('.shop-pagesbuttons button').click(function(e){
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
    let page = parseInt(this.innerText, 10);
    if(Number.isInteger(page)){
        params['page'] = page;
        let url = document.location.pathname + '?';
        for(let key in params){
            if(key != "")
                url += key + '=' + params[key] + '&';
        }
        url = url.slice(0, -1);
        document.location = url;
    }
});