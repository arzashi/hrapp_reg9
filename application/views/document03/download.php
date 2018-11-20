<script src="<?php echo base_url(); ?>asset/js/pages/document03_download.js"></script>

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
            <h3 class="box-title">เลือกช่วงเวลาและสาขา</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>เลือกเดือน : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                    <input type="text" id="monthYear" class="form-control">
                </div>
				
				
                <div class="col-sm-2 no-padding">
                    <div align="right"><label>สาขา  : &nbsp;</label></div>
                </div>
                <div class="col-sm-3 no-padding">
                   <select class="form-control">
					<option>การประปาส่วนภูมิภาคสาขาชลบุรี (ชั้นพิเศษ)</option>
					<option>การประปาส่วนภูมิภาคสาขาพัทยา (ชั้นพิเศษ)</option>
				   </select>
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
            <br>
        </div>
    </div>

</section>
