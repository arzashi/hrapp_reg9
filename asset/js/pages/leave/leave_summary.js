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

});

function searchLeave()
{
	table.clear().draw();
	$.ajax({
		url: $('#base_url').val() + 'index.php/Leave_Service/listLeave',
		data: {
			start_date: $('#startLeaveDate').val(),
			end_date: $('#endLeaveDate').val(),
			emp_code: $('#emp_code').val(),
			method: 'HR'
		},
		dataType: 'json',
		type: 'GET',
		success: function (data) {
			if (data.length > 0) {
			for (var i = 0 ; i < data.length ; i++) {
				table.row.add([
					'<center>' + (i+1) + '</center>',
					data[i].username,
					data[i].gender + "     " + data[i].name + "     " + data[i].surname,
					data[i].position,
					data[i].level,
					data[i].job_name,
					data[i].Leave_type_code + '    ' + data[i].Leave_type_desc,
					'<center>' + data[i].start_date + '</center>',
					'<center>' + data[i].end_date + '</center>',
					'<center>' + data[i].sum_leave + '</center>',
					data[i].attachment,
					data[i].approve_user
				]).draw();
			}
		}
		}
	});	
	
}

function generateReport()
{
	var	start_date = $('#startLeaveDate').val();
	var	end_date = $('#endLeaveDate').val();
	var	emp_code = $('#emp_code').val();
	var win = window.open($('#base_url').val() + 'index.php/download/leave_download?start_date=' + start_date + '&end_date=' 
												+ end_date + "&method=HR&emp_code=" + emp_code , '_blank');
	if (win) {
		//Browser has allowed it to be opened
		win.focus();
	} else {
		//Browser has blocked it
		alert('Please allow popups for this website');
	}
}