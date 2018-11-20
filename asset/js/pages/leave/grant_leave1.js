$(function () {   
     
	$('#save_btn').click(function () {
        saveLeave();
    });
});

function saveLeave()
{
	var hiddens = $('input[type=hidden]');
	var saveList = [];
	for(var i=0 ; i< hiddens.length ; i++)
	{
		if($('input[type=hidden]')[i].id != 'base_url')
		{
			var leave_id = $($('input[type=hidden]')[i]).val();
			var reason = $('#reject_reason_' + leave_id).val();
			var sumleave = $('#sum_leave_' + leave_id).text();
			approveValue = $('input[name=leave_type_' + leave_id + ']:checked').val();
			if(parseInt(approveValue) == 0 || parseInt(approveValue) == 1)
				saveList.push({"leave_id":leave_id,"approveValue": approveValue,"reason":  reason,"sumleave":sumleave});
		}
	}
	
	$.ajax({
		url: $('#base_url').val() + 'index.php/Leave_Service/saveGrant1',
		data: {
			grantList: saveList
		},
		dataType: 'json',
		type: 'POST',
		success: function (data) {
			if (data == true) {
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