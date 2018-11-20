<script src="<?php echo base_url(); ?>asset/js/pages/work/grant_work2.js"></script>
<section class="content">
    <div class="row">
        <div class="box box-solid">
			<div class="box-header " >
				<i class="fa fa-check-square"></i>
				<h3 class="box-title">  รับทราบอนุมัติเดินทาง(ผอ กอง)</h3>
			</div>
            <div class="box-body table-responsive">
                <table id="tbl" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center; ">เลขที่</th>
                            <th width="5%" style="text-align:center; ">รหัสพนักงาน</th>
                            <th width="20%" style="text-align:center; ">ชื่อ-สกุล ตำแหน่ง ชั้น</th>
                            <th width="10%" style="text-align:center; ">วันที่เริ่มต้น</th>
                            <th width="10%" style="text-align:center; ">วันที่สิ้นสุด</th>
                            <th width="10%" style="text-align:center; ">ปฎิบัติงาน</th>
                            <th width="10%" style="text-align:center; ">สถานที่</th>
                            <th width="3%" style="text-align:center; ">รวม</th>
                            <th width="10%" style="text-align:center; ">รักษาการ</th>
                            <th width="2%" style="text-align:center; ">ไฟล์แนบ</th>
                            <th width="20%" style="text-align:center; ">ความเห็น</th>
                            <th width="10%" style="text-align:center; ">เหตุผลที่ไม่อนุญาต</th>
                        </tr>
                    </thead>
                    <tbody id="result_tbl">
					<?php
						foreach ($pendingWorks as $pendingWork) {
							echo "<tr><td>". $pendingWork->docno . 
								"</td><td>". $pendingWork->create_by . 
								"</td><td>". $pendingWork->alluser .
								"</td><td>". $pendingWork->startdate .
								"</td><td>". $pendingWork->enddate .
								"</td><td>". $pendingWork->detail .
								"</td><td>". $pendingWork->location .
								"</td><td><span id='sum_work_" . $pendingWork->id . "'>". $pendingWork->sumWork . "</span>" .
								"</td><td>" . $pendingWork->standby_gender . $pendingWork->standby_name . "     " . $pendingWork->standby_surname .
								"</td><td>". $pendingWork->attachment . 
								"</td><td><div class='form-group'><div class='radio'><label><input type='radio' name='work_type_" . $pendingWork->id . "' id='work_type_" . $pendingWork->id . "_1' value='1'>เรียน ผอ.กปภ.ข.1  เพื่อโปรด อนุมัติการเดินทางให้ต่อไปด้วย </label></div><div class='radio'><label><input type='radio' name='work_type_" . $pendingWork->id . "' id='work_type_" . $pendingWork->id . "_0' value='0'>ไม่เห็นควรให้เดินทางไปปฏิบัติราชการ </label></div></div>".
								"</td><td><input type='text' id='reject_reason_" . $pendingWork->id . "'>". 
								"<input type='hidden' value='" . $pendingWork->id . "'></td></tr>";
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