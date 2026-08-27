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
 * Ganesha theme drawers layout.
 *
 * @package     theme_ganesha
 * @copyright   2026 Ganesha Theme
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG, $OUTPUT;

// Universal, crash-proof template context that offloads rendering to the output manager.
$templatecontext = [
    'output' => $this,
    'config' => $CFG,
    'footertext' => get_config('theme_ganesha', 'footertext')
        ?: 'Powered by Suman Kumar Das and Digital Tricksters',
    'isadmin' => is_siteadmin(),
];

// Render Ganesha drawers template.
echo $OUTPUT->render_from_template('theme_ganesha/drawers', $templatecontext);

if (false) {
    echo $OUTPUT->main_content();
}
