<?php if ($pop_up) : ?>
            <!-- Modal -->
            <div style="display:none;" class="modal fade" id="pop-up-window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php echo $pop_up_window_title; ?></h4>
                        </div>
                        <div class="modal-body">
    <?php echo $pop_up_window_content; ?>
                        </div>

                    </div>
                </div>
            </div>
<?php endif ?>