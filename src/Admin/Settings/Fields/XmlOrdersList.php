<?php
/**
 * XmlOrdersList.php
 *
 * @since      1.0.0
 * @package    WcElectronInvoiceFree\Admin\Settings\Fields
 * @author     alfiopiccione <alfio.piccione@gmail.com>
 * @copyright  Copyright (c) 2018, alfiopiccione
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2
 *
 * Copyright (C) 2018 alfiopiccione <alfio.piccione@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

namespace WcElectronInvoiceFree\Admin\Settings\Fields;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use WcElectronInvoiceFree\Admin\XmlOrderListTable;
use WcElectronInvoiceFree\Utils\TimeZone;
use function WcElectronInvoiceFree\Functions\getPostMeta;

/**
 * Class XmlOrdersList
 *
 * @since  1.0.0
 * @author alfiopiccione <alfio.piccione@gmail.com>
 */
final class XmlOrdersList
{
    /**
     * List type
     *
     * @since 1.0.0
     */
    const LIST_TYPE = 'shop_order';

    /**
     * XmlOrdersList constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Init
     *
     * @since 1.0.0
     */
    private function init()
    {
        add_action('wc_el_inv-after_settings_form', array($this, 'template'));
    }

    /**
     * Summary data
     *
     * @return object
     */
    private function summaryData()
    {
        //  Initialized
        $sentCount   = 0;
        $noSentCount = 0;

        if (! empty(XmlOrderListTable::$listIds)) {
            foreach (XmlOrderListTable::$listIds as $postID) {
                $sent = getPostMeta('_invoice_sent', null, $postID);
                switch ($sent) {
                    case 'sent':
                        $sentCount++;
                        break;
                    case 'no_sent':
                        $noSentCount++;
                        break;
                    default:
                        break;
                }
            }
        }

        return (object)array(
            'sent'   => $sentCount,
            'noSent' => $noSentCount,
        );
    }

