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
							data[i].alluser,
							'<center>' + data[i].docno + '</center>',
							data[i].Work_type_code + '  ' + data[i].Work_type_desc,
							data[i].detail,
							data[i].location,
							'<center>' + data[i].startdate + '</center>',
							'<center>' + data[i].enddate + '</center>',
							'<center>' + data[i].sumWorkReport + '</center>'
						]).draw();
					}
				}
			}
		});		
}


function generateReport()
{
	var	start_date = $('#startWork').val();
	var	end_date = $('#endWork').val();
	var	emp_code = $('#emp_code').val();
	var win = window.open($('#base_url').val() + 'index.php/download/workreport_download?start_date=' + start_date + '&end_date=' 
												+ end_date + "&method=HR&emp_code=" + emp_code , '_blank');
	if (win) {
		//Browser has allowed it to be opened
		win.focus();
	} else {
		//Browser has blocked it
		alert('Please allow popups for this website');
	}
}