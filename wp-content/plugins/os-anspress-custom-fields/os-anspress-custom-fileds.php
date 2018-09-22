<?php
/**
 * Plugin Name: OS AnsPress Custom Fields
 * Plugin URI: http://offshorent.com/blog/extensions/os-anspress-custom-fields
 * Description: To create custom fields for AnsPress answer.
 * Version: 1.1
 * Author: Jinesh P.V, Team Leader Offshorent Solutions Pvt Ltd
 * Author URI: http://offshorent.com/
 * Requires at least: 4.0
 * Tested up to: 4.6.1
**/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! version_compare( AP_VERSION, '2.3', '>' ) ) {
	function ap_category_admin_error_notice() {
	    echo '<div class="update-nag error"> <p>'.sprintf( __( 'OS AnsPress Custom Fields require AnsPress 2.4-RC or above. Download from Github %shttp://github.com/anspress/anspress%s', 'tags-for-anspress' ), '<a target="_blank" href="http://github.com/anspress/anspress">', '</a>' ).'</p></div>';
	}
	add_action( 'admin_notices', 'osap_custom_fields_admin_error_notice' );
	return;
}


/**
 * OS AnsPress Custom Fields for AnsPress
 */

class OSAnsPressCustomFields {

	/**
	 * Class instance
	 * @var object
	 * @since 1.1
	 */
	private static $instance;


