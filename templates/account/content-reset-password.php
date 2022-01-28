<?php b40_print_notices(); 

$login = get_query_var('login');
$key = get_query_var('key');

?>

<div class="row">
    <div class="col-lg-4">

        <form class="b40-reset-password b40-validate" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">

            <div class="field-group">
                <label for="pass1">New password</label>
                <input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" required />
            </div>

            <div class="field-group">
                <label for="pass2">Repeat New Password</label>
                <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" required />
            </div>

            <input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $login ); ?>" autocomplete="off" />
            <input type="hidden" name="rp_key" value="<?php echo esc_attr( $key ); ?>" />        
            <input type="submit" class="btn btn-default btn-sm" value="Reset Password" />
        </form>

    </div>
</div>
