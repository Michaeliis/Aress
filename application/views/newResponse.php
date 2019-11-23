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
                                        
                <h2 class="panel-title">New Response</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('bot/insertConditionResponse')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Response Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="responseName" name="responseName"  class="form-control mb-md" required>
                        </div>
                    </div>

                    <?php foreach($item as $items){?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample"><?= $items->itemName?></label>

                        <div class="col-sm-8">
                            <?php if($items->itemValue == "textarea"){?>
                            <textarea name="<?= $items->itemId?>" rows="4" class="form-control mb-md" required></textarea>
                            <?php }?>

                            <?php if($items->itemValue == "text"){?>
                            <input type="text" name="<?= $items->itemId?>" class="form-control mb-md" required>
                            <?php }?>

                            <?php if($items->itemValue == "number"){?>
                            <input type="number" name="<?= $items->itemId?>" class="form-control mb-md" required>
                            <?php }?>

                            <?php if($items->itemValue == "select"){?>
                            <select name="<?= $items->itemId?>" class="form-control mb-md" required>
                                <option value="">Select <?= $items->itemId?></option>
                                <?php foreach($itemOption[$items->itemId] as $itemOptions){?>
                                    <option value="<?=$itemOptions["itemOptionValue"]?>"><?=$itemOptions["itemOptionName"]?></option>
                                <?php }?>
                            </select>
                            <?php }?>
                        </div>
                    </div>
                    <?php }?>
                    
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