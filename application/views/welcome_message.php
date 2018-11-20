<section class="content-header">
    <div id="content-form" class="box box-primary box-solid">
        <div class="box-header " data-widget="collapse">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-bookmark"></i>
                </button>
            </div><!-- /. tools -->
            <i class="fa fa-edit"></i>
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
            </div>
            <div class="row">
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
            </div>
            <div class="row">
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
            </div>
            <div class="row">
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