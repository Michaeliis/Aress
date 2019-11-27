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
                    <th>Conversation Flow Name</th>
                    <th>Conversation Flow Detail</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($conversationflow as $conversationflows){?>
                <tr class="gradeX">
                    <td><?=$conversationflows->conversationFlowName?></td>
                    <td><?=$conversationflows->conversationFlowDetail?></td>
                    <td>
                        <?php if($conversationflows->conversationFlowStatus == "1"){?>
                            <span style="color:green">Active</span>
                        <?php }else if($conversationflows->conversationFlowStatus == "0"){?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <a href="<?= base_url("condition/edit_condition/").$conversationflows->conversationFlowId?>" class="btn btn-success">
                            Edit
                        </a>
                        <a href="<?= $conversationflows->conversationFlowId?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>