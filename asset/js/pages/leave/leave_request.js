var url;
var currentTime;

$(function () {
	currentTime = Math.floor(Date.now());
	if($('#leave_attachment').val() != "")
		currentTime = parseInt($('#leave_attachment').val());
	
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
	
    $('#startLeave1').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function(e) {
        calculateSumLeave1();
    });
	
    $('#endLeave1').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function(e) {
        calculateSumLeave1();
    });
	
	$( "#timeLeave1" ).change(function() {
	  calculateSumLeave1();
	});

    $('#startLeave2').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function(e) {
        calculateSumLeave2();
    });
	
    $('#endLeave2').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function(e) {
        calculateSumLeave2();
    });

	$( "#timeLeave2" ).change(function() {
	  calculateSumLeave2();
	});
	
    $('#save_btn').click(function () {
        validateLeave();
    });

	if($('#is_approve').val() == "0" || $('#is_approve').val() == "1")
	{
		$("#content-form :input").attr("disabled", true);
	}
	
});

function calculateSumLeave1()
{
	if($('#startLeave1').val() != '' && $('#endLeave1').val() != '')
	{
		sumLeave = 0;
		var date1 = $("#startLeave1").datepicker("getDate");
		var date2 = $("#endLeave1").datepicker("getDate");
		var timeDiff = date2.getTime() - date1.getTime();
		sumLeave = Math.ceil(timeDiff / (1000 * 3600 * 24));
		sumLeave += 1;
		if($('#timeLeave1').val() != 0)
			sumLeave -= 0.5;
		
		$('#sumLeave1').val(sumLeave);
	}else
	{
		$('#sumLeave1').val('');
	}
}

function calculateSumLeave2()
{
	if($('#startLeave2').val() != '' && $('#endLeave2').val() != '')
	{
		sumLeave = 0;
		var date1 = $("#startLeave2").datepicker("getDate");
		var date2 = $("#endLeave2").datepicker("getDate");
		var timeDiff = date2.getTime() - date1.getTime();
		sumLeave = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
		sumLeave += 1;		
		if($('#timeLeave2').val() != 0)
			sumLeave -= 0.5;
		
		$('#sumLeave2').val(sumLeave);
	}else
	{
		$('#sumLeave2').val('');
	}
}

function validateLeave()
{
	var leaveType = $('input[name=leave_type]:checked').val();
	var sumLeave1 = parseFloat($('#sumLeave1').val());
	sumLeave1 = (isNaN(sumLeave1) ? 0 : sumLeave1) ;
	var sumLeave2 = parseFloat($('#sumLeave2').val());
	sumLeave2 = (isNaN(sumLeave2) ? 0 : sumLeave2) ;
	
	if(leaveType !== undefined &&  (sumLeave1 > 0 || sumLeave2 > 0))
	{
		var previousLeave = 0;
		
		if(parseInt(leaveType) == 4)
		{
			previousLeave = parseInt($('#sick_sum').val()) + sumLeave1 + sumLeave2;
			if (previousLeave > 10)
			{
				alert("คุณใช้โควต้าวันลาพักผ่อนเกินกำหนด");
			}else
			{
					SaveLeave();
			}
		}else
		{
			previousLeave = parseInt($('#holiday_sum').val()) + sumLeave1 + sumLeave2;
			if (previousLeave > 30)
			{
				alert("คุณใช้โควต้าวันลาป่วยเกินกำหนด");
			}else
			{
				SaveLeave();
			}
		}	
	}else
	{
		$('.alert').removeClass('alert-success');
		$('.alert').addClass('alert-danger');
		$('#alert_body').html('<strong>ผิดพลาด</strong> กรุณาบันทึกข้อมูลให้ครบถ้วน');
		window.scrollTo(0, 0);
		$('.alert').show();
	}
}

function SaveLeave()
{
	$.ajax({
			url: $('#base_url').val() + 'index.php/Leave_Service/saveLeave',
			data: {
				leave_id: $('#leave_id').val(),
				leave_type: $('input[name=leave_type]:checked').val(),
				leave_standby: $('#acting').val(),
				leave_attachment: currentTime,
				username: $('#code').val(),
				startLeave1: $('#startLeave1').val(),
				endLeave1: $('#endLeave1').val(),
				timeLeave1: $('#timeLeave1').val(),
				sumLeave1: $('#sumLeave1').val(),
				startLeave2: $('#startLeave2').val(),
				endLeave2: $('#endLeave2').val(),
				timeLeave2: $('#timeLeave2').val(),
				sumLeave2: $('#sumLeave2').val()
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
}

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