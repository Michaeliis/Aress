<style>
    #dataTable td{
        vertical-align: top;
        padding: 5px;
    }
</style>
<!-- start: page -->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                                        
                <h2 class="panel-title">Edit Keyword</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('bot/editKeyword')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Entity Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="entity" name="entity"  class="form-control mb-md" required value="<?= $entity?>" readonly>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th class="col-md-8">Keyword</th>
                                <th class="col-md-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($keyword as $keywords){?>
                            <tr class="gradeX">
                                <td><?=$keywords->keyword?></td>
                                <td>
                                    <a href="<?= base_url("bot/edit_keyword_detail/").$keywords->entity."/".$keywords->keyword?>" class="btn btn-success">
                                        Edit
                                    </a>
                                    <a href="<?= base_url("bot/delete_keyword_detail/").$keywords->entity."/".$keywords->keyword?>" class="btn btn-danger">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-10">
                                <input type="submit" value="Submit" class="btn btn-primary">
                                <input type="reset" value="Reset" class="btn btn-default">
                            </div>
                        </div>
                    </footer>
                </form>
            </div>
        </section>										
    </div>
</div>
<!-- end: page -->