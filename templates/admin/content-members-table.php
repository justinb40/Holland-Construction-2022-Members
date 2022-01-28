<div class="ocms-emmbers-wrap wrap">    
    <h1 class="wp-heading-inline">Members</h1>
    <a href="/wp-admin/admin.php?page=ocms-members&member_id=new" class="page-title-action">Add New</a>
    
    <?php
    if (isset($_SESSION['ocms_admin_message'])) {
        echo '<div class="ocms-admin-message">' . $_SESSION['ocms_admin_message'] . '</div>';
        unset($_SESSION['ocms_admin_message']);
    }
    ?>

    <div class="ocms-members-table">			
        <div id="ocms-post-body">		
            <form id="ocms-member-list-form" method="get">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <?php 
                $data->search_box( __( 'Search', 'ocms-members' ), 'ocms-member-search');
                $data->display(); ?>				
            </form>
        </div>			
    </div>
</div>