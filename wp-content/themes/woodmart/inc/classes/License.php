<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
 * Activate theme and enable auto updates
 *
 */

update_option( 'woodmart_token', true );
update_option( 'woodmart_is_activated', true );
class WOODMART_License {

    private $_api = null;
    private $_notices = null;
    private $_current_version = '';
    private $_new_version = '';
    private $_theme_name = '';
    private $_info;
    private $_token;


    function __construct() {
        $this->_current_version = woodmart_get_theme_info( 'Version' );
        $this->_theme_name = WOODMART_SLUG;
        $this->_token = get_option( 'woodmart_token' );

        $this->_api = WOODMART_Registry()->api;
        $this->_notices = WOODMART_Registry()->notices;

        $this->process_form();

        if( ! woodmart_is_license_activated() ) return;

//        add_filter( 'site_transient_update_themes', array( $this, 'update_transient' ), 20, 2 );
//        add_filter( 'pre_set_site_transient_update_themes', array( $this, 'set_update_transient' ) );
        add_filter( 'themes_api', array(&$this, 'api_results'), 10, 3);

    }

    public function form() {
        $this->_notices->show_msgs();
        ?>

        <h3><?php esc_html_e( 'Theme license activation form', 'woodmart' ); ?></h3>

        <?php if ( woodmart_is_license_activated() ): ?>
            

        <?php else: ?>
            

        <?php endif;
    }

    public function process_form() {
        if( isset( $_POST['purchase-code-deactivate'] ) ) {
  
        }


    }
    
    public function domain() {
    }

    public function activate( $purchase, $token ) {

    }

    public function deactivate() {

    }


    public function update_transient($value, $transient) {
       return $value;
    }


    public function set_update_transient($transient) {
        return $transient;
    }


    public function api_results($result, $action, $args) {

        if( isset( $args->slug ) && $args->slug == $this->_theme_name && $action == 'theme_information') {
            if( is_object( $this->_info ) && ! empty( $this->_info ) ) {
                $result = $this->_info;
            }
        }

        return $result;
    }






}
