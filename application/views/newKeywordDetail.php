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
                                        
                <h2 class="panel-title">New Keyword</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('bot/insertKeywordDetail')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Entity</label>

                        <div class="col-sm-8">
                            <input type="text" id="entity" name="entity"  class="form-control mb-md" required value="<?= $entity?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                    <h3 class="col-sm-offset-1">Keywords</h3>
                    <p class="col-sm-offset-1"> 
                        <input type="button" class="btn btn-success" value="Add Keyword" onClick="addRow('dataTable')"> 
                        <input type="button" class="btn btn-danger" value="Remove Keyword" onClick="deleteRow('dataTable')">
                    </p>
                    
                    <table id="dataTable" class="input-group col-sm-10 col-sm-offset-1 mb-md">
                        <tbody>
                        <tr>
                            <p>
                            <td><input type="checkbox" required="required" name="chk[]" checked="checked" /></td>
                            <td>
                                <input type="text" name="keyword[]" class="form-control" placeholder="Keyword" required>
                            </td>
                            </p>
                        </tr>
                        </tbody>
                    </table>
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