<?php if(isset($_SESSION["error"])){?>
    <script>alert("<?=$_SESSION['error']?>")</script>
<?php }?>
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
                                        
                <h2 class="panel-title">Edit Entity</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('entity/editEntity')?>" method="POST">
                    <input type="text" name="entityId" value="<?= $entity->entityId?>" hidden>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Entity Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="entity" name="entity" value="<?= $entity->entityName?>" class="form-control mb-md" required readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Entity Detail</label>

                        <div class="col-sm-8">
                            <textarea rows="4" id="entityDetail" name="entityDetail" class="form-control mb-md" required><?= $entity->entityDetail?></textarea>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th class="col-md-3">Value</th>
                                <th class="col-md-3">Expression</th>
                                <th class="col-md-3">Created By</th>
                                <th class="col-md-2">Status</th>
                                <th class="col-md-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($value as $values){?>
                            <tr class="gradeX">
                                <td><?=$values->value?></td>
                                <td>
                                    <?php foreach($expression[$values->valueId] as $expressions){
                                        echo ($expressions->expression . "; ");
                                    }?>
                                </td>
                                <td><?=$values->userName?></td>
                                <td>
                                    <?php if($values->valueStatus == "1"){?>
                                        <span style="color:green">Active</span>
                                    <?php }else if($values->valueStatus == "0"){?>
                                        <span style="color:red">Inactive</span>
                                    <?php }?>
                                </td>
                                </td>
                                <td>
                                    <?php if($values->valueStatus == "1"){?>
                                        <a href="<?= base_url("entity/delete_value/").$entity->entityId. "/". $values->valueId?>" class="btn btn-danger">
                                            Delete
                                        </a>
                                        <a href="<?= base_url("entity/edit_value/").$entity->entityId. "/". $values->valueId?>" class="btn btn-success">
                                            Edit
                                        </a>
                                    <?php }else if($values->valueStatus == "0"){?>
                                        <a href="<?= base_url("entity/activate_value/").$entity->entityId. "/". $values->valueId?>" class="btn btn-danger">
                                            Reactivate
                                        </a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    <div class="form-group">
                        <h3 class="col-sm-offset-1">New Values</h3>
                        <p class="col-sm-offset-1"> 
                            <input type="button" class="btn btn-success" value="Add Value" onClick="addRow('dataTable')"> 
                            <input type="button" class="btn btn-danger" value="Remove Value" onClick="deleteRow('dataTable')">
                        </p>
                        
                        <table id="dataTable" class="input-group col-sm-10 col-sm-offset-1 mb-md">
                            <tbody>
                            <tr>
                                <p>
                                <td><input type="checkbox" name="chk[]"/></td>
                                <td>
                                    <input type="text" name="value[]" class="form-control" placeholder="Value Name" maxlength="50">
                                </td>
                                <td>
                                    <textarea name="expression[]" class="form-control" placeholder="Expressions / Synonyms"></textarea>
                                </td>
                                </p>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("entity/all_entity")?>" class="btn btn-warning">Back</a>
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

<script>
function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < 20){                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i <colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
		}
	}else{
		 alert("Maximum location count is 20");
			   
	}
}

function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++) {
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		if(null != chkbox && true == chkbox.checked) {
			if(rowCount <= 1) {               // limit the user from removing all the fields
				alert("Cannot Remove all the Item.");
				break;
			}
			table.deleteRow(i);
			rowCount--;
			i--;
		}
	}
}
</script>