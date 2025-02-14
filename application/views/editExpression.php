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
                                        
                <h2 class="panel-title">Edit Expression</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('entity/editExpression')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Entity Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="entity" name="entity" hidden required value="<?= $entity->entityId?>" readonly>
                            <input type="text" id="entityName" name="entityName" class="form-control mb-md" required value="<?= $entity->entityName?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Value Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="value" name="value" hidden required value="<?= $value->valueId?>" readonly>
                            <input type="text" id="valueName" name="valueName"  class="form-control mb-md" required value="<?= $value->value?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">Expression</label>

                        <div class="col-sm-8">
                        <input type="text" id="expressionOld" name="expressionOld" required value="<?= $expression->expression?>" readonly hidden>
                        <input type="text" id="expression" name="expression"  class="form-control mb-md" required value="<?= $expression->expression?>" maxlength="50">
                        </div>
                    </div>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("entity/edit_value/").$entity->entityId."/".$value->valueId?>" class="btn btn-warning">Back</a>
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