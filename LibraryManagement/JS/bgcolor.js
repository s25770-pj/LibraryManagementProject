function setBGColor() {
    var color = document.getElementById("colorInput").value;
    document.body.style.backgroundColor = color;
    var url = "../Service/set_cookie.php?color=" + encodeURIComponent(color);
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.send();
}

function getBGColor() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../Service/get_cookie.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var color = xhr.responseText;
            if (color) {
                document.body.style.backgroundColor = color;
                document.getElementById("colorInput").value = color;
            }
        }
    };
    xhr.send();
}