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
                                        
                <h2 class="panel-title">Edit Condition</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('condition/editConditionDetail')?>" method="POST">
                    <input type="text" name="conditionDetailId" value="<?= $conditionDetail->conditionDetailId?>" readonly hidden required>
                    <input type="text" name="conditionId" value="<?= $conditionDetail->conditionId?>" readonly hidden required>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Entity</label>

                        <div class="col-sm-8">
                            <select name="entity" id="entity" class="form-control mb-md" required>
                                <?php foreach($entity as $entities){?>
                                    <option value="<?= $entities->entityId?>" <?php if($conditionDetail->conditionEntity == $entities->entityName){ echo "selected";}?>><?= $entities->entityName?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Value</label>

                        <div class="col-sm-8">
                            <select name="value" id="value" class="form-control mb-md" required>
                                <?php foreach($value as $values){?>
                                    <option value="<?= $values->value?>" <?php if($values->value == $conditionDetail->conditionValue){ echo "selected";}?>><?= $values->value?></option>
                                <?php } ?>
                            </select>
                        </div>
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
$(document).ready(function(){
 
 $('#entity').change(function(){ 
     var entity = $(this).val();
     $.ajax({
         url : "<?php echo site_url('ajax/selectValue');?>",
         method : "POST",
         data : {entity: entity},
         async : true,
         dataType : 'json',
         success: function(data){
              
             var html = '';
             var i;
             for(i=0; i<data.length; i++){
                 html += '<option value='+data[i].value+'>'+data[i].value+'</option>';
             }
             $('#value').html(html);

         }
     });
     return false;
 }); 
  
});
</script>
</script>