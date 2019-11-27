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
                                        
                <h2 class="panel-title">New Conversation Flow</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('entity/insertEntity')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Conversation Flow Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="conversationFlowName" name="conversationFlowName"  class="form-control mb-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Conversation Flow Detail</label>

                        <div class="col-sm-8">
                            <textarea rows="4" id="conversationFlowDetail" name="conversationFlowDetail"  class="form-control mb-md" required></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                    <h3 class="col-sm-offset-1">Values</h3>
                    <p class="col-sm-offset-1"> 
                        <input type="button" class="btn btn-success" value="Add Value" onClick="addRow('dataTable')"> 
                        <input type="button" class="btn btn-danger" value="Remove Value" onClick="deleteRow('dataTable')">
                    </p>
                    
                    <table id="dataTable" class="input-group col-sm-10 col-sm-offset-1 mb-md">
                        <tbody>
                        <tr>
                            <p>
                                <td>
                                    <select name="conditionBefore[]" disabled>
                                        <option value="">Start</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="conditionId[]">
                                        <option value="">Select Condition</option>
                                        <?php foreach($condition as $conditions){?>
                                            <option value="<?= $conditions->conditionId?>"><?= $conditions->conditionName?></option>
                                        <?php }?>
                                    </select>
                                </td>
                                <td>
                                    <select name="responseId[]">
                                        <option value="">Select Response</option>
                                        <?php foreach($response as $responses){?>
                                            <option value="<?= $responses->responseId?>"><?= $responses->responseName?></option>
                                        <?php }?>
                                    </select>
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

        var newcell = row.insertCell(1);
        newcell.innerHTML = '<input type="text"  class="form-control" placeholder="Text" required="required" name="text[]" />';

        var newcell = row.insertCell(2);
        newcell.innerHTML = '<select name="conditionBefore[]" disabled><option value="">Start</option><?php foreach($condition as $conditions){?><option value="<?= $conditions->conditionId?>"><?= $conditions->conditionName?></option><?php }?></select>';

        var newcell = row.insertCell(3);
        newcell.innerHTML = '<select name="responseId[]"><option value="">Select Response</option><?php foreach($response as $responses){?><option value="<?= $responses->responseId?>"><?= $responses->responseName?></option><?php }?></select>';

        rowNum++;
        console.log(rowNum);
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