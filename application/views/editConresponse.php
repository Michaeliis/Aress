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
                <h2 class="panel-title">Edit Condition Response</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('conresponse/editConresponse')?>" method="POST">
                    <input type="text" name="crId" value="<?= $conresponse->crId?>" required hidden>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Condition</label>

                        <div class="col-sm-8">
                            <input type="text" name="oldCondition" value="<?= $conresponse->conditionId?>" required hidden>
                            <select name="condition" id="condition" class="form-control mb-md" required>
                                <option value="">Select Condition</option>
                                <?php foreach($condition as $conditions){?>
                                    <option value="<?= $conditions->conditionId?>" <?php if($conditions->conditionId == $conresponse->conditionId){echo "selected";}?>><?= $conditions->conditionName?></option>
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
                                    <option value="<?= $responses->responseId?>" <?php if($responses->responseId == $conresponse->responseId){echo "selected";}?>><?= $responses->responseName?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("conresponse/all_condition_response")?>" class="btn btn-warning">Back</a>
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
<script src="<?=base_url("assets/")?>vendor/jquery/jquery.js"></script>


<script>
    <?php if(isset($_SESSION["notif"])){?>
    $(document).ready(function(){
        new PNotify({
            title: 'Notification',
            text: '<?=$_SESSION['notif']?>',
            type: '<?=$_SESSION['notifType']?>'
        });
    });
    <?php }?>
</script>