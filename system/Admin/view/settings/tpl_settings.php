<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="admin/home">Kezdőoldal</a> 
                <i class="fa fa-angle-right"></i>
            </li>
            <li><span>Beállítások</span></li>
        </ul>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- END PAGE HEADER-->

    <div class="margin-bottom-20"></div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <!-- echo out the system feedback (error and success messages) -->
            <?php $this->renderFeedbackMessages(); ?>

            <form action='' name='settings_form' id='form' method='POST'>
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-cogs"></i>Beállítások szerkesztése</div>
                        <div class="actions">
                            <button class='btn green btn-sm' type='submit' name='submit_settings'><i class="fa fa-check"></i> Mentés</button>
                        </div>							
                    </div>
                    <div class="portlet-body">
                        <div class="form-group">
                            <label for="ceg">Cég/üzlet/iroda elnevezése</label>	
                            <input type='text' name='ceg' class='form-control input-xlarge' value="<?php echo (empty($settings['ceg'])) ? "" : $settings['ceg']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="cim">Cím</label>	
                            <input type='text' name='cim' class='form-control input-xlarge' value="<?php echo (empty($settings['cim'])) ? "" : $settings['cim']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="tel">Telefonszám 1</label>	
                            <input type='text' name='mobil' class='form-control input-xlarge' value="<?php echo (empty($settings['mobil'])) ? "" : $settings['mobil']; ?>"/>
                        </div>                        
                        <div class="form-group">
                            <label for="tel">Telefonszám 2</label>	
                            <input type='text' name='tel' class='form-control input-xlarge' value="<?php echo (empty($settings['tel'])) ? "" : $settings['tel']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail (lábléc e-mail űrlap)</label>	
                            <input type='text' name='email' class='form-control input-xlarge' value="<?php echo (empty($settings['email'])) ? "" : $settings['email']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="facebook">Facebook fiók url-je</label>	
                            <input type='text' name='facebook' class='form-control input-xlarge' value="<?php echo (empty($settings['facebook'])) ? "" : $settings['facebook']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="googleplus">Google plus fiók url-je</label>	
                            <input type='text' name='googleplus' class='form-control input-xlarge' value="<?php echo (empty($settings['googleplus'])) ? "" : $settings['googleplus']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="twitter">Twitter fiók url-je</label>	
                            <input type='text' name='twitter' class='form-control input-xlarge' value="<?php echo (empty($settings['twitter'])) ? "" : $settings['twitter']; ?>"/>
                        </div>   
                        <div class="form-group">
                            <label for="linkedin">Linkedin fiók url-je</label>	
                            <input type='text' name='linkedin' class='form-control input-xlarge' value="<?php echo (empty($settings['linkedin'])) ? "" : $settings['linkedin']; ?>"/>
                        </div> 
                        <div class="form-group">
                            <label for="pagination">Megjelenített elemek száma oldalanként</label>  
                            <select name="pagination" class="form-control input-xlarge">
                                <?php for ($i = 6; $i < 22 ; $i += 3) {
                                    echo '<option value="' . $i . '"';
                                    echo ($settings['pagination'] == $i) ? 'selected' : '';
                                    echo '>' . $i . '</option>' . "\r\n";
                                } ?>
                            </select>
                        </div>
                    </div> <!-- END USER GROUPS PORTLET BODY-->
                </div> <!-- END USER GROUPS PORTLET-->

                <!-- SMTP beállítások portlet -->
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-envelope-o"></i>SMTP beállítások</div>
                    </div>
                    <div class="portlet-body">
                        <div class="form-group">
                            <label for="smtp_host">SMTP host</label>  
                            <input type='text' name='smtp_host' class='form-control input-xlarge' value="<?php echo (empty($settings['smtp_host'])) ? "" : $settings['smtp_host']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="smtp_username">SMTP felhasználónév</label>  
                            <input type='text' name='smtp_username' class='form-control input-xlarge' value="<?php echo (empty($settings['smtp_username'])) ? "" : $settings['smtp_username']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="smtp_password">SMTP jelszó</label>  
                            <input type='password' name='smtp_password' class='form-control input-xlarge' value="<?php echo (empty($settings['smtp_password'])) ? "" : $settings['smtp_password']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="smtp_port">SMTP port</label>  
                            <input type='text' name='smtp_port' class='form-control input-xlarge' value="<?php echo (empty($settings['smtp_port'])) ? "" : $settings['smtp_port']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="smtp_encryption">SMTP titkosítás</label>  
                            <select name="smtp_encryption" class="form-control input-xlarge">
                                <option value="" <?php echo ($settings['smtp_encryption'] == '') ? 'selected' : ''; ?>>Nincs titkosítás</option>
                                <option value="ssl" <?php echo ($settings['smtp_encryption'] == 'ssl') ? 'selected' : ''; ?>>SSL titkosítás használata</option>
                                <option value="tls" <?php echo ($settings['smtp_encryption'] == 'tls') ? 'selected' : ''; ?>>TLS titkosítás használata</option>
                            </select>
                        </div>
                    </div> <!-- END SMTP PORTLET BODY-->
                </div> <!-- SMTP PORTLET-->

            </form>
        </div> <!-- END COL-MD-12 -->
    </div> <!-- END ROW -->	
</div> <!-- END PAGE CONTENT-->