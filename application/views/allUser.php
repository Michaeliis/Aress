<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Basic</h2>
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
                        <?php 
                        if($users->userStatus == 1){
                            echo "Unassigned";
                        }else if($users->userStatus == 2){
                            echo "Assigned";
                        }else if($users->userStatus == 3){
                            echo "Resolved";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="<?= base_url("user/edit_user/").$users->userId?>" class="btn btn-success">
                            Edit
                        </a>
                        <a href="<?=$users->userId?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>