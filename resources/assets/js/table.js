var table = {
	init:function(){
        if ($('#tableGallery').length) {
			var column = [
				{'data':'title'},
				{'data':'desc', 'orderable': false,},
				{'data':'publish'},
                {'data':null},
			];

			columnDefs = [
                {
                    "targets": 2,
		            "data": "publish",
                    "orderable": false,
		            "render": function(data, type, full, meta){
                        var data = 'Unpublish';
                        if (full.publish == 1) {
                            data = 'Published';
                        }

                        return data;
                    }
                },
				{
		       		"targets": 3,
		            "data": "id",
                    "width": "10%",
                    "orderable": false,
		            "render": function(data, type, full, meta){
                        var id = encodeURIComponent(window.btoa(full.id));

                        if (full.publish == 1) {
                            var toggle = '<a href="/gallery/unpublish/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Unpublish">'+
                                            '<i class="fas fa-cloud-download-alt fa-sm"></i>'+
                                        '</a>';
                        } else {
                            var toggle = '<a href="/gallery/publish/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Publish">'+
                                            '<i class="fas fa-cloud-upload-alt fa-sm"></i>'+
                                        '</a>';
                        }
						
						var data = '<div class="d-flex">'+
                                        '<a href="/gallery/edit/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Edit">'+
                                            '<i class="fas fa-eye fa-sm"></i>'+
                                        '</a>'+
                                        toggle+
                                        '<a href="/gallery/delete/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Delete">'+
                                            '<i class="fas fa-trash-alt fa-sm"></i>'+
                                        '</a>'
                                    '</div>';
                        
		              	return data;
		           	}
		        }
	        ];

			table.serverSide('tableGallery',column,'gallery/list',null,columnDefs)
		}
		if ($('#tableArticle').length) {
			var column = [
				{'data':'title'},
				{'data':'sub_menu.name'},
				{'data':'publish'},
				{'data':'created_at'},
                {'data':null},
			];

			columnDefs = [
                {
                    "targets": 2,
		            "data": "publish",
                    "orderable": false,
		            "render": function(data, type, full, meta){
                        var data = 'Unpublish';
                        if (full.publish == 1) {
                            data = 'Published';
                        }

                        return data;
                    }
                },
				{
		       		"targets": 4,
		            "data": "id",
                    "width": "10%",
                    "orderable": false,
		            "render": function(data, type, full, meta){
                        var id = encodeURIComponent(window.btoa(full.id));

                        if (full.publish == 1) {
                            var toggle = '<a href="/article/unpublish/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Unpublish">'+
                                            '<i class="fas fa-cloud-download-alt fa-sm"></i>'+
                                        '</a>';
                        } else {
                            var toggle = '<a href="/article/publish/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Publish">'+
                                            '<i class="fas fa-cloud-upload-alt fa-sm"></i>'+
                                        '</a>';
                        }
						
						var data = '<div class="d-flex">'+
                                        '<a href="/article/edit/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Edit">'+
                                            '<i class="fas fa-eye fa-sm"></i>'+
                                        '</a>'+
                                        toggle+
                                        '<a href="/article/delete/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Delete">'+
                                            '<i class="fas fa-trash-alt fa-sm"></i>'+
                                        '</a>'
                                    '</div>';
                        
		              	return data;
		           	}
		        }
	        ];

			table.serverSide('tableArticle',column,'article/list',null,columnDefs)
		}
		if ($('#tableMenu').length) {
			var column = [
				{'data':'name'},
				{'data':'slug'},
				{'data':'is_child'},
				{'data':'created_at'},
                {'data':null},
			];

			columnDefs = [
                {
                    "targets": 2,
		            "data": "is_child",
                    "orderable": false,
		            "render": function(data, type, full, meta){
                        var data = 'Parent';
                        if (full.is_child == 1) {
                            data = 'Child';
                        }

                        return data;
                    }
                },
				{
		       		"targets": 4,
		            "data": "id",
                    "width": "10%",
                    "orderable": false,
		            "render": function(data, type, full, meta){
                        var id = encodeURIComponent(window.btoa(full.id));
						
						var data = '<div class="d-flex">'+
                                        '<a href="/menu/edit/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Edit">'+
                                            '<i class="fas fa-eye fa-sm"></i>'+
                                        '</a>'+
                                        '<a href="/menu/delete/'+full.link_id+'" class="btn btn-primary btn-circle btn-sm btn-action mx-1" title="Delete">'+
                                            '<i class="fas fa-trash-alt fa-sm"></i>'+
                                        '</a>'
                                    '</div>';
                        
		              	return data;
		           	}
		        }
	        ];

			table.serverSide('tableMenu',column,'menu/list',null,columnDefs)
		}
	},
	filter:function(id,value){
        if (id == 'filterParameter') {
            var column = [
				{'data':'name'},
				{'data':null},
				{'data':null},
				{'data':'kode_hl'},
				{'data':'instalasi_name'}, // instalasi
				{'data':null},
				{'data':null} // status
			];

			columnDefs = [
				{
                    "targets": 1,
                    "data": "tipe_parameter",
                    "render": function(data, type, full, meta) {
                        var data = '-';
						if (full.tipe_parameter == 1) {
							data = 'Lab';
						} else if (full.tipe_parameter == 2) {
							data = 'Non Lab';
						}

                        return data;
                    }
                }, {
                    "targets": 2,
                    "data": "tipe_pemeriksaan",
                    "render": function(data, type, full, meta) {
                        var data = '-';
						if (full.tipe_pemeriksaan == 1) {
							data = 'Klinik';
						} else if (full.tipe_pemeriksaan == 2) {
							data = 'Non Klinik';
						}

                        return data;
                    }
                }, {
                    "targets": 5,
                    "data": "harga",
                    "render": function(data, type, full, meta){
						var data = full.harga.replace(".00", "");
						var rupiah = '';
						var angkarev = data.toString().split('').reverse().join('');
						for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
						var trx = 'Rp '+rupiah.split('',rupiah.length-1).reverse().join('');

						return trx;
					}
                }, {
                    "targets": 6,
                    "data": "status",
                    "render": function(data, type, full, meta){
						if (full.status == 1) {
							var data = '<span class="badge-blue">Active</span>';
						} else if (full.status == 2) {
							var data = '<span class="badge-grey">Deactive</span>';
						}
                        
						return data;
					}
                }, {
		       		"targets": 7,
		            "data": "id",
		            "render": function(data, type, full, meta){
                        var id = encodeURIComponent(window.btoa(full.id));

						if (full.status == 1) { // aktif
							var toggle = '<button class="dropdown-item btnActiveParameter">'+
											'<img src="/image/icon/icon-action-deactive.svg" alt="icon" />'+
											'<p>Deactive</p>'+
										'</button>';
						} else {
							var toggle = '<button class="dropdown-item btnDeactiveParameter">'+
											'<img src="/image/icon/icon-action-active.svg" alt="icon" />'+
											'<p>Active</p>'+
										'</button>';
						}
						
						var data = '<div class="btn-group table-action-dropdown">'+
										'<button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
						  					'<i class="fas fa-ellipsis-v"></i>'+
										'</button>'+
										'<div class="dropdown-menu dropdown-menu-right">'+
											'<button class="dropdown-item btnViewParameter">'+
												'<img src="/image/icon/icon-action-view.svg" alt="icon" />'+
												'<p>View</p>'+
											'</button>'+
											'<a href="/parameter/edit/'+id+'" class="dropdown-item">'+
												'<img src="/image/icon/icon-action-edit.svg" alt="icon" />'+
												'<p>Edit</p>'+
											'</a>'+
											toggle+
										'</div>'+
									'</div>';
		              	return data;
		           	}
		        }
	        ];

			table.serverSide('tableParameter',column,'parameter/list',value,columnDefs)
        }
	},
	getData:function(url,params,callback){
		$.ajax({
			url:url,
			type:'post',
			data:params,
			success:function(result){
				if(!result.error){
					callback(null,result.data);
				}else{
					callback(data);
				}
			}
		})
	},
	clear:function(id){
		var tbody = $('#'+id).find('tbody');
		tbody.html('');
	},
	serverSide:function(id,columns,url,custParam=null,columnDefs=null){
		var urutan = [0, 'desc'];

		var search = true;
		var bLength = true;
		var bInfo = true;
		var page = true;
		
		if (id == 'tableUser') {
			search = false;
		}

		var svrTable = $("#"+id).DataTable({
			// processing:true,
			serverSide:true,
			columnDefs:columnDefs,
			columns:columns,
			responsive: false,
			scrollX: true,
			scrollY: true,
			ajax:function(data, callback, settings){
				data.param = custParam
				ajax.getData(url,'post',data,function(result){
					// console.log(result)
					if(result.status=='reload'){
						ui.popup.show('confirm',result.messages.title,result.messages.message,'refresh');
					}else if(result.status=='logout'){
	        			ui.popup.alert(result.messages.title,result.messages.message,'logout');
	        		}else{
						// if untuk menampilkan respon summary ketika servicenya jadi 1
						if (id == 'tableReport') {
							$('#summary_unpaid').html(result.summary.unpaid)
							$('#summary_paid').html(result.summary.paid)
							$('#summary_expired').html(result.summary.expired)
						}
						callback(result);
					}
				})
			},
			bDestroy: true,
			bLengthChange: bLength,
			bInfo: bInfo,
			searching:search,
			order:urutan,
			ordering:true,
			bPaginate:page,
			language: {
				paginate: {
				  	next: '<i class="fas fa-chevron-right"></i>',
				  	previous: '<i class="fas fa-chevron-left"></i>',
					first: '<i class="fas fa-angle-double-left"></i>',
					last: '<i class="fas fa-angle-double-right"></i>'
				}
			},
			pagingType: 'full_numbers'
		})
		// svrTable.columns.adjust();
		$('div.dataTables_filter input').unbind();
        $('div.dataTables_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13){
	          svrTable.search(this.value).draw();
            }
        });
	},
	setAndPopulate:function(id,columns,data,columnDefs,ops,order){

		var orderby = order? order:[0,"asc"];
		var option = {
			"data": data,
			"drawCallback": function( settings ) {

			},
			tableTools: {
				"sSwfPath": "assets/plugins/datatables/TableTools/swf/copy_csv_xls_pdf.swf",
					"aButtons": [ "xls", "csv", "pdf" ]
			},
			"columns": columns,
			"pageLength": 10,
			"order": [orderby],
			"bDestroy": true,
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
			"aoColumnDefs": columnDefs,
			"scrollX": true,
			"scrollY": true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	        "buttons": [
	            'csv','pdf'
	        ],
			"rowCallback": function( row, data ) {
				if(id == "tbl_notification") {
					if(data.read == "1") {
						$(row).css('background-color', '#D4D4D4');
					}
				}
				if(id == "tbl_mitra" || id == "tbl_user" || id == "tbl_agent_approved") {
					if(data.status == "0") {
						$(row).css('background-color', '#FF7A7A');
					}
				}
			}
		};
		if(ops!=null){
			$.extend(option,ops);
		}
		var tbody = $('#'+id).find('tbody');

		var t = $('#' + id).DataTable(option);
		t.on( 'order.dt search.dt', function () {
			if (id == 'tableFitur') {

			}else{
		        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
		            cell.innerHTML = i+1;
		        } );
			}
	    } )
	    .draw();
	}
}

