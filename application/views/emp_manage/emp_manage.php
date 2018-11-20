<script src="<?php echo base_url(); ?>asset/js/pages/emp_manage/emp_manage.js"></script>

<section class="content-header">
    <div id="content-form" class="box box-success box-solid">
        <div class="box-header " data-widget="collapse">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div><!-- /. tools -->
            <i class="fa fa-search"></i>
            <h3 class="box-title"> จัดการข้อมูลพนักงาน</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>รหัสพนักงาน : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="code" class="form-control">
                </div>
				
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>ชื่อ : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="name" class="form-control">
                </div>
								
            </div>
            <div class="row">
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>ตำแหน่ง  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
					<input type="text" id="position" class="form-control" list="pos" />
					<datalist id="pos">
						<?php
							$positions =  $this->employee_model->getPositions();
							foreach ($positions as $pos) {
								echo "<option>{$pos->position}</option>";
							}
						?>
					</datalist>
                </div>
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>งาน  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
					<input type="text" id="job" class="form-control" list="jobs" />
					<datalist id="jobs">
						<?php
							$jobs =  $this->employee_model->getJobs();
							foreach ($jobs as $job) {
								echo "<option>{$job->job_name}</option>";
							}
						?>
					</datalist>
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
							$departments =  $this->department_model->getAllDepartment();
							foreach ($departments as $dept) {
								echo "<option value='{$dept->d_id}'>{$dept->d_name}</option>";
							}
						?>
					</datalist>
                </div>
				
            </div>
			
			
			<br>
			<div class="row">
                <div class="col-sm-12 no-padding">    
					<center>
						<button class="btn btn-flat btn-primary" id="search_btn">ค้นหา</button>
					</center>
                </div>
            </div>
        </div>
    </div>

</section>


<button class="btn btn-flat btn-danger" id="add_btn" data-toggle="modal" data-target="#employeeModal">เพิ่มพนักงาน</button>
<section class="content">
    <div class="row">
        <div class="box box-solid">
            <div class="box-body table-responsive">
                <table id="tbl" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="8%" style="text-align:center; ">รหัสพนักงาน</th>
                            <th width="8%" style="text-align:center; ">คำนำหน้า</th>
                            <th width="12%" style="text-align:center; ">ชื่อ</th>
                            <th width="12%" style="text-align:center; ">นามสกุล</th>
                            <th width="15%" style="text-align:center; ">ตำแหน่ง</th>
                            <th width="8%" style="text-align:center; ">ชั้น</th>
                            <th width="15%" style="text-align:center; ">งาน</th>
                            <th width="10%" style="text-align:center; ">ประปา/กอง</th>
                            <th width="10%" style="text-align:center; ">วันที่เริ่มงาน</th>
                            <th width="2%" style="text-align:center; ">ลบ</th>
                        </tr>
                    </thead>
                    <tbody id="result_tbl"></tbody>					
                </table>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
	<div class="row">
		<div class="col-sm-12 no-padding">    
			<center>
				<button class="btn btn-flat btn-primary" id="save_btn">บันทึก</button>
			</center>
		</div>
	</div>
</section>



<!-- Modal -->
<div class="modal fade" id="employeeModal" role="dialog">
	<div class="modal-dialog">

	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">เพิ่มพนักงาน</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-sm-3">
					<div align="right"><label>รหัสพนักงาน : &nbsp;</label></div>
				</div>
				<div class="col-sm-3">
					<input type="text" id="emp_code" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div align="right"><label>คำนำหน้า-ชื่อ -สกุล : &nbsp;</label></div>
				</div>
				<div class="col-sm-2">
					<input type="text" id="emp_gender" class="form-control">
				</div>
				<div class="col-sm-3">
					<input type="text" id="emp_name" class="form-control">
				</div>
				<div class="col-sm-3">
					<input type="text" id="emp_surname" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div align="right"><label>ตำแหน่ง  : &nbsp;</label></div>
				</div>
				<div class="col-sm-4">
					<input type="text" id="emp_position" class="form-control" list="pos" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div align="right"><label>ชั้น  : &nbsp;</label></div>
				</div>
				<div class="col-sm-4">
					<input type="number" id="emp_level" class="form-control" list="pos" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div align="right"><label>งาน  : &nbsp;</label></div>
				</div>
				<div class="col-sm-4">
					<input type="text" id="emp_job" class="form-control" list="jobs" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div align="right"><label>ประปาสาขา  : &nbsp;</label></div>
				</div>
				<div class="col-sm-4">
					<input type="text" id="emp_department" class="form-control" list="dept" >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div align="right"><label>วันที่เริ่มงาน  : &nbsp;</label></div>
				</div>
				<div class="col-sm-4">
					<input type="text" id="emp_start_work" class="form-control">
				</div>
			</div>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-success" id="add_employee_btn">บันทึก</button>
		  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
		</div>
	  </div>
	  
	</div>
</div>