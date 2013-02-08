

$('.mouseover').bind('mouseover', function() {
  var src  = $(this).attr("src").replace (".png", "-over.png");
  $(this).attr("src", src);
});

$('.mouseover').bind('mouseout', function() {
  var src  = $(this).attr("src").replace ("-over.png", ".png");
  $(this).attr("src", src);
});