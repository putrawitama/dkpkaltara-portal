$(document).ready(function() {
	if ($('.select2').length) {
		$('.select2').select2();
	}
	if ($('.select2-multiple-limit2').length) {
		$('.select2-multiple-limit2').select2({
			placeholder: "Pilih Parameter Pemeriksaan"
		});
	}
	if ($('.carousel').length) {
		$('.carousel').carousel();
	}

	$('#recipeCarousel').carousel({
		interval: 1000
	  })
	  
	  $('.carousel .carousel-link').each(function(){
		  var minPerSlide = 4;
		  var next = $(this).next();
		  if (!next.length) {
		  next = $(this).siblings(':first');
		  }
		  next.children(':first-child').clone().appendTo($(this));
		  
		  for (var i=0;i<minPerSlide;i++) {
			  next=next.next();
			  if (!next.length) {
				  next = $(this).siblings(':first');
				}
			  
			  next.children(':first-child').clone().appendTo($(this));
			}
	  });
	  
})