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
			url: $('#base_url').val() + 'index.php/WorkReport_Service/listWorkReport',
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
						
						var edit = '<center><a href="' + $('#base_url').val() + 'index.php/work/workReport?work_report_id=' + data[i].id + '"><button class="btn btn-flat btn-warning">ดู/แก้ไข</button></a></center>';
						
						var del = '<center><button class="btn btn-flat btn-danger" onclick="deleteWorkReport(' + i+1 + ',\'' + data[i].id + '\')">ลบ</button></a></center>';
						
						if (data[i].create_by != $('#code').val())
						{
							edit = '';
							del = '';
						}
						if(data[i].approve_1 == "0" || data[i].approve_1 == "1")
						{
							del = '';
						}
						
						table.row.add([
							'<center>' + (i+1) + '</center>',
							data[i].Work_type_code + '  ' + data[i].Work_type_desc,
							data[i].detail,
							data[i].location,
							'<center>' + data[i].startdate + '</center>',
							'<center>' + data[i].enddate + '</center>',
							'<center>' + data[i].sumWorkReport + '</center>',
							edit ,
							del
						]).draw();
					}
				}
			}
		});		
}

function deleteWorkReport(docNo , work_id)
{
	var con = confirm("ยืนยันลบรายงานการเดินทางหมายเลข   " + docNo);
	if (con == true) {
		$.ajax({
			url: $('#base_url').val() + 'index.php/WorkReport_Service/removeWorkReport',
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
	var win = window.open($('#base_url').val() + 'index.php/download/workreport_download?start_date=' + start_date + '&end_date=' 
												+ end_date , '_blank');
	if (win) {
		//Browser has allowed it to be opened
		win.focus();
	} else {
		//Browser has blocked it
		alert('Please allow popups for this website');
	}
}