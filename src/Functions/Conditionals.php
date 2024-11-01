<?php
/**
 * Conditionals.php
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

/**
 * Is WpMl active
 *
 * @since 1.0.0
 *
 * @return bool If the class SitePress exists and the theme support WpMl.
 */
function isWpmlActive()
{
    return class_exists('SitePress');
}

/**
 * Is WooCommerce active
 *
 * @since 1.0.0
 *
 * @return bool If the function WC exists.
 */
function isWooCommerceActive()
{
    return function_exists('WC');
}
