<?php  
if(!isset($_SESSION)){
    @session_start();
}

/*
$_SESSION["userid"]= "9357";
$_SESSION["username"]= "0008956";
$_SESSION["_user_PWA"]= "0008956";
$_SESSION["sql_pwd"]= "d840c7313657feb425575ebb9dcfa9c2981227a0";
$_SESSION["email"]= "SupasitW@pwa.co.th";
$_SESSION["nickname"]= "yang";
$_SESSION["OfficeID"]= "5530200";
$_SESSION["MyName"]= "นภดล";
$_SESSION["MySurname"]= "อิฐสุวรรณ";
$_SESSION["eMyName"]= "supasit";
$_SESSION["eMySurname"]= "wiriyapap";
$_SESSION["AJob"]= "นักบริหารงานทั่วไป 7";
$_SESSION["Myba"]= "1101";
$_SESSION["Mycostcenter"]= "101938";
$_SESSION["Mylevel"]= "5";
$_SESSION["Myorgname"]= "สายงานรองผู้ว่าการ (ปฏิบัติการ 3)";
$_SESSION["Myposition"]= "นักบริหารงานทั่วไป";
$_SESSION["MyGender"]= "1";
$_SESSION["MyPart"]= "3";
$_SESSION["MyArea"]= "1";
$_SESSION["Mydep_name"]= "การประปาส่วนภูมิภาคเขต 1";
$_SESSION["MyJob_name"]= "งานทรัพยากรบุคคล";
$_SESSION["Mydiv_name"]= "กองบริหารทั่วไป";
$_SESSION["moiidnew"]= "5531000";

*/

/*
if(!$_SESSION['username'] || !$_SESSION['checkpwa']) {
	$LoginScript = "http://www.pwa.co.th/login.php";
	$website = "http://".$_SERVER["HTTP_HOST"];
	$redirecturl = $website;
	$redirecturl .= $_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"];
	$redirecturl = base64_encode($redirecturl);
	header("Location: $LoginScript?mylink=$redirecturl");
	exit;
};
*/

   

 if(!$_SESSION['username'] || !$_SESSION['checkpwa9']) {
        //http://localhost:8080 https://reg9.pwa.co.th
     
	$LoginScript = "http://192.168.90.241:8090/oauth/login.php";
	$website = "http://".$_SERVER["HTTP_HOST"];
	$redirecturl = $website;
	$redirecturl .= $_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"];
	$redirecturl = base64_encode($redirecturl);
	header("Location: $LoginScript?mylink=$redirecturl");
	exit;
}
   


/*** TEST SESSION LOGIN ***/

// พนักงาน or Admin or HR
/*
$_SESSION["username"] = "10326";
$_SESSION["Myposition"] = "นักวิชาการคอมพิวเตอร์";
$_SESSION["MyName"]  = "นายชาตรี";
$_SESSION["MySurname"] = "ขาวงาม";
$_SESSION["MyJob_name"] = "งานบริการคอมพิวเตอร์ และเครือข่าย";
$_SESSION["Mydep_name"] = "กองเทคโนโลยีสารสนเทศ";
$_SESSION["Mylevel"] = "7";
*/
/*
$_SESSION["username"] = "10861";
$_SESSION["Myposition"] = "พนักงานคอมพิวเตอร์";
$_SESSION["MyName"]  = "นายสุรเชษฐ์";
$_SESSION["MySurname"] = "ระวังศรี";
$_SESSION["MyJob_name"] = "งานประมวลข้อมูล";
$_SESSION["Mydep_name"] = "กองเทคโนโลยีสารสนเทศ";
$_SESSION["Mylevel"] = "6";
*/

// หัวหน้างาน 1
/*
$_SESSION["username"] = "8174";
$_SESSION["Myposition"] = "หัวหน้างานบริการคอมพิวเตอร์ และเครือข่าย";
$_SESSION["MyName"]  = "นายชวลิต";
$_SESSION["MySurname"] = "อรรถาชิต";
$_SESSION["MyJob_name"] = "งานบริการคอมพิวเตอร์ และเครือข่าย";
$_SESSION["Mydep_name"] = "กองเทคโนโลยีสารสนเทศ";
$_SESSION["Mylevel"] = "8";
*/

