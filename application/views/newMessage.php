        <div class="inner-body">
            
            <div class="mailbox-compose">

                <!-- Form kirim -->
                <form id="compose" action="<?= base_url('report/confirm_report')?>" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-bordered" accept-charset="utf-8">
                    <!--
                    <div class="form-group form-group-invisible">
                        <label for="to" class="control-label-invisible">To:</label>
                        <div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
                            <input id="to" type="text" class="form-control form-control-invisible" data-role="tagsinput" data-tag-class="label label-primary" value="">
                        </div>
                    </div>
                    -->
        
                    <div class="form-group form-group-invisible">
                        <label for="to" class="control-label-invisible">To:</label>
                        <div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
                            <select id="to" type="text" class="form-control form-control-invisible" data-role="tagsinput" data-tag-class="label label-primary" name="to">
                                <option value="Ares">Ares</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group-invisible">
                        <label for="to" class="control-label-invisible">Impact:</label>
                        <div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
                            <select id="impact" type="text" class="form-control form-control-invisible" data-role="tagsinput" data-tag-class="label label-primary" name="impact">
                                <option value="personal">Personal</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group-invisible">
                        <label for="to" class="control-label-invisible">Urgency:</label>
                        <div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
                            <select id="urgency" type="text" class="form-control form-control-invisible" data-role="tagsinput" data-tag-class="label label-primary" name="urgency">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="very high">Very high</option>
                            </select>
                        </div>
                    </div>
                    
        
                    <div class="form-group form-group-invisible">
                        <label for="subject" class="control-label-invisible">Subject:</label>
                        <div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
                            <input id="subject" name="subject" type="text" class="form-control form-control-invisible" value="">
                        </div>
                    </div>
        
                    <div class="form-group">
                        <div class="compose">
                            <textarea name="report" id="summernote" class="compose-control">
                            </textarea>
                        </div>
                    </div>
                    <input type="file" name="userfile" size="20" />
                    <p class="text-right">
                        <a onclick="document.forms['compose'].submit();" class="btn btn-success"><i class="fa fa-send-o mr-sm"></i> Send</a>
                    </p>  
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end: page -->