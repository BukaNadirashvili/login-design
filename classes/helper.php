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
            $description = !empty( $args['description'] ) ? $args['description'] : '';
            $value = $this->get_value($args);

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


        /**
         * Display a text input form element.
         *
         * @param array $args Text input settings.
         */
        public function form_text( $args ) {

            $id = $args['id'];
            $description = !empty( $args['description'] ) ? $args['description'] : '';
            $value = $this->get_value($args);

?>
            <input type="text" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( LOGIN_DESIGN_OPTIONS ); ?>[<?php echo esc_html( $id ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
<?php
            if ( ! empty( $description ) ) {
                echo '<br /><span class="description">' . esc_html( $description ) . '</span>';
            }

        }

        /**
         * Display a textarea form control.
         *
         * @param array $args Control arguments.
        */
        public function form_textarea( $args ) {

            $id = $args['id'];
            $description = !empty( $args['description'] ) ? $args['description'] : '';
            $value = $this->get_value($args);
?>
        <textarea type="text" rows="10" cols="50" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( LOGIN_DESIGN_OPTIONS ); ?>[<?php echo esc_html( $id ); ?>]"><?php echo esc_textarea( $value ); ?></textarea>
<?php
            if ( ! empty( $description ) ) {
                echo '<p class="description">' . esc_html( $description ) . '</p>';
            }

        }

        private function get_value($args) {

            if ( ! empty( $args['value'][ $args['id'] ] ) ) {
                $value = $args['value'][ $args['id'] ];
            } else {
                if ( ! empty( $args['default'] ) ) {
                    $value = $args['default'];
                }
            }

            return $value ?? '';

        }

    }
endif;

Helper::instance();