window.addEventListener('DOMContentLoaded', function() {
    searchBooks();
  });
  
function searchBooks() {

    var phrase = document.getElementById("searchPhrase").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("bookResults").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "szukaj.php?phrase=" + phrase, true);
    xhttp.send();
}
