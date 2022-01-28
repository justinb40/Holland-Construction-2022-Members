<?php b40_print_notices(); ?>

<div class="row">

    <div class="col-lg-4">

        <form class="b40-validate" method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">

            <div class="field-group">
                <label for="email" class="light">Email</label>
                <input type="text" name="email" id="email" required>
            </div>
 
            <div class="field-group mb-2">
                <label for="username" class="light">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="check-group mb-3">
                <input type="checkbox" name="remember_me" id="remember_me">
                <label for="remember_me" class="check-label">
                    Remember Me
                </label>
            </div>

            <?php //wp_nonce_field('b40_login_member', 'b40_login_member_nonce'); ?>

            <input name="action" type="hidden" value="b40_login_member">
            <input class="btn btn-default btn-sm" type="submit" id="submit" value="Login">

            <div class="b40-forgot-password-link mt-4">
                <a href="<?php //echo b40_get_page_link('forgot_password_page'); ?>">Forgot your password?</a>
            </div>

        </form>

    </div>

</div>