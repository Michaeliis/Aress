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
                                        
                <h2 class="panel-title">Edit Item</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('response/editResponseDetail')?>" method="POST">
                <input type="text" id="responseId" name="responseId" value="<?= $responsedetail->responseId ?>" required hidden readonly>
                <input type="text" id="responseTitle" name="oldresponseTitle" value="<?= $responsedetail->responseTitle ?>" required hidden readonly>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Title</label>

                        <div class="col-sm-8">
                            <input type="text" id="responseTitle" name="responseTitle"  class="form-control mb-md" value="<?= $responsedetail->responseTitle ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Value</label>

                        <div class="col-sm-8">
                        <input type="text" id="responseValue" name="responseValue"  class="form-control mb-md" value="<?= $responsedetail->responseValue ?>" required>
                        </div>
                    </div>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("response/edit_response/").$responsedetail->responseId?>" class="btn btn-warning">Back</a>
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