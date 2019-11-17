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
                    <th>Entity</th>
                    <th>Value</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tableData = array();
                foreach($value as $values){
                    $tableData[$values->entity][] = $values->value;
                }

                foreach($entity as $entities){
                    $entityName = $entities->entity;?> 
                <tr class="gradeX">
                    <td><?= $entityName?></td>
                    <td>
                        <?php
                        foreach($tableData[$entityName] as $values){
                            echo $values. "; ";
                        }?>
                    </td>
                    <td>
                        <a href="<?= base_url("entity/edit_entity/").$entityName?>" class="btn btn-success">
                            Edit
                        </a>
                        <a href="<?= $entityName    ?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>