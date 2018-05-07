<?php echo $body; ?>


 



<!-- MODAL -->

<?php 
//use System\Libs\Language as Lang;
?>
<div style="display:none;" class="modal fade" id="modal_ingy_elemzes" tabindex="-1" role="dialog" aria-labelledby="modal_ingy_elemzes_label">
  <div class="modal-dialog" role="document">
	<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="modal_ingy_elemzes_label">Kérjük, adjon meg néhány adatot, amely szükséges az INGYENES piaci elemzés elkészítéséhez!</h4>
        </div>
        

        <div id="message"></div>

		<div class="modal-body">

			<form action="<?php echo (LANG != 'hu') ? LANG . '/' : ''; ?>sendemail/init/ingyenes_elemzes" method="POST" id="ingy_elemzes_form" name="ingy_elemzes_form">	
			
				<input type="text" name="mezes_bodon" id="mezes_bodon">

				<!-- Ingatlan típusa -->
				<div class="form-group">
					<label for="ingatlan_kategoria" class="control-label">Ingatlan típusa</label>
					<select name="ingatlan_kategoria" class="form-control input-xlarge">
						<option value="">-- Kérem válasszon! --</option>
						<option value="Lakás">Lakás</option>
						<option value="Ház">Ház</option>
						<option value="Sorház">Sorház</option>
						<option value="Ikerház">Ikerház</option>
						<option value="Nyaraló">Nyaraló</option>
						<option value="Garázs">Garázs</option>
						<option value="Telek">Telek</option>
						<option value="Iroda">Iroda</option>
						<option value="Üzlethelyiség">Üzlethelyiség</option>
					</select>
				</div>

				<!-- Irányítószám -->
				<div class="form-group">
					<label for="iranyitoszam" class="control-label">Irányítószám</label>
					<input type="text" name="iranyitoszam" class="form-control input-xlarge" />
				</div>

				<!-- Alapterület -->
				<div class="form-group">
					<label for="alapterulet" class="control-label">Alapterület</label>
					<input type="text" name="alapterulet" class="form-control input-xlarge" />
				</div>

				<!-- Építés módja -->
				<div class="form-group">
					<label for="ingatlan_szerkezet" class="control-label">Építés módja</label>
					<select name="ingatlan_szerkezet" class="form-control input-xlarge">
						<option value="">-- Kérem válasszon! --</option>
						<option value="Tégla">Tégla</option>
						<option value="Panel">Panel</option>
						<option value="Csúsztatott zsalus">Csúsztatott zsalus</option>
						<option value="Alagútzsalus">Alagútzsalus</option>
						<option value="Könnyűszerkezetes">Könnyűszerkezetes</option>
						<option value="Egyéb">Egyéb</option>
					</select>					
				</div>

				<!-- Ingatlan állapot  -->
				<div class="form-group">
					<label for="ingatlan_allapot" class="control-label">Állapot</label>
					<select name="ingatlan_allapot" class="form-control input-xlarge">
						<option value="">-- Kérem válasszon! --</option>
						<option value="Új">Új</option>
						<option value="Kiváló">Kiváló</option>
						<option value="Jó">Jó</option>
						<option value="Újszerű">Újszerű</option>
						<option value="Felújított">Felújított</option>
						<option value="Felújítandó">Felújítandó</option>
						<option value="Bontandó">Bontandó</option>
					</select>					
				</div>

				<hr style="border-width: 1px;">
				<p style="font-size: 16px;">
					Kinek küldjük az elemzést?
				</p>

				<!-- Kinek küldjük -->
				<div class="form-group">
					<label for="name" class="control-label">Név</label>
					<input type="text" name="name" class="form-control input-xlarge" />
				</div>
				<div class="form-group">
					<label for="email" class="control-label">E-mail</label>
					<input type="text" name="email" class="form-control input-xlarge" />
				</div>
				<div class="form-group">
					<label for="phone" class="control-label">Telefon</label>
					<input type="text" name="phone" class="form-control input-xlarge" />
				</div>

			</form>	
    <!-- <p> Lorem ipsum dolor sit amet!</p>  -->
		</div>
		<div class="modal-footer">
			<button type="button" class="send-btn" id="ingy_elemzes_submit">Elküld</button>
			<button id="close_button" type="button" class="btn btn-secondary" data-dismiss="modal" style="display: none;">Bezár</button>
		</div>

	</div>
  </div>
</div>