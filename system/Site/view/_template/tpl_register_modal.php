<div style="display:none;" class="modal fade" id="modal_register" tabindex="-1" role="dialog" aria-labelledby="modal_register_label">
  <div class="modal-dialog" role="document">
	<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="modal_register_label">Regisztráció</h4>
		<p>Lorem ipsum dolor sit amet!</p> 
                </div>
		
            		
		<div class="modal-body">
                    
			<div id="message_register"></div>

			<form action="" method="POST" id="register_form" name="register_form">	
				<div class="form-group">
					<label for="user_name" class="control-label">Felhasználó név</label>
					<input type="text" name="user_name" placeholder="minimum hat karakter, ékezetek nélkül" class="form-control input-xlarge" />
				</div>
				<div class="form-group">
					<label for="user_email" class="control-label">E-mail cím</label>
					<input type="text" placeholder="" name="user_email" class="form-control input-xlarge" />
				</div>
				<div class="form-group">
					<label for="password" class="control-label">Jelszó</label>
					<input type="password" id="register_password" name="password" class="form-control input-xlarge"/>
				</div>	
				<div class="form-group">
					<label for="password_again" class="control-label">Jelszó ismétlése</label>
					<input type="password" name="password_again" class="form-control input-xlarge" />
				</div>
	<!-- 
	<div>
		<label>	
			<input type="checkbox" value="1" name="user_newsletter" id="user_newsletter">
			Kérek hírlevelet
		</label>
	</div>
	 -->
				<!-- Ezt majd css-ben kell eltüntetni!! -->
				<!-- <input type="hidden"  name="security_name" />-->
			</form>	
    <!-- <p> Lorem ipsum dolor sit amet!</p>  -->
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="register_submit">Regisztrálok</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Bezár</button>
		</div>
			

	</div>
  </div>
</div>




<!--
<div class="register-block">
	
	<div class="register-form">
		<form action="#">
			<input type="text" class="name" placeholder="Név">
			<input type="email" class="email" placeholder="Email">
			<input type="text" class="name" placeholder="Jelszó">
			<button class="send-btn">Regisztráció</button>
		</form>
	</div>
</div>
-->