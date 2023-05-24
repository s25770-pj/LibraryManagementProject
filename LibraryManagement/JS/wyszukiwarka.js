window.addEventListener('DOMContentLoaded', function() {
    searchBooks();
  });
  
function searchBooks() {

    var fraza = document.getElementById("znajdzFraze").value;
    var gatunek = document.getElementById("jakiGatunek").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("bookResults").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "szukaj.php?fraza=" + fraza + "&gatunek=" + gatunek, true);
    xhttp.send();
}
