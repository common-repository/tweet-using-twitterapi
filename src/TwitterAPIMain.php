<?php
/**
* Main Class File
*
* @since  1.0
* @package src/TwitterApi_Main-Class-main
* @author  Deepen
*/
class TwitterAPIMain {

	protected $plugin_name;

	protected $plugin_version;

	protected $plugin_slug;

	public function __construct() {
		$this->plugin_name = TF_PLUGIN_NAME;
		$this->plugin_version = TF_PLUGIN_VERSION;
		$this->plugin_slug = TF_PLUGIN_SLUG;
		add_action( 'wp_enqueue_scripts', array( $this, 'tf_enqueues_public_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'tf_enqueues_admin_scripts' ) );
		add_action( 'plugins_loaded', array($this, 'tf_load_textdomain') );
		$this->tf_load_dependencies();
		add_action( 'init', array($this,'tf_configure_keys' ) );
			//Initialize the Widget
		add_action( 'widgets_init', array($this, 'tf_twitter_widget') );
	}

	/**
	* Including Necessary Files
	* @since 1.0
	*
	* @since  1.0
	* @author  Deepen
	*/
	public function tf_load_dependencies() {
		//Main Core Loader for Twitter
		require_once( TF_PATH . 'src/TwitterAPIExchange.php' );
		//Load Helpers
		require_once( TF_PATH . 'includes/helpers/TwitterAPIhelper.php' );
		//Shortcodes
		require_once( TF_PATH . 'includes/shortcodes/TwitterAPItimeline.php' );
		//Widget
		require_once( TF_PATH . 'includes/widgets/TwitterAPIWidget.php' );
		//Pages
		require_once( TF_PATH . 'includes/pages/TwitterAPIPage.php' );
	}

	/**
	* Function for configure the API keys
	*
	* @since 1.0
	* @author Deepen
	* @return N/A
	*/
	public static function tf_configure_keys() {
		$settings = array(
			'oauth_access_token' => get_option( 'tf_oauth_access_token' ),
			'oauth_access_token_secret' => get_option( 'tf_access_secret_token' ),
			'consumer_key' => get_option( 'tf_consumer_key' ),
			'consumer_secret' => get_option( 'tf_consumer_secret_key' )
			);

		return $settings;
	}

	/**
	* Enqueue Scripts and Styles
	*
	* @since  1.0
	* @author  Deepen
	*/
	public function tf_enqueues_public_scripts() {
		wp_enqueue_style( TF_PLUGIN_SLUG . '-tf', TF_URL . 'assets/css/tf-feeds.css' );
		wp_enqueue_style( TF_PLUGIN_SLUG . '-tf-maginific', TF_URL . 'assets/css/magnific-popup.css' );
		
		//Scripts
		wp_enqueue_script( TF_PLUGIN_SLUG . '-nicesroll', TF_URL . 'assets/js/jquery.nicescroll.min.js', array('jquery'), time(), true );
		wp_enqueue_script( TF_PLUGIN_SLUG . '-tfjs', TF_URL . 'assets/js/tf-editor.js', array('jquery'), time(), true );
		wp_enqueue_script( TF_PLUGIN_SLUG . '-tf-maginifcscrpit', TF_URL . 'assets/js/jquery.magnific-popup.min.js', array('jquery'), time(), true );
	}

	/**
	* Load Text Domain
	*
	* @since  1.3
	* @author  Deepen
	*/
	public function tf_load_textdomain() {
		load_plugin_textdomain( 'tfdocs_textdomain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Enqueue Scripts and Styles for Admin
	 * @since 1.0
	 * @author  Deepen
	 */
	public function tf_enqueues_admin_scripts() {
		wp_enqueue_style( TF_PLUGIN_SLUG . '-tf', TF_URL . 'assets/admin/css/tf-feeds.css' );
		wp_enqueue_style( 'wp-color-picker' ); 
		//Scripts
		wp_enqueue_script( TF_PLUGIN_SLUG . '-tf-js', TF_URL . 'assets/admin/js/tf-feeds.js', array('jquery', 'wp-color-picker'), time(), true );
	}

	/**
	 * Register the Twitter Widget
	 * @since 1.0
	 * @author  Deepen
	 */
	public function tf_twitter_widget() {
		register_widget( 'TwitterAPIWidget' );
	}

}


?>
