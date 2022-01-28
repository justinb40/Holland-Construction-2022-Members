<?php
/**
 * Extends the WP List Table Class to display the registered members in a table.
 *
 * @package    b40_members
 * @subpackage b40_members/admin
 * @author     Back40 Design <info@back40design.com>
 */

class B40_Members_List_Table extends B40_List_Table {

    public function prepare_items() {

        // check if a search was performed.
        $user_search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
    
        // check and process any actions such as bulk actions.
        $this->handle_table_actions();

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();

        if( $user_search_key != '' ) {
            $data = $this->filter_table_data( $data, $user_search_key );
        }

        $perPage = 25;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->items = array_reverse($data);
    }

    // filter the table data based on the search key
    public function filter_table_data( $table_data, $search_key ) {
        $filtered_table_data = array_values( array_filter( $table_data, function( $row ) use( $search_key ) {
            foreach( $row as $row_val ) {
                if( stripos( $row_val, $search_key ) !== false ) {
                    return true;
                }				
            }			
        } ) );

        return $filtered_table_data;

    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns() {
        $columns = array(
            'cb'		  => '<input type="checkbox" />',	 
            'name'        => 'Name',
            'email'       => 'Email',
            'registered'  => 'Date',
        );

        return $columns;
    }

     /**
     * Get value for checkbox column.
     *
     * @param object $item  A row's data.
     * @return string Text to be placed inside the column <td>.
     */
    protected function column_cb( $item ) {
        return sprintf(		
            '<label class="screen-reader-text" for="user_' . $item['id'] . '">' . sprintf( __( 'Select %s' ), $item['email'] ) . '</label>'
            . "<input type='checkbox' name='users[]' id='user_{$item['id']}' value='{$item['id']}' />"
        );
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns() {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns() {
        return array(
            'name' => array('last_name', true),
        );
    }

    /*
    * Method for rendering the name column.
    * Adds row action links to the name column.
    * e.g. url/users.php?page=nds-wp-list-table-demo&action=view_usermeta&user=18&_wpnonce=1984253e5e
    */
    protected function column_name($item) {		
        $admin_page_url =  admin_url( 'admin.php?page=b40-members' );

        // Edit User Row Action
        $query_args_approve_user = array(
            'page'		=>  wp_unslash( $_REQUEST['page'] ),
            'member_id'	=> absint( $item['id']),
        );

        $edit_link = esc_url( add_query_arg( $query_args_approve_user, $admin_page_url ) );		
        $actions['edit_user'] = '<a href="' . $edit_link . '">' . __( 'Edit', 'b40-members' ) . '</a>';

        $row_value = '<strong>' . $item['name'] . '</strong>';

        // Delete User Row Action
        $query_args_approve_user = array(
            'page'		=>  wp_unslash( $_REQUEST['page'] ),
            'action'	=> 'delete',
            'user_id'	=> absint( $item['id']),
            '_wpnonce'	=> wp_create_nonce( 'delete_user_nonce' ),
        );

        $delete_link = esc_url( add_query_arg( $query_args_approve_user, $admin_page_url ) );		
        $actions['delete_user'] = '<a href="' . $delete_link . '" style="color: #a00;">' . __( 'Delete', 'b40-members' ) . '</a>';

        return $row_value . $this->row_actions( $actions );

    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data() {
        
        $data = array();

        $orderby = 'last_name';
        $order = 'asc';

        $args = array(
            'role' => 'Member',
            'order'     => $order,
            'meta_key' => $orderby,
            'orderby'   => $orderby,
        );

        $users = get_users($args);

        foreach ($users as $user) {

            $user_data = get_userdata( $user->ID );
            $registered = $user_data->user_registered;
            $email = $user_data->user_email;

            $first_name = get_user_meta($user->ID, 'first_name', true);
            $last_name = get_user_meta($user->ID, 'last_name', true);
            $name = $first_name . ' ' . $last_name;

            $data[] = array(
                'name'  => '<a href="/wp-admin/admin.php?page=b40-members&member_id=' . $user->ID . '">' . $name . '</a>',
                'email' => $email,
                'registered'  => date( 'm/d/Y', strtotime($registered)),
                'id'  => $user->ID
            );
        }
        
        return $data;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'name':
            case 'email':
            case 'registered':
                return $item[$column_name];
            default:
                return print_r( $item, true ) ;
        }
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b ) {

        // Set defaults
        $orderby = 'name';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby'])) {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order'])) {
            $order = $_GET['order'];
        }

        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc') {
            return $result;
        }

        return -$result;
    }

    public function no_items() {
        _e( 'No members avaliable.', 'b40-members' );
    }

    function get_bulk_actions() {

        $actions = array();

        $actions['edit'] = '<a href="#">'.__( 'Edit' ).'</a>';
        $actions['delete'] = '<a href="#">'.__( 'Delete' ).'</a>';

        return $actions;

    }

}
  