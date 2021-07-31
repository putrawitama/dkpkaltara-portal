var ajax = {
	init: function init() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: function beforeSend(jxqhr) {
				ui.popup.showLoader();
			},
			timeout: 30000,
			error: function error(event, jxqhr, status, _error) {
				ui.popup.show('error', 'Sedang Gangguan Jaringan', 'Error');
				ui.popup.hideLoader();	
			},
			complete: function complete() {
			},
			global: true
		});
	},
	getData: function getData(url, method, params, callback) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		if (params == null) {
			params = {};
		}
		$.ajax({
			type: method,
			url: baseUrl + url,
			data: params,
			success: function success(result) {
				ui.popup.hideLoader();
				if (result.status == 'success') {
					ui.popup.hideLoader();
					if (result.callback == 'redirect') {
						ui.popup.show(result.status, result.message, result.url);
					}
				}
				if (result.status == 'error') {
					ui.popup.show('error', result.messages.message, result.messages.title);
				} else if (result.status == 'reload') {
					ui.popup.alert(result.messages.title, result.messages.message, 'refresh');
				} else if (result.status == 'logout') {
					ui.popup.alert(result.messages.title, result.messages.message, 'logout');
				} else if (result == 401) {
					ui.popup.show('warning', 'Sesi Anda telah habis, harap login kembali', 'Session Expired')					
					if ($('.toast-warning').length == 2) {
						$('.toast-warning')[1].remove();
					}
					setInterval(function() {
						window.location = '/logout'
					}, 3000); 
				} else {
					if (result instanceof Array || result instanceof Object) {
						callback(result);
					} else {
						callback(JSON.parse(result));
					}
				}
			}
		});
	},
	submitData: function submitData(url, data, form_id) {
		other.encrypt(data, function (err, encData) {
			if (err) {
				callback(err);
			} else {
				$.ajax({
					url: url,
					type: 'post',
					data: encData,
					error: function error(jxqhr, status, _error2) {
						ui.popup.hideLoader();
						ui.popup.show('error', _error2, 'Error');
					},
					success: function success(result, status) {
						if (result == null) {
							ui.popup.show(result.status, 'Error');
							ui.popup.hideLoader();
						} else if (result == 401) {
							ui.popup.show('warning', 'Sesi anda habis, mohon login kembali', 'Session Expired')
							ui.popup.hideLoader();
							setInterval(function() {
								window.location = '/logout'
							}, 3000);
						} else {
							if (result.status == 'success') {
								$('.modal').modal('hide');
								ui.popup.hideLoader();
								if (result.callback == 'redirect') {
									console.log(result.url);
									ui.popup.show(result.status, result.message, result.url);
								} else if(result.callback == 'login'){
									// ui.toast.show();
									setInterval(function(){window.location = result.url;}, 2000);
								}
							}else if(result.status == 'info'){
								ui.popup.hideLoader();
								// bisa menggunakan if seperti diatas
							}else if(result.status == 'warning'){
								ui.popup.hideLoader();
								if (result.callback == 'redirect') {
									ui.popup.show(result.status, result.message, result.url);
								}
							}else{
								$('.modal').modal('hide');
								if(result.messages == '<p>Error: Validation</p>') {
									ui.popup.hideLoader();
									$("#"+form_id).validate().showErrors(result.errors);
									ui.popup.show(result.status, "Harap cek isian");
								}else{
									ui.popup.show(result.status, result.message);
									ui.popup.hideLoader();
								}
							}
						}
					}
				});
			}
		});
	},
	submitImage: function submitImage(url, form_id, path, to_id) {}
}
