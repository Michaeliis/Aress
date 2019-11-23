<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All Condition</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Condition Name</th>
                    <th>Condition Entities</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($condition as $conditions){?>
                <tr class="gradeX">
                    <td><?=$conditions->conditionName?></td>
                    <td><?=$conditions->conditionCount?></td>
                    <td>
                        <?php if($conditions->conditionStatus == "1"){?>
                            <span style="color:green">Active</span>
                        <?php }else if($conditions->conditionStatus == "0"){?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <a href="<?= base_url("condition/edit_condition/").$conditions->conditionId?>" class="btn btn-success">
                            Edit
                        </a>
                        <a href="<?= $conditions->conditionId?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>