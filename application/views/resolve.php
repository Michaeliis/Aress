<!-- start: page -->
<?php foreach($msgInfo as $msgInfos){
    $msgReceiver = $msgInfos->msgReceiver;
    $msgStart = $msgInfos->msgDate;
    $msgCategory = $msgInfos->msgCategory;?>
<h3>Incident: <?= $msgInfos->msgId?></h3>

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
                <table>
                    <tr>
                        <td>
                            <b>Caller</b>
                        </td>
                        <td>
                            : <?= $msgInfos->msgSender?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Status</b>
                        </td>
                        <td>
                            : <?php 
                            if($msgInfos->msgStatus == 1){
                                echo "Unassigned";
                            }else if($msgInfos->msgStatus == 2){
                                echo "Assigned";
                            }else if($msgInfos->msgStatus == 3){
                                echo "Resolved";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Title</b>
                        </td>
                        <td>
                            : <?= $msgInfos->msgSubject?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Description</b>&nbsp;&nbsp;
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php foreach($firstChat as $chats){
                                echo $chats->chatContent;
                            } ?>
                        </td>
                    </tr>
                </table>
                <br>
            </div>
            <?php }?>
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
                <table>
                    <tr>
                        <td>
                            <b>Impact</b>
                        </td>
                        <td>
                            : test
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Urgency</b>
                        </td>
                        <td>
                            : test
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Priority</b>
                        </td>
                        <td>
                            : 
                        </td>
                    </tr>
                </table>
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
                <table>
                    <tr>
                        <td>
                            <b>Team</b>
                        </td>
                        <td>
                            : <?= $msgCategory?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Agent</b>
                        </td>
                        <td>
                            : <?= $msgReceiver?>
                        </td>
                    </tr>
                </table>
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
            <table>
                    <tr>
                        <td>
                            <b>Start Date</b>
                        </td>
                        <td>
                            : <?= $msgStart?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Last Update</b>
                        </td>
                        <td>
                            : test
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Assignment Date</b>
                        </td>
                        <td>
                            : 
                        </td>
                    </tr>
                </table>
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
                Content.
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