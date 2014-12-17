function handleFileSelect(evt) {
  var files = evt.target.files; // FileList object

  // Loop through the FileList and render image files as thumbnails.
  for (var i = 0, f; f = files[i]; i++) {

    // Only process image files.
    if (!f.type.match('image.*')) {
      continue;
    }

    var reader = new FileReader();

    // Closure to capture the file information.
    reader.onload = (function(theFile) {
      return function(e) {
        var item = document.getElementById('review');
        item.innerHTML = "";
        // Render thumbnail.
        var span = document.createElement('span');
        span.innerHTML = ['<img class="review_image" src="', e.target.result,'" title="', escape(theFile.name), '"/> Best Shot'].join('');
        document.getElementById('review').insertBefore(span, null);
      };
    })(f);

    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
  }
}

var elementExists = document.getElementById("Shots_image");
if (elementExists) {
  elementExists.addEventListener("change", handleFileSelect);
}

$(function() {
  $('[data-toggle="tooltip"]').tooltip();
  if ($.session.get('showrules') != 0) {
    $(".rules").fadeIn().addClass('pad');
  }
  $(".close-it").click(function() {
    $.session.set('showrules', 0);
    $(this).parents(".close-element").addClass("animated fadeOut forwards").fadeOut("slow").delay(5000).remove();
  });
});