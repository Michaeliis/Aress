<!-- start: page -->
<section class="content-with-menu mailbox">
    <div class="content-with-menu-container" data-mailbox data-mailbox-view="email">
        <div class="inner-menu-toggle">
            <a href="#" class="inner-menu-expand" data-open="inner-menu">
                Show Menu <i class="fa fa-chevron-right"></i>
            </a>
        </div>
        
        <menu id="content-menu" class="inner-menu" role="menu">
            <div class="nano">
                <div class="nano-content">
        
                    <div class="inner-menu-toggle-inside">
                        <a href="#" class="inner-menu-collapse">
                            <i class="fa fa-chevron-up visible-xs-inline"></i><i class="fa fa-chevron-left hidden-xs-inline"></i> Hide Menu
                        </a>
        
                        <a href="#" class="inner-menu-expand" data-open="inner-menu">
                            Show Menu <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
        
                    <div class="inner-menu-content">
                        <a href="<?= base_url('report/compose')?>" class="btn btn-block btn-primary btn-md pt-sm pb-sm text-md">
                            <i class="fa fa-envelope mr-xs"></i>
                            Compose
                        </a>
        
                        <ul class="list-unstyled mt-xl pt-md">
                            <li>
                                <a href="<?= base_url('report/inbox')?>" class="menu-item active">Inbox <span class="label label-primary text-normal pull-right">43</span></a>
                            </li>
                            <li>
                                <a href="mailbox-folder.html" class="menu-item">Important</a>
                            </li>
                            <li>
                                <a href="mailbox-folder.html" class="menu-item">Sent</a>
                            </li>
                            <li>
                                <a href="mailbox-folder.html" class="menu-item">Drafts</a>
                            </li>
                            <li>
                                <a href="mailbox-folder.html" class="menu-item">Trash</a>
                            </li>
                        </ul>
        
                        <hr class="separator" />
        
                        <hr class="separator" />
        
                        <div class="sidebar-widget m-none">
                            <div class="widget-header">
                                <h6 class="title">Chat</h6>
                                <span class="widget-toggle">+</span>
                            </div>
                            <div class="widget-content">
                                <ul class="list-unstyled mailbox-bullets"><!--/*people you chat to-->
                                    <li>
                                        <a href="#" class="menu-item">Amy Doe <span class="ball green"></span></a>
                                    </li>
                                    <li>
                                        <a href="#" class="menu-item">Joey Doe <span class="ball green"></span></a>
                                    </li>
                                    <li>
                                        <a href="#" class="menu-item">Robert Doe <span class="ball orange"></span></a>
                                    </li>
                                    <li>
                                        <a href="#" class="menu-item">John Doe <span class="ball red"></span></a>
                                    </li>
                                    <li>
                                        <a href="#" class="menu-item">Uncle Doe <span class="ball red"></span></a>
                                    </li>
                                    <li class="text-center mt-sm">
                                        <em><a href="#">show offline</a></em>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </menu>