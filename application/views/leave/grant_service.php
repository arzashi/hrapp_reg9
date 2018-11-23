<link href="<?php echo base_url(); ?>asset/css/jquery.signaturepad.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>asset/js/pages/leave/grant_leave.js"></script>
<script src="<?php echo base_url(); ?>asset/js/sign/numeric-1.2.6.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/sign/bezier.js"></script>
<script src="<?php echo base_url(); ?>asset/js/sign/jquery.signaturepad.js"></script>
<script src="<?php echo base_url(); ?>asset/js/sign/json2.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/sign/html2canvas.js"></script>
<style type="text/css">
			
			
			#signArea{
				width:304px;
				margin: 50px auto;
			}
			.sign-container {
				width: 60%;
				margin: auto;
			}
			.sign-preview {
				width: 150px;
				height: 50px;
				border: solid 1px #CFCFCF;
				margin: 10px 5px;
			}
			.tag-ingo {
				font-family: cursive;
				font-size: 12px;
				text-align: left;
				font-style: oblique;
			}
		</style>
<section class="content">
    <div class="row">
        <div class="box box-solid">
			<div class="box-header " >
				<i class="fa fa-check"></i>
				<h3 class="box-title"> อนุมัติการลา</h3>
			</div>
            <div class="box-body table-responsive">
                <table id="tbl" class="table table-bordered">
                    <!--
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
                    -->
                    <tbody id="result_tbl">
                        <?php 
                            foreach ($pendingLeaves as $pendingLeave) {
                        ?>                        
                        <tr>
                            <td>รหัสพนักงาน</td>
                            <td><?php echo $pendingLeave->username ?></td>
                        </tr>
                        <tr>
                            <td>ชื่อ-สกุล</td>
                            <td><?php echo $pendingLeave->gender . $pendingLeave->name . "     " . $pendingLeave->surname ?></td>
                        </tr>
                        <tr>
                            <td>ตำแหน่ง</td>
                            <td><?php echo $pendingLeave->position . " " . $pendingLeave->level ?></td>
                        </tr>
                        <tr>
                            <td>สังกัด</td>
                            <td><?php echo $pendingLeave->job_name ?></td>
                        </tr>
                        <tr>
                            <td>ประเภทการลา</td>
                            <td><?php echo $pendingLeave->Leave_type_code . "    " . $pendingLeave->Leave_type_desc ?></td>
                        </tr>
                        <tr>
                            <td>วันที่เริ่มลา</td>
                            <td><?php echo $pendingLeave->start_date ?></td>
                        </tr>
                        <tr>
                            <td>วันที่สิ้นสุดการลา</td>
                            <td><?php echo $pendingLeave->end_date ?></td>
                        </tr>
                        <tr>
                            <td>รวม</td>
                            <td><?php echo "<span id='sum_leave_" . $pendingLeave->leave_id . "'>". $pendingLeave->sum_leave . "</span>" ?></td>
                        </tr>
                        <tr>
                            <td>ไฟล์แนบ</td>
                            <td><?php echo $pendingLeave->attachment ?></td>
                        </tr>
                        <tr>
                            <td>ความเห็น</td>
                            <td><?php echo "<div class='form-group'><div class='radio'><label><input type='radio' name='leave_type_" . $pendingLeave->leave_id . "' id='leave_type_" . $pendingLeave->leave_id . "_1' value='1'>อนุญาต </label></div><div class='radio'><label><input type='radio' name='leave_type_" . $pendingLeave->leave_id . "' id='leave_type_" . $pendingLeave->leave_id . "_0' value='0'>ไม่อนุญาต </label></div></div>" ?></td>
                        </tr>
                        <tr>
                            <td>เหตุผลที่ไม่อนุญาต</td>
                            <td><?php 
                                    echo "<input type='text' id='reject_reason_" . $pendingLeave->leave_id . "'>" .
                                         "<input type='hidden' value='" . $pendingLeave->leave_id . "'>"                                    
                                ?>
                            </td>
                        </tr>                        
                        
					<?php 
                                        echo "<input type='hidden' id='approve_code' value='" . $_REQUEST['code'] . "'>" .
                                             "<input type='hidden' id='grant_level' value='" . $_REQUEST['grant_level'] . "'>";
                                        /*
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
						}*/
                                        ?>
			<?PHP
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
	 <div id="signArea" >
                            <h2 class="tag-ingo">Put signature below,</h2>
                            <div class="sig sigWrapper" style="height:auto;">
                                    <div class="typed"></div>
                                    <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                            </div>
                        </div>
	
	<br>
	<div class="row">
		<div class="col-sm-12 no-padding">    
			<center>
				<button class="btn btn-flat btn-primary" id="save_btn">ยืนยัน</button>
			</center>
		</div>
	</div>
</section>