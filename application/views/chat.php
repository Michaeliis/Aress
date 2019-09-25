		<div class="inner-body mailbox-email">
			<?php foreach($msgInfo as $msgInfos){?>
			<div class="mailbox-email-header mb-lg">
				<h3 class="mailbox-email-subject m-none text-light">
					<?= $msgInfos->msgSubject?> <!--/*/*title here-->
				</h3>
		
				<p class="mt-lg mb-none text-md">From <a href="#"><?= $msgInfos->msgSender?> <!--/*from--></a> to <a href="#"><?= $msgInfos->msgReceiver?></a> <?= $msgInfos->msgDate?><!--/*date start--></p>
			</div>
			<div class="mailbox-email-container">
				<div class="mailbox-email-screen">
					<?php foreach($chat as $chats){?>
					<div class="panel">
						<div class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
								<a href="#" class="fa fa-mail-reply"></a>
								<a href="#" class="fa fa-mail-reply-all"></a>
								<a href="#" class="fa fa-star-o"></a>
							</div>
		
							<p class="panel-title"><?= $chats->chatSender?><!--/*from--> <i class="fa fa-angle-right fa-fw"></i> <?= $chats->chatReceiver?><!--/*to--></p>
						</div>
						<div class="panel-body">
						<?= $chats->chatContent?>
							<!--/*body-->
						</div>
						<div class="panel-footer">
							<p class="m-none"><small><?= $chats->chatDate?><!--/*date sent--></small></p>
						</div>
					</div>
					<?php }?>
		
				<div class="compose">
					<form name="ooga" method="POST" action="<?= base_url('Contest/nyobawys')?>">
						<textarea name="mail" id="summernote">
						</textarea>
						<div class="text-right mt-md">
							<a href="#" class="btn btn-primary" onclick="document.forms['ooga'].submit();">
								<i class="fa fa-send mr-xs"></i>
								Send
							</a>
						</div>
					</form>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</section>
<!-- end: page -->