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
            <a href="#" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="<?php echo base_url(); ?>asset/img/logo.png" width="40" height="45" /> PWA9
            </a>
           
        </header>
       
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