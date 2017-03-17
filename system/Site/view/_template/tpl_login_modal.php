<?php 
use System\Libs\Language as Lang;
?>
<div style="display:none;" class="modal fade" id="modal_login" tabindex="-1" role="dialog" aria-labelledby="modal_login_label">
  <div class="modal-dialog" role="document">
	<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="modal_login_label"><?php echo Lang::get('login_modal_cim'); ?></h4>
		</div>
		
		<div class="modal-body">
		
			<div id="message_login"></div>
			
			<form action="" method="POST" id="login_form" name="login_form">	
				<div class="form-group">
					<label for="user_name" class="control-label"><?php echo Lang::get('login_modal_nev_vagy_email'); ?></label>
					<input type="text" name="user_name" class="form-control input-xlarge" />
				</div>

				<div class="form-group">
					<label for="user_password" class="control-label"><?php echo Lang::get('login_modal_jelszo'); ?></label>
					<input type="password" name="user_password" class="form-control input-xlarge" />
				</div>	
			</form>	

			<a href="javascript:;" title="Új jelszó kérése" id="new_pw_button"><?php echo Lang::get('login_modal_elfelejtett_jelszo'); ?></a>
			
		</div>
		<div class="modal-footer">
			<!-- <button type="button" class="btn btn-primary" id="login_submit">Bejelentkezés</button> -->
			<button type="button" class="send-btn" id="login_submit"><?php echo Lang::get('login_modal_gomb'); ?></button>
			<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezár</button> -->
		</div>
			
	</div>
  </div>
</div>