/*
$_SESSION["username"] = "8878";
$_SESSION["Myposition"] = "หัวหน้างานงานประมวลข้อมูล";
$_SESSION["MyName"]  = "น.ส.รุ่งนภา";
$_SESSION["MySurname"] = "ส่งมหาชัย";
$_SESSION["MyJob_name"] = "งานประมวลข้อมูล";
$_SESSION["Mydep_name"] = "กองเทคโนโลยีสารสนเทศ";
$_SESSION["Mylevel"] = "8";
*/
// ผอ.กอง
/*
$_SESSION["username"] = "9435";
$_SESSION["Myposition"] = "ผู้อำนวยการกองเทคโนโลยีสารสนเทศ";
$_SESSION["MyName"]  = "นายนิรัญ";
$_SESSION["MySurname"] = "เจริญ";
$_SESSION["MyJob_name"] = "";
$_SESSION["Mydep_name"] = "กองเทคโนโลยีสารสนเทศ";
$_SESSION["Mylevel"] = "9";
*/
// ผอ.เขต
/*
$_SESSION["username"] = "5589";
$_SESSION["Myposition"] = "ผู้อำนวยการการประปาส่วนภูมิภาคเขต9";
$_SESSION["MyName"]  = "นายหลักชัย";
$_SESSION["MySurname"] = "พัฒนเจริญ";
$_SESSION["MyJob_name"] = "";
$_SESSION["Mydep_name"] = "";
$_SESSION["Mylevel"] = "11";
*/    
    $employee = $this->employee_model->getEmployee($_SESSION["username"]);
    $department = $this->department_model->getDepartment2($employee[0]->div_code);

    
    $_SESSION["Myposition"] = $employee[0]->position;
    $_SESSION["MyName"]  = $employee[0]->gender."".$employee[0]->name;
    $_SESSION["MySurname"] = $employee[0]->surname;
    $_SESSION["MyJob_name"] = $employee[0]->job_name;
    $_SESSION["Mydep_name"] = $department[0]->d_name;
    $_SESSION["Mylevel"] = $employee[0]->level;

    $_SESSION["OfficeID"]= "5511000";//REG9

    

    

/*** END ***/ 


$isAdmin = false;
$isHR = false;

$standbyrole = $this->employee_model->getStandbyRow((int)$_SESSION["username"]);

if(strpos($_SESSION["Myposition"], "หัวหน้างาน") !== false || strpos($_SESSION["Myposition"], "รก.หนง.") !== false)
	$role = 1;
else if (strpos($_SESSION["Myposition"], "ผู้จัดการ") !== false || strpos($_SESSION["Myposition"], "ผู้อำนวยการกอง") !== false)
	$role = 2;
else if (strpos($_SESSION["Myposition"], "ผู้อำนวยการการ") !== false || strpos($_SESSION["Myposition"], "ผอ.กปภ.ข.") !== false)
	$role = 3;


if((int)$_SESSION["username"] == 10326 || (int)$_SESSION["username"] == 10326)
	$isAdmin = true;

if ((int)$_SESSION["username"] == 10326 || (int)$_SESSION["username"] == 10326)
	$isHR = true;

$_SESSION["role"] = $role;

?>

