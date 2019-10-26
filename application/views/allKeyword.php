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
                $counter = 0;
                foreach($keyword as $keywords){
                    $keywordList[$keywords->entity][] = $keywords->keyword;
                }
                foreach($keywordList as $keywordLists => $vals){?>
                <tr class="gradeX">
                    <td><?=$keywordLists?></td>
                    <td>
                        <?php
                        foreach($vals as $values => $valss){
                            echo $valss. "; ";
                        }?>
                    </td>
                    <td>
                        <a href="<?= base_url("keyword/edit_keyword/").$keywordLists?>" class="btn btn-success">
                            Edit
                        </a>
                        <a href="<?= $keywordLists?>" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>