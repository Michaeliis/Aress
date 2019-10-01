<!-- start: page -->
<?php
    $msgReceiver = $msgInfo->msgReceiver;
    $msgStart = $msgInfo->msgDate;
    $msgCategory = $msgInfo->msgCategory;?>
    <p class="text-right">
        <a class="btn btn-primary">Assign</a>
        <a href="<?= base_url('incident/edit_resolve/'). $msgId?>" class="btn btn-info">Modify</a>
    </p>
<h3>Incident: <?= $msgInfo->msgId?></h3>

<div class="row">

    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">General Information</h2>
            </header>

            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="position"><b>Caller</b></label>

                    <div class="col-sm-9">
                        <?= $msgInfo->msgSender?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="position"><b>Status</b></label>

                    <div class="col-sm-9">
                        <?php 
                        if($msgInfo->msgStatus == 1){
                            echo "Unassigned";
                        }else if($msgInfo->msgStatus == 2){
                            echo "Assigned";
                        }else if($msgInfo->msgStatus == 3){
                            echo "Resolved";
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="position"><b>Title</b></label>

                    <div class="col-sm-9">
                        <?= $msgInfo->msgSubject?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="position"><b>Description</b></label>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-12">
                        <?= $firstChat->chatContent?>
                    </div>
                </div>
                <br>
            </div>
        </section>
    </div>

    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Qualification</h2>
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="position"><b>Impact</b></label>

                    <div class="col-sm-9">
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="position"><b>Urgency</b></label>

                    <div class="col-sm-9">
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="position"><b>Priority</b></label>

                    <div class="col-sm-9">
                        
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Contact</h2>
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="position"><b>Team</b></label>

                    <div class="col-sm-9">
                        <?= $msgCategory?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="position"><b>Agent</b></label>

                    <div class="col-sm-9">
                        <?= $msgReceiver?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Dates</h2>
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="position"><b>Start Date</b></label>

                    <div class="col-sm-8">
                        <?= $msgStart?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="position"><b>Last Update</b></label>

                    <div class="col-sm-8">
                        
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" for="position"><b>Assignment Date</b></label>

                    <div class="col-sm-8">
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Resolution</h2>
            </header>
            <div class="panel-body">
                
            </div>
        </section>
    </div>

    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Public Log</h2>
            </header>
            <div class="panel-body">
                <?php foreach($restChat as $chats){?>
                <?= $chats->chatSender?>, <?=$chats->chatDate?>
                <blockquote><?= $chats->chatContent?></blockquote>
                <?php } ?>
            </div>
        </section>
    </div>
</div>
<!-- end: page -->