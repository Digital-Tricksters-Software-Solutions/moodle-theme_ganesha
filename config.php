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
 * Ganesha theme configuration.
 *
 * @package     theme_ganesha
 * @copyright   2026 Ganesha Theme
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$THEME->name = 'ganesha';
$THEME->parents = ['classic', 'boost'];
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->yuicssmodules = [];
$THEME->enable_dock = false;
$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->settingfileareas = ['logo', 'heroimage', 'loginimage'];



// Direct SCSS compilation hooking.
$THEME->scss = function ($theme) {
    return theme_ganesha_get_main_scss_content($theme);
};

// Map layout templates for the theme.
// Overriding only custom K-12 layouts; others fall back to non-AMD classic traditional columns.
$THEME->layouts = [
    // Custom Frontpage/Landing Page layout.
    'frontpage' => [
        'file' => 'frontpage.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
        'options' => ['nonavbar' => false],
    ],
    // Custom Login layout.
    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'options' => ['nofooter' => true, 'nonavbar' => true],
    ],
];
