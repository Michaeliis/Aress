<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All Category</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Value</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($item as $items){?>
                <tr class="gradeX">
                    <td><?=$items->itemId?></td>
                    <td><?=$items->itemValue?></td>
                    <td><?=$items->itemDetail?></td>
                    <td>
                        <?php if($items->itemStatus == "1"){?>
                            <span style="color:green">Active</span>
                        <?php }else{?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <a href="<?= base_url("item/edit_item/").$items->itemId?>" class="btn btn-success">
                            Edit
                        </a>
                        <?php if($items->itemStatus == "1"){?>
                            <a href="<?= base_url("item/delete_item/").$items->itemId?>" class="btn btn-danger">
                                Delete
                            </a>
                        <?php }else{?>
                            <a href="<?= base_url("item/activate_item/").$items->itemId?>" class="btn btn-danger">
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