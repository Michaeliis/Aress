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
                <h2 class="panel-title">New User</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('user/insertUser')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="name" name="name"  class="form-control mb-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Email</label>

                        <div class="col-sm-8">
                            <input type="text" id="email" name="email"  class="form-control mb-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Phone</label>

                        <div class="col-sm-8">
                            <input type="text" id="phone" name="phone"  class="form-control mb-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Position</label>

                        <div class="col-sm-8">
                            <input type="text" id="position" name="position"  class="form-control mb-md" required>
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