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
                                        
                <h2 class="panel-title">Train Bot</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('item/newItem')?>" method="POST">
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Item Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="item" name="item"  class="form-control mb-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Item Detail</label>

                        <div class="col-sm-8">
                            <textarea id="detail" name="detail" rows="4" class="form-control mb-md" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">Item Value</label>

                        <div class="col-sm-8">
                            <select id="value" name="value" class="form-control mb-md" required>
                                <option value="">Select Value</option>
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="number">Number</option>
                                <option value="select">Select</option>
                            </select>
                        </div>
                    </div>

                    
                    <div id="option" class="form-group" hidden>
                        <h3 class="col-sm-offset-1">Select Option</h3>
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
   document.getElementById("value").onchange = function(){
       var val = document.getElementById("value").value;
       console.log(val);
       if(val == "select"){
        document.getElementById("option").removeAttribute("hidden");
       }else{
        document.getElementById("option").setAttribute("hidden", "false");
       }
    }

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