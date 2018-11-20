$(function () {
	$('#save_btn').click(function () {
        saveWork();
    });
});

function saveWork()
{
	var hiddens = $('input[type=hidden]');
	var saveList = [];
	for(var i=0 ; i< hiddens.length ; i++)
	{
		if($('input[type=hidden]')[i].id != 'base_url')
		{
			var work_id = $($('input[type=hidden]')[i]).val();
			var reason = $('#reject_reason_' + work_id).val();
			approveValue = $('input[name=work_type_' + work_id + ']:checked').val();
			if(parseInt(approveValue) == 0 || parseInt(approveValue) == 1)
				saveList.push({"work_id":work_id,"approveValue": approveValue,"reason":  reason});
		}
	}
	
	$.ajax({
		url: $('#base_url').val() + 'index.php/WorkReport_Service/saveGrant3',
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