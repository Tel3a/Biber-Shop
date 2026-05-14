$(document).ready(function(){

	// Der Button wird mit JavaScript erzeugt und vor dem Ende des body eingebunden.
	var pfeill_button = ['<a href="#top" class="pfeill"><img src="pfeill.png" alt="pfeill" ></a>'].join("");
	$("body").append(pfeill_button)

	// Der Button wird ausgeblendet
	$(".pfeill").hide();

	// Funktion für das Scroll-Verhalten
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) { // Wenn 100 Pixel gescrolled wurde
				$('.pfeill').fadeIn();
			} else {
				$('.pfeill').fadeOut();
			}
		});

		$('.pfeill').click(function () { // Klick auf den Button
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});

  var elem = document.querySelector('.gallerie');
  var flkty = new Flickity(elem, {
    wrapAround: true
  });