
$(function () {
    table = $('#tbl').DataTable({"bPaginate": false});
	
	$('#add_employee_btn').click(function () {
        addEmployee();
    });
		
	$('#search_btn').click(function () {
        searchEmployee();
    });
	
	$('#save_btn').click(function () {
        saveEmployee();
    });
	
	$('#emp_start_work').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true
	});
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
		$.ajax({
			url: $('#base_url').val() + 'index.php/Emp_Service/getEmployeeByCondition',
			data: {
				emp_code: $('#code').val(),
				name: $('#name').val(),
				department: $('#department').val(),
				position: $('#position').val(),
				job_name: $('#job').val(),
				work_date: ''
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if (data.length > 0) {
					for (var i = 0 ; i < data.length ; i++) {
						table.row.add([
							'<input class="form-control" type="text" id="'+ data[i].code + '_code" value="' + data[i].code + '" disabled />',
							'<input class="form-control" type="text" id="'+ data[i].code + '_gender" value="' + data[i].gender + '" />',
							'<input class="form-control" type="text" id="'+ data[i].code + '_name" value="' + data[i].name + '" />',
							'<input class="form-control" type="text" id="'+ data[i].code + '_surname" value="' + data[i].surname + '" />',
							'<input class="form-control" type="text" id="'+ data[i].code + '_position" value="' + data[i].position + '" list="pos" />',
							'<input class="form-control" type="number" id="'+ data[i].code + '_level" value="' + data[i].level + '" />',
							'<input class="form-control" type="text" id="'+ data[i].code + '_job_name" value="' + data[i].job_name + '" list="jobs" />',
							'<input class="form-control" type="text" id="'+ data[i].code + '_div_code" value="' + data[i].div_code + '" list="dept" />',
							'<input class="form-control date-input" type="text" id="'+ data[i].code + '_start_work" value="' + data[i].start_work + '" />',
							'<input type="checkbox" id="'+ data[i].code + '" />'
						]).draw();
					}
					
					$('.date-input').datepicker({
						format: 'dd/mm/yyyy',
						autoclose: true
					});
					
				}
			}
		});	
}

function addEmployee()
{
	var emp_code = $('#emp_code').val();
	
	if(emp_code == ''){
		alert('กรุณากรอกรหัสพนักงาน');
	}
	else
	{
		$.ajax({
			url: $('#base_url').val() + 'index.php/Work_Service/getEmployeeByCode',
			data: {
				code: emp_code
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if ((data == null || data.length == 0) && $('#' + emp_code ).val() == undefined) {
					var emp = {
						code: emp_code,
						gender: $('#emp_gender').val(),
						name: $('#emp_name').val(),
						surname: $('#emp_surname').val(),
						position: $('#emp_position').val(),
						level: $('#emp_level').val(),
						job_name: $('#emp_job').val(),
						div_code: $('#emp_department').val(),
						start_work: $('#emp_start_work').val(),
					};
					table.row.add([
						'<input class="form-control" type="text" id="'+ emp.code + '_code" value="' + emp.code + '" disabled />',
						'<input class="form-control" type="text" id="'+ emp.code + '_gender" value="' + emp.gender + '" />',
						'<input class="form-control" type="text" id="'+ emp.code + '_name" value="' + emp.name + '" />',
						'<input class="form-control" type="text" id="'+ emp.code + '_surname" value="' + emp.surname + '" />',
						'<input class="form-control" type="text" id="'+ emp.code + '_position" value="' + emp.position + '" list="pos" />',
						'<input class="form-control" type="number" id="'+ emp.code + '_level" value="' + emp.level + '" />',
						'<input class="form-control" type="text" id="'+ emp.code + '_job_name" value="' + emp.job_name + '" list="jobs" />',
						'<input class="form-control" type="text" id="'+ emp.code + '_div_code" value="' + emp.div_code + '" list="dept" />',
						'<input class="form-control date-input" type="text" id="'+ emp.code + '_start_work" value="' + emp.start_work + '" />',
						'<input type="checkbox" id="'+ emp.code + '" />'
					]).draw();
					clearModal();
					$('#employeeModal').modal('hide');
					
					
					$('.date-input').datepicker({
						format: 'dd/mm/yyyy',
						autoclose: true
					});
				}else
				{
					alert('รหัสพนักงานซ้ำกับที่มีอยู่');
				}
			}
		});		
	}
}

function clearModal(){
	$('#emp_code').val('');
	$('#emp_gender').val('');
	$('#emp_name').val('');
	$('#emp_surname').val('');
	$('#emp_position').val('');
	$('#emp_level').val('');
	$('#emp_job').val('');
	$('#emp_department').val('');
	$('#emp_start_work').val('');
}

function saveEmployee(){
	var hiddens = $('input[type=checkbox]');
	var saveList = [];
	var deleteList = [];
	for(var i=0 ; i< hiddens.length ; i++)
	{
			var emp_code = $($('input[type=checkbox]')[i]).attr('id');
			if(document.getElementById(emp_code).checked)
			{
				deleteList.push({code: emp_code});
			}else
			{
				var emp = {
						code: emp_code,
						gender: $('#' + emp_code + '_gender').val(),
						name: $('#' + emp_code + '_name').val(),
						surname: $('#' + emp_code + '_surname').val(),
						position: $('#' + emp_code + '_position').val(),
						level: $('#' + emp_code + '_level').val(),
						job_name: $('#' + emp_code + '_job_name').val(),
						div_code: $('#' + emp_code + '_div_code').val(),
						start_work: $('#' + emp_code + '_start_work').val()
					};
				saveList.push(emp);			
			}
	}
	
	$.ajax({
			url: $('#base_url').val() + 'index.php/Emp_Service/saveEmployee',
			data: {
				saveList: saveList,
				deleteList: deleteList
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