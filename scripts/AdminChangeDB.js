$('form.additionalinfo-form').submit(function(e){
    e.preventDefault();
    let form_data = $(this).serializeArray();
    let run = true;
    for(let elem of form_data)
        if(elem.name == "id" && elem.value != "")
            if(!confirm("Вы уверены? Если существует запись с данным ID, она будет заменена.")){
                run = false;
                break;
            }
    if(run){
        $.post('modules/admin_db.php', form_data).done(function(data) {
            if(data == 'REFRESH'){
                document.location.reload();
            }
            else{
                $('p.error-str').html(data);
            }
        });
    }
});

$('form.search-form').submit(function(e){
	e.preventDefault();
	let form_data = $(this).serializeArray();
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
	let input = $(this).find('input[type="text"]');
	if(input.val() == ""){
		delete params[input.attr("name")];
	}
	else
		params[input.attr("name")] = input.val();
	
	let url = 'admin-pannel-additional-info.php?';
	for(let key in params){
		if(key != "")
			url += key + '=' + params[key] + '&';
	}
	url = url.slice(0, -1);
	document.location = url;
});

function setChangeInfo(target){
    let elements = new Array();
    $(target.parentNode.parentNode.parentNode.parentNode.parentNode).find('form.additionalinfo-form').find ('input[type="text"], textearea, select')
    .each(function() { elements.push(this);});
    let curr_td = 0;
    for(let elem of elements){
        elem.value = target.parentNode.parentNode.parentNode.getElementsByTagName("td")[curr_td].innerText;
        curr_td++;
    }
}

function deleteInfo(target, id){
    if(confirm("Вы уверены? Вы собираетесь удалить строку с id = " + id)){
        let delete_form = $(target.parentNode.parentNode.parentNode.parentNode.parentNode).find('form.additionalinfo-form').find('input[type="hidden"]').val();
        $.post('modules/admin_db.php', { delete_form : delete_form, id : id }).done(function(data) {
            if(data == 'REFRESH'){
                document.location.reload();
            }
            else{
                $('p.error-str').html(data);
            }
        });
    }
}