
$(document).ready(function() {
    function updateCounter() {
      $.ajax({
        url: 'odswiez_licznik.php',
        type: 'GET',
        success: function(response) {
          $('#counter').html(response); // Aktualizuj wartość licznika na stronie
        },
        error: function() {
          console.log('Wystąpił błąd podczas aktualizacji licznika.');
        }
      });
    }
  
    // Uruchamiaj aktualizację licznika co określony czas (np. co sekundę)
    setInterval(updateCounter, 1000);
  });