// Action User
$('#tableUser tbody').on('click', 'button.btnViewUser', function (e) {
	var table = $('#tableUser').DataTable();
	var dataRow = table.row($(this).closest('tr')).data();
    console.log(dataRow)
	var id = encodeURIComponent(window.btoa(dataRow.id));
	$('.modalEditUser').attr('href', '/user/edit/'+id)

	$('.btnActionUser').removeClass('btnModalDeactiveUser')
	$('.btnActionUser').removeClass('btnModalActiveUser')

	$('.btnActionUser').data('id', dataRow.user_id)
	$('.btnActionUser').data('status', dataRow.status)
	$('.btnActionUser').data('name', dataRow.first_name+' '+dataRow.last_name)
	if (dataRow.status == 1) { //aktif
		$('.btnActionUser img').attr('src', '/image/icon/icon-action-deactive.svg')
		$('.btnActionUser').addClass('btnModalDeactiveUser')
		$('.btnActionUser p').html('Deactive')
	} else {
		$('.btnActionUser img').attr('src', '/image/icon/icon-action-active.svg')
		$('.btnActionUser').addClass('btnModalActiveUser')
		$('.btnActionUser p').html('Active')
	}

	$('#detailUserEmail').html(dataRow.email == null ? '-' : dataRow.email);
    $('#detailUserFirstName').html(dataRow.first_name == null ? '-' : dataRow.first_name);
    $("#detailUserNoHP").html(dataRow.telp == null || dataRow.telp == '' ? '-' : dataRow.telp)
	$("#detailUserAlamat").html(dataRow.alamat == null ? '-' : dataRow.alamat)
	$("#detailUserLastName").html(dataRow.last_name == null ? '-' : dataRow.last_name)
	$("#detailUserNIP").html(dataRow.nip == null ? '-' : dataRow.nip)
	$("#detailUserJabatan").html(dataRow.jabatan == null ? '-' : dataRow.jabatan)
	$("#detailUserRole").html(dataRow.role_title)

	$('#modalViewUser').modal('show');

	if ($('.btnActionUser').length) {
		$('.btnActionUser').click(function (e) {
			$('.modal').modal('hide')

			var id = $(this).data('id')
			var status = $(this).data('status')
			var name = $(this).data('name')
			console.log(status)
			if (status == 1) {
				$('#nameUser b').html('')

				$('#idUserDeactive').val(id)
				$('#idUserActive').val('')
				$('#nameUser b').html(name)

				$('#modalDeactiveUser').modal('show')
			} else if (status == 2) {
				$('#nameUser b').html('')

				$('#idUserDeactive').val('')
				$('#idUserActive').val(id)
				$('#nameUser b').html(name)

				$('#modalActiveUser').modal('show')
			}
		})
	}
});