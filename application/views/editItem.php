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
                                        
                <h2 class="panel-title">Edit Item</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('item/editItem')?>" method="POST">
                <input type="text" id="itemId" name="itemId" value="<?= $item->itemId ?>" required hidden readonly>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Item Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="item" name="item"  class="form-control mb-md" value="<?= $item->itemName ?>" required readonly maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Item Detail</label>

                        <div class="col-sm-8">
                            <textarea id="detail" name="detail" rows="4" class="form-control mb-md" required><?= $item->itemDetail ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Item Value</label>

                        <div class="col-sm-8">
                            <input type="text" id="value" name="value"  class="form-control mb-md" value="<?= $item->itemValue ?>" required readonly>
                        </div>
                    </div>

                    <?php if($item->itemValue == "select"){?>

                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th>Value</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($option as $options){?>
                            <tr class="gradeX">
                                <td><?=$options->itemOptionValue?></td>
                                <td><?=$options->itemOptionName?></td>
                                <td>
                                    <?php if($options->itemOptionStatus == 1){
                                        echo "active";
                                    }else if($options->itemOptionStatus == 0){
                                        echo "inactive";
                                    }?>
                                </td>
                                <td>
                                    <a href="<?= base_url("item/edit_item_option/").$options->itemId."/".$options->itemOptionValue?>" class="btn btn-success">
                                        Edit
                                    </a>
                                    <a href="<?= base_url("item/delete_item_option/").$options->itemId."/".$options->itemOptionValue?>" class="btn btn-danger">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div id="option" class="form-group">
                        <h3 class="col-sm-offset-1">New Select Option</h3>
                        <p class="col-sm-offset-1"> 
                            <input type="button" class="btn btn-success" value="Add Option" onClick="addRow('dataTable')"> 
                            <input type="button" class="btn btn-danger" value="Remove Option" onClick="deleteRow('dataTable')">
                        </p>
                        
                        <table id="dataTable" class="input-group col-sm-10 col-sm-offset-1 mb-md">
                            <tbody>
                            <tr>
                                <p>
                                <td><input type="checkbox" name="chk[]"/></td>
                                <td>
                                    <input type="text" name="optionValue[]" class="form-control" placeholder="Value">
                                </td>
                                <td>
                                    <input type="text" name="optionName[]" class="form-control" placeholder="Name">
                                </td>
                                </p>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("item/all_item")?>" class="btn btn-warning">Back</a>
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