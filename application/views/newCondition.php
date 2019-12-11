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
                                        
                <h2 class="panel-title">New Condition</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('condition/newCondition')?>" method="POST">
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Condition Name</label>

                        <div class="col-sm-8">
                            <input type="text" name="conditionName"  class="form-control mb-md" required maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Intent</label>

                        <div class="col-sm-8">
                            <select name="intent"  class="form-control mb-md" required>
                                <option value="">Select Intent</option>
                                <?php foreach($intent as $intents){?>
                                    <option value="<?= $intents->intentName?>"><?= $intents->intentName?></option>
                                <?php }?>
                            </select>
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
                                <td><input type="checkbox" name="chk[]"/></td>
                                <td>
                                    <select name="entity[]" class="form-control" placeholder="Entity" param=0 onchange="valueSet(this)" required>
                                        <option value="">Select Entity</option>
                                    <?php foreach($entity as $entities){?>
                                        <option value="<?= $entities->entityId?>"><?= $entities->entityName?></option>
                                    <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="value[]" class="form-control" placeholder="Value" param=0 required>
                                        <option value="">Select Value</option>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
var rowNum = 1;
console.log(rowNum);
function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < 20){                            // limit the user from creating fields more than your limits
        var row = table.insertRow(rowCount);

        var newcell = row.insertCell(0);
        newcell.innerHTML = '<input type="checkbox" name="chk[]" />';

        var newcell = row.insertCell(1);
        newcell.innerHTML = '<select name="entity[]" class="form-control" placeholder="Entity" param='+(rowNum)+' onchange="valueSet(this)" required><option value="">Select Entity</option><?php foreach($entity as $entities){?><option value="<?= $entities->entityId?>"><?= $entities->entityName?></option><?php } ?></select>';

        var newcell = row.insertCell(2);
        newcell.innerHTML = '<select name="value[]" class="form-control" placeholder="Value" param="'+ (rowNum) +'" required><option value="">Select Value</option></select>';
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
      console.log(rowNum);
		}
	}
}

function valueSet(obj){
    var entity = $(obj).val();
    var param = obj.getAttribute("param");
    $.ajax({
        url : "<?php echo base_url('ajax/selectValue');?>",
        method : "POST",
        data : {entity: entity},
        async : true,
        dataType : 'json',
        success: function(data){
                
            var html = '';
            var i;
            for(i=0; i<data.length; i++){
                html += '<option value='+data[i].valueId+'>'+data[i].value+'</option>';
            }
            $("[name='value[]'][param="+param+"]").html(html);

        }
    });
    return false;
}
</script>