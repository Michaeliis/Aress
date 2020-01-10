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
                                        
                <h2 class="panel-title">Edit Value</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url("entity/editValue")?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Entity Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="entityId" name="entityId" required value="<?= $entity->entityId?>" readonly hidden>
                            <input type="text" id="entityName" name="entityName"  class="form-control mb-md" required value="<?= $entity->entityName?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Value Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="valueId" name="valueId" required value="<?= $value->valueId?>" readonly hidden>
                            <input type="text" id="valueName" name="valueName"  class="form-control mb-md" required value="<?= $value->value?>" readonly>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th>Expression</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($expression as $expressions){?>
                            <tr class="gradeX">
                                <td>
                                    <?= $expressions->expression?>
                                </td>
                                <td>
                                    <?= $expressions->userName?>
                                </td>
                                <td>
                                    <?php if($expressions->expressionStatus=="1"){?>
                                        <span style="color:green">Active</span>
                                    <?php }else if($expressions->expressionStatus=="0"){?>
                                        <span style="color:red">Inactive</span>
                                    <?php }?>
                                </td>
                                <td>
                                    <?php if($expressions->expressionStatus=="1"){?>
                                        <a href="<?= base_url("entity/delete_expression/").$entity->entityId."/".$value->valueId."/".$expressions->expressionId?>" class="btn btn-danger">
                                            Delete
                                        </a>
                                        <a href="<?= base_url("entity/edit_expression/").$entity->entityId."/".$value->valueId."/".$expressions->expressionId?>" class="btn btn-success">
                                            Edit
                                        </a>
                                    <?php }else if($expressions->expressionStatus=="0"){?>
                                        <a href="<?= base_url("entity/activate_expression/").$entity->entityId."/".$value->valueId."/".$expressions->expressionId?>" class="btn btn-danger">
                                            Reactivate
                                        </a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">New Expression(s)</label>

                        <div class="col-sm-8">
                            <textarea name="expression" class="form-control mb-md" rows="4" required></textarea>
                        </div>
                    </div>
                    
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("entity/edit_entity/").$entity->entityId?>" class="btn btn-warning">Back</a>
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