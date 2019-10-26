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
                                        
                <h2 class="panel-title">Edit Keyword</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('keyword/editKeywordDetail')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Entity Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="entity" name="entity"  class="form-control mb-md" required value="<?= $entity?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">Keyword</label>

                        <div class="col-sm-8">
                        <input type="text" id="keywordOld" name="keywordOld" required value="<?= $keyword?>" readonly hidden>
                            <input type="text" id="keyword" name="keyword"  class="form-control mb-md" required value="<?= $keyword?>">
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