<?php 
use System\Libs\Language as Lang;
?>
<div style="display:none;" class="modal fade" id="modal_forgottenpw" tabindex="-1" role="dialog" aria-labelledby="modal_forgottenpw_label">
  <div class="modal-dialog" role="document">
	<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="modal_forgottenpw_label"><?php echo Lang::get('elfelejtett_jelszo_modal_cim'); ?></h4>
		</div>
		
		<div class="modal-body">
		
			<div id="info_forgottenpw">
			    <?php echo Lang::get('elfelejtett_jelszo_modal_leiras'); ?>
			</div>
            <br />            			
			<div id="message_forgottenpw"></div>
			
			<form action="" method="POST" id="forgottenpw_form" name="forgottenpw_form">	
				<div class="form-group">
					<label for="user_email" class="control-label"><?php echo Lang::get('elfelejtett_jelszo_modal_email'); ?></label>
					<input type="text" name="user_email" class="form-control input-xlarge" />
				</div>
			</form>	
			
		</div>
		<div class="modal-footer">
			<button type="button" class="send-btn" id="forgottenpw_submit"><?php echo Lang::get('elfelejtett_jelszo_modal_gomb'); ?></button>
			<!-- <button type="button" class="btn btn-primary" id="forgottenpw_submit">Új jelszó</button> -->
			<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezár</button> -->
		</div>
			
	</div>
  </div>
</div>