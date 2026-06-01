$(document).ready(function(){

	//Button 
	var pfeil_button = ['<a href="#" class="pfeil" aria-label="Nach oben">',
		'<img src="pfeil.svg" alt="Nach oben" />',
	'</a>'].join("");
	$("body").append(pfeil_button)

	$(".pfeil").hide();

	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) { // Wenn 100 Pixel gescrolled wurde
				$('.pfeil').fadeIn();
			} else {
				$('.pfeil').fadeOut();
			}
		});

		$('.pfeil').click(function () { // Klick auf den Button
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});



//Fotogallerie

	var elem = document.querySelector('.fotogallerie');
	if (elem) {
		var flkty = new Flickity(elem, {
			wrapAround: true,
			autoPlay: 3000,
			pauseAutoPlayOnHover: false,
			imagesLoaded: true,
			resize: false
		});
	}



/*const lightbox = document.getElementById("lightbox");
const lightboxImg = document.getElementById("lightboxImg");

document.querySelectorAll(".open-lightbox").forEach(link => {
  link.addEventListener("click", e => {
    e.preventDefault();
    lightboxImg.src = link.href;
    lightbox.hidden = false;
  });
});

document.getElementById("closeLightbox").addEventListener("click", () => {
  lightbox.hidden = true;
});

*/





//Sidenav 
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

var _menu = document.getElementById("menu");
if (_menu) {
	_menu.addEventListener("click", openNav);
}
