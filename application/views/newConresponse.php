<style>
    #dataTable td{
        vertical-align: top;
        padding: 5px;
    }
</style>
<!-- start: page -->
<?php if(isset($_SESSION["error"])){?>
    <script>alert("<?=$_SESSION['error']?>")</script>
<?php }?>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">New Condition Response</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('conresponse/newConresponse')?>" method="POST">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Condition</label>

                        <div class="col-sm-8">
                            <select name="condition" id="condition" class="form-control mb-md" required>
                                <option value="">Select Condition</option>
                                <?php foreach($condition as $conditions){?>
                                    <option value="<?= $conditions->conditionId?>"><?= $conditions->conditionName?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Response</label>

                        <div class="col-sm-8">
                            <select name="response" id="response" class="form-control mb-md" required>
                                <option value="">Select Response</option>
                                <?php foreach($response as $responses){?>
                                    <option value="<?= $responses->responseId?>"><?= $responses->responseName?></option>
                                <?php } ?>
                            </select>
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