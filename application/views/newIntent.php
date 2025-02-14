<!-- start: page -->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">       
                <h2 class="panel-title">New Intent</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('intent/newIntent')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Intent Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="intentName" name="intentName"  class="form-control mb-md" required maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Intent Detail</label>

                        <div class="col-sm-8">
                            <textarea name="intentDetail" rows="4" class="form-control mb-md" required></textarea>
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