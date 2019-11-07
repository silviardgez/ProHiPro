function selectChange(selectedElement) {
    let urlRoute = "./UserController.php?currentPage=1&itemsPerPage=" + selectedElement.value;
    window.location.href = urlRoute;
}