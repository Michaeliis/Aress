        <div class="inner-body mailbox-folder">
            <!-- START: .mailbox-header -->
            <header class="mailbox-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="mailbox-title text-light m-none">
                            <a id="mailboxToggleSidebar" class="sidebar-toggle-btn trigger-toggle-sidebar">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line line-angle1"></span>
                                <span class="line line-angle2"></span>
                            </a>
        
                            Inbox
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="search">
                            <div class="input-group input-search">
                                <form name="searchMsg" id="searchMsg" action="<?= base_url('contest/search_message')?>">
                                    <input type="text" class="form-control" name="q" id="q" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- END: .mailbox-header -->
        
            <!-- START: .mailbox-actions -->
            <div class="mailbox-actions">
                <ul class="list-unstyled m-none pt-lg pb-lg">
                    <li class="ib mr-sm">
                        <div class="btn-group">
                            <a href="#" class="item-action fa fa-chevron-down dropdown-toggle" data-toggle="dropdown"></a>
        
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">All</a></li>
                                <li><a href="#">None</a></li>
                                <li><a href="#">Read</a></li>
                                <li><a href="#">Unread</a></li>
                                <li><a href="#">Starred</a></li>
                                <li><a href="#">Unstarred</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="ib mr-sm">
                        <a class="item-action fa fa-refresh" href="#"></a>
                    </li>
                    <li class="ib mr-sm">
                        <a class="item-action fa fa-tag" href="#"></a>
                    </li>
                    <li class="ib">
                        <a class="item-action fa fa-times text-danger" href="#"></a>
                    </li>
                </ul>
            </div>
            <!-- END: .mailbox-actions -->
        
            <div id="mailbox-email-list" class="mailbox-email-list">
                <div class="nano">
                    <div class="nano-content">
                        <ul id="" class="list-unstyled">
                            <?php foreach($message as $messages){?>
                            <li class="unread">
                                <a href="<?= base_url('contest/chat/'). $messages->msgId?>">
                                    <div class="col-sender">
                                        <div class="checkbox-custom checkbox-text-primary ib">
                                            <input type="checkbox" id="mail1">
                                            <label for="mail1"></label>
                                        </div>
                                        <p class="m-none ib"><?= $messages->msgReceiver?></p>
                                    </div>
                                    <div class="col-mail">
                                        <p class="m-none mail-content">
                                            <span class="subject"><?= $messages->msgSubject?></span>
                                        </p>
                                        <p class="m-none mail-date">
                                            <?php
                                            $date = strtotime($messages->msgDate);
                                            if(date("dmY", $date) == date("dmY")){
                                                echo date("H:i", $date);
                                            }else{
                                                echo date("d M", $date);
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end: page -->