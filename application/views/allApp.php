<?php if(isset($_SESSION["error"])){?>
    <script>alert("<?=$_SESSION['error']?>")</script>
<?php }?>
<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All App</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>App Name</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($app as $apps){?>
                <tr class="gradeX">
                    <td><?=$apps->appName?></td>
                    <td><?=$apps->appDetail?></td>
                    <td>
                        <?php if($apps->appStatus=="1"){?>
                            <span style="color:green">Active</span>
                        <?php }else if($apps->appStatus=="0"){?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <a href="<?= base_url("app/edit_app/"). $apps->appId?>" class="btn btn-success">
                            Edit
                        </a>
                        <?php if($apps->appStatus=="1"){?>
                            <a href="<?= base_url("app/delete_app/"). $apps->appId?>" class="btn btn-danger">
                                Delete
                            </a>
                        <?php }else if($apps->appStatus=="0"){?>
                            <a href="<?= base_url("app/activate_app/"). $apps->appId?>" class="btn btn-danger">
                                Reactivate
                            </a>
                        <?php }?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>