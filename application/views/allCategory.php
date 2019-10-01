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
                    <th>Category Name</th>
                    <th>Detail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($category as $categories){?>
                <tr class="gradeX">
                    <td><?=$categories->categoryName?></td>
                    <td><?=$categories->categoryDetail?></td>
                    <td>
                        <a href="<?= base_url("category/edit_category/").$categories->categoryName?>" class="btn btn-success">
                            Edit
                        </a>
                        <a href="<?= $categories->categoryName?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>