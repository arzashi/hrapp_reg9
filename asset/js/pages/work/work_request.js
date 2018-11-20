var url;
var currentTime;
var validFlag;

$(function () {
	validFlag = true;
	currentTime = Math.floor(Date.now());
	if($('#work_attachment').val() != "")
		currentTime = parseInt($('#work_attachment').val());
	
	// Change this to the location of your server-side upload handler:
	url = $('#base_url').val() + 'asset/upload/',
		uploadButton = $('<button/>')
			.addClass('btn btn-primary')
			.prop('disabled', true)
			.text('Processing...')
			.on('click', function () {
				var $this = $(this),
					data = $this.data();
				$this
					.off('click')
					.text('Abort')
					.on('click', function () {
						$this.remove();
						data.abort();
					});
				data.submit().always(function () {
					$this.remove();
				});
			});
	SetFileUpload();
	
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
	
	$('input[type=radio][name=car_selected]').change(function() {
        displayCarDetail(this.value);
    });

	$('#docNo').change(function() {
        checkDocNo();
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

});

function SetFileUpload()
{
	
	$('#fileupload').fileupload({
		url: url,
		dataType: 'json',
		autoUpload: false,
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf|doc|docx|xls|xlsx)$/i,
		maxFileSize: 999000,
		// Enable image resizing, except for Android and Opera,
		// which actually support image resizing, but fail to
		// send Blob objects via XHR requests:
		disableImageResize: /Android(?!.*Chrome)|Opera/
			.test(window.navigator.userAgent),
		previewMaxWidth: 100,
		previewMaxHeight: 100,
		previewCrop: true
	}).on('fileuploadadd', function (e, data) {
		data.context = $('<div/>').appendTo('#checklist_files');
		$.each(data.files, function (index, file) {
			var node = $('<p/>')
					.append($('<span/>').text(file.name));
			if (!index) {
				node
					.append('<br>')
					.append(uploadButton.clone(true).data(data));
			}
			node.appendTo(data.context);
		});
	}).on('fileuploadprocessalways', function (e, data) {
		var index = data.index,
			file = data.files[index],
			node = $(data.context.children()[index]);
		if (file.preview) {
			node
				.prepend('<br>')
				.prepend(file.preview);
		}
		if (file.error) {
			node
				.append('<br>')
				.append($('<span class="text-danger"/>').text(file.error));
		}
		if (index + 1 === data.files.length) {
			data.context.find('button')
				.text('Upload')
				.prop('disabled', !!data.files.error);
		}
	}).on('fileuploadprogressall', function (e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#progress .progress-bar').css(
			'width',
			progress + '%'
		);
	}).on('fileuploaddone', function (e, data) {
		$.each(data.result.files, function (index, file) {
			if (file.url) {
				$(data.context.children()[index])
					.append('<button type="button" class="btn btn-danger delete" onclick="DeleteAttachment(this,\'' + file.name
											+ '\')"><i class="glyphicon glyphicon-trash"></i><span>Delete</span></button>');
			} else if (file.error) {
				var error = $('<span class="text-danger"/>').text(file.error);
				$(data.context.children()[index])
					.append('<br>')
					.append(error);
			}
		});
	}).on('fileuploadfail', function (e, data) {
		$.each(data.files, function (index) {
			var error = $('<span class="text-danger"/>').text('File upload failed.');
			$(data.context.children()[index])
				.append('<br>')
				.append(error);
	});
	}).prop('disabled', !$.support.fileInput)
			.parent().addClass($.support.fileInput ? undefined : 'disabled'); 
			
	$('#fileupload').bind('fileuploadsubmit', function (e, data) {
		data.formData = {org: $('#org_id').val() , user_id: $('#code').val() , timeStamp: currentTime };
	});	
}

function DeleteAttachment(button,fileName)
{
	$.ajax({
			url: $('#base_url').val() + 'index.php/Leave_Service/deleteAttachment',
			data: {
				org: $('#org_id').val(),
				user_id: $('#code').val(),
				timeStamp: currentTime,
				fileName: fileName
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if(data == true)
					$(button).parent().parent().remove();
			}
		});	
}

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
		if($('#sumWork').val() != 0)
			sumWork -= 0.5;
		
		$('#sumWork').val(sumWork);
	}else
	{
		$('#sumWork').val('');
	}
}

function displayCarDetail(value)
{
	if(value == 1 || value == 2)
	{
		$('#carDescTxt').empty().append('หมายเลขทะเบียน');
		$('#carDesc').show();
		$('#carUserDescTxt').show();
	}else if(value == 3)
	{
		$('#carDescTxt').empty();
		$('#carDesc').hide();
		$('#carUserDescTxt').hide();
	}else
	{
		$('#carDescTxt').empty().append('กรุณาระบุ');
		$('#carDesc').show();
		$('#carUserDescTxt').hide();
	}
	
}

function saveWork()
{
	if(parseFloat($('#sumWork').val()) > 0 && validFlag == true && validateData() == true)
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
			url: $('#base_url').val() + 'index.php/Work_Service/saveWork',
			data: {
				work_id: $('#work_id').val(),
				docNo: $('#docNo').val(),
				startdate: $('#startWork').val(),
				enddate: $('#endWork').val(),
				sumWork: $('#sumWork').val(),
				detail: $('#descriptionWork').val(),
				locationWork: $('#placeWork').val(),
				work_standby: $('#standbyWork').val(),
				work_attachment: currentTime,
				cartype_id: $('input[name=car_selected]:checked').val(),
				car_detail1: $('#carDesc').val(),
				car_detail2: $('#carUser').val(),
				empList: employeeList
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				if (!isNaN(parseInt(data))) {
					$('#docNo').val(data);
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
	return ($('#descriptionWork').val().trim() && $('#placeWork').val().trim() && $('#sumWork').val().trim() && $('input[name=car_selected]:checked').val());	
}

function checkDocNo()
{
	$.ajax({
			url: $('#base_url').val() + 'index.php/Work_Service/checkDocNo',
			data: {
				docNo: $('#docNo').val()
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				validFlag = data;
				if(data == false)
				{
					alert('เลขที่เอกสารซ้ำกับในระบบ');
					$('#docNo').focus();
				}
			}
		});	
}