function openDependenciesModal(title, message) {
    document.getElementById('modal-title').innerHTML = title;
    document.getElementById('modal-text').innerHTML = message;
    $("#exampleModal").modal('toggle');
}