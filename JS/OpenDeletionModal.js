function openDeletionModal(title, message, $href) {
    document.getElementById('modal-title').innerHTML = title;
    document.getElementById('modal-text').innerHTML = message;
    document.getElementById('delete-button').href = $href;
    $("#exampleModal").modal('toggle');
}