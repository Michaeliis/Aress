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
                    <th>Synonym</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tableData = array();
                foreach($keyword as $keywords){
                    $tableData[$keywords->entity][] = $keywords->keyword;
                }

                foreach($entity as $entities){
                    $entity = $entities->entity;?> 
                <tr class="gradeX">
                    <td><?= $entity?></td>
                    <td>
                        <?php
                        foreach($tableData[$entity] as $values){
                            echo $values. "; ";
                        }?>
                    </td>
                    <td>
                        <a href="<?= base_url("keyword/edit_keyword/").$entity?>" class="btn btn-success">
                            Edit
                        </a>
                        <a href="<?= $entity?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>