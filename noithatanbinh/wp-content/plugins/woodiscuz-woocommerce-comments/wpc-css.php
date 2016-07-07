<?php

class WPC_CSS {

    private $primary_color;
    private $highlight_color;
    private $wpc_options;

    function __construct($wpc_options_serialized) {
        $this->init_colors();
        $this->wpc_options_serialized = $wpc_options_serialized;
    }

    /**
     * init woo discuss styles
     */
    public function init_styles() {
        ?>
        <style type="text/css">
            #woopcomm .wpc-form-wrapper{ background:<?php echo isset($this->wpc_options_serialized->wpc_form_bg_color) ? $this->wpc_options_serialized->wpc_form_bg_color : '#f9f9f9'; ?>; }#woopcomm .wpc-comment .wpc-comment-right{ background:<?php echo $this->wpc_options_serialized->wpc_comment_bg_color; ?>; }#woopcomm .wpc-reply .wpc-comment-right{ background:<?php echo $this->wpc_options_serialized->wpc_reply_bg_color; ?>; }#woopcomm .wpc-comment-text{ font-size:<?php echo isset($this->wpc_options_serialized->wpc_comment_text_size) ? $this->wpc_options_serialized->wpc_comment_text_size : '14px'; ?>; color:<?php echo $this->wpc_options_serialized->wpc_comment_text_color; ?>; }#woopcomm .wpc-comment-author{ color:<?php echo $this->primary_color; ?>; }#woopcomm .wpc-comment-author a{ color:<?php echo $this->primary_color; ?>; }#woopcomm .wpc-comment-label{ background:<?php echo $this->primary_color; ?>; }#woopcomm .wpc-comment-footer a{ color:<?php echo $this->highlight_color; ?>; }#woopcomm .wpc-comment-footer .wpc-vote-result{ background:<?php echo $this->highlight_color; ?>; }#woopcomm .wpc-reply-link, #woopcomm .wpc-vote-link, #woopcomm .wpc-share-link,#woopcomm span.wpc_cancel_edit,#woopcomm span.wpc_save_edited_comment,#woopcomm span.wpc_editable_comment { color: <?php echo $this->highlight_color; ?>; }#wpc_openModalFormAction > div#wpc_response_info a.close { background: url("<?php echo plugins_url(WPC_Core::$PLUGIN_DIRECTORY . '/files/img/x.png'); ?>") no-repeat; }
        </style>
        <?php
    }

    /**
     * init woocomerce colors
     */
    public function init_colors() {
        $colors = get_option('woocommerce_frontend_css_colors');
        $this->primary_color = ( $colors['primary'] ) ? $colors['primary'] : '#ad74a2';
        $this->highlight_color = ( $colors['highlight'] ) ? $colors['highlight'] : '#85ad74';
    }

}
?>
