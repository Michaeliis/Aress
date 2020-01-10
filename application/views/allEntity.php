<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All Entity</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Entity</th>
                    <th>Value</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($entity as $entities){?> 
                <tr class="gradeX">
                    <td><?= $entities->entityName?></td>
                    <td>
                        <?php
                        foreach($value[$entities->entityId] as $values){
                            echo $values->value. "; ";
                        }?>
                    </td>
                    <td><?= $entities->userName?></td>
                    <td>
                        <?php if($entities->entityStatus == "1"){?>
                            <span style="color:green">Active</span>
                        <?php }else if($entities->entityStatus == "0"){?>
                            <span style="color:red">Inactive</span>
                        <?php }?>
                    </td>
                    <td>
                        <?php if($entities->entityStatus == "1"){?>
                            <a href="<?= base_url("entity/delete_entity/").$entities->entityId?>" data-href="<?= base_url("entity/delete_entity/").$entities->entityId?>" class="btn btn-danger">
                                Delete
                            </a>
                            <a href="<?= base_url("entity/edit_entity/").$entities->entityId?>" class="btn btn-success">
                                Edit
                            </a>
                        <?php }else if($entities->entityStatus == "0"){?>
                            <a href="<?= base_url("entity/activate_entity/").$entities->entityId?>" class="btn btn-danger">
                                Reactivate
                            </a>
                        <?php }?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>

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