	/**
	 * Get active object instance
	 *
	 * @since 1.1
	 *
	 * @access public
	 * @static
	 * @return object
	 */
	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new OSAnsPressCustomFields(); }

		return self::$instance;
	}
	/**
	 * Initialize the class
	 * @since 2.0
	 */
	public function __construct() {

		if ( ! class_exists( 'AnsPress' ) ) {
			return; // AnsPress not installed.
		}

		self::osmp_admin_styles_scrips();

		define( 'OSAP_PLUGIN_FILE', __FILE__ );
		define( 'OSAP_PLUGIN_BASENAME', plugin_basename( dirname( __FILE__ ) ) );
		define( 'OSAP_PLUGIN_URL', plugins_url() . '/' . OSAP_PLUGIN_BASENAME );
		define( 'OSAP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
		define( 'OSAP_TEXT_DOMAIN', 'osap-custom-fields' );

		add_action( 'admin_init', array( $this, 'osap_admin_init' ) );
		add_action( 'ap_admin_menu', array( $this, 'osap_admin_custom_fields_menu' ) );
		add_action( 'add_meta_boxes_answer', array( &$this, 'osap_answer_meta_box' ), 10, 1 );
		add_action( 'ap_answer_form_fields', array( $this, 'osap_ap_answer_form_fields' ), 10, 2 );
		add_action( 'ap_processed_new_answer', array( $this, 'osap_after_new_question' ), 1, 2 );
		add_action( 'ap_processed_update_answer', array( $this, 'osap_after_new_question' ), 1, 2 );

		add_filter( 'ap_answer_fields_validation', array( $this, 'osap_answer_fields_validation' ) ) ;
	}

	/**
	* Admin init osap when WordPress Initialises.
	* @return void
	 * @since 2.0
	*/
	 
	public function osap_admin_init() {

		$dir = get_template_directory() . '/anspress';
		$source_file = OSAP_PLUGIN_PATH . 'includes/answer.php';
		$destination_file = $dir . '/answer.php';

		if ( !file_exists( $dir ) ) {
		    mkdir( $dir, 0777, true );
			copy( $source_file, $destination_file );
		}	

		register_setting(
			'osap-settings', // Option group
			'osap', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);
	}

	/**
	 * Add settings menu in wp-admin
	 * @return void
	 * @since 2.0
	 */
	public function osap_admin_custom_fields_menu() {

		add_submenu_page( 'anspress', 'Custom Fields', 'Custom Fields', 'manage_options', 'osap-custom-fields', array( $this, 'osap_custom_fields' ) );
	}

	/**
	* Admin side style and javascript hook for OSAnsPressCustomFields
	* @return void
	 * @since 2.0
	 */
	 
	public function osmp_admin_styles_scrips() {
		wp_enqueue_script( 'jquery-ui-sortable' );      
		wp_enqueue_style( 'osap-admin-style', plugins_url( 'css/style-min.css', __FILE__ ) );
		wp_enqueue_script( 'osap-custom-min', plugins_url( 'js/custom-min.js', __FILE__ ), array( 'jquery' ), '1.1', true );
	}

	/**
	 * Add se menu in wp-admin
	 * @return void
	 * @since 2.0
	 */
	public function osap_custom_fields () {

		include_once( 'includes/osap.custom-fields.php' );
	}

	/**
	* Sanitize each setting field as needed
	* @since 1.1
	*/
		 
	public function sanitize( $input ) {

		$new_input = array();
		$new_input = $input;
		
		return $new_input;
	}	

	/**
	 * add custom fields in ask form
	 * @param  array $validate
	 * @return void
	 */

	public function osap_ap_answer_form_fields( $args, $editing ){

	    global $editing_post; 

	    $osap = get_option( 'osap' );
	    if( !empty( $osap ) ) {
            foreach( $osap as $valueObj ){
                foreach( $valueObj as $key => $object ) {
			    	$field_name = sanitize_title( $object['label'] );
			    	switch ( $key ) {
                        case "text":
                        case "textarea":
                        case "checkbox":
										    $args['fields'][] = array(
										        'name' => $field_name,
										        'label' => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'type'  => $object['type'],
										        'value' => ( $editing ? update_post_meta( $editing_post->ID, $field_name, true ) : wp_kses_post( @$_POST[$field_name] ) ),
										        'desc' => __( $object['description'], OSAP_TEXT_DOMAIN ),
										        'order' => 6,
										        'placeholder'  => __( $object['label'], OSAP_TEXT_DOMAIN )
										    );
										    break;

						case "number":
											$min = isset( $object['min'] ) ? $object['min'] : "1";
										    $args['fields'][] = array(
										        'name' => $field_name,
										        'label' => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'type'  => 'number',
										        'value' => ( $editing ? update_post_meta( $editing_post->ID, $field_name, true ) : wp_kses_post( @$_POST[$field_name] ) ),
										        'desc' => __( $object['description'], OSAP_TEXT_DOMAIN ),
										        'order' => 6,
										        'placeholder'  => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'attr' => ' min="' . $min .'" max = "' . $object['max'] . '"'
										    );
										    break;	

						case "select":
											$values = explode( "|", $object['values'] );
											foreach ( $values as $key => $value ) {
												$options[$value] = $value;
											}
										    $args['fields'][] = array(
										        'name' => $field_name,
										        'label' => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'type'  => 'select',
										        'value' => ( $editing ? update_post_meta( $editing_post->ID, $field_name, true ) : wp_kses_post( @$_POST[$field_name] ) ),
										        'desc' => __( $object['description'], OSAP_TEXT_DOMAIN ),
										        'order' => 6,
										        'placeholder'  => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'options' => $options
										    );
										    break;

						case "taxonomy":
										    $args['fields'][] = array(
										        'name' => $field_name,
										        'label' => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'type'  => 'taxonomy_select',
										        'value' => ( $editing ? update_post_meta( $editing_post->ID, $field_name, true ) : wp_kses_post( @$_POST[$field_name] ) ),
										        'desc' => __( $object['description'], OSAP_TEXT_DOMAIN ),
										        'order' => 6,
										        'placeholder'  => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'taxonomy' => $object['taxonomy'],
										        'orderby' => $object['orderby'],
										        'hide_empty' => $object['hide_empty'],
										        'hierarchical' => $object['hierarchical'],
										        'echo' => $object['echo']
										    );
										    break;
						case "page":
										    $args['fields'][] = array(
										        'name' => $field_name,
										        'label' => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'type'  => 'page_select',
										        'value' => ( $editing ? update_post_meta( $editing_post->ID, $field_name, true ) : wp_kses_post( @$_POST[$field_name] ) ),
										        'desc' => __( $object['description'], OSAP_TEXT_DOMAIN ),
										        'order' => 6,
										        'placeholder'  => __( $object['label'], OSAP_TEXT_DOMAIN )
										    );
										    break;

                        case "editor":
										    $args['fields'][] = array(
										        'name' => $field_name,
										        'label' => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'type'  => $object['type'],
										        'value' => ( $editing ? update_post_meta( $editing_post->ID, $field_name, true ) : wp_kses_post( @$_POST[$field_name] ) ),
										        'desc' => __( $object['description'], OSAP_TEXT_DOMAIN ),
										        'order' => 6,
										        'placeholder'  => __( $object['label'], OSAP_TEXT_DOMAIN ),
										        'settings'      => apply_filters( 'ap_answer_form_editor_settings', array(
																		'textarea_rows' => 8,
																		'tinymce'   => ap_opt( 'answer_text_editor' ) ? false : true,
																		'quicktags' => ap_opt( 'answer_text_editor' ) ? true : false,
																		'media_buttons' => false,
																	))
										    );
										    break;										    
										    				    				    
						default:
                                            break;					    
					}
				}
			}
		}
		
	    return $args;
	}

	/**
	 * add custom fields in validation field
	 * @param  array $fields
	 * @return array
	 * @since  1.1
	 */

	public function osap_answer_fields_validation( $args ){

		$osap = get_option( 'osap' ); 
	    if( !empty( $osap ) ) {
            foreach( $osap as $valueObj ){
                foreach( $valueObj as $key => $object ) {
			    	if( $object['validation'] == true ) {
				    	$field_name = sanitize_title( $object['label'] );
				    	if( empty( $_POST[$field_name] ) ) {
						    $args[$field_name] = array(
						        'validate' => array( 'required' => true ),
						    );
						}
					}
				}
			}
		}

		return $args;
	}

	/**
	* Things to do after creating or updating question
	* @param  int $post_id
	* @param  object $post
	* @return void
	* @since 1.1
	*/

	public function osap_after_new_question( $post_id, $post ) {

		global $validate;

		if ( empty( $validate ) ) {
			return; 
		}

		$osap = get_option( 'osap' );
		$updated = get_post_meta( $post_id, '_ap_updated', true );
		if( !empty( $osap ) ) {
            foreach( $osap as $valueObj ){
                foreach( $valueObj as $key => $object ) {
			    	$field_name = sanitize_title( $object['label'] );
					if( isset( $_POST[$field_name] ) )
					    $field_name = update_post_meta( $post_id, $field_name, wp_kses_post( $_POST[$field_name] ) );
				}
			}
		}

		if ( $updated == '' ) {
			do_action( 'ap_after_new_answer', $post_id, $post );
		} else {
			do_action( 'ap_after_update_answer', $post_id, $post );
		}
	}

	/**
     * callback function for osap_answer_meta_box.
     */

    public function osap_answer_meta_box() {
        add_meta_box( 	
                        'osap_display_answer_metabox',
                        'Custom Meta',
                        array( &$this, 'osap_display_answer_metabox' ),
                        'answer',
                        'normal', 
                        'high'
                    );
    }

    /**
     * display function for osap_display_answer_metabox.
     */

    public function osap_display_answer_metabox() {

        wp_nonce_field( 'osap-meta', 'osap-meta' );
        include_once( 'includes/meta.php' );
    }
}

/**
 * Get everything running
 * @since 1.1
 * @access private
 * @return void
 */

return new OSAnsPressCustomFields();
?>