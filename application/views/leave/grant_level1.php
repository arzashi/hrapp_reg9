<script src="<?php echo base_url(); ?>asset/js/pages/leave/grant_leave1.js"></script>
<section class="content">
    <div class="row">
        <div class="box box-solid">
			<div class="box-header " >
				<i class="fa fa-check"></i>
				<h3 class="box-title"> อนุมัติการลา(หัวหน้า)</h3>
			</div>
            <div class="box-body table-responsive">
                <table id="tbl" class="table table-bordered table-hover">
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
                            <th width="10%" style="text-align:center; ">รวม</th>
                            <th width="2%" style="text-align:center; ">ไฟล์แนบ</th>
                            <th width="10%" style="text-align:center; ">ความเห็น</th>
                            <th width="10%" style="text-align:center; ">เหตุผลที่ไม่อนุญาต</th>
                        </tr>
                    </thead>
                    <tbody id="result_tbl">
					<?php
						foreach ($pendingLeaves as $pendingLeave) {
							echo "<tr><td>". $pendingLeave->username . 
								"</td><td>". $pendingLeave->gender . $pendingLeave->name . "     " . $pendingLeave->surname .
								"</td><td>". $pendingLeave->position .
								"</td><td>". $pendingLeave->level .
								"</td><td>". $pendingLeave->job_name .
								"</td><td>". $pendingLeave->Leave_type_code . "    " . $pendingLeave->Leave_type_desc .
								"</td><td>". $pendingLeave->start_date .
								"</td><td>". $pendingLeave->end_date .
								"</td><td><span id='sum_leave_" . $pendingLeave->leave_id . "'>". $pendingLeave->sum_leave . "</span>" .
								"</td><td>". $pendingLeave->attachment . 
								"</td><td><div class='form-group'><div class='radio'><label><input type='radio' name='leave_type_" . $pendingLeave->leave_id . "' id='leave_type_" . $pendingLeave->leave_id . "_1' value='1'>อนุญาต </label></div><div class='radio'><label><input type='radio' name='leave_type_" . $pendingLeave->leave_id . "' id='leave_type_" . $pendingLeave->leave_id . "_0' value='0'>ไม่อนุญาต </label></div></div>".
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