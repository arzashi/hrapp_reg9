<script src="<?php echo base_url(); ?>asset/js/pages/work_report/work_report.js"></script>

<input type="hidden" id="org_id" value="<?php echo $_SESSION["OfficeID"] ?>">
<input type="hidden" id="work_report_id" value="<?php echo (isset($header) ? $header->id : "") ?>">
<input type="hidden" id="is_approve" value="<?php echo (isset($header) ? $header->approve_3 : "") ?>">
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
            <h3 class="box-title">รายงานการปฏิบัติงาน</h3>
        </div>
        <div class="box-body">
			<div class="row">
                <div class="col-sm-12">
					<button class="btn btn-flat btn-success" id="addPerson_btn">เพิ่มพนักงานที่ร่วมเดินทาง</button>
                </div>
            </div>
			<div id="work_person">
				<?php
					if(isset($detail) && count($detail) > 0)
					{
						for($i = 0; $i < count($detail); $i++) {
							$emp_index = $i-1;
							if((int)$_SESSION["username"] != (int) $detail[$i]->code)
							{
								echo "<div class='row'><div class='col-sm-2'>รหัสพนักงาน  <input type='text' id='code_person{$emp_index}' " .
								"name='code_person' class='form-control' onchange='getEmployeeDetail(\'{$emp_index}\')' value='{$detail[$i]->code}'></div>" .
								"<div class='col-sm-4'>ชื่อ-นามสกุล  <input type='text' id='name_person{$emp_index}' class='form-control' value='{$detail[$i]->gender}{$detail[$i]->name}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$detail[$i]->surname}'></div>" .
								"<div class='col-sm-4'>ตำแหน่ง  <input type='text' id='position_person{$emp_index}' class='form-control' value='{$detail[$i]->position}'></div>" .
								"<div class='col-sm-1'>ชั้น  <input type='text' id='level_person{$emp_index}' class='form-control' value='{$detail[$i]->level}'></div>" .
								"<div class='col-sm-1'><br /><button class='btn btn-flat btn-danger' onclick='delPerson({$emp_index})'>ลบ</button></div></div>";
							}
						}
					}
				?>
			</div>
			<br />
			<div class="row">
                <div class="col-sm-12">
					มีการ <span class="text-red">*</span>
                </div>
            </div>
			<div class="row">
                <div class="col-sm-12">
					<div class="form-group">
						<?php
                            $workTypes = $this->workType_model->getAllWorkType();
                            foreach ($workTypes as $workType) {
								if(isset($header) && $workType->id == $header->work_type_id )
								{
									echo " <div class='radio'><label><input type='radio' name='work_detail' id='work_detail_{$workType->id}' value='{$workType->id}' checked=''>{$workType->Work_type_desc} ({$workType->Work_type_code})</label></div>";
								}else
								{
									echo " <div class='radio'><label><input type='radio' name='work_detail' id='work_detail_{$workType->id}' value='{$workType->id}' >{$workType->Work_type_desc} ({$workType->Work_type_code})</label></div>";
								}
                            }
                        ?>
					</div>
                </div>
			</div>
			
			<br />
			<div class="row">
                <div class="col-sm-12">
					มีกำหนดดังนี้
                </div>
            </div>
			<div class="row">
                <div class="col-sm-1">
					วันที่เริ่มต้น <span class="text-red">*</span>
                </div>
                <div class="col-sm-2">
					<input type="text" id="startWork" class="form-control" value="<?php echo (isset($header) ? $header->startdate : "") ?>">
                </div>
                <div class="col-sm-1">
					วันที่สิ้นสุด <span class="text-red">*</span>
                </div>
                <div class="col-sm-2">
					<input type="text" id="endWork" class="form-control" value="<?php echo (isset($header) ? $header->enddate : "") ?>">
                </div>
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>เวลา (กรณีครึ่งวัน)  : &nbsp;</label></div>
                </div>
                <div class="col-sm-2 no-padding">
                    <select id="timeWork">
						<?php
							$worktimes =  $this->workTime_model->getAllWorkTime();
							foreach ($worktimes as $work) {
								$select = (isset($header) && $header->timework == "0" ? "selected" : "");
								echo "<option value='{$work->work_time_code}' {$select}>{$work->work_time_desc}</option>";
							}
						?>
					</select>
                </div>
				
				<div class="col-sm-1 no-padding">
                    <div align="right"><label>รวม  : &nbsp;</label></div>
                </div>
				<div class="col-sm-1">
                    <div align="left"><input type="text" class="form-control" disabled id="sumWork" style="width:50px;" value="<?php echo (isset($header) ? $header->sumWorkReport : "") ?>"></input></div>
                </div>
            </div>
			<div class="row">
                <div class="col-sm-3">
					ระบุหมายเลขใบคำขออนุมัติเดินทาง <span class="text-red">*</span>
                </div>
                <div class="col-sm-1">
					<input type="text" id="workRequestNo" class="form-control">
					<input type="hidden" id="work_id" />
                </div>
            </div>
			<div class="row">
                <div class="col-sm-12" id="request_detail">
					
                </div>
            </div>
			<br>
			<div class="row">
                <div class="col-sm-12 no-padding">    
					<center>
						<button class="btn btn-flat btn-primary" id="save_btn">ยืนยันการรายงาน</button>
					</center>
                </div>
            </div>			
        </div>
    </div>
</section>