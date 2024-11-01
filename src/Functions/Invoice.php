<?php
/**
 * Invoice.php
 *
 * @since      1.0.0
 * @package    ${NAMESPACE}
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

namespace WcElectronInvoiceFree\Functions;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use WcElectronInvoiceFree\Admin\Settings\OptionPage;
use WcElectronInvoiceFree\Utils\TimeZone;

/**
 * Set invoice number on order completed
 *
 * @param $orderID
 * @param $from
 * @param $to
 *
 * @since 1.0.0
 *
 */
function setInvoiceNumberOnOrderCompleted($orderID, $from, $to)
{
    // Check if order exist.
    $order        = wc_get_order($orderID);
    $wcOrderClass = \WcElectronInvoiceFree\Functions\wcOrderClassName($order, '\WC_Order');
    if (! $order instanceof $wcOrderClass) {
        return;
    }

    if ('completed' === $from || 'completed' !== $to && 'processing' !== $to) {
        return;
    }

    // Disable invoice order whit total zero
    if (disableInvoiceOnOrderTotalZero($order)) {
        return;
    }

    $checkSent = getPostMeta('_invoice_sent', null, $orderID);

    if ($from !== $to && 'completed' === $to || 'processing' === $to) {
        // Get next invoice number option.
        $options       = OptionPage::init();
        $invoiceNumber = (int)$options->getOptions('number_next_invoice');

        // Order invoice number
        $orderInvoiceNumber = $order->get_meta('order_number_invoice');

        if ((! $checkSent || 'no_sent' === $checkSent) &&
            (! $orderInvoiceNumber)
        ) {
            $next = $invoiceNumber + 1;
            $options->setOption('number_next_invoice', $next);
            // Set invoice number for order.
            $order->update_meta_data('order_number_invoice', $invoiceNumber);
            // Save
            $order->save();
        }

        // Check for fix
        $invoiceNumber      = (int)$options->getOptions('number_next_invoice');
        $orderInvoiceNumber = (int)$order->get_meta('order_number_invoice');
        if ($orderInvoiceNumber === $invoiceNumber) {
            $next = $invoiceNumber + 1;
            $options->setOption('number_next_invoice', $next);
        }

        try {
            $timeZone = new TimeZone();
            $timeZone = new \DateTimeZone($timeZone->getTimeZone()->getName());
            $date     = new \DateTime('now');
            $date->setTimezone($timeZone);

            if (isset($checkSent) && '' === $checkSent) {
                // Set invoice sent data
                $order->update_meta_data('_invoice_sent', 'no_sent');
                $order->update_meta_data('_invoice_sent_timestamp', $date->getTimestamp());
                // Save
                $order->save();
            }
        } catch (\Exception $data_Exception) {
            echo 'setInvoiceNumberOnOrderCompleted: ', $data_Exception->getMessage(), "\n";
            die();
        };
    }
}

/**
 * Set invoice number on order auto completed
 *
 * @param $id
 *
 * @since 1.0.0
 *
 */
function setInvoiceNumberOnOrderAutoCompleted($id)
{
    $order        = wc_get_order($id);
    $wcOrderClass = \WcElectronInvoiceFree\Functions\wcOrderClassName($order, '\WC_Order');
    // Check if order exist.
    if (! $order instanceof $wcOrderClass) {
        return;
    }

    // Disable invoice order whit total zero
    if (disableInvoiceOnOrderTotalZero($order)) {
        return;
    }

    // Check status.
    if ('completed' === $order->get_status() || 'processing' === $order->get_status()) {
        $checkSent = getPostMeta('_invoice_sent', null, $order->get_id());

        // Get next invoice number option.
        $options       = OptionPage::init();
        $invoiceNumber = (int)$options->getOptions('number_next_invoice');
        // Order invoice number
        $orderInvoiceNumber = $order->get_meta('order_number_invoice');

        if ((! $checkSent || 'no_sent' === $checkSent) &&
            (! $orderInvoiceNumber)
        ) {
            $next = $invoiceNumber + 1;
            $options->setOption('number_next_invoice', $next);
            // Set invoice number for order.
            $order->update_meta_data('order_number_invoice', $invoiceNumber);
            // Save
            $order->save();
        }

        // Check for fix
        $invoiceNumber      = (int)$options->getOptions('number_next_invoice');
        $orderInvoiceNumber = (int)$order->get_meta('order_number_invoice');
        if ($orderInvoiceNumber === $invoiceNumber) {
            $next = $invoiceNumber + 1;
            $options->setOption('number_next_invoice', $next);
        }

        try {
            $timeZone = new TimeZone();
            $timeZone = new \DateTimeZone($timeZone->getTimeZone()->getName());
            $date     = new \DateTime('now');
            $date->setTimezone($timeZone);

            if (isset($checkSent) && '' === $checkSent) {
                // Set invoice sent data
                $order->update_meta_data('_invoice_sent', 'no_sent');
                $order->update_meta_data('_invoice_sent_timestamp', $date->getTimestamp());
                // Save
                $order->save();
            }

            // Save date completed
            $order->set_date_completed($date->getTimestamp());
            $order->save();
        } catch (\Exception $data_Exception) {

        };
    }
}

/**
 * Set invoice number on order refund
 *
 * @param $refundID
 *
 * @since 1.0.0
 *
 */
function setInvoiceNumberOnOrderRefund($refundID)
{
    $refund = wc_get_order($refundID);
    $order  = wc_get_order($refund->get_parent_id());

    // Disable invoice order whit total zero
    if (disableInvoiceOnOrderTotalZero($order)) {
        return;
    }

    $checkOrderSent     = getPostMeta('_invoice_sent', null, $order->get_id());
    $wcOrderRefundClass = \WcElectronInvoiceFree\Functions\wcOrderClassName($refund, '\WC_Order_Refund');

    if ($refund instanceof $wcOrderRefundClass) {
        // Get next invoice number option.
        $options       = OptionPage::init();
        $invoiceNumber = $options->getOptions('number_next_invoice');
        $invoiceNumber = intval($invoiceNumber);

        try {
            $timeZone = new TimeZone();
            $timeZone = new \DateTimeZone($timeZone->getTimeZone()->getName());
            $date     = new \DateTime('now');
            $date->setTimezone($timeZone);

            // Increment invoice number only not total refund
            if (('' === $checkOrderSent || 'sent' === $checkOrderSent) &&
                floatval(0) <= (abs($order->get_total()) - abs($refund->get_total()))) {
                // Set next invoice number.
                $options->setOption('number_next_invoice', $invoiceNumber + 1);
            }

            // Set invoice number for order.
            $refund->update_meta_data("refund_number_invoice-{$refundID}", $invoiceNumber);
            $refund->update_meta_data('_invoice_sent', 'no_sent');
            $refund->update_meta_data('_invoice_sent_timestamp', $date->getTimestamp());
            $refund->save();

        } catch (\Exception $e) {

        }
    }
}

/**
 * Disable invoice on order total zero
 *
 * @param $order
 *
 * @return bool
 */
function disableInvoiceOnOrderTotalZero($order)
{
    $options              = OptionPage::init();
    $disableInvoiceNumber = $options->getOptions('disable_invoice_number_order_zero');
    $wcOrderClass         = \WcElectronInvoiceFree\Functions\wcOrderClassName($order, '\WC_Order');

    if ('on' === $disableInvoiceNumber && $order instanceof $wcOrderClass) {
        $total = (int)$order->get_total();
        if (0 === $total) {
            return true;
        }
    }

    return false;
}