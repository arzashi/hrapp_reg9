$(function () {
    table = $('#tbl').DataTable();
	
    $('#startWork').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    $('#endWork').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
	
    $('#search_btn').click(function () {
        searchWork();
    });

    $('#report_btn').click(function () {
        generateReport();
    });
	
});


function searchWork()
{
    table.clear().draw();
	$.ajax({
			url: $('#base_url').val() + 'index.php/Work_Service/listWork',
			data: {
				start_date: $('#startWork').val(),
				end_date: $('#endWork').val(),
				method: 'report'
			},
			dataType: 'json',
			type: 'GET',
			success: function (data) {
				if (data.length > 0) {
					for (var i = 0 ; i < data.length ; i++) {
						
						var edit = '<center><a href="' + $('#base_url').val() + 'index.php/work/request?work_id=' + data[i].id + '"><button class="btn btn-flat btn-warning">ดู/แก้ไข</button></a></center>';
						
						var del = '<center><button class="btn btn-flat btn-danger" onclick="deleteWork(' + i+1 + ',\'' + data[i].id + '\')">ลบ</button></a></center>';
						
						var approveTxt = 'ยังไม่อนุมัติ';
						if (data[i].create_by != $('#code').val())
						{
							edit = '';
							del = '';
						}
						if(data[i].approve_1 == "0")
						{
							del = '';
							approveTxt = 'ไม่อนุมัติ';
						}else if (data[i].approve_1 == "1")
						{
							del = '';
							approveTxt = 'อนุมัติ';
						}
						
						table.row.add([
							'<center>' + (i+1) + '</center>',
							'<center>' + data[i].docno + '</center>',
							data[i].detail,
							data[i].location,
							'<center>' + data[i].startdate + '</center>',
							'<center>' + data[i].enddate + '</center>',
							'<center>' + data[i].sumWork + '</center>',
							data[i].attachment,
							approveTxt,
							edit ,
							del
						]).draw();
					}
				}
			}
		});		
}

function deleteWork(docNo , work_id)
{
	var con = confirm("ยืนยันลบขออนุมัติเดินทางหมายเลข   " + docNo);
	if (con == true) {
		$.ajax({
			url: $('#base_url').val() + 'index.php/Work_Service/removeWork',
			data: {
				work_id: work_id,
			},
			dataType: 'json',
			type: 'GET',
			success: function (data) {
				if (!isNaN(parseInt(data))) {
					$('.alert').removeClass('alert-danger');
					$('.alert').addClass('alert-success');
					$('#alert_body').html('<strong>สำเร็จ</strong>  ลบข้อมูลเรียบร้อย');

					$('#save_btn').prop('disabled', true);
				} else {
					$('.alert').removeClass('alert-success');
					$('.alert').addClass('alert-danger');
					$('#alert_body').html('<strong>ผิดพลาด</strong> เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้');

					$('#save_btn').prop('disabled', false);
				}
				$('.alert').show();
				searchWork();
			}
		});	
	}
}

function generateReport()
{
	var	start_date = $('#startWork').val();
	var	end_date = $('#endWork').val();
	var win = window.open($('#base_url').val() + 'index.php/download/work_download?start_date=' + start_date + '&end_date=' 
												+ end_date , '_blank');
	if (win) {
		//Browser has allowed it to be opened
		win.focus();
	} else {
		//Browser has blocked it
		alert('Please allow popups for this website');
	}
}