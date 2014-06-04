$(document).ready(function() {      
   $('.carousel').carousel('pause');
});

$('.panel').hover(
  function() {
    $( this ).toggleClass( 'active' );
  }, function() {
    $( this ).toggleClass( 'active' );
  }
);
