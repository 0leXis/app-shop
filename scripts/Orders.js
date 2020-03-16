$('.choosable tr').click(function(e){
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
    if($(this).find('td').length <= 1)
        return;
	if($(this).find('td')[0].innerText == ""){
		delete params['choosed'];
	}
	else
        params['choosed'] = $(this).find('td')[0].innerText.substring(7);
        
	let url = document.location.pathname + '?';
	for(let key in params){
		if(key != "")
			url += key + '=' + params[key] + '&';
	}
	url = url.slice(0, -1);
	document.location = url;
});