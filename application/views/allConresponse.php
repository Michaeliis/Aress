<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All Condition-Response</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Condition Name</th>
                    <th>Response Name</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($conresponse as $conresponses){?>
                <tr class="gradeX">
                    <td><?=$conresponses->conditionName?></td>
                    <td><?=$conresponses->responseName?></td>
                    <td><?=$conresponses->userName?></td>
                    <td>
                        <?php if($conresponses->crStatus=="1"){?>
                            <span style="color:green">Active</span>
                        <?php }else if($conresponses->crStatus=="0"){?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <a href="<?= base_url("conresponse/edit_condition_response/"). $conresponses->crId?>" class="btn btn-success">
                            Edit
                        </a>
                        <?php if($conresponses->crStatus=="1"){?>
                            <a href="<?= base_url("conresponse/delete_condition_response/"). $conresponses->crId?>" class="btn btn-danger">
                                Delete
                            </a>
                        <?php }else if($conresponses->crStatus=="0"){?>
                            <a href="<?= base_url("conresponse/activate_condition_response/"). $conresponses->crId?>" class="btn btn-danger">
                                Activate
                            </a>
                        <?php }?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<script src="<?=base_url("assets/")?>vendor/jquery/jquery.js"></script>


<script>
    <?php if(isset($_SESSION["notif"])){?>
    $(document).ready(function(){
        new PNotify({
            title: 'Notification',
            text: '<?=$_SESSION['notif']?>',
            type: '<?=$_SESSION['notifType']?>'
        });
    });
    <?php }?>
</script>