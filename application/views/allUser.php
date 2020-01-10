<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All User</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($user as $users){?>
                <tr class="gradeX">
                    <td><?=$users->userId?></td>
                    <td><?=$users->userName?></td>
                    <td><?=$users->userPhone?></td>
                    <td><?=$users->userEmail?></td>
                    <td><?=$users->userPosition?></td>
                    <td>
                        <?php if($users->userStatus == "1"){?>
                            <span style="color:green">Active</span>
                        <?php }else if($users->userStatus == "0"){?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <a href="<?= base_url("user/edit_user/").$users->userId?>" class="btn btn-success">
                            Edit
                        </a>
                        <?php if($users->userStatus == "1"){?>
                            <a href="<?= base_url("user/delete_user/").$users->userId?>" class="btn btn-danger">
                                Delete
                            </a>
                        <?php }else if($users->userStatus == "0"){?>
                            <a href="<?= base_url("user/activate_user/").$users->userId?>" class="btn btn-danger">
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