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
                                        
                <h2 class="panel-title">Edit Response</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('bot/editResponseDetail')?>" method="POST">
                    <input type="text" id="responseId" name="responseId" value="<?= $response->responseId?>" hidden required>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Response Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="responseName" name="responseName" value="<?= $response->responseName?>" class="form-control mb-md" required>
                        </div>
                    </div>

                    <?php foreach($responsedetail as $responsedetails){?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample"><?= $responsedetails->responseTitle?></label>

                        <div class="col-sm-8">
                            <textarea id="<?= $responsedetails->responseTitle?>" name="<?= $responsedetails->responseTitle?>" class="form-control mb-md" required><?= $responsedetails->responseValue ?></textarea>
                        </div>
                    </div>
                    <?php }?>
                    
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