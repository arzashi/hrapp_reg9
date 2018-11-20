<script src="<?php echo base_url(); ?>asset/js/pages/leave/grant_leave2.js"></script>
<section class="content">
    <div class="row">
        <div class="box box-solid">
			<div class="box-header " >
				<i class="fa fa-check-square"></i>
				<h3 class="box-title">  อนุมัติการลา(ผอ กอง)</h3>
			</div>
            <div class="box-body table-responsive">
                <table id="tbl" class="table table-bordered table-hover" style="width:150%; max-width:150%">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center; ">รหัสพนักงาน</th>
                            <th width="10%" style="text-align:center; ">ชื่อ-สกุล</th>
                            <th width="10%" style="text-align:center; ">ตำแหน่ง</th>
                            <th width="2%" style="text-align:center; ">ชั้น</th>
                            <th width="10%" style="text-align:center; ">สังกัด</th>
                            <th width="10%" style="text-align:center; ">ประเภทการลา</th>
                            <th width="10%" style="text-align:center; ">วันที่เริ่มลา</th>
                            <th width="10%" style="text-align:center; ">วันที่สิ้นสุดการลา</th>
                            <th width="3%" style="text-align:center; ">รวม</th>
                            <th width="10%" style="text-align:center; ">รักษาการ</th>
                            <th width="2%" style="text-align:center; ">ไฟล์แนบ</th>
                            <th width="20%" style="text-align:center; ">ความเห็น</th>
                            <th width="10%" style="text-align:center; ">เหตุผลที่ไม่อนุญาต</th>
                        </tr>
                    </thead>
                    <tbody id="result_tbl">
					<?php
						foreach ($pendingLeaves as $pendingLeave) {
							
							if ($pendingLeave->leave_standby != null && trim($pendingLeave->leave_standby) != "")
							{
								$leaveYesText = "อนุญาตการลา <br /> เรียน ผอ.กปภ.ข.1. เพื่อโปรดแต่งตั้งรักษาการตามเสนอ";
								$leaveNoText = "ไม่อนุมัติแต่งตั้งรักษาการตามเสนอ";
							}else
							{
								$leaveYesText = "อนุญาตการลา";
								$leaveNoText = "ไม่อนุญาต";
							}
							
							echo "<tr><td>". $pendingLeave->username . 
								"</td><td>". $pendingLeave->gender . $pendingLeave->name . "     " . $pendingLeave->surname .
								"</td><td>". $pendingLeave->position .
								"</td><td>". $pendingLeave->level .
								"</td><td>". $pendingLeave->job_name .
								"</td><td>". $pendingLeave->Leave_type_code . "    " . $pendingLeave->Leave_type_desc .
								"</td><td>". $pendingLeave->start_date .
								"</td><td>". $pendingLeave->end_date .
								"</td><td><span id='sum_leave_" . $pendingLeave->leave_id . "'>". $pendingLeave->sum_leave . "</span>" .
								"</td><td>" . $pendingLeave->standby_gender . $pendingLeave->standby_name . "     " . $pendingLeave->standby_surname .
								"</td><td>". $pendingLeave->attachment . 
								"</td><td><div class='form-group'><div class='radio'><label><input type='radio' name='leave_type_" . $pendingLeave->leave_id . "' id='leave_type_" . $pendingLeave->leave_id . "_1' value='1'>" . $leaveYesText . 
								"</label></div><div class='radio'><label><input type='radio' name='leave_type_" . $pendingLeave->leave_id . "' id='leave_type_" . $pendingLeave->leave_id . "_0' value='0'>" . $leaveNoText . " </label></div></div>".
								"</td><td><input type='text' id='reject_reason_" . $pendingLeave->leave_id . "'>". 
								"<input type='hidden' value='" . $pendingLeave->leave_id . "'></td></tr>";
						}
                    ?>
					
					</tbody>
                </table>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
	
	
	<br>
	<div class="row">
		<div class="col-sm-12 no-padding">    
			<center>
				<button class="btn btn-flat btn-primary" id="save_btn">ยืนยัน</button>
			</center>
		</div>
	</div>
</section>