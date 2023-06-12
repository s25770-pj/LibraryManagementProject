
$(document).ready(function() {
    function updateCounter() {
      $.ajax({
        url: '../Includes/refresh_meter.php',
        type: 'GET',
        success: function(response) {
          $('#counter').html(response);
        },
        error: function() {
          console.log('Wystąpił błąd podczas aktualizacji licznika.');
        }
      });
    }

    setInterval(updateCounter, 1000);
  });