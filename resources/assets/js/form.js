var form = {
	init:function(){
		$('form').attr('autocomplete', 'off');
		$.validator.addMethod("lettersonly", function(value, element) {
		 	return this.optional(element) || /^[a-z]+$/i.test(value);
		}, "Letters only please");

		$.validator.addMethod("regexp", function(value, element, regexpr) {
		 	return regexpr.test(value);
		}, "");
		$.each($('form'),function(key,val){
			$(this).validate(formrules[$(this).attr('id')]);
		});
		$('form').submit(function(e){
			e.preventDefault();
			console.log('masuk')
			var form_id = $(this).attr('id');
			form.validate(form_id);
		});
	},
	validate:function(form_id){

		var formVal = $('#'+form_id);
		var message = formVal.attr('message');
		var agreement = formVal.attr('agreement');
		var defaultOptions = {
			errorPlacement: function(error, element) {
				if (element.parent().hasClass('input-group')) {
					error.appendTo(element.parent().parent());
				} else {
					var help = element.parents('.form-group').find('.help-block');
					if(help.length){
						error.appendTo(help);
					}else{
						error.appendTo(element.parents('.form-group'))
					}
				}
			},
			highlight:function(element, errorClass, validClass){
				alert('test')
				$(element).parents('.form-group').addClass('has-error');
			},
			unhighlight:function(element, errorClass, validClass){

				$(element).parents('.form-group').removeClass('has-error');
			},
		}
		var ops = Object.assign(defaultOptions,formrules[form_id]);

		var myform = formVal.validate(ops);
		$('button[type=reset]').click(function(){
			myform.resetForm();
		});
		if(formVal.valid()){
			console.log(form_id)
			if(message!=null && message!=''){
				if(message.indexOf('|') > -1){
					var m_data = message.split('|');
					var m_text = m_data[0];
					var m_val = m_data[1];


					var t_data = m_val.split(';');
					var table = '<table class="table">';
					$.each(t_data,function(key,val){
						var c1 = val.split(':')[0];
						var c2 = form.find('input[name='+val.split(':')[1]+'],select[name='+val.split(':')[1]+']').val();
						table += '<tr><td>'+c1+'</td><td>'+c2+'</td></tr>';
					});
					table +='</table>';


					message = m_text+table;
				}
				ui.popup.confirm('Konfirmasi',message,'form.submit("'+form_id+'")');
			}
			else if(agreement != null && agreement != '') {
				message = $("#"+agreement).html();
				ui.popup.agreement('Persetujuan Agen Baru', message, 'form.submit("'+form_id+'")');
			}
			else{
				form.submit(form_id);
			}
		}else{
			ui.popup.show('error','Harap cek isian','Form Tidak Valid');
		}
	},
	submit:function(form_id){
		var form = $('#'+form_id);
		var url = form.attr('action');
		var ops = formrules[form_id];
		if(ops==null){
			ops={};
		}
		var i =1;
		var input = $('.form-control');
		var data = form.serialize();
		var isajax = form.attr('ajax');
		var isFilter = form.attr('filter');
		if(isajax=='true'){
            ajax.submitData(url,data,form_id);
		}else if(isFilter=='true'){
			table.filter(form_id,data);
		}else{
			other.encrypt(data,function(err,encData){
				if(err){
					callback(err);
				}else{
					var encryptedElement = $('<input type="hidden" name="data" />');
					$(encryptedElement).val(encData['data']);
					form.find('select,input:not("input[type=file],input[type=hidden][name=_token],input[name=captcha]")')
						.attr('disabled','true')
						.end()
						.append(encryptedElement)
						.unbind('submit')
						.submit();
				}
			});
		}

	}
}

