<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All Intent</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Intent Name</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($intent as $intents){?>
                <tr class="gradeX">
                    <td><?=$intents->intentName?></td>
                    <td><?=$intents->intentDetail?></td>
                    <td>
                        <?php if($intents->intentStatus == "1"){?>
                            <span style="color:green">Active</span>
                        <?php }else if($intents->intentStatus == "0"){?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <a href="<?= base_url("intent/edit_intent/").$intents->intentId?>" class="btn btn-success">
                            Edit
                        </a>
                        <?php if($intents->intentStatus == "1"){?>
                            <a href="<?= base_url("intent/delete_intent/").$intents->intentId?>" class="btn btn-danger">
                                Delete
                            </a>
                        <?php }else if($intents->intentStatus == "0"){?>
                            <a href="<?= base_url("intent/activate_intent/").$intents->intentId?>" class="btn btn-danger">
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