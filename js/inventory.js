
function openModal(){
    const addProd = document.querySelector(".addProd");
    addProd.classList.remove("hidden");
    addProd.classList.add("flex");
}

function cancelCoseModal(){

    const addProd = document.querySelector(".addProd");
    addProd.classList.remove("flex");
    addProd.classList.add("hidden");
}

function closeModal(){

    const addProd = document.querySelector(".addProd");
    addProd.classList.remove("flex");
    addProd.classList.add("hidden");
}