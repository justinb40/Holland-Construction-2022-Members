<?php b40_print_notices(); ?>

<div class="row">
    <div class="col-lg-4">
        <form class="b40-forgot-password b40-validate" action="<?php echo wp_lostpassword_url(); ?>" method="post">
            <div class="field-group">
                <label for="user_login" class="light" autocomplete="email">Email:</label>
                <input type="text" name="user_login" id="user_login" required>
            </div>
            <input type="hidden" name="redirect_to" value="<?php //echo b40_get_page_link('login_page'); ?>">
            <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-sm btn-default" value="Get New Password">
        </form>
    </div>
</div>
