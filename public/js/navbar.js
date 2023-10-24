function navbarToggle() {
    const component = document.getElementById("navbar-default");
    if(component !== null && component !== undefined){
        if(component.classList.contains("hidden")){
            component.classList.remove("hidden");
        }else{
            component.classList.add("hidden");
        }
    }
}