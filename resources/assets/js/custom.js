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
})