<script src="<?php echo base_url(); ?>asset/js/pages/work_report/approve_level2.js"></script>
<section class="content">
    <div class="row">
        <div class="box box-solid">
			<div class="box-header " >
				<i class="fa fa-check-square"></i>
				<h3 class="box-title">  รับทราบรายงานปฏิบัติงาน(ผอ กอง)</h3>
			</div>
            <div class="box-body table-responsive">
                <table id="tbl" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center; ">รหัสพนักงาน</th>
                            <th width="20%" style="text-align:center; ">ชื่อ-สกุล ตำแหน่ง ชั้น</th>
                            <th width="10%" style="text-align:center; ">ประเภท</th>
                            <th width="10%" style="text-align:center; ">วันที่เริ่มต้น</th>
                            <th width="10%" style="text-align:center; ">วันที่สิ้นสุด</th>
                            <th width="10%" style="text-align:center; ">ปฎิบัติงาน</th>
                            <th width="10%" style="text-align:center; ">สถานที่</th>
                            <th width="5%" style="text-align:center; ">รวม</th>
                            <th width="20%" style="text-align:center; ">ความเห็น</th>
                            <th width="10%" style="text-align:center; ">เหตุผลที่ไม่อนุญาต</th>
                        </tr>
                    </thead>
                    <tbody id="result_tbl">
					<?php
						foreach ($workReports as $workReport) {
							echo "<tr><td>". $workReport->create_by . 
								"</td><td>". $workReport->alluser .
								"</td><td>". $workReport->Work_type_code . "     " . $workReport->Work_type_desc . 
								"</td><td>". $workReport->startdate .
								"</td><td>". $workReport->enddate .
								"</td><td>". $workReport->detail .
								"</td><td>". $workReport->location .
								"</td><td><span id='sum_work_" . $workReport->id . "'>". $workReport->sumWorkReport . "</span>" .
								"</td><td><div class='form-group'><div class='radio'><label><input type='radio' name='work_type_" . $workReport->id . "' id='work_type_" . $workReport->id . "_1' value='1'>เรียน ผอ.กปภ.ข.1  เพื่อโปรดทราบรายงานการเดินทาง </label></div></div>".
								"</td><td><input type='text' id='reject_reason_" . $workReport->id . "'>". 
								"<input type='hidden' value='" . $workReport->id . "'></td></tr>";
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