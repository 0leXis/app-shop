let stars = Array();
let user_score_elem;

function setFormListeners(formName){
    let form = document.getElementsByName(formName)[0];
    user_score_elem = form.querySelector('[name="user_score"]');
    stars = Array.from(form.getElementsByClassName("dark-star"));
    for(let index = 0; index < stars.length; index++){
        console.log(stars[index]);
        stars[index].addEventListener("click", onStarClick);
        stars[index].addEventListener("mouseover", onStarHover);
        stars[index].addEventListener("mouseout", onStarOut);
    }
}

function onStarClick(event){
    user_score_elem.value = stars.findIndex((element) => element === event.target);
}

function onStarHover(event){
    for(let el of stars){
        el.classList.remove("yellow-star");
        el.classList.add("dark-star");
    }
    let selected_star = stars.findIndex((element) => element === event.target);
    for(let index = 0; index <= selected_star; index++){
        stars[index].classList.remove("dark-star");
        stars[index].classList.add("yellow-star");
    }
}

function onStarOut(event){
    for(let el of stars){
        el.classList.remove("yellow-star");
        el.classList.add("dark-star");
    }
    for(let index = 0; index <= user_score_elem.value; index++){
        stars[index].classList.remove("dark-star");
        stars[index].classList.add("yellow-star");
    }
}