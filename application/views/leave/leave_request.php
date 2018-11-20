<script src="<?php echo base_url(); ?>asset/js/pages/leave/leave_request.js"></script>

<input type="hidden" id="org_id" value="<?php echo $_SESSION["OfficeID"] ?>">
<input type="hidden" id="leave_attachment" value="<?php  echo (isset($header) ? $header->leave_attachment : "") ?>">
<input type="hidden" id="leave_id" value="<?php echo (isset($header) ? $header->leave_id : "") ?>">
<input type="hidden" id="is_approve" value="<?php echo (isset($header) ? $header->approve_3 : "") ?>">
<input type="hidden" id="sick_sum" value="<?php echo $sick_sum ?>">
<input type="hidden" id="holiday_sum" value="<?php echo $holiday_sum ?>">
<section class="content-header">
    <div id="info-form" class="box box-info box-solid">
        <div class="box-header " data-widget="collapse">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div><!-- /. tools -->
            <i class="fa fa-bookmark"></i>
            <h3 class="box-title">ข้อมูลส่วนตัว</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>ชื่อ-สกุล  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="name" disabled class="form-control" value="<?php echo $_SESSION["MyName"] . "     " . $_SESSION["MySurname"] ?>">
                </div>
				
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>รหัสพนักงาน  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="code" disabled class="form-control" value="<?php echo (int)$_SESSION["username"] ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>ตำแหน่ง  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="position" disabled class="form-control" value="<?php echo $_SESSION["Myposition"] ?>">
                </div>
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>ชั้น  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="level" disabled class="form-control" value="<?php echo $_SESSION["Mylevel"] ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>สังกัดงาน  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="department" disabled class="form-control" value="<?php echo $_SESSION["MyJob_name"] ?>">
                </div>
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>สาขา  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="organization" disabled class="form-control" value="<?php echo $_SESSION["Mydep_name"] ?>">
                </div>
            </div>
            <br>
        </div>
    </div>

</section>


