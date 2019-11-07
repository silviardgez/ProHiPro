function showSidebar() {
    var x = document.getElementById("sidebar-menu");
    if (x.style.display === "none" || x.style.display === "") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

//Cerrar el menú
$(document).mouseup(function (e){
    var x = document.getElementById("sidebar-menu");
    if(x.style.display === "block") {
        var container = $("#sidebar-menu");
        var container2 = $("#button-sidebar");
        if ((!container.is(e.target) && container.has(e.target).length === 0) 
            && (!container2.is(e.target) && container2.has(e.target).length === 0)){
            x.style.display = "none";
        }
    }
}); 
