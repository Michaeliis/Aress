<?php if(isset($_SESSION["error"])){?>
    <script>alert("<?=$_SESSION['error']?>")</script>
<?php }?>
<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All Sample</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Text</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($sample as $samples){?>
                <tr class="gradeX">
                    <td><?= $samples->sampleDate?></td>
                    <td><?= $samples->sampleText?></td>
                    <td><?= $samples->userName?></td>
                    <td>
                        <?php if($samples->sampleStatus == "1"){?>
                            <span style="color:green">Active</span>
                        <?php }else if($samples->sampleStatus == "0"){?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <a href="<?= base_url("sample/view_sample/").$samples->sampleId?>" class="btn btn-success">
                            View
                        </a>
                        <a href="<?= base_url("sample/delete_sample/").$samples->sampleId?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>