        <div class="inner-body">
            <div class="inner-toolbar clearfix">
                <ul>
                    <li>
                        <a onclick="document.forms['compose'].submit();"><i class="fa fa-send-o mr-sm"></i> Send</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-paperclip mr-sm"></i> Attach</a>
                    </li>
                </ul>
            </div>
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
                        <label for="to" class="control-label-invisible">To:</label>
                        <div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
                            <select id="to" type="text" class="form-control form-control-invisible" data-role="tagsinput" data-tag-class="label label-primary" name="to">
                                <option value="Ares">Ares</option>
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
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end: page -->