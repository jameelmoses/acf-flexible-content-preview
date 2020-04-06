<?php namespace FCP;

class Main {
	use Singleton;

	protected function init() {

		// Assets
		add_action( 'acf/input/admin_footer', [ $this, 'register_assets' ], 1 );
		add_action( 'acf/input/admin_footer', [ $this, 'enqueue_assets' ] );

		// Images
		add_action( 'acf/input/admin_footer', [ $this, 'layouts_images_style' ], 20 );

		add_action( 'acf/input/admin_head', [ $this, 'retrieve_flexible_keys' ], 1 );
	}

	/**
	 * Display the flexible layouts images related css for backgrounds
	 */
	public function layouts_images_style() {
		$images = $this->get_layouts_images();
		if ( empty( $images ) ) {
			return;
		}

		$css = "\n<style>";
		$css .= "\n\t /** Flexible Content Preview for Advanced Custom Fields : dynamic images */";
		foreach ( $images as $layout_key => $image_url ) {
			$css .= sprintf( "\n\t .acf-fc-popup ul li a[data-layout=%s] .acf-fc-popup-image { background-image: url(\"%s\"); }", $layout_key, $image_url );
		}
		$css .= "\n</style>\n";

		echo $css;
	}

	/**
	 * Get all ACF flexible content field layout keys
	 *
	 * TODO: Add caching?
	 *
	 * @return array
	 */
	public function retrieve_flexible_keys() {
		$keys   = [];
		$groups = acf_get_field_groups();
		if ( empty( $groups ) ) {
			return $keys;
		}

		foreach ( $groups as $group ) {
			$fields = (array) acf_get_fields( $group );
			if ( empty( $fields ) ) {
				continue;
			}

			foreach ( $fields as $field ) {
				if ( 'flexible_content' === $field['type'] ) {
					// Flexible is recursive structure with sub_fields into layouts
					foreach ( $field['layouts'] as $layout_field ) {
						if ( ! empty( $keys [ $layout_field['key'] ] ) ) {
							continue;
						}
						$keys[ $layout_field['key'] ] = $layout_field['name'];
					}

          // One level of recursion to find child flexible content fields
          $sub_fields = (array) acf_get_fields( $layout_field );
          foreach( $sub_fields as $sub_field ) {
            if( 'flexible_content' === $sub_field['type'] ) {
              foreach( $sub_field['layouts'] as $layout_sub_field ) {
                if ( ! empty( $keys [ $layout_sub_field['key'] ] ) ) {
                  continue;
                }
                $keys[ $layout_sub_field['key'] ] = $layout_sub_field['name'];
              }
            }
          }
				}
			}
		}

		return $keys;
	}

	/**
	 * Get images for all flexible content field keys
	 *
	 * @return mixed
	 */
	public function get_layouts_images() {
		$flexibles = $this->retrieve_flexible_keys();
		if ( empty( $flexibles ) ) {
			return [];
		}

		foreach ( $flexibles as $flexible ) {
			$layouts_images[ $flexible ] = $this->locate_image( $flexible );
		}

		/**
		 * Allow to add/remove/change a flexible layout key
		 *
		 * @params array $layouts_images : Array of flexible content field layout's keys with associated image url
		 *
		 * @return array
		 */
		return apply_filters( 'acf-flexible-content-preview.images', $layouts_images );
	}

	/**
	 * Locate layout in the theme or plugin if needed
	 *
	 * @param string $layout : the layout name, add automatically .jpg at the end of the file
	 *
	 * @return false|string
	 */
	public function locate_image( $layout ) {
		if ( empty( $layout ) ) {
			return false;
		}

		/**
		 * Allow to add/remove/change the path to images
		 *
		 * @params array $path : Path to check
		 *
		 * @return array
		 */
		$path = apply_filters( 'acf-flexible-content-preview.images_path', 'lib/admin/images/acf-flexible-content-preview' );

		// Rework the tpl
		$layout = str_replace( '_', '-', $layout );

		$image_path = get_stylesheet_directory() . '/' . $path . '/' . $layout . '.jpg';
		$image_uri = get_stylesheet_directory_uri() . '/' . $path . '/' . $layout . '.jpg';

		// Direct path to custom folder
		if ( is_file( $image_path ) ) {
			return $image_uri;
		}

		return FCP_URL . 'assets/images/default.jpg';
	}

	/**
	 * Register assets
	 */
	public function register_assets() {
		wp_register_script( 'acf-flexible-content-preview', FCP_URL . 'assets/js/acf-flexible-content-preview.js', [ 'jquery' ], FCP_VERSION );
		wp_register_style( 'acf-flexible-content-preview', FCP_URL . 'assets/css/acf-flexible-content-preview.css', [], FCP_VERSION );
	}

	/**
	 * Enqueue assets
	 */
	public function enqueue_assets() {
		wp_enqueue_script( 'acf-flexible-content-preview' );
		wp_enqueue_style( 'acf-flexible-content-preview' );
	}
}
