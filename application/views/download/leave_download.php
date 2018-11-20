<?php  
if(!isset($_SESSION)){
    @session_start();
}


header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="รายงานข้อมูลการลา.xls"');#ชื่อไฟล์
?>

<HTML>

<HEAD>

<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

</HEAD><BODY>
<center><h3 id="headreport">แบบรายงานใบลางาน/หยุดงาน (Absence)</h3></center><br>
				
<TABLE  x:str BORDER="1" style="font-size: 12px;" id="mainTable">

        <thead>
            
			<tr>
				<th width="2%" style="text-align:center; ">ลำดับ</th>
				<th width="5%" style="text-align:center; ">รหัสพนักงาน</th>
				<th width="10%" style="text-align:center; ">ชื่อ-สกุล</th>
				<th width="10%" style="text-align:center; ">ตำแหน่ง</th>
				<th width="5%" style="text-align:center; ">ชั้น</th>
				<th width="10%" style="text-align:center; ">งาน</th>
				<th width="10%" style="text-align:center; ">สังกัด</th>
				<th width="10%" style="text-align:center; ">ประเภทการลา</th>
				<th width="10%" style="text-align:center; ">วันที่เริ่มลา</th>
				<th width="10%" style="text-align:center; ">วันที่สิ้นสุดการลา</th>
				<th width="10%" style="text-align:center; ">รวม</th>
				<th width="10%" style="text-align:center; ">ผู้อนุมัติ</th>
				
            </tr>
        </thead>
        <tbody>
			<?php
			if (isset($records) && count($records) > 0)
			{
				$index=1;
				foreach ($records as $record) {
					echo "<tr><td>{$index}</td><td>{$record->username}</td><td>{$record->gender}{$record->name}   {$record->surname}</td>"
						."<td>{$record->position}</td><td>{$record->level}</td><td>{$record->job_name}</td><td>{$record->d_name}</td>"
						."<td>{$record->Leave_type_code}  {$record->Leave_type_desc}</td><td>{$record->start_date}</td>"
						."<td>{$record->end_date}</td><td>{$record->sum_leave}</td><td>{$record->approve_user}  {$record->approve_job}</td>"
						."</tr>";
					$index++;
				}
			}
			?>
		</tbody>
    
</TABLE>
<br /><br />
<b>สร้างโดยระบบสารสนเทศทรัพยากรบุคคล ณ วันที่ <?php echo date("Y-m-d  h:i:sa"); ?></b>
</BODY>

</HTML>