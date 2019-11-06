function showToast(title, titleColor, text) {
    document.getElementById('message-toast').textContent = text;
    document.getElementById('header-toast').style.backgroundColor = titleColor;
    document.getElementById('title-name').textContent = title;
    $('.toast').toast('show');
}