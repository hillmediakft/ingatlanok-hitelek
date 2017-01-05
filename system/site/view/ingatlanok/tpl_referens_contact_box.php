<!-- BEGIN WORKER SIDEBAR-->
<section class="worker worker--sidebar ">

    <!-- end of block .worker__header-->
    <div class="worker__list">
        <div class="worker--properties">

            <div class="worker__photo"><span class="item-photo item-photo--static"><img src="<?php echo Config::get('user.upload_path') . $this->referens['user_photo']; ?>" alt="<?php echo $this->referens['user_first_name'] . ' ' . $this->referens['user_last_name']; ?>" class="photo">
                </span></div>
            <div class="worker__intro">
                <h3 class="worker__name fn"><?php echo $this->referens['user_first_name'] . ' ' . $this->referens['user_last_name']; ?></h3>

                <!-- end of block .worker__listings-->
                <div class="worker__intro-row">
                    <div class="worker__intro-col">
                        <div class="worker__contacts">

                            <div class="tel"><span class="type"><i class="fa fa-phone"></i></span><a href="tel:<?php echo $this->referens['user_phone']; ?>" class="uri value"><?php echo $this->referens['user_phone']; ?></a></div>
                            <div class="email"><span class="type"><i class="fa fa-envelope"></i></span><a href="mailto:<?php echo $this->referens['user_email']; ?>" class="uri value"><?php echo $this->referens['user_email']; ?></a></div>

                        </div>
                        <!-- end of block .worker__contacts-->
                    </div>

                </div>
            </div>

            <!-- end of block .worker__item-->
        </div>
        <div class="clearfix"></div>  
        <div class="">
            <div class="form form--properties">
                <form action="send_email/init/agent" method="POST" class="form__wrap" id="contact_agent_form">

                    <div class="form__row form-group">
                        <input type="text" required="" name="name" id="panel_name" placeholder="Az Ön neve" class="form__in form__in--text form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12"> 
                            <div class="form__row form__row--email form-group">
                                <input type="email" placeholder="Az Ön e-mail címe" required="" name="email" id="panel_email"class="form__in form__in--text form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form__row form__row--tel form-group">
                                <input type="text" placeholder="Az Ön telefonszáma" required="" name="phone" id="panel_phone"class="form__in form__in--text form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form__row form-group">
                        <textarea rows="5" required="" name="message" id="panel_message" class="form__in form__in--textarea form-control">Érdekel a <?php echo $this->property_data['id']; ?> referencia számú ingatlan, kérem vegyék fel velem a kapcsolatot!</textarea>
                    </div>

                    <input type="hidden" name="agent_name" id="agent_name" value="<?php echo $this->referens['user_first_name'] . ' ' . $this->referens['user_last_name']; ?>">
                    <input type="hidden" name="agent_email" id="agent_email" value="<?php echo $this->referens['user_email']; ?>">
                    <input type="text" name="mezes_bodon" id="mezes_bodon">

                    <button class="form__submit" type="submit" name="submit_contact_agent" id="submit_contact_agent">Küldés</button>
                </form>
            </div>



            <!-- end of block .worker__item-->
        </div>
        <!-- end of block .worker__list-->
    </div>
</section>

