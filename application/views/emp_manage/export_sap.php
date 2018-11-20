<script src="<?php echo base_url(); ?>asset/js/pages/emp_manage/export_sap.js"></script>

<section class="content-header">
    <div id="content-form" class="box box-primary box-solid">
        <div class="box-header " data-widget="collapse">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div><!-- /. tools -->
            <i class="fa fa-edit"></i>
            <h3 class="box-title"> ส่งออก Text file</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>วันที่เริ่มต้น  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
					<input type="text" id="start_date" class="form-control" >
                </div>
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>วันที่สิ้นสุด  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
					<input type="text" id="end_date" class="form-control" >
                </div>
								
            </div>
            <div class="row">
			
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>ประปาสาขา  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
					<input type="text" id="department" class="form-control" list="dept" >
					<datalist id="dept">
						<option value=''>-</option>
						<?php
							$departments =  $this->department_model->getAllDepartmentWithXPath();
							foreach ($departments as $dept) {
								echo "<option value='{$dept->d_id}'>{$dept->d_name}</option>";
							}
						?>
					</datalist>
                </div>
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>ประเภทไฟล์  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
					<select class="form-control" id="file_type">
						<option value="ZHTMIF03">ใบลา</option>
						<option value="ZHTMIF04">รายงานการเดินทาง</option>
                                                <!-- for version 2
						<option value="ZHTMIF05">เวลาทำงาน</option>
                                                -->
					</select>
                </div>
            </div>
			
			
			<br>
			<div class="row">
                <div class="col-sm-12 no-padding">    
					<center>
						<button class="btn btn-flat btn-primary" id="generate_btn">ส่งออก</button>
					</center>
                </div>
            </div>
        </div>
    </div>

</section>


<section class="content-header">
    
	<div id="file_download"></div>

</section>