if ($('.select-provinsi').length) {
    $('.select-provinsi').empty();
    $('.select-provinsi').append('<option value="">--Pilih Provinsi--</option>');

    $('.select-kota').empty();
    $('.select-kota').append('<option value="">--Pilih Kab/Kota--</option>');

    $('.select-kecamatan').empty();
    $('.select-kecamatan').append('<option value="">--Pilih Kecamatan--</option>');

    $('.select-kelurahan').empty();
    $('.select-kelurahan').append('<option value="">--Pilih Kelurahan--</option>');

    $('.select-kodepos').val('');

    ajax.getData('wilayah', 'post', null, function(data){
    	var dataProvinsi = [];
        for (var i = 0; i < data.data.length; i++) {
	      	var option = '<option value="'+data.data[i].provinsi+'">'+data.data[i].provinsi+'</option>'
		    dataProvinsi.push(option);
	    }

	    $("#provinsi").append(dataProvinsi);

	    $('#provinsi').change(function(){

	    	var provinsi = $('#provinsi').val();

	    	ajax.getData('wilayah', 'post', {propinsi:provinsi}, function(data){
			    var dataKota = [];

                $('.select-kota').empty();
                $('.select-kota').append('<option value="">--Pilih Kab/Kota--</option>');

                $('.select-kecamatan').empty();
                $('.select-kecamatan').append('<option value="">--Pilih Kecamatan--</option>');

                $('.select-kelurahan').empty();
                $('.select-kelurahan').append('<option value="">--Pilih Kelurahan--</option>');

                $('.select-kodepos').val('');

			    for (var i = 0; i < data.data.length; i++) {
				      var option = '<option value="'+data.data[i].kabupaten+'">'+data.data[i].kabupaten+'</option>'

				      dataKota.push(option);
			    }

			    $("#kota").append(dataKota).val("").trigger("change");

			    $('#kota').change(function(){

			    	var kota = $('#kota').val();
			    	var provinsi = $('#provinsi').val();

			    	ajax.getData('wilayah', 'post', {propinsi:provinsi,kota:kota}, function(data){
					    var dataKecamatan = [];

                        $('.select-kecamatan').empty();
                        $('.select-kecamatan').append('<option value="">--Pilih Kecamatan--</option>');

                        $('.select-kelurahan').empty();
                        $('.select-kelurahan').append('<option value="">--Pilih Kelurahan--</option>');

                        $('.select-kodepos').val('');

					    for (var i = 0; i < data.data.length; i++) {
					      var option = '<option value="'+data.data[i].kecamatan+'">'+data.data[i].kecamatan+'</option>'

						      dataKecamatan.push(option);
					    }

					    $("#kecamatan").append(dataKecamatan).val("").trigger("change");

					    $('#kecamatan').change(function(){

					    	var kecamatan = $('#kecamatan').val();
					    	var kota = $('#kota').val();
					    	var provinsi = $('#provinsi').val();

					    	ajax.getData('wilayah', 'post', {propinsi:provinsi,kota:kota, kecamatan:kecamatan}, function(data){
							    var dataKelurahan = [];

                                $('.select-kelurahan').empty();
                                $('.select-kelurahan').append('<option value="">--Pilih Kelurahan--</option>');

                                $('.select-kodepos').val('');

							    for (var i = 0; i < data.data.length; i++) {
								      var option = '<option value="'+data.data[i].kelurahan+'">'+data.data[i].kelurahan+'</option>'

								      dataKelurahan.push(option);
							    }

							    $("#kelurahan").append(dataKelurahan).val("").trigger("change");

							    $('#kelurahan').change(function(){

							    	var kelurahan = $('#kelurahan').val();
							    	var kecamatan = $('#kecamatan').val();
							    	var kota = $('#kota').val();
							    	var provinsi = $('#provinsi').val();

							    	$('#divKodePos').addClass('focused');

							    	ajax.getData('wilayah', 'post', {propinsi:provinsi,kota:kota, kecamatan:kecamatan, kelurahan:kelurahan}, function(data){

	                                	$('.select-kodepos').val('');

									    $("#kodepos").val(data.data[0].kodepos);
								    })
							    })
							});
						});
					});
				});
    		});
		});
    });
}

