$(function () {
    $('#startWork').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function(e) {
        calculateSumWork();
    });
    $('#endWork').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function(e) {
        calculateSumWork();
    });
	
	$( "#timeWork" ).change(function() {
	  calculateSumWork();
	});
	
	$('#workRequestNo').change(function() {
        displayRequestDetail(this.value);
    });
	


    $('#addPerson_btn').click(function () {
        addPerson('','','','');
    });
    $('#save_btn').click(function () {
        saveWork();
    });

	if($('#is_approve').val() == "0" || $('#is_approve').val() == "1")
	{
		$("#content-form :input").attr("disabled", true);
	}
	
	getWorkDocNo();
});

function addPerson(code,name,position,level){
	var length = $('input[type=text][name=code_person]').length;
	$('#work_person').append('<div class="row"><div class="col-sm-2">รหัสพนักงาน  <input type="text" id="code_person' + length + '" ' + 
					'name="code_person" class="form-control" onchange="getEmployeeDetail(' + length + ')" value="' + code + '"></div>' +
					'<div class="col-sm-4">ชื่อ-นามสกุล  <input type="text" id="name_person' + length + '" class="form-control" value="' + 
					name + '"></div>' +
					'<div class="col-sm-4">ตำแหน่ง  <input type="text" id="position_person' + length + '" class="form-control" value="' + 
					position + '"></div>' +
					'<div class="col-sm-1">ชั้น  <input type="text" id="level_person' + length + '" class="form-control" value="' + 
					level + '"></div>' + 
					'<div class="col-sm-1"><br /><button class="btn btn-flat btn-danger" onclick="delPerson(' + length + ')">ลบ</button></div></div>');
	
}

function delPerson(index){
	
	var length = $('input[type=text][name=code_person]').length;
	var employeeList = [];
	for(var i=0 ; i < length ; i++)
	{
		var code = $("#code_person" + i).val();
		var name = $("#name_person" + i).val();
		var position = $("#position_person" + i).val();
		var level = $("#level_person" + i).val();
		if(i != index)  // Remove delete from employeeList
			employeeList.push({"code":code,"name":name,"position":position,"level":level});
	}
	$('#work_person').empty();
	for(var i=0 ; i < employeeList.length ; i++)
	{
		addPerson(employeeList[i].code , employeeList[i].name, employeeList[i].position, employeeList[i].level);
	}
}

function getWorkDocNo()
{
	var report_id = $("#work_report_id").val();
	if (report_id != "")
	{
		$.ajax({
			url: $('#base_url').val() + 'index.php/WorkReport_Service/getWorkByWorkReport',
			data: {
				report_id: report_id
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if(data)
				{
					$("#workRequestNo").val(data.docno);
					displayRequestDetail(data.docno);
				}
			}
		});	
	}
}


function getEmployeeDetail(index)
{
	var code = $("#code_person" + index).val();
	$.ajax({
			url: $('#base_url').val() + 'index.php/Work_Service/getEmployeeByCode',
			data: {
				code: code
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if(data)
				{
					$("#name_person" + index).val(data.gender + data.name +  '     ' + data.surname);
					$("#position_person" + index).val(data.position);
					$("#level_person" + index).val(data.level);
				}
			}
		});	
}


function calculateSumWork()
{
	if($('#startWork').val() != '' && $('#endWork').val() != '')
	{
		sumWork = 0;
		var date1 = $("#startWork").datepicker("getDate");
		var date2 = $("#endWork").datepicker("getDate");
		var timeDiff = date2.getTime() - date1.getTime();
		sumWork = Math.ceil(timeDiff / (1000 * 3600 * 24));
		sumWork += 1;
		if($('#timeWork').val() != 0)
			sumWork -= 0.5;
		
		$('#sumWork').val(sumWork);
	}else
	{
		$('#sumWork').val('');
	}
}

function displayRequestDetail(value)
{
	$('#request_detail').empty();
	$('#work_id').val('');
	$.ajax({
			url: $('#base_url').val() + 'index.php/WorkReport_Service/getWorkRequestByCode',
			data: {
				code: value
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if(data)
				{
					$('#request_detail').append('<br /> เพื่อปฏิบัติงาน' + data.detail + ' ณ สถานที่ ' + data.location + ' ณ วันที่ ' + data.startdate + ' ถึง ' + data.enddate + ' <br /> เดินทางโดย' + data.Car_type_desc);
					$('#work_id').val(data.id);
				}
			}
		});	
	
}

function saveWork()
{
	var confirmSave = true;
	if($('input[name=work_detail]:checked').val() == 1)
	{
		confirmSave = confirm("เฉพาะการอบรมที่มีเลขรุ่นหลักสูตรเท่านั้น");
	}

	if(validateData() && confirmSave)
	{
		var length = $('input[type=text][name=code_person]').length;
		var employeeList = [];
		employeeList.push({"code":$('#code').val()});
		for(var i=0 ; i < length ; i++)
		{
			var code = $("#code_person" + i).val();
			if(!isNaN(parseInt(code)))
				employeeList.push({"code":code});
		}
		
		$.ajax({
			url: $('#base_url').val() + 'index.php/WorkReport_Service/saveWorkReport',
			data: {
				work_report_id: $('#work_report_id').val(),
				work_type_id: $('input[name=work_detail]:checked').val(),
				startdate: $('#startWork').val(),
				enddate: $('#endWork').val(),
				timework: $('#timeWork').val(),
				sumWorkReport: $('#sumWork').val(),
				work_header_id: $('#work_id').val(),
				empList: employeeList
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if (!isNaN(parseInt(data))) {
					$('.alert').removeClass('alert-danger');
					$('.alert').addClass('alert-success');
					$('#alert_body').html('<strong>สำเร็จ</strong>  บันทึกข้อมูลเรียบร้อย');

					$('#save_btn').prop('disabled', true);
				} else {
					$('.alert').removeClass('alert-success');
					$('.alert').addClass('alert-danger');
					$('#alert_body').html('<strong>ผิดพลาด</strong> เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้');

					$('#save_btn').prop('disabled', false);
				}
				window.scrollTo(0, 0);
				$('.alert').show();
			}
		});	
	}else
	{
		$('.alert').removeClass('alert-success');
		$('.alert').addClass('alert-danger');
		$('#alert_body').html('<strong>ผิดพลาด</strong> กรุณาบันทึกข้อมูลให้ครบถ้วน');
		window.scrollTo(0, 0);
		$('.alert').show();
	}
	
}

function validateData()
{
	return (parseFloat($('#sumWork').val()) > 0 && $('#workRequestNo').val() != '' && $('#sumWork').val().trim());	
}