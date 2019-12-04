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
                                        
                <h2 class="panel-title">View Sample</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Sample</label>

                        <div class="col-sm-8">
                            <span  class="form-control mb-md"><?= $sample->sampleText?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Intent</label>

                        <div class="col-sm-8">
                            <span  class="form-control mb-md"><?= $sampleintent->intentName?></span>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th class="col-md-4">Entity</th>
                                <th class="col-md-6">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($sampleentity as $sampleenties){?>
                            <tr class="gradeX">
                                <td><?= $sampleenties->entityName ?></td>
                                <td><?= $sampleenties->valueName ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-11">
                                <a href="<?= base_url("sample/all_sample")?>" class="btn btn-warning">Back</a>
                            </div>
                        </div>
                    </footer>
                </form>
            </div>
        </section>										
    </div>
</div>
<!-- end: page -->