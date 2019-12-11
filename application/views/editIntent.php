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
                <form class="form-horizontal form-bordered" action="<?= base_url('intent/editIntent')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Intent Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="intentId" name="intentId" hidden required value="<?= $intent->intentId?>" readonly>
                            <input type="text" id="intentNameBefore" name="intentNameBefore" hidden required value="<?= $intent->intentName?>" readonly>
                            <input type="text" id="intentName" name="intentName" class="form-control mb-md" required value="<?= $intent->intentName?>" maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Intent Detail</label>

                        <div class="col-sm-8">
                            <textarea id="intentDetail" name="intentDetail" class="form-control mb-md" required><?= $intent->intentDetail?></textarea>
                        </div>
                    </div>

                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("intent/all_intent")?>" class="btn btn-warning">Back</a>
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