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
                <h2 class="panel-title">Edit App</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('app/editApp')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">App Id</label>

                        <div class="col-sm-8">
                            <input type="text" id="appId" name="appId" value="<?= $app->appId?>" class="form-control mb-md" required readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">App Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="appName" name="appName" value="<?= $app->appName?>" class="form-control mb-md" required maxlength="30">
                            <input type="text" id="appNameOld" name="appNameOld" value="<?= $app->appName?>" required hidden>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">App Language</label>

                        <div class="col-sm-8">
                            <select id="appLanguage" name="appLanguage"  class="form-control mb-md" required>
                                <option value="">Select Language</option>
                                <option value="en" <?php if($app->appLanguage == "en"){ echo "selected='selected'";}?>>English</option>
                                <option value="id" <?php if($app->appLanguage == "id"){ echo "selected='selected'";}?>>Indonesian</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">App Token</label>

                        <div class="col-sm-8">
                            <input type="text" id="appToken" name="appToken" value="<?= $app->appToken?>" class="form-control mb-md" required readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">App Detail</label>

                        <div class="col-sm-8">
                            <textarea name="appDetail" rows="4" class="form-control mb-md" required><?= $app->appDetail?></textarea>
                        </div>
                    </div>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("app/all_app")?>" class="btn btn-warning">Back</a>
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