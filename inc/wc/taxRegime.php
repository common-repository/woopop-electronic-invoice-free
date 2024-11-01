<?php
/**
 * taxRegime.php
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

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

return apply_filters('wc_el_inv-general_shop_tax_regime', array(
    'IT' => array(
        'RF01' => esc_html__('Ordinary', WC_EL_INV_FREE_TEXTDOMAIN),
        'RF02' => esc_html__('Minimum taxpayers (art.1, c.96-117, Italian Law 244/07)', WC_EL_INV_FREE_TEXTDOMAIN),
        'RF11' => esc_html__('Travel and tourism agencies (art.74-ter, DPR 633/72)', WC_EL_INV_FREE_TEXTDOMAIN),
        'RF19' => esc_html__('Flat-rate regime (art.1, c.54-89, Italian Law 190/2014)', WC_EL_INV_FREE_TEXTDOMAIN),
    ),
));