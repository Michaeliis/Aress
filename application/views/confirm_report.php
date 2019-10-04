<div class="inner-body">
            
            <div class="mailbox-compose">

                <!-- Form kirim -->
                <form id="compose" action="<?= base_url('report/sendReport')?>" method="POST" class="form-horizontal form-bordered form-bordered">
                    <!--
                    <div class="form-group form-group-invisible">
                        <label for="to" class="control-label-invisible">To:</label>
                        <div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
                            <input id="to" type="text" class="form-control form-control-invisible" data-role="tagsinput" data-tag-class="label label-primary" value="">
                        </div>
                    </div>
                    -->

                    <div class="form-group form-group-invisible">
                        <label for="to" class="control-label-invisible">Report Category:</label>
                        <div class="col-sm-offset-3 col-sm-8 col-md-offset-2 col-md-9">
                            <select id="to" type="text" class="form-control form-control-invisible" data-role="tagsinput" data-tag-class="label label-primary" name="to">
                                <?php foreach($category as $categories){?>
                                <option value="<?= $categories->categoryName?>" <?php if ($categories->categoryName == $_SESSION["confirmReport"]["message"]["msgCategory"]) echo "selected"?>><?= $categories->categoryName?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
        
                    <div class="form-group form-group-invisible">
                        <label for="to" class="control-label-invisible">To:</label>
                        <div class="col-sm-offset-3 col-sm-8 col-md-offset-2 col-md-9">
                            <select id="to" type="text" class="form-control form-control-invisible" data-role="tagsinput" data-tag-class="label label-primary" name="to" disabled>
                                <option value="Ares">Ares</option>
                            </select>
                        </div>
                    </div>
                    
        
                    <div class="form-group form-group-invisible">
                        <label for="subject" class="control-label-invisible">Subject:</label>
                        <div class="col-sm-offset-3 col-sm-8 col-md-offset-2 col-md-9">
                            <input id="subject" name="subject" type="text" class="form-control form-control-invisible" value="<?= $_SESSION["confirmReport"]["message"]["msgSubject"]?>" readonly>
                        </div>
                    </div>
        
                    <div class="form-group">
                        <div class="compose">
                            <?= $_SESSION["confirmReport"]["chat"][0]["chatContent"]?>
                        </div>
                    </div>
                    <?php if(isset($_SESSION["confirmReport"]["userFile"])){
                        echo "Attached File: ". $_SESSION["confirmReport"]["userFile"];
                    } ?>
                    <p class="text-right">
                        <a onclick="document.forms['compose'].submit();" class="btn btn-success"><i class="fa fa-send-o mr-sm"></i> Send</a>
                    </p>  
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end: page -->