if ($('.select-provinsi-edit').length) {
	$('#provinsiEdit').change(function(){

    	var provinsi = $('#provinsiEdit').val();

    	ajax.getData('wilayah', 'post', {propinsi:provinsi}, function(data){
		    var dataKota = [];

        	$('.select-kota-edit').empty();
		    $('.select-kota-edit').append('<option value="">--Pilih Kab/Kota--</option>');

		    $('.select-kecamatan-edit').empty();
		    $('.select-kecamatan-edit').append('<option value="">--Pilih Kecamatan--</option>');

		    $('.select-kelurahan-edit').empty();
		    $('.select-kelurahan-edit').append('<option value="">--Pilih Kelurahan--</option>');

		    $('.select-kodepos-edit').val('');

		    for (var i = 0; i < data.data.length; i++) {
			      var option = '<option value="'+data.data[i].kabupaten+'">'+data.data[i].kabupaten+'</option>'

			      dataKota.push(option);
		    }

		    $("#kotaEdit").append(dataKota).val("").trigger("change");

		    $('#kotaEdit').change(function(){

		    	var kota = $('#kotaEdit').val();
		    	var provinsi = $('#provinsiEdit').val();

		    	ajax.getData('wilayah', 'post', {propinsi:provinsi,kota:kota}, function(data){
				    var dataKecamatan = [];

                	$('.select-kecamatan-edit').empty();
                    $('.select-kecamatan-edit').append('<option value="">--Pilih Kecamatan--</option>');

                    $('.select-kelurahan-edit').empty();
                    $('.select-kelurahan-edit').append('<option value="">--Pilih Kelurahan--</option>');

                    $('.select-kodepos-edit').val('');

				    for (var i = 0; i < data.data.length; i++) {
				      var option = '<option value="'+data.data[i].kecamatan+'">'+data.data[i].kecamatan+'</option>'

					      dataKecamatan.push(option);
				    }

				    $("#kecamatanEdit").append(dataKecamatan).val("").trigger("change");

				    $('#kecamatanEdit').change(function(){

				    	var kecamatan = $('#kecamatanEdit').val();
				    	var kota = $('#kotaEdit').val();
				    	var provinsi = $('#provinsiEdit').val();

				    	ajax.getData('wilayah', 'post', {propinsi:provinsi,kota:kota, kecamatan:kecamatan}, function(data){
						    var dataKelurahan = [];

                        	$('.select-kelurahan-edit').empty();
                            $('.select-kelurahan-edit').append('<option value="">--Pilih Kelurahan--</option>');

                            $('.select-kodepos-edit').val('');

						    for (var i = 0; i < data.data.length; i++) {
							      var option = '<option value="'+data.data[i].kelurahan+'">'+data.data[i].kelurahan+'</option>'

							      dataKelurahan.push(option);
						    }

						    $("#kelurahanEdit").append(dataKelurahan).val("").trigger("change");

						    $('#kelurahanEdit').change(function(){

						    	var kelurahan = $('#kelurahanEdit').val();
						    	var kecamatan = $('#kecamatanEdit').val();
						    	var kota = $('#kotaEdit').val();
						    	var provinsi = $('#provinsiEdit').val();

						    	ajax.getData('wilayah', 'post', {propinsi:provinsi,kota:kota, kecamatan:kecamatan, kelurahan:kelurahan}, function(data){

									$('.select-kodepos-edit').val('');

								    $("#kodeposEdit").val(data.data[0].kodepos);
							    });
						    });
						});
					});
				});
			});
		});
	});
}

// Fungsi Format rupiah untuk form
function formatRupiahRp(angka) {
	var number_string = angka.replace(/[^,\d]/g, "").toString(),
	split = number_string.split(","),
	sisa = split[0].length % 3,
	rupiah = split[0].substr(0, sisa),
	ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if (ribuan) {
		separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}

	rupiah = split[1] != undefined ? rupiah + split[1] : rupiah;
	// return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
	return 'Rp '+rupiah
}

function readFileImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var labelPreview = $(input).next()

            labelPreview.text(input.files[0].name)
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$('.thisIconEye').click(function() {
    var state = $(this).parent().find('input').attr('type');
    console.log(state)
    if (state === 'password') {
        $(this).parent().find('img').attr('src', '/image/icon/icon-eye-close.svg');
        $(this).parent().find('input').attr('type', 'text');
    } else {
        $(this).parent().find('img').attr('src', '/image/icon/icon-eye.svg');
        $(this).parent().find('input').attr('type', 'password');
    }
})

function readFileImageMore(input) {
    console.log($(input).parent())
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            // console.log(e.target.result)
            var imagePreview = $(input).parent()
            var imageTemp = $(input).parent().find('span')

            imagePreview.css('background-image', 'url(' + e.target.result + ')')
            imageTemp.hide()
        };

        reader.readAsDataURL(input.files[0]);
    }
}

if ($('#formAddGallery').length) {
	$("#videos").hide()
	$("#customSwitch2").change(function(){
		if (this.checked) {
			console.log('true');
			$("#videos").show()
			$("#images").hide()
		} else {
			console.log('false');
			$("#videos").hide()
			$("#images").show()
		}
	})
    $(".imageMore").change(function(){
        readFileImageMore(this);
    })
    
    $(".btn-add-gallery").click(function(){
        var option = '<div class="form-group mx-2" id="uploadGambar">'+
                        '<div class="custom-file-multiple">'+
                            '<input type="file" class="custom-file-input imageMore" name="image[]" id="image" accept=".jpg, .png, .jpeg">'+
                            '<label class="custom-file-label" for="image">'+
                                '<button type="button" class="btn-remove-image">'+
                                    '<i class="fas fa-trash"></i>'+
                                '</button>'+
                            '</label>'+
                            '<span><i class="fas fa-images"></i></span>'+
                        '</div>'+
                    '</div>';

        $('#listGallery').append(option)

        $(".imageMore").change(function(){
            readFileImageMore(this);
        })
        $(".btn-remove-image").on('click', function(e){
            var element = $('.imageMore').length;
            if (element > 1) {
                $(this).parent().parent().parent().remove();
            }
        })
    })
}
if ($('#formEditGallery').length) {
    $(".imageMore").change(function(){
        readFileImageMore(this);
    })

    $(".btn-remove-image-exist").on('click', function(e){
        var element = $('.imageMore').length;
        if (element > 1) {
            $(this).parent().parent().parent().remove();
        }
    })
    
    $(".btn-add-gallery").click(function(){
        var option = '<div class="form-group mx-2" id="uploadGambar">'+
                        '<div class="custom-file-multiple">'+
                            '<input type="file" class="custom-file-input imageMore" name="image[]" id="image" accept=".jpg, .png, .jpeg">'+
                            '<label class="custom-file-label" for="image">'+
                                '<button type="button" class="btn-remove-image">'+
                                    '<i class="fas fa-trash"></i>'+
                                '</button>'+
                            '</label>'+
                            '<span><i class="fas fa-images"></i></span>'+
                        '</div>'+
                    '</div>';

        $('#listGallery').append(option)

        $(".imageMore").change(function(){
            readFileImageMore(this);
        })
        $(".btn-remove-image").on('click', function(e){
            var element = $('.imageMore').length;
            if (element > 1) {
                $(this).parent().parent().parent().remove();
            }
        })
    })
}

if ($('#formAddArticle').length) {
    $(".imageMore").change(function(){
        readFileImageMore(this);
    })
}

if ($('#formEditArticle').length) {
    $(".imageMore").change(function(){
        readFileImageMore(this);
    })
}

if ($('#formAddMenu').length) {
    $("#customSwitch1").change(function(){
		if (this.checked) {
			console.log('true');
			$("#selectMenu").show()
		} else {
			console.log('false');
			$("#selectMenu").hide()
		}
	})
}

if ($('#formEditMenu').length) {
    $("#customSwitch1").change(function(){
		if (this.checked) {
			$("#selectMenu").show()
		} else {
			$("#selectMenu").hide()
		}
	})
}