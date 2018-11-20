
$(function () {
	$('#generate_btn').click(function () {
        generateSAPFile();
    });
	
	$('#start_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
	
	$('#end_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
	
});


function generateSAPFile()
{
	if($('#department').val() == '')
	{
		alert('กรุณาเลือกประปาสาขา / กอง');
	}else if($('#start_date').val() == '' || $('#end_date').val() == '')
	{
		alert('กรุณาเลือกวันที่เริ่มต้นและสิ้นสุด');
	}else
	{
		$('#file_download').empty();
		$.ajax({
			url: $('#base_url').val() + 'index.php/Emp_Service/generateTextFile',
			data: {
				start_date:$('#start_date').val(),
				end_date:$('#end_date').val(),
				department:$('#department').val(),
				file_type:$('#file_type').val()
			},
			dataType: 'json',
			type: 'POST',
			success: function (data) {
				$('#file_download').append('<a download="file.txt" href="' + $('#base_url').val() + data + '">'
				+ $('#file_type').val() + '</a>');
			}
		});
	}
}