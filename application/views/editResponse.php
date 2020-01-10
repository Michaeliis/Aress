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
                                        
                <h2 class="panel-title">Edit Response</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('response/editResponse')?>" method="POST">
                    <input type="text" id="responseId" name="responseId" value="<?= $response->responseId?>" hidden required>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Response Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="responseName" name="responseName" value="<?= $response->responseName?>" class="form-control mb-md" required maxlength="30">
                            <input type="text" id="responseNameOld" name="responseNameOld" value="<?= $response->responseName?>" required hidden>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th class="col-md-3">Title</th>
                                <th class="col-md-3">Value</th>
                                <th class="col-md-2">Status</th>
                                <th class="col-md-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($responsedetail as $responsedetails){?>
                            <tr class="gradeX">
                                <td><?= $responsedetails->responseTitle?></td>
                                <td><?= $responsedetails->responseValue ?></td>
                                <td>
                                    <?php if($responsedetails->responseDetailStatus=="1"){?>
                                        <span style="color:green">Active</span>
                                    <?php }else if($responsedetails->responseDetailStatus=="0"){?>
                                        <span style="color:red">Inactive</span>
                                    <?php }?>
                                </td>
                                <td>
                                    <a href="<?= base_url("response/edit_response_detail/").$response->responseId. "/". $responsedetails->responseTitle?>" class="btn btn-success">
                                        Edit
                                    </a>
                                    <?php if($responsedetails->responseDetailStatus=="1"){?>
                                        <a href="<?= base_url("response/delete_response_detail/").$response->responseId."/".$responsedetails->responseTitle?>" class="btn btn-danger">
                                            Delete
                                        </a>
                                    <?php }else if($responsedetails->responseDetailStatus=="0"){?>
                                        <a href="<?= base_url("response/activate_response_detail/").$response->responseId."/".$responsedetails->responseTitle?>" class="btn btn-danger">
                                            Reactivate
                                        </a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a class="btn btn-success" href="<?= base_url('response/new_response_detail/'). $response->responseId?>">Add New</a>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("response/all_response")?>" class="btn btn-warning">Back</a>
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