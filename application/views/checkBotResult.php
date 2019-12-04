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
                <h2 class="panel-title">New Check</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">Message</label>

                        <div class="col-sm-8">
                            <textarea readonly name="message" rows="4" class="form-control mb-md" required><?= $message?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">Result</label>

                        <div class="col-sm-8">
                            <textarea readonly name="result" rows="4" class="form-control mb-md" required><?= $result?></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </section>										
    </div>
</div>
<!-- end: page -->