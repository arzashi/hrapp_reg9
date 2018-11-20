$(function () {
    table = $('#tbl').DataTable();
	
    $('#startLeaveDate').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    $('#endLeaveDate').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('#search_btn').click(function () {
        searchLeave();
    });
	
    $('#report_btn').click(function () {
        generateReport();
    });
	
	loadLeaveSummary();

});

function loadLeaveSummary()
{
	$.ajax({
		url: $('#base_url').val() + 'index.php/Leave_Service/getLeaveSummary',
		data: {},
		dataType: 'json',
		type: 'GET',
		success: function (data) {
			$('#sick_year').append(data['sick_year']);
			$('#holiday_year').append(data['holiday_year']);
			$('#sick_total').append(data["sick_sum"]);
			$('#holiday_total').append(data["holiday_sum"]);
		}
	});		
}

function searchLeave()
{
    table.clear().draw();
	$.ajax({
		url: $('#base_url').val() + 'index.php/Leave_Service/listLeave',
		data: {
			start_date: $('#startLeaveDate').val(),
			end_date: $('#endLeaveDate').val(),
			method: 'report'
		},
		dataType: 'json',
		type: 'GET',
		success: function (data) {
			if (data.length > 0) {
			for (var i = 0 ; i < data.length ; i++) {
				
				var edit = '<center><a href="' + $('#base_url').val() + 'index.php/leave/request?leave_id=' + data[i].leave_id + '"><button class="btn btn-flat btn-warning">ดู/แก้ไข</button></a></center>';
						
				var del = '<center><button class="btn btn-flat btn-danger" onclick="deleteLeave(' + i+1 + ',\'' + data[i].leave_id + '\')">ลบ</button></a></center>';
				
				var approveTxt = 'ยังไม่อนุมัติ';
				if(data[i].approve_3 == "0")
				{
					del = '';
					approveTxt = 'ไม่อนุมัติ';
				}else if (data[i].approve_3 == "1")
				{
					del = '';
					approveTxt = 'อนุมัติ';
				}
				
				
				table.row.add([
					'<center>' + (i+1) + '</center>',
					data[i].Leave_type_code + '    ' + data[i].Leave_type_desc,
					'<center>' + data[i].start_date + '</center>',
					'<center>' + data[i].end_date + '</center>',
					'<center>' + data[i].sum_leave + '</center>',
					data[i].attachment,
					approveTxt,
					edit,
					del
				]).draw();
			}
		}
		}
	});		
}

function deleteLeave(leave_no , leave_id)
{
	var con = confirm("ยืนยันลบการลาหมายเลข   " + leave_no);
	if (con == true) {
		$.ajax({
			url: $('#base_url').val() + 'index.php/Leave_Service/removeLeave',
			data: {
				leave_id: leave_id,
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
				searchLeave();
			}
		});	
	}
}

function generateReport()
{
	var	start_date = $('#startLeaveDate').val();
	var	end_date = $('#endLeaveDate').val();
	var win = window.open($('#base_url').val() + 'index.php/download/leave_download?start_date=' + start_date + '&end_date=' + end_date , '_blank');
	if (win) {
		//Browser has allowed it to be opened
		win.focus();
	} else {
		//Browser has blocked it
		alert('Please allow popups for this website');
	}
}