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
                                        
                <h2 class="panel-title">Edit Value</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('keyword/editKeywordDetail')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Entity Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="entity" name="entity"  class="form-control mb-md" required value="<?= $entity?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Value Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="value" name="value"  class="form-control mb-md" required value="<?= $value?>" readonly>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th>Expression</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($expression as $expressions){?>
                            <tr class="gradeX">
                                <td>
                                    <?= $expressions->expression?>
                                </td>
                                <td>
                                    <a href="<?= base_url("entity/edit_expression/").$entity."/".$value."/".$expressions->expression?>" class="btn btn-success">
                                        Edit
                                    </a>
                                    <a href="<?= $expressions->expression?>" class="btn btn-danger">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </section>										
    </div>
</div>
<!-- end: page -->