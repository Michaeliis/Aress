</section>
            </div>
        </section>

		<!-- Vendor -->
		<script src="<?=base_url("assets/")?>vendor/jquery/jquery.js"></script>
		<script src="<?=base_url("assets/")?>vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?=base_url("assets/")?>vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?=base_url("assets/")?>vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?=base_url("assets/")?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?=base_url("assets/")?>vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?=base_url("assets/")?>vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
        <script src="<?=base_url("assets/")?>vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="<?=base_url("assets/")?>vendor/summernote/summernote.js"></script>
		<script>
		$(document).ready(function() {
			$('.summernote').summernote({
				toolbar: [
					// [groupName, [list of button]]
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']]
				]
			});
		});
		</script>

        <script src="<?=base_url("assets/")?>vendor/select2/select2.js"></script>
		<script src="<?=base_url("assets/")?>vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="<?=base_url("assets/")?>vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="<?=base_url("assets/")?>vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		<script src="<?=base_url("assets/")?>vendor/pnotify/pnotify.custom.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?=base_url("assets/")?>javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?=base_url("assets/")?>javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?=base_url("assets/")?>javascripts/theme.init.js"></script>

        <!-- Examples -->
		<script src="<?=base_url("assets/")?>javascripts/tables/examples.datatables.default.js"></script>
		<script src="<?=base_url("assets/")?>javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="<?=base_url("assets/")?>javascripts/tables/examples.datatables.tabletools.js"></script>
	</body>
</html>