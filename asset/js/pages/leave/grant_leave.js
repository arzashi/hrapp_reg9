$(function () {   
     
	$('#save_btn').click(function () {
           
            
            var con = confirm("ยืนยันดำเนินการ");
            if (con==true) {
                //saveLeave();
                //alert($($('input[type=hidden]')[3]).val());
            }
           
    });
    
});

/**** test confirm login
$(function () {   
    $('#save_btn').click(function () {
        var thePrompt = window.open("", "", "widht=500");
        var theHTML = "";

        theHTML += "<p>The server http://localhost:8888 requires a username and password. The server says: These are restricted files, please authenticate yourself.</p>";
        theHTML += "<br/>";
        theHTML += "Username: <input type='text' id='theUser' placeholder='Enter Username...'/>";
        theHTML += "<br />";
        theHTML += "Password: <input type='text' id='thePass' placeholder='Enter Password...'/>";
        theHTML += "<br />";
        theHTML += "<input type='button' value='OK' id='authOK'/>";
        thePrompt.document.body.innerHTML = theHTML;

        var theUser = thePrompt.document.getElementById("theUser").value;
        var thePass = thePrompt.document.getElementById("thePass").value;
        thePrompt.document.getElementById("authOK").onclick = function () {
            doAuthentication(theUser, thePass);
        }
    });
});

function doAuthentication(user, pass) {
    //do authentication
    alert();
}
*/
function doSign()
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
                            var approve_code = $($('input[type=hidden]')[2]).val();
                            var grant_level = $($('input[type=hidden]')[3]).val();
                            approveValue = $('input[name=leave_type_' + leave_id + ']:checked').val();
                            if(parseInt(approveValue) == 0 || parseInt(approveValue) == 1)
                                    saveList.push(
                                        {
                                            "leave_id":leave_id,
                                            "approveValue": approveValue,
                                            "reason":  reason,
                                            "sumleave":sumleave,
                                            "grant_level":grant_level,
                                            "approve_code":approve_code
                                        }
                                    );
                    }
            }

            $.ajax({
                    url: $('#base_url').val() + 'index.php/Leave_Service/saveGrant',
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
                            var approve_code = $($('input[type=hidden]')[2]).val();
                            var grant_level = $($('input[type=hidden]')[3]).val();
                            approveValue = $('input[name=leave_type_' + leave_id + ']:checked').val();
                            if(parseInt(approveValue) == 0 || parseInt(approveValue) == 1)
                                    saveList.push(
                                        {
                                            "leave_id":leave_id,
                                            "approveValue": approveValue,
                                            "reason":  reason,
                                            "sumleave":sumleave,
                                            "grant_level":grant_level,
                                            "approve_code":approve_code
                                        }
                                    );
                    }
            }

            $.ajax({
                    url: $('#base_url').val() + 'index.php/Leave_Service/saveGrant',
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

