window.addEventListener('DOMContentLoaded', function() {
    searchBooks();
  });
  
function searchBooks() {

    var phrase = document.getElementById("find_phrase").value;
    var category = document.getElementById("what_category").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("bookResults").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "search.php?phrase=" + phrase + "&category=" + category, true);
    xhttp.send();
}