<!DOCTYPE html>
<html lang="th">
    <head>
        <title>การประปาส่วนภูมิภาค เขต 9 (Provincial Waterworks Authority  Region 9)</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/bootstrap.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/ionicons.min.css">
		<!-- Date picker -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/plugins/bootstrap-datepicker/bootstrap-datepicker.css">
		<!-- File upload -->
		<link rel="stylesheet"  href="<?php echo base_url(); ?>asset/css/jquery.fileupload.css">
		<!-- Datatable -->
		<link rel="stylesheet"  href="<?php echo base_url(); ?>asset/plugins/datatables/jquery.dataTables.min.css">

		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/AdminLTE.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/skins/_all-skins.min.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery 2.2.3 -->
		<script src="<?php echo base_url(); ?>asset/plugins/jQuery/jquery-2.2.3.min.js"></script>    
		<!-- Date picker -->
		<script src="<?php echo base_url(); ?>asset/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo base_url(); ?>asset/js/app.js"></script>
		<!-- Sparkline -->
		<script src="<?php echo base_url(); ?>asset/plugins/sparkline/jquery.sparkline.min.js"></script>
		<!-- input mask -->
		<script src="<?php echo base_url(); ?>asset/plugins/input-mask/jquery.inputmask.js"></script>
		<!-- SlimScroll 1.3.0 -->
		<script src="<?php echo base_url(); ?>asset/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<!-- ChartJS 1.0.1 -->
		<script src="<?php echo base_url(); ?>asset/plugins/chartjs/Chart.min.js"></script>
		<!-- File upload-->
		<script src="<?php echo base_url(); ?>asset/plugins/fileUpload/jquery.ui.widget.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>asset/plugins/fileUpload/jquery.iframe-transport.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>asset/plugins/fileUpload/jquery.fileupload.js" type="text/javascript"></script>

		<!-- Fileupload -->
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/jquery.iframe-transport.js"></script>
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/jquery.fileupload.js"></script>
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/canvas-to-blob.min.js"></script>
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/load-image.all.min.js"></script>
		<!-- The File Upload processing plugin -->
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/jquery.fileupload-process.js"></script>
		<!-- The File Upload image preview & resize plugin -->
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/jquery.fileupload-image.js"></script>
		<!-- The File Upload audio preview plugin -->
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/jquery.fileupload-audio.js"></script>
		<!-- The File Upload video preview plugin -->
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/jquery.fileupload-video.js"></script>
		<!-- The File Upload validation plugin -->
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/jquery.fileupload-validate.js"></script>
		<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
		<script src="<?php echo base_url(); ?>asset/js/fileupload/js/vendor/jquery.ui.widget.js"></script>
		
		<link href="<?php echo base_url(); ?>asset/js/fileupload/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />
		
		<!-- Datatable -->
		<script src="<?php echo base_url(); ?>asset/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>

		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="<?php echo base_url(); ?>asset/js/pages/common.js"></script>
		
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
        <header class="main-header">
			<input type="hidden" value="<?php echo base_url(); ?>" id="base_url">
            <!-- Logo -->
            <a href="<?php echo base_url(); ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="<?php echo base_url(); ?>asset/img/logo.png" width="45" height="45" /> PWA9
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span id="notify_number" class="label label-warning"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li id="header_notify" class="header"></li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul id="detail_notify" class="menu">
                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                
                                <span class="hidden-xs"><?php echo $_SESSION["MyName"] . "     " . $_SESSION["MySurname"] ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    
                                    <p>
                                        <?php echo $_SESSION["MyName"] . "     " . $_SESSION["MySurname"] ?>
                                        <small><?php echo $_SESSION["MyJob_name"] . "     " . $_SESSION["Mydep_name"] ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <!--<a href="https://intranet.pwa.co.th/logout.php" class="btn btn-default btn-flat">ออกจากระบบ</a> -->
                                        <a href="<?php echo base_url(); ?>index.php/home/logout" class="btn btn-default btn-flat">ออกจากระบบ</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-medkit"></i> <span>การลา</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url(); ?>index.php/leave/request"><i class="fa fa-edit text-yellow"></i> เขียนใบลา</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/leave/report"><i class="fa fa-file text-green"></i> สรุปการลา</a></li>
							<?php if ($role == 1 || $isAdmin || $standbyrole == 1) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/leave/grant_level1"><i class="fa fa-check text-blue"></i> อนุมัติการลา(หัวหน้า)</a></li>
							<?php } if ($role == 2 || $isAdmin || $standbyrole == 2) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/leave/grant_level2"><i class="fa fa-check-square text-red"></i> อนุมัติการลา(ผอ กอง)</a></li>
							<?php } if ($role == 3 || $isAdmin || $standbyrole == 3) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/leave/grant_level3"><i class="fa fa-check-square-o text-purple"></i> อนุมัติการลา(ผอ เขต)</a></li>
							<?php } if ($isAdmin || $isHR) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/leave/summary"><i class="fa fa-database text-black"></i> สรุปการลาของ HR</a></li>
							<?php } ?>
							
                        </ul>
                    </li>
                    <!-- for version 2.0
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-car"></i> <span>อนุมัติเดินทาง</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url(); ?>index.php/work/request"><i class="fa fa-edit text-yellow"></i> ขออนุมัติเดินทาง</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/work/report"><i class="fa fa-file text-green"></i> สรุปการขออนุมัติ</a></li>
                            <?php if ($role == 1 || $isAdmin || $standbyrole == 1) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/work/grant_level1"><i class="fa fa-check text-blue"></i> รับทราบอนุมัติเดินทาง (หัวหน้า)</a></li>
							<?php } if ($role == 2 || $isAdmin || $standbyrole == 2) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/work/grant_level2"><i class="fa fa-check-square text-red"></i> รับทราบอนุมัติเดินทาง (ผอ กอง)</a></li>
							<?php } if ($role == 3 || $isAdmin || $standbyrole == 3) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/work/grant_level3"><i class="fa fa-check-square-o text-purple"></i> รับทราบอนุมัติเดินทาง(ผอ เขต)</a></li>
							<?php } ?>
                        </ul>
                    </li>
                    -->
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-envelope-o"></i> <span>รายงานการปฏิบัติงาน</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
							<li><a href="<?php echo base_url(); ?>index.php/work/workReport"><i class="fa fa-newspaper-o text-green"></i> รายงานการมาปฏิบัติงาน</a></li>
							<li><a href="<?php echo base_url(); ?>index.php/work/workReportSummary"><i class="fa fa-file text-green"></i> สรุปรายงานปฏิบัติงาน</a></li>
							
							<?php if ($role == 1 || $isAdmin || $standbyrole == 1) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/work/approve_level1"><i class="fa fa-check text-blue"></i> รับทราบรายงานปฏิบัติงาน (หัวหน้า)</a></li>
							<?php } if ($role == 2 || $isAdmin || $standbyrole == 2) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/work/approve_level2"><i class="fa fa-check-square text-red"></i> รับทราบรายงานปฏิบัติงาน (ผอ กอง)</a></li>
							<?php } if ($role == 3 || $isAdmin || $standbyrole == 3) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/work/approve_level3"><i class="fa fa-check-square-o text-purple"></i> รับทราบรายงานปฏิบัติงาน(ผอ เขต)</a></li>
							<?php } if ($isAdmin || $isHR) { ?>
								<li><a href="<?php echo base_url(); ?>index.php/work/summary"><i class="fa fa-database text-black"></i> สรุปการมาปฏิบัติงานของ HR </a></li>
							<?php } ?>
                            
                        </ul>
                    </li>
					<?php if ($isAdmin || $isHR) { ?>
						<li class="treeview">
							<a href="#">
								<i class="fa fa-keyboard-o"></i> <span>งานทรัพยากรบุคคล</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="<?php echo base_url(); ?>index.php/empManage/manage"><i class="fa fa-users text-brown"></i> จัดการข้อมูลพนักงาน</a></li>
                                                                <!-- for version 2
								<li><a href="<?php echo base_url(); ?>index.php/empManage/work_time"><i class="fa fa-calendar-o text-orange"></i> ลงเวลาปฏิบัติงาน</a></li>
                                                                -->
								<li><a href="<?php echo base_url(); ?>index.php/empManage/export_sap"><i class="fa fa-clone text-green"></i> ส่งออก Text file</a></li>
							</ul>
						</li>
					<?php } ?>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content" id="content-section">
				
				<div class="modal fade" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
					  <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-header">
						  <h1>กำลังประมวลผล...</h1>
						</div>
						<div class="modal-body">
							<div class="progress">
							  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar"
							  style="width:100%">
							  </div>
							</div>
						</div>
					  </div>
					  
					</div>
				</div>
				
                <br/>
                <div class="alert" style="display: none">
                    <div class="close" id="closeAlert">&times;</div>
                    <div id="alert_body"></div>
                </div>