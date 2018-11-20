<script src="<?php echo base_url(); ?>asset/js/pages/leave/leave_summary.js"></script>

<section class="content-header">
    <div id="content-form" class="box box-primary box-solid">
        <div class="box-header " data-widget="collapse">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div><!-- /. tools -->
            <i class="fa fa-search"></i>
            <h3 class="box-title"> สรุปการลาของ HR</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>เลือกช่วงเวลา : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="startLeaveDate" class="form-control">
                </div>
				
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>สิ้นสุด  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="endLeaveDate" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>รหัสพนักงาน : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="emp_code" class="form-control">
                </div>
            </div>
			
			<br>
			<div class="row">
                <div class="col-sm-12 no-padding">    
					<center>
						<button class="btn btn-flat btn-primary" id="search_btn">ค้นหา</button>
						<button class="btn btn-flat btn-primary" id="report_btn">สร้างรายงาน</button>
					</center>
                </div>
            </div>
            <br>
        </div>
    </div>

</section>


<section class="content">
    <div class="row">
        <div class="box box-solid">
            <div class="box-body table-responsive">
                <table id="tbl" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center; ">ลำดับ</th>
                            <th width="5%" style="text-align:center; ">รหัสพนักงาน</th>
                            <th width="10%" style="text-align:center; ">ชื่อ-สกุล</th>
                            <th width="15%" style="text-align:center; ">ตำแหน่ง</th>
                            <th width="5%" style="text-align:center; ">ชั้น</th>
                            <th width="10%" style="text-align:center; ">สังกัด</th>
                            <th width="10%" style="text-align:center; ">ประเภทการลา</th>
                            <th width="10%" style="text-align:center; ">วันที่เริ่มลา</th>
                            <th width="10%" style="text-align:center; ">วันที่สิ้นสุดการลา</th>
                            <th width="10%" style="text-align:center; ">รวม</th>
                            <th width="10%" style="text-align:center; ">ไฟล์แนบ</th>
                            <th width="10%" style="text-align:center; ">ผู้อนุมัติ</th>
                        </tr>
                    </thead>
                    <tbody id="result_tbl"></tbody>
                </table>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>