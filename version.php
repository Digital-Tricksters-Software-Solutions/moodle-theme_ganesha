<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Ganesha theme version details.
 *
 * @package     theme_ganesha
 * @copyright   2026 Ganesha Theme
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2026060204;             // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires  = 2021051700;             // Requires Moodle 3.11 or later.
$plugin->component = 'theme_ganesha';        // Full name of the plugin (must match folder name).
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = '1.1.8';
$plugin->dependencies = [
    'theme_boost' => 2021051700,             // Standard Boost dependency.
];
