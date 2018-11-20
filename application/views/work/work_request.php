<script src="<?php echo base_url(); ?>asset/js/pages/work/work_request.js"></script>

<input type="hidden" id="org_id" value="<?php echo $_SESSION["OfficeID"] ?>">
<input type="hidden" id="work_attachment" value="<?php  echo (isset($header) ? $header->work_attachment : "") ?>">
<input type="hidden" id="work_id" value="<?php echo (isset($header) ? $header->id : "") ?>">
<input type="hidden" id="is_approve" value="<?php echo (isset($header) ? $header->approve_1 : "") ?>">
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
            <h3 class="box-title">ขออนุมัติเดินทาง</h3>
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
					ขออนุมัติเดินทางไปปฏิบัติงานต่างท้องที่
                </div>
            </div>
			<div class="row">
                <div class="col-sm-1">
					วันที่เริ่มต้น <span class="text-red">*</span>
                </div>
                <div class="col-sm-3">
					<input type="text" id="startWork" class="form-control" value="<?php echo (isset($header) ? $header->startdate : "") ?>">
                </div>
                <div class="col-sm-1">
					วันที่สิ้นสุด  <span class="text-red">*</span>
                </div>
                <div class="col-sm-3">
					<input type="text" id="endWork" class="form-control" value="<?php echo (isset($header) ? $header->enddate : "") ?>">
                </div>
				
				<div class="col-sm-1 no-padding">
                    <div align="right"><label>รวม  : &nbsp;</label></div>
                </div>
				<div class="col-sm-1">
                    <div align="left"><input type="text" class="form-control" disabled id="sumWork" value="<?php echo (isset($header) ? $header->sumWork : "") ?>"></input></div>
                </div>
            </div>
			<div class="row">
                <div class="col-sm-2">
					เลขที่เอกสาร
                </div>
                <div class="col-sm-3">
					<input type="text" id="docNo" class="form-control" disabled value="<?php echo (isset($header) ? $header->docno : "") ?>">
                </div>
            </div>
			<div class="row">
                <div class="col-sm-2">
					เพื่อปฏิบัติงาน <span class="text-red">*</span>
                </div>
                <div class="col-sm-4">
					<textarea id="descriptionWork" class="form-control"><?php echo (isset($header) ? $header->detail : "") ?></textarea>
                </div>
                <div class="col-sm-2">
					ณ สถานที่ <span class="text-red">*</span>
                </div>
                <div class="col-sm-4">
					<textarea id="placeWork" class="form-control"><?php echo (isset($header) ? $header->location : "") ?></textarea>
                </div>
            </div>
			<div class="row">
                <div class="col-sm-2">
					เดินทางโดยยานพาหนะ <span class="text-red">*</span>
                </div>
                <div class="col-sm-4">
					<div class="form-group">
						<?php
                            $carTypes = $this->carType_model->getAllCarType();
                            foreach ($carTypes as $carType) {
								if(isset($header) && $carType->id == $header->cartype_id )
								{
									echo " <div class='radio'><label><input type='radio' name='car_selected' id='car_selected_{$carType->id}' value='{$carType->id}' checked=''>{$carType->Car_type_desc}</label></div>";
								}else
								{
									echo " <div class='radio'><label><input type='radio' name='car_selected' id='car_selected_{$carType->id}' value='{$carType->id}'>{$carType->Car_type_desc}</label></div>";
								}
                            }
                        ?>
					</div>
                </div>
                <div class="col-sm-6">
					<div class="row">
					    <div class="col-sm-3">
							<label id="carDescTxt">หมายเลขทะเบียน</label>
						</div>
						<div class="col-sm-6">
							<input type="text" id="carDesc" class="form-control" value="<?php echo (isset($header) ? $header->car_detail1 : "") ?>">
						</div>
					</div>
					<div class="row" id="carUserDescTxt">
						<div class="col-sm-3">
							ขออนุมัติให้
						</div>
						<div class="col-sm-6">
							<input type="text" id="carUser" class="form-control" value="<?php echo (isset($header) ? $header->car_detail2 : "") ?>">
						</div>
						<div class="col-sm-2">
							เป็นผู้ขับรถ
						</div>
					</div>				
                </div>
            </div>
			<div class="row">
                <div class="col-sm-5">
                     <div align="left"><label>ข้าพเจ้าได้แนบเอกสารประกอบการขออนุมัติดังรายการต่อไปนี้  : &nbsp;</label></div>
                </div>
                <div class="col-sm-7 no-padding">
				   <span id="checklist_Upload" class="btn btn-primary fileinput-button">
						<i class="glyphicon glyphicon-plus"></i>
						<span>เพิ่มไฟล์...</span>
						<!-- The file input field used as target for the file upload widget -->
						<input id="fileupload" type="file" name="files[]" multiple="">
					</span>
					
					<!-- The container for the uploaded files -->
					<div id="checklist_files" class="files">
					
					<?php
						if((isset($header) && $header->work_attachment != "")){
							$dirName = dirname(@$_SERVER['SCRIPT_FILENAME']) . '/asset/upload/files/' . $_SESSION["OfficeID"] . '/' . (int)$_SESSION["username"] . '/' . $header->work_attachment;
							if (file_exists($dirName)) {
								if ($handle = opendir($dirName)) {
									while (false !== ($entry = readdir($handle))) {

										if ($entry != "." && $entry != ".." && $entry != "thumbnail") {

											echo "<div><p><a target='_blank' href='" . base_url() . "asset/upload/files/" . $_SESSION["OfficeID"] . "/" . (int)$_SESSION["username"] . "/" . $header->work_attachment . "/" . $entry ."'>". $entry . "</a><br><button type='button' class='btn btn-danger delete' onclick='DeleteAttachment(this,\"" . $entry . "\")'><i class='glyphicon glyphicon-trash'></i><span>Delete</span></button></p></div>";
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
			<div class="row">
                <div class="col-sm-5">
					ในระหว่างที่ข้าพเจ้าเดินทางไปปฏิบัติงานต่างท้องที่ครั้งนี้ ขอแต่งตั้งให้
                </div>
                <div class="col-sm-4">
					<select id="standbyWork" class="form-control">
						<option value=''>-</option>
					<?php
						$employees = $this->employee_model->getEmployeeInDiv((int)$_SESSION["username"]);
						foreach ($employees as $employee) {
							if(isset($header) && $header->work_standby == $employee->code)
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
                <div class="col-sm-2">
					ทำหน้าที่รักษาการ
                </div>
            </div>
			<br>
			<div class="row">
                <div class="col-sm-12 no-padding">    
					<center>
						<button class="btn btn-flat btn-primary" id="save_btn">ยืนยันการขออนุมัติเดินทาง</button>
					</center>
                </div>
            </div>			
        </div>
    </div>
</section>