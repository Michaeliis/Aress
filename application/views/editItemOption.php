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
                                        
                <h2 class="panel-title">Edit Item Option</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('item/editItemOption')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Item Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="itemId" name="itemId"  class="form-control mb-md" required value="<?= $itemOption->itemId?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Option Value</label>

                        <div class="col-sm-8">
                            <input type="text" id="itemOptionValue" name="itemOptionValue"  class="form-control mb-md" required value="<?= $itemOption->itemOptionValue?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Option Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="itemOptionName" name="itemOptionName"  class="form-control mb-md" required value="<?= $itemOption->itemOptionName?>">
                        </div>
                    </div>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("item/edit_item/").$itemOption->itemId?>" class="btn btn-warning">Back</a>
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