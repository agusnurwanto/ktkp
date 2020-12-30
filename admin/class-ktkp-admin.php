<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Ktkp
 * @subpackage Ktkp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ktkp
 * @subpackage Ktkp/admin
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Ktkp_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ktkp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ktkp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ktkp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ktkp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ktkp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ktkp-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function getScriptOutput($path, $print = FALSE){
	    ob_start();

	    if( is_readable($path) && $path ){
	        include $path;
	    }else{
	        return FALSE;
	    }

	    if( $print == FALSE ){
	        return ob_get_clean();
	    }else{
	        echo ob_get_clean();
	    }
	}

	public function reset_val(){
		$url = plugin_dir_path( __FILE__ ).'partials/sampul-spk.html';
		$sampul_spk = $this->getScriptOutput($url);
		carbon_set_theme_option( 'ktkp_sampul_spk', $sampul_spk );
	}

	// https://docs.carbonfields.net/#/containers/theme-options
	public function crb_attach_ktkp_options(){
		$sampul_spk = $this->getScriptOutput(Carbon_Fields_Plugin\PLUGIN_FILE.'/admin/partials/sampul-spk.html');
		$basic_options_container = Container::make( 'theme_options', __( 'Kontrak Kerja' ) )
			->set_page_menu_position( 5 )
	        ->add_fields( array(
	        	Field::make( 'image', 'ktkp_logo_daerah', __( 'Logo Daerah' ) )
	        		->set_type( array( 'image' ) )
	        		->set_value_type( 'url' ),
	        	Field::make( 'text', 'ktkp_nama_daerah', __( 'Nama Daerah' ) )
	        		->set_default_value('PEMERINTAH KABUPATEN MAGETAN'),
	        	Field::make( 'text', 'ktkp_opd', __( 'Nama OPD' ) )
	        		->set_default_value('DINAS KOMUNIKASI DAN INFORMATIKA'),
	        	Field::make( 'text', 'ktkp_alamat_opd', __( 'Alamat OPD' ) )
	        		->set_default_value('Jalan.  Kartini No. 2 Magetan Kode Pos 63314'),
	        	Field::make( 'text', 'ktkp_tlp_opd', __( 'Nomor Telephone OPD' ) )
	        		->set_default_value('0351 - 8197913'),
	        	Field::make( 'text', 'ktkp_email_opd', __( 'Email OPD' ) )
	        		->set_default_value('kominfo@magetan.go.id'),
	            Field::make( 'rich_text', 'ktkp_sampul_spk', 'Sampul SPK' )
	            	->set_default_value($sampul_spk)
	            	->set_help_text('link GITHUB <a href="https://github.com/agusnurwanto/ktkp" target="_blank">github.com/agusnurwanto/ktkp</a>.')
	        ) );

	    Container::make( 'theme_options', __( 'Proses PL' ) )
		    ->set_page_parent( $basic_options_container );

	    Container::make( 'theme_options', __( 'SPK' ) )
		    ->set_page_parent( $basic_options_container );

	    Container::make( 'theme_options', __( 'Pengadaan Langsung' ) )
		    ->set_page_parent( $basic_options_container );
		
		// $this->reset_val();
	}

}
