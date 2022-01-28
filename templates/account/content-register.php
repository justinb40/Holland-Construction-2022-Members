<?php b40_print_notices(); ?>

<div class="row">

    <div class="col-lg-6">

        <form method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" enctype="multipart/form-data" id="b40_register" class="b40-validate">

            <fieldset>

                <div class="row">
                     <div class="col-lg-6">
                        <div class="field-group">
                            <label for="first_name" class="light">First Name <span class="req">*</span></label>
                            <input type="text" placeholder="First" name="first_name" id="first_name" required>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="field-group">
                            <label for="last_name" class="light">Last Name <span class="req">*</span></label>
                            <input type="text" placeholder="Last" name="last_name" id="last_name" required>
                        </div>
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-group">
                        <label for="email" class="light">Email <span class="req">*</span></label>
                        <input type="text" placeholder="Email" name="email" id="email" required>
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-group">
                        <label for="password" class="light">Password <span class="req">*</span></label>
                        <input type="password" placeholder="Password" name="password" id="password" required>
                    </div>
                </div>

                <?php wp_nonce_field('b40_register_member', 'b40_register_member_nonce'); ?>

                <input name="action" type="hidden" value="b40_register_member">
                
                <button class="btn btn-default">Register</button>

            </fieldset>

        </form>

    </div>

</div>