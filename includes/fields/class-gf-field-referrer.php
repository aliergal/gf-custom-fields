<?php
if (class_exists('GF_Field')) {
	class GF_Referrer_Field extends GF_Field {

        public $type = 'referrer';
        
        /**
         * Return the field title.
         * 
         * @access public
         * @return string
         */
        public function get_form_editor_field_title() {
            return esc_attr__( 'Referrer', 'gravityforms' );
        }


        /**
         * Returns the field's form editor description.
         *
         * @since 4.5
         *
         * @return string
         */
        public function get_form_editor_field_description() {
            return esc_attr__( 'Places hidden fields to capture the referrer.', 'gravityforms' );
        }


         /**
         * Adds the field button to the specified group.
         *
         * @param array $field_groups The field groups containing the individual field buttons.
         *
         * @return array
         */
        public function add_button( $field_groups ) {
            $field_groups = $this->tracking_field_group( $field_groups );
        
            return parent::add_button( $field_groups );
        }


        /**
         * Adds the custom field group if it doesn't already exist.
         *
         * @param array $field_groups The field groups containing the individual field buttons.
         *
         * @return array
         */
        public function tracking_field_group( $field_groups ) {
            foreach ( $field_groups as $field_group ) {
                if ( $field_group['name'] == 'tracking_field_group' ) {
        
                    return $field_groups;
                }
            }
        
            $field_groups[] = array(
                'name'   => 'tracking_field_group',
                'label'  => __( 'Tracking Fields', 'simplefieldaddon' ),
                'fields' => array()
            );
        
            return $field_groups;
        }

        /**
         * Return the button for the form editor.
         *
         * @sicne unknown
         * @since 4.5 Added icon and description to button array.
         *
         * @access public
         * @return array
         */
        public function get_form_editor_button() {
            return array(
                'group' => 'tracking_field_group',
                'text'  => $this->get_form_editor_field_title(),
            );
        }
        

        public function get_form_editor_field_settings() {
            return [
                'label_setting',
            ];
        }
    
        public function get_field_input( $form, $value = '', $entry = null ) {
            $is_form_editor  = $this->is_form_editor();
    
            $form_id  = $form['id'];
            $field_id = intval( $this->id );
            
            
            $referrer_markup = '<input class="gf_referrer" type="hidden" name="input_' . $field_id . '" id="input_' . $form_id . '_' . $field_id . '">';
            
    

            
            if($is_form_editor){
                return '<div class="gf-html-container"><span class="gf_blockheader">
                <i class="fa fa-eye-slash fa-lg"></i> Referrer</span><span>This is a content placeholder. Referrer content is not displayed in the form admin. Preview this form and check page source to see the referrer field</span></div>';
            }else{
                return $referrer_markup;
            }
            
        }

        public function get_field_content( $value, $force_frontend_label, $form ) {
            $form_id             = $form['id'];
            $admin_buttons       = $this->get_admin_buttons();
            $is_entry_detail     = $this->is_entry_detail();
            $is_form_editor      = $this->is_form_editor();
            $is_admin            = $is_entry_detail || $is_form_editor;
            $field_label         = $this->get_field_label( $force_frontend_label, $value );
            $field_id            = $is_admin || $form_id == 0 ? "input_{$this->id}" : 'input_' . $form_id . "_{$this->id}";
            $admin_hidden_markup = ( $this->visibility == 'hidden' ) ? $this->get_hidden_admin_markup() : '';
            $field_content       = ! $is_admin ? '{FIELD}' : $field_content = sprintf( "%s%s<label class='gfield_label' for='%s'>%s</label>{FIELD}", $admin_buttons, $admin_hidden_markup, $field_id, esc_html( $field_label ) );
    
            return $field_content;
        }
    
        public function get_form_editor_inline_script_on_page_render() {
    
            // set the default field label for the field
            $script = sprintf( "function SetDefaultValues_%s(field) {
            field.inputs = [new Input(field.id, '%s')];
            }", $this->type, $this->get_form_editor_field_title(), 'referrer' ) . PHP_EOL;
    
            return $script;
        }
    
        public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
            if ( is_array( $value ) ) {
                $referrer = trim( rgget( $this->id, $value ) );
    
                $return = $referrer;
    
            } else {
                $return = 'No referrer value submitted!';
            }
    
            if ( $format === 'html' ) {
                $return = $return;
            }
    
            return $return;
        }
    
    }
    
    GF_Fields::register( new GF_Referrer_Field() );
}