<?php

if(!class_exists('Helper')) :


	/**
	 * Additional helper class for plugin
	*/
    class Helper {

        private static $instance;

        static function instance(){

            if(!isset( self::$instance ) && !( self::$instance instanceof Helper )) {
                self::$instance = new Helper();
            }
        }

		
		/**
		 * Callback function which adds url field
		*/
        public function form_url( $args ) {

			$id = $args['id'];
			$value = '';
			$description = '';

			if ( ! empty( $args['value'][ $args['id'] ] ) ) {
				$value = $args['value'][ $args['id'] ];
			} else {
				if ( ! empty( $args['default'] ) ) {
					$value = $args['default'];
				}
			}

			if ( ! empty( $args['description'] ) ) {
				$description = $args['description'];
			}

            ?>
			<input type="text" size="36" name="<?php echo esc_attr( LOGIN_DESIGN_OPTIONS ); ?>[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_url( $value ); ?>" />
            <?php
			if ( ! empty( $description ) ) {
				echo '<br /><span class="description">' . esc_html( $description ) . '</span>';
			}
		}

    }
endif;

Helper::instance();