<?php
if (class_exists('GF_Field')) {
	class GF_UTM_Fields extends GF_Field {

        public $type = 'utm_parameters';
    
        public function get_form_editor_field_title() {
            return esc_attr__( 'UTM Parameters', 'gravityforms' );
        }

        public function get_form_editor_field_description() {
            return esc_attr__( 'Places hidden fields to capture UTM parameters.', 'gravityforms' );
        }
    
        public function get_form_editor_button() {
            return array(
                'group' => 'advanced_fields',
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
            
            
            $utm_source_markup = '<input class="utm_source" type="hidden" name="input_' . $field_id . '.1" id="input_' . $field_id . '_' . $form_id . '_1">';
            $utm_medium_markup = '<input class="utm_medium" type="hidden" name="input_' . $field_id . '.2" id="input_' . $field_id . '_' . $form_id . '_2">';
            $utm_campaign_markup = '<input class="utm_campaign" type="hidden" name="input_' . $field_id . '.3" id="input_' . $field_id . '_' . $form_id . '_3">';
            $utm_content_markup = '<input class="utm_content" type="hidden" name="input_' . $field_id . '.4" id="input_' . $field_id . '_' . $form_id . '_4">';
            $utm_term_markup = '<input class="utm_term" type="hidden" name="input_' . $field_id . '.5" id="input_' . $field_id . '_' . $form_id . '_4">';
            
    

            
            if($is_form_editor){
                return '<div class="gf-html-container"><span class="gf_blockheader">
                <i class="fa fa-eye-slash fa-lg"></i> UTM Parameters</span><span>This is a content placeholder. UTM Parameters content is not displayed in the form admin. Preview this form and check page source to see these parameters</span></div>';
            }else{
                return "{$utm_source_markup}
                        {$utm_medium_markup}
                        {$utm_campaign_markup}
                        {$utm_content_markup}
                        {$utm_term_markup}";
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
            field.inputs = [new Input(field.id + '.1', '%s'), new Input(field.id + '.2', '%s'), new Input(field.id + '.3', '%s'), new Input(field.id + '.4', '%s'), new Input(field.id + '.5', '%s')];
            }", $this->type, $this->get_form_editor_field_title(), 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term' ) . PHP_EOL;
    
            return $script;
        }
    
        public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
            if ( is_array( $value ) ) {
                $utm_source = trim( rgget( $this->id . '.1', $value ) );
                $utm_medium  = trim( rgget( $this->id . '.2', $value ) );
                $utm_campaign = trim( rgget( $this->id . '.3', $value ) );
                $utm_content = trim( rgget( $this->id . '.4', $value ) );
                $utm_term = trim( rgget( $this->id . '.5', $value ) );
    
                $return = "<b>Source:</b> " . $utm_source;
                $return .= ! empty( $return ) && ! empty( $utm_medium ) ? " <b>Medium:</b> $utm_medium" : $utm_medium;
                $return .= ! empty( $return ) && ! empty( $utm_campaign ) ? " <b>Campaign:</b> $utm_campaign" : $utm_campaign;
                $return .= ! empty( $return ) && ! empty( $utm_content ) ? " <b>Content:</b> $utm_content" : $utm_content;
                $return .= ! empty( $return ) && ! empty( $utm_term ) ? " <b>Term:</b> $utm_term" : $utm_term;
    
            } else {
                $return = 'No UTM values submitted!';
            }
    
            if ( $format === 'html' ) {
                $return = $return;
            }
    
            return $return;
        }
    
    }
    
    GF_Fields::register( new GF_UTM_Fields() );
}