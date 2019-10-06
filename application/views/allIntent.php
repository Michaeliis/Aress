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
                    <th>Intent Name</th>
                    <th>Response</th>
                    <th>Category</th>
                    <th>Assigned To</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($response as $responses){?>
                <tr class="gradeX">
                    <td><?=$responses->intent?></td>
                    <td><?=$responses->response?></td>
                    <td><?=$responses->category?></td>
                    <td><?=$responses->assignedTo?></td>
                    <td>
                        <a href="<?= base_url("category/edit_category/").$responses->intent?>" class="btn btn-success">
                            Edit
                        </a>
                        <a href="<?= $responses->intent?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>