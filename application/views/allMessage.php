<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">All Response</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tableData = array();
                foreach($message as $messages){?> 
                <tr class="gradeX">
                    <td><?= $messages->messageText?></td>
                    <td><?= $messages->messageDate?></td>
                    <td>
                        <?php 
                        if($messages->messageStatus == 1){
                            echo "Replied";
                        }else if($messages->messageStatus == 0){
                            echo "Not Replied";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="<?= base_url("message/view_message/").$messages->messageId?>" class="btn btn-success">
                            View
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>