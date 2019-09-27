<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Basic</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Message Id</th>
                    <th>Subject</th>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Category</th>
                    <th>Date Time</th>
                    <th>Message Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($message as $messages){?>
                <tr class="gradeX">
                    <td><a href="<?= base_url('incident/resolve/'). $messages->msgId?>"><?=$messages->msgId?></a></td>
                    <td><?=$messages->msgSubject?></td>
                    <td><?=$messages->msgSender?></td>
                    <td><?=$messages->msgReceiver?></td>
                    <td><?=$messages->msgCategory?></td>
                    <td><?=$messages->msgDate?></td>
                    <td>
                        <?php 
                        if($messages->msgStatus == 1){
                            echo "Unassigned";
                        }else if($messages->msgStatus == 2){
                            echo "Assigned";
                        }else if($messages->msgStatus == 3){
                            echo "Resolved";
                        }
                        ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>