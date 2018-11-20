
$(function () {
    table = $('#tbl').DataTable({"bPaginate": false});
	
	$('#search_btn').click(function () {
        searchEmployee();
    });
	
	$('#save_btn').click(function () {
        saveWorktime();
    });
	
	$('#work_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    })
	$('#work_date').datepicker('setDate', new Date());
	
});

function searchEmployee()
{
	var r = confirm("การค้นหาจะทำให้ข้อมูลที่ยังไม่ถูกบันทึกหายไป ต้องการค้นหาต่อหรือไม่!");
	if (r == true) {
		sarchEmployeeByCondition();
	}
}

function sarchEmployeeByCondition()
{
	table.clear().draw();
	var is_holiday = false;
		$.ajax({
			url: $('#base_url').val() + 'index.php/Emp_Service/getEmployeeByCondition',
			data: {
				emp_code: $('#code').val(),
				name: $('#name').val(),
				department: $('#department').val(),
				position: $('#position').val(),
				job_name: $('#job').val(),
				work_date: $('#work_date').val()
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if (data.length > 0) {
					for (var i = 0 ; i < data.length ; i++) {
						var worktime = data[i].work_time;
						if (worktime == null)
							worktime = '-'
						
						table.row.add([
							data[i].code ,
							data[i].gender + data[i].name + '    ' + data[i].surname,
							data[i].position,
							data[i].level,
							data[i].job_name,
							data[i].div_code,
							'<input class="form-control data-mask" type="text" id="'+ data[i].code + '_work_time" value="' + worktime + '" />' +
							'<input type="hidden" value="' + data[i].code + '">'
						]).draw();
						
						if(data[i].is_holiday == 1)
							is_holiday = true;
						
					}
					$(".data-mask").inputmask("99.99-99.99");
				}
				document.getElementById("is_holiday").checked = is_holiday;
			}
		});	
}

function saveWorktime(){
	var hiddens = $('input[type=hidden]');
	var saveList = [];
	for(var i=0 ; i< hiddens.length ; i++)
	{
		if($('input[type=hidden]')[i].id != 'base_url')
		{
			var emp_id = $($('input[type=hidden]')[i]).val();
			var work_time = $('#' + emp_id + '_work_time').val();
			var work_date = $('#work_date').val();
			saveList.push({"emp_code":emp_id,"work_time": work_time,"work_date":work_date});
		}
	}
	
	$.ajax({
			url: $('#base_url').val() + 'index.php/Emp_Service/saveWorktime',
			data: {
				saveList: saveList,
				is_holiday: (document.getElementById("is_holiday").checked ? 1 : 0)
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if (data == true) {
					$('.alert').removeClass('alert-danger');
					$('.alert').addClass('alert-success');
					$('#alert_body').html('<strong>สำเร็จ</strong>  บันทึกข้อมูลเรียบร้อย');
				} else {
					$('.alert').removeClass('alert-success');
					$('.alert').addClass('alert-danger');
					$('#alert_body').html('<strong>ผิดพลาด</strong> เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้');
				}
				window.scrollTo(0, 0);
				$('.alert').show();
				sarchEmployeeByCondition();
			}
	});	

}