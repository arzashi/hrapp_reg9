var myApp;

$(function () {

    $('#closeAlert').click(function () {
        $('.alert').hide();
    });

    myApp = myApp || (function () {
        var pleaseWaitDiv = $('#pleaseWaitDialog');
        return {
            showPleaseWait: function () {
                pleaseWaitDiv.modal();
                $("#pleaseWaitDialog").removeClass("hide");
            },
            hidePleaseWait: function () {
                pleaseWaitDiv.modal('hide');
                $("#pleaseWaitDialog").addClass("hide");
            },
        };
    })();
	
    if ($("#group_itemID").val())
    {
        GetTypeItems();

        $("#group_itemID").change(function () {
            GetTypeItems();
        });
    }
	
	$( document ).ajaxStart(function() {
	  myApp.showPleaseWait();
	});
	
	$( document ).ajaxComplete(function() {
	  myApp.hidePleaseWait();
	});

	$( document ).ajaxError(function() {
	  myApp.hidePleaseWait();
	});
	
	getNotify();
});

function getNotify()
{	
	$.ajax({
		url: $('#base_url').val() + 'index.php/Emp_Service/getNotify',
		data: {},
		dataType: 'json',
		type: 'POST',
		success: function (data) {
			if (data.length > 0)
			{
				$('#notify_number').append(data.length);
				$('#header_notify').append('มี ' + data.length + 'การแจ้งเตือน');
				
				for(var i=0 ; i<data.length ; i++)
				{
					var approve_text = (data[i].approve_3 == 1)? '(อนุมัติแล้ว)' : '(รอการอนุมัติ)';
					
					if(data[i].description == "work")
					{
						var work_link = $('#base_url').val() + 'index.php/work/request?work_id=' + data[i].id
						$('#detail_notify').append('<li><a href="' + work_link + '"><i class="fa fa-users text-aqua"></i> อนุมัติเดินทาง  ' 
													+ approve_text + '  วันที่ ' + data[i].startdate + '</a></li>');
					}else
					{
						var leave_link = $('#base_url').val() + 'index.php/leave/request?leave_id=' + data[i].id
						$('#detail_notify').append('<li><a href="' + leave_link + '"><i class="fa fa-users text-aqua"></i> มีการลา  ' 
													+ approve_text + '  วันที่ ' + data[i].start_date + '</a></li>');
						
					}
				}
				
			}else
			{
				$('#notify_number').append(0);
				$('#header_notify').append('ไม่มีการแจ้งเตือนใหม่');
			}
		}
	});	
}