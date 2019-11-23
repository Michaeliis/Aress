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
                <h2 class="panel-title">New App</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('app/newApp')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">App Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="appName" name="appName"  class="form-control mb-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">App Language</label>

                        <div class="col-sm-8">
                            <select id="appLanguage" name="appLanguage"  class="form-control mb-md" required>
                                <option value="">Select Language</option>
                                <option value="en">English</option>
                                <option value="id">Indonesian</option>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">App Detail</label>

                        <div class="col-sm-8">
                            <textarea name="appDetail" rows="4" class="form-control mb-md" required></textarea>
                        </div>
                    </div>
                    
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