<section class="content-header">

    <div id="content-form" class="box box-warning box-solid">
        <div class="box-header " data-widget="collapse">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div><!-- /. tools -->
            <i class="fa fa-edit"></i>
            <h3 class="box-title">เขียนใบลา</h3>
        </div>
        <div class="box-body">
            <div class="row">
				<div class="col-sm-2 no-padding">
					<div align="right"><label>มีความจำเป็นที่ขอ  : &nbsp;</label></div>
				</div>
				<div class="col-sm-3 no-padding">
					<div class="form-group">
						<?php
                            $leaveTypes = $this->leaveType_model->getAllLeaveType();
                            foreach ($leaveTypes as $leaveType) {
								if(isset($header) && $leaveType->id == $header->leave_type )
								{
									echo " <div class='radio'><label><input type='radio' name='leave_type' id='leave_type_{$leaveType->id}' value='{$leaveType->id}' checked=''>{$leaveType->Leave_type_desc} ({$leaveType->Leave_type_code})</label></div>";
								}else
								{
									echo " <div class='radio'><label><input type='radio' name='leave_type' id='leave_type_{$leaveType->id}' value='{$leaveType->id}'>{$leaveType->Leave_type_desc} ({$leaveType->Leave_type_code})</label></div>";
								}

                            }
                        ?>
					</div>
				</div>
			</div>
			
			<div class="row">
                <div class="col-sm-1 no-padding">
                    <div align="right"><label>วันที่เริ่มลา   <span class="text-red">*</span>: &nbsp;</label></div>
                </div>
                <div class="col-sm-2 no-padding">
                    <input type="text" id="startLeave1" class="form-control" value="<?php  echo (isset($detail) && count($detail) > 0 ? $detail[0]->start_date : "") ?>">
                </div>
				
                <div class="col-sm-1 no-padding">
                    <div align="right"><label>วันที่สิ้นสุด   <span class="text-red">*</span>: &nbsp;</label></div>
                </div>
                <div class="col-sm-2 no-padding">
                    <input type="text" id="endLeave1" class="form-control" value="<?php  echo (isset($detail) && count($detail) > 0 ? $detail[0]->end_date : "") ?>">
                </div>
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>เวลา (กรณีลาครึ่งวัน)  : &nbsp;</label></div>
                </div>
                <div class="col-sm-2 no-padding">
                    <select id="timeLeave1">
						<?php
							$worktimes =  $this->workTime_model->getAllWorkTime();
							foreach ($worktimes as $work) {
								$select = (isset($detail) && count($detail) > 0 && $detail[0]->leave_time == $work->work_time_code ? "selected" : "");
								echo "<option value='{$work->work_time_code}' {$select}>{$work->work_time_desc}</option>";
							}
						?>
					</select>
                </div>
				
				<div class="col-sm-1 no-padding">
                    <div align="right"><label>รวม  : &nbsp;</label></div>
                </div>
				<div class="col-sm-1">
                    <div align="left"><input type="text" disabled class="form-control" id="sumLeave1" value="<?php  echo (isset($detail) && count($detail) > 0 ? $detail[0]->sum_leave : "") ?>"></input></div>
                </div>
            </div>
			
			<div class="row hidden">
                <div class="col-sm-1 no-padding">
                    <div align="right"><label>วันที่เริ่มลา   <span class="text-red">*</span>: &nbsp;</label></div>
                </div>
                <div class="col-sm-2 no-padding">
                    <input type="text" id="startLeave2" class="form-control" value="<?php  echo (isset($detail) && count($detail) > 1 ? $detail[1]->start_date : "") ?>">
                </div>
				
				
                <div class="col-sm-1 no-padding">
                    <div align="right"><label>วันที่สิ้นสุด  <span class="text-red">*</span> : &nbsp;</label></div>
                </div>
                <div class="col-sm-2 no-padding">
                    <input type="text" id="endLeave2" class="form-control" value="<?php  echo (isset($detail) && count($detail) > 1 ? $detail[1]->end_date : "") ?>">
                </div>
				
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>เวลา (กรณีลาครึ่งวัน)  : &nbsp;</label></div>
                </div>
                <div class="col-sm-2 no-padding">
                    <select id="timeLeave2">
						<?php
							$worktimes =  $this->workTime_model->getAllWorkTime();
							foreach ($worktimes as $work) {
								$select = (isset($detail) && count($detail) > 1 && $detail[1]->leave_time == $work->work_time_code ? "selected" : "");
								echo "<option value='{$work->work_time_code}' {$select}>{$work->work_time_desc}</option>";
							}
						?>
					</select>
                </div>
				
				<div class="col-sm-2 no-padding">
                    <div align="left"><label>รวม  : &nbsp; </label><input type="text" disabled id="sumLeave2" value="<?php  echo (isset($detail) && count($detail) > 1 ? $detail[1]->sum_leave : "") ?>"></input></div>
                </div>
            </div>
            <br>
			<div class="row">
                <div class="col-sm-4">
                     <div align="left"><label>ข้าพเจ้าได้แนบเอกสารประกอบการลาดังรายการต่อไปนี้  : &nbsp;</label></div>
                </div>
                <div class="col-sm-8 no-padding">
				   <span id="checklist_Upload" class="btn btn-primary fileinput-button">
						<i class="glyphicon glyphicon-plus"></i>
						<span>เพิ่มไฟล์...</span>
						<!-- The file input field used as target for the file upload widget -->
						<input id="fileupload" type="file" name="files[]" multiple="">
					</span>
					
					<!-- The container for the uploaded files -->
					<div id="checklist_files" class="files">
					
					<?php
						if((isset($header) && $header->leave_attachment != "")){
							$dirName = dirname(@$_SERVER['SCRIPT_FILENAME']) . '/asset/upload/files/' . $_SESSION["OfficeID"] . '/' . (int)$_SESSION["username"] . '/' . $header->leave_attachment;
							if (file_exists($dirName)) {
								if ($handle = opendir($dirName)) {
									while (false !== ($entry = readdir($handle))) {

										if ($entry != "." && $entry != ".." && $entry != "thumbnail") {

											echo "<div><p><a target='_blank' href='" . base_url() . "asset/upload/files/" . $_SESSION["OfficeID"] . "/" . (int)$_SESSION["username"] . "/" . $header->leave_attachment . "/" . $entry ."'>". $entry . "</a><br><button type='button' class='btn btn-danger delete' onclick='DeleteAttachment(this,\"" . $entry . "\")'><i class='glyphicon glyphicon-trash'></i><span>Delete</span></button></p></div>";
										}
									}
									closedir($handle);
								}
							} 	
						}
					?>
					</div>
                </div>
            </div>
			<br>
			<div class="row">
                <div class="col-sm-4">
                     <div align="left"><label>ในระหว่างที่ข้าพเจ้าลาหยุดงานนี้ ขอแต่งตั้งให้  : &nbsp;</label></div>
                </div>
                <div class="col-sm-4 no-padding">
					<select id="acting" class="form-control">
						<option value=''>-</option>
					<?php
						$employees = $this->employee_model->getEmployeeInDiv((int)$_SESSION["username"]);
						foreach ($employees as $employee) {
							if(isset($header) && $header->leave_standby == $employee->code)
							{
								echo "<option selected value='{$employee->code}'>{$employee->gender} {$employee->name}  {$employee->surname}</option>";
							}else
							{
								echo "<option value='{$employee->code}'>{$employee->gender} {$employee->name}  {$employee->surname}</option>";
							}
						}
                    ?>
					</select>
                </div>
                <div class="col-sm-4">
                     <div align="left"><label>เป็นผู้รักษาการแทน</label></div>
                </div>
            </div>
			
			<br>
			<div class="row">
                <div class="col-sm-12 no-padding">    
					<center>
						<button class="btn btn-flat btn-primary" id="save_btn">ยืนยันการลา</button>
					</center>
                </div>
            </div>
			<br>
        </div>
    </div>

</section>