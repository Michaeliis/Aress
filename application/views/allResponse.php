<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All Response</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Response Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($response as $responses){?>
                <tr class="gradeX">
                    <td><?=$responses->responseName?></td>
                    <td>
                        <?php if($responses->responseStatus == "1"){?>
                            <span style="color:green">Active</span>
                        <?php }else if($responses->responseStatus == "0"){?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <a href="<?= base_url("response/edit_response/").$responses->responseId?>" class="btn btn-success">
                            Edit
                        </a>
                        <a href="<?= $responses->responseId?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>