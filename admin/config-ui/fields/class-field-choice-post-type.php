<?php
/**
 * @package WPSEO\Admin\ConfigurationUI
 */

/**
 * Class WPSEO_Config_Field_Choice_Post_Type
 */
class WPSEO_Config_Field_Choice_Post_Type extends WPSEO_Config_Field_Choice {

	/** @var string Post type */
	protected $post_type;

	/**
	 * WPSEO_Config_Field_Choice_Post_Type constructor.
	 *
	 * @param string $post_type The post type to add.
	 * @param string $label     Label to show (translated post type).
	 */
	public function __construct( $post_type, $label ) {
		parent::__construct( 'postType' . ucfirst( $post_type ) );

		$this->post_type = $post_type;

		/* Translators: %1$s expands to the name of the post type. The options given to the user are "visible" and "hidden" */
		$this->set_property( 'label', sprintf( __( 'The post type "%1$s" should be', 'wordpress-seo' ), $label ) );

		$this->add_choice( 'true', __( 'Visible', 'wordpress-seo' ) );
		$this->add_choice( 'false', __( 'Hidden', 'wordpress-seo' ) );
	}

	/**
	 * Set adapter
	 *
	 * @param WPSEO_Configuration_Options_Adapter $adapter Adapter to register lookup on.
	 */
	public function set_adapter( WPSEO_Configuration_Options_Adapter $adapter ) {
		$adapter->add_custom_lookup(
			$this->get_identifier(),
			array( $this, 'get_data' ),
			array( $this, 'set_data' )
		);
	}

	/**
	 * Get the post type of this field.
	 *
	 * @return string Post type.
	 */
	public function get_post_type() {
		return $this->post_type;
	}

	/**
	 * @return bool
	 */
	public function get_data() {
		$option = WPSEO_Options::get_option( 'wpseo_titles' );

		$key = 'noindex-' . $this->get_post_type();

		if ( isset( $option[ $key ] ) && $option[ $key ] === false ) {
			return 'true';
		}

		return 'false';
	}

	/**
	 * Set new data
	 *
	 * @param string $visible Visible (true) or hidden (false).
	 *
	 * @return bool
	 */
	public function set_data( $visible ) {
		$post_type = $this->get_post_type();

		$option = WPSEO_Options::get_option( 'wpseo_titles' );

		$option[ 'noindex-' . $post_type ] = ( $visible === 'false' );

		update_option( 'wpseo_titles', $option );

		// Check if everything got saved properly.
		$saved_option = WPSEO_Options::get_option( 'wpseo_titles' );

		return ( ( $visible === 'false' ) && $saved_option[ 'noindex-' . $post_type ] === true );
	}
}
