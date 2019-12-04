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
                                        
                <h2 class="panel-title">View Message</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Message</label>

                        <div class="col-sm-8">
                            <span  class="form-control mb-md"><?= $message->messageText?></span>
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
                            <?php foreach($messageResponse as $item => $value){?>
                            <tr class="gradeX">
                                <td><?= $item ?></td>
                                <td><?= $value ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </section>										
    </div>
</div>
<!-- end: page -->