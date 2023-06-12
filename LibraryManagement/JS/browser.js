window.addEventListener('DOMContentLoaded', function() {
    searchBooks();
  });
  
  function searchBooks() {
    var phrase = document.getElementById("find_phrase").value;
    var category = document.getElementById("what_category").value;
  
    var encodedPhrase = encodeURIComponent(phrase);
  
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("bookResults").innerHTML = this.responseText;
      }
    };
  
    var params = "phrase=" + encodedPhrase + "&category=" + category;
    xhttp.open("POST", "../Service/search.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
  }
  