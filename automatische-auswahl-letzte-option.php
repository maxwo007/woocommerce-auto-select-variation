<?php
/**
 * Plugin Name: Woocommerce Automatic selection of the last remaining option for each attribute
 * Plugin URI: https://b4pixel.com/
 * Description: This plugin automatically selects the last remaining option for each attribute in WooCommerce product variations.
 * Version: 1.0
 * Author: Maximilian Wolter
 * Author URI: https://b4pixel.com/
 * License: GPLv2 or later
 */

if (!defined('ABSPATH')) {
    exit; // Verhindert den direkten Zugriff auf die Datei.
}

add_action('wp_footer', 'automatische_auswahl_der_letzten_option_fuer_jedes_attribut');

function automatische_auswahl_der_letzten_option_fuer_jedes_attribut() {
    if (is_product()) {
        ?>
        <script type="text/javascript">
            (function($) {
                $(document).ready(function() {
                    $('body').on('woocommerce_update_variation_values', function() {
                        $('.variations_form select').each(function() {
                            var $select = $(this);
                            var $options = $select.find('option:enabled[value!=""]');

                            if ($options.length === 1 && $select.val() === '') {
                                $select.val($options.val());
                                setTimeout(function() {
                                    $select.trigger('change');
                                    $('.variations_form').trigger('woocommerce_variation_select_change');
                                    $('.variations_form').trigger('check_variations');
                                    $('.variations_form').data('blockUI.isBlocked', 0); // Entfernt BlockUI, wenn es aktiviert ist
                                }, 100); // 100 Millisekunden Verzögerung
                            }
                        });
                    });
                });
            })(jQuery);
        </script>
        <?php
    }
}