    /**
     * Filter customer
     *
     * @since 1.0.0
     */
    private function filterSelects()
    {
        // @codingStandardsIgnoreLine
        $customer    = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'customer_id', FILTER_UNSAFE_RAW);
        $type        = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'type', FILTER_UNSAFE_RAW);
        $current     = null;
        $currentType = null;
        if (isset($customer) && '' !== $customer) {
            $current = intval($customer);
        }

        if (isset($type) && '' !== $type) {
            $currentType = $type;
        }

        $selectOptions = array(
            'shop_order'        => esc_html__('Invoice', WC_EL_INV_FREE_TEXTDOMAIN),
            'shop_order_refund' => esc_html__('Refund', WC_EL_INV_FREE_TEXTDOMAIN),
            'receipt'           => esc_html_x('Receipt', 'invoice_choice', WC_EL_INV_FREE_TEXTDOMAIN),
        );

        echo '<label for="filter_type">';
        echo esc_html__('Type:', WC_EL_INV_FREE_TEXTDOMAIN);
        echo '<select id="filter_type" name="filter_type">';
        echo "<option value=''>" . esc_html__('All', WC_EL_INV_FREE_TEXTDOMAIN) . "</option>";
        foreach ($selectOptions as $key => $option) {
            $selected = $currentType === $key ? 'selected="selected"' : '';
            echo "<option {$selected} value={$key}>{$option}</option>";
        }
        echo '</select>';
        echo '</label>';
    }

    /**
     * @return string
     */
    public function buttonBulkAction()
    {
        $output = '<div class="actions-sent-bulk">';
        $output .= sprintf('<h4>%s <strong style="color:red;">%s</strong></h4>',
            esc_html__('Bulk Actions', WC_EL_INV_FREE_TEXTDOMAIN), WC_EL_INV_PREMIUM);
        $output .= sprintf('<button id="mark_as_sent-bulk-undo" name="bulk-sent" value="no_sent" title="%s" class="mark_bulk_trigger disabled mark_undo button button-secondary" type="submit">' .
                           '%s <span class="dashicons dashicons-undo"></span></button>',
            WC_EL_INV_PREMIUM, esc_html__('Mark as Not Sent', WC_EL_INV_FREE_TEXTDOMAIN));
        $output .= sprintf('<button id="mark_as_sent-bulk-sent" name="bulk-sent" value="sent" title="%s" class="mark_bulk_trigger disabled mark_as_sent button button-secondary" type="submit">' .
                           '%s <span class="dashicons dashicons-yes"></span></button>',
            WC_EL_INV_PREMIUM, esc_html__('Mark as Sent', WC_EL_INV_FREE_TEXTDOMAIN));
        $output .= '</div>';

        echo wp_kses_post($output);
    }

    /**
     * Bulk Actions
     *
     * @param array orders data
     *
     * @since 1.1.0
     *
     */
    private function bulkActions($orders)
    {
        // @codingStandardsIgnoreLine
        $customer = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'customer_id', FILTER_UNSAFE_RAW);
        $dateIN   = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'date_in', FILTER_UNSAFE_RAW);
        $dateOUT  = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'date_out', FILTER_UNSAFE_RAW);

        // Js error not set date value
        $dateIN  = 'NaN' !== $dateIN ? $dateIN : time();
        $dateOUT = 'NaN' !== $dateOUT ? $dateOUT : time();
        $output  = '';

        // DatePicker scripts.
        wp_script_is('wc_el_inv_datepicker', 'registered') ? wp_enqueue_script('wc_el_inv_datepicker') : null;
        wp_script_is('datepicker-lang', 'registered') ? wp_enqueue_script('datepicker-lang') : null;

        // Admin page
        $adminUrl = admin_url() . "admin.php?page=wc_el_inv-options-page&tab=xml";

        $output .= ' <div class="bulk-actions">';

        $output .= sprintf('<label class="bulk-actions-label">%s<small>%s</small></label>',
            esc_html__('Filter by date: ',
                WC_EL_INV_FREE_TEXTDOMAIN),
            esc_html__('(Corresponds to orders created between 11:59 PM on the first date and 11:59 PM on the second date)',
                WC_EL_INV_FREE_TEXTDOMAIN)
        );

        $output .= sprintf('<span> %s <input type="text" value="%s" id="date_in" class="wc_el_inv-datepicker"></span>',
            esc_html__('From: ', WC_EL_INV_FREE_TEXTDOMAIN),
            isset($dateIN) && false !== $dateIN ? date('Y-m-d', $dateIN) : ''
        );
        $output .= sprintf('<span> %s <input type="text" value="%s" id="date_out" class="wc_el_inv-datepicker"></span>',
            esc_html__('To: ', WC_EL_INV_FREE_TEXTDOMAIN),
            isset($dateOUT) && false !== $dateOUT ? date('Y-m-d', $dateOUT) : ''
        );

        $output .= '<span class="actions-button">';
        // Filter
        $output .= sprintf(
            '<a class="button button-secondary filter" href="%1$s" title="%2$s">' .
            '<span class="dashicons dashicons-filter"></span> %2$s</a>',
            esc_url($adminUrl),
            esc_html__('Filter', WC_EL_INV_FREE_TEXTDOMAIN)
        );

        if (0 !== $orders && (isset($dateIN) && false !== $dateIN || isset($dateOUT) && false !== $dateOUT)) {
            $output .= sprintf(
                '<a class="button button-secondary disabled get-all" target="_blank" href="#" title="%1$s %2$s">' .
                '<span class="dashicons dashicons-editor-ul"></span></a>',
                esc_html__('Get all Xml', WC_EL_INV_FREE_TEXTDOMAIN),
                WC_EL_INV_PREMIUM
            );

            $output .= sprintf(
                '<a class="button button-primary disabled view-all" target="_blank" href="#" title="%1$s %2$s">' .
                '<span class="dashicons dashicons-visibility"></span></a>',
                esc_html__('View all Xml', WC_EL_INV_FREE_TEXTDOMAIN),
                WC_EL_INV_PREMIUM
            );

            $output .= sprintf(
                '<a class="button button-secondary disabled button-save save-all" target="_blank" href="#" title="%1$s %2$s">' .
                '<span class="dashicons dashicons-media-code"></span></a>',
                esc_html__('Save all Xml', WC_EL_INV_FREE_TEXTDOMAIN),
                WC_EL_INV_PREMIUM
            );

            $output .= sprintf(
                '<a class="button button-secondary button-csv disabled save-all-csv" target="_blank" href="#" title="%1$s %2$s">' .
                '<span class="dashicons dashicons-list-view"></span></a>',
                esc_html__('Save Csv', WC_EL_INV_FREE_TEXTDOMAIN),
                WC_EL_INV_PREMIUM
            );
        }

        $output .= '<span>';

        $output .= '</div>';

        echo $output;
    }

    /**
     * Notice
     *
     * @since 1.0.0
     */
    private function notice()
    {
        // Notice no found or disabled view
        $foundOrder   = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'found_order', FILTER_UNSAFE_RAW);
        $disabledView = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'disabled_view', FILTER_UNSAFE_RAW);

        if (isset($foundOrder) && 'no' === $foundOrder) : ?>
            <div class="notice notice-error is-dismissible">
                <p><span class="dashicons dashicons-no"></span>
                    <?php esc_html_e(
                        'No order found!',
                        WC_EL_INV_FREE_TEXTDOMAIN
                    ); ?>
                </p>
            </div>
        <?php endif;

        if (isset($disabledView) && 'yes' === $disabledView) : ?>
            <div class="notice notice-error is-dismissible">
                <p><span class="dashicons dashicons-no"></span>
                    <?php esc_html_e(
                        'TThe display of all XML is disabled. First filter orders by user and/or dates.',
                        WC_EL_INV_FREE_TEXTDOMAIN
                    ); ?>
                </p>
            </div>
        <?php endif;
    }

    /**
     * Xml list template
     *
     * @since 1.1.0
     */
    public function template()
    {
        $xmlOrdersListTable = new XmlOrderListTable(array());
        $orders             = $xmlOrdersListTable->getOrders(true);

        $dateIN        = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'date_in', FILTER_UNSAFE_RAW);
        $dateOUT       = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'date_out', FILTER_UNSAFE_RAW);
        $orderToSearch = \WcElectronInvoiceFree\Functions\filterInput($_GET, 'order_search', FILTER_SANITIZE_NUMBER_INT);

        // Notice
        $this->notice();
        // List table.
        echo '<div class="wrap">';
        echo '<form id="wp-list-table-invoice-form" method="post">';
        if (! $dateIN && ! $dateOUT) {
            try {
                $timeZone = new TimeZone();
                $timeZone = new \DateTimeZone($timeZone->getTimeZone()->getName());
                $now      = new \DateTime('now');
                $now->setTimezone($timeZone);

                $before = date_i18n('d, M Y', $now->getTimestamp());
                $now->modify(apply_filters('wc_el_inv-orders_days_range', "-14 days"));
                $after = date_i18n('d, M Y', $now->getTimestamp());
                echo sprintf('<h4 class="invoice_range">(*) %s <strong>%s</strong> %s <strong>%s</strong></h4>',
                    esc_html__('You are viewing invoices after', WC_EL_INV_FREE_TEXTDOMAIN),
                    $after,
                    esc_html__('until', WC_EL_INV_FREE_TEXTDOMAIN),
                    $before
                );
            } catch (\Exception $e) {
            }
        }

        echo '<div class="filter-line">';
        echo '<div class="filter-selects">';
        $this->filterSelects();
        echo '</div>';
        echo '<hr>';
        echo '<div class="search">';
        $searchLabel  = esc_html__('Search order number:', WC_EL_INV_FREE_TEXTDOMAIN);
        $searchButton = esc_html__('Search', WC_EL_INV_FREE_TEXTDOMAIN);
        $adminUrl     = admin_url() . "admin.php?page=wc_el_inv-options-page&tab=xml";
        echo "<label id='wc_el_inv_order_search_label' for='wc_el_inv_order_search'>{$searchLabel}<br>";
        echo "<input id='wc_el_inv_order_search' type='search' name='wc_el_inv_order_search' value='{$orderToSearch}'>";
        echo "<a href='{$adminUrl}' class='wc_el_inv_order_search_trigger button button-secondary'><span class='dashicons dashicons-search'></span> {$searchButton}</a></label>";
        echo '</div>';
        $this->bulkActions($orders);
        $this->buttonBulkAction();
        echo '</div>';

        echo '<div class="summary-data">';
        $summaryTitle = esc_html__('Summary', WC_EL_INV_FREE_TEXTDOMAIN);
        echo "<h3>{$summaryTitle}</h3>";
        $data        = $this->summaryData();
        $labelLines  = esc_html__('Totals:', WC_EL_INV_FREE_TEXTDOMAIN);
        $labelSent   = esc_html__('Sent:', WC_EL_INV_FREE_TEXTDOMAIN);
        $labelNoSent = esc_html__('Not Sent:', WC_EL_INV_FREE_TEXTDOMAIN);
        $lineCount   = count(XmlOrderListTable::$listIds);
        echo "<p class='count-sent'>{$labelLines}<strong>{$lineCount}</strong></p>";
        echo "<p class='count-sent'>{$labelSent}<strong style='color:red;'>" . WC_EL_INV_PREMIUM . "</strong></p>";
        echo "<p class='count-no-sent'>{$labelNoSent}<strong style='color:red;'>" . WC_EL_INV_PREMIUM . "</strong></p>";

        $label    = esc_html__('Last Download', WC_EL_INV_FREE_TEXTDOMAIN);
        echo "<hr><strong>{$label}:</strong> <a class='last-download disabled' href='javascript:;'>".
             "<span><i class='dashicons dashicons-media-code'></i> <strong style='color:red;'>" . WC_EL_INV_PREMIUM . "</strong></span></a>";

        echo '</div>';
        $xmlOrdersListTable->prepare_items();
        $xmlOrdersListTable->display();
        echo '</form>';
        echo '</div>'; // wrap
    }
}
