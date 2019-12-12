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

                    <h3>Chat-bot Response</h3>

                    <?php foreach($result as $title => $value){?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample"><?= $title?></label>

                        <div class="col-sm-8">
                            <p><?= $value?></p>
                        </div>
                    </div>
                    <?php }?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">JSON Response</label>

                        <div class="col-sm-8">
                            <textarea readonly name="result" rows="4" class="form-control mb-md" required><?= json_encode($result)?></textarea>
                        </div>
                    </div>
                    
                    <h3>Wit.ai Response</h3>
                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th>Entity</th>
                                <th>Value</th>
                                <th>Confidence</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($server_output["entities"] as $entities => $value){?>
                                <?php foreach($value as $val){?>
                                    <tr class="gradeX">
                                        <td><?=$entities?></td>
                                        <td><?=$val["value"]?></td>
                                        <td><?=$val["confidence"]?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">JSON Response</label>

                        <div class="col-sm-8">
                            <textarea readonly name="result" rows="4" class="form-control mb-md" required><?= json_encode($server_output)?></textarea>
                        </div>
                    </div>

                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-11">
                                <a href="<?= base_url("bot/check_message")?>" class="btn btn-warning">Back</a>
                            </div>
                        </div>
                    </footer>
                </form>
            </div>
        </section>										
    </div>
</div>
<!-- end: page -->