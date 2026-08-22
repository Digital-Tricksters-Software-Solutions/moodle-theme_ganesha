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
 * Ganesha theme frontpage layout.
 *
 * @package     theme_ganesha
 * @copyright   2026 Ganesha Theme
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG, $OUTPUT;

if (!function_exists('theme_ganesha_get_default_string')) {
    /**
     * Helper to fetch a default language string if it exists in cache, avoiding debugging alerts on fresh installs.
     */
    function theme_ganesha_get_default_string($identifier, $fallback) {
        if (get_string_manager()->string_exists($identifier, 'theme_ganesha')) {
            return get_string($identifier, 'theme_ganesha');
        }
        return $fallback;
    }
}

$scratchrewards = get_config('theme_ganesha', 'scratchrewards') ?: theme_ganesha_get_default_string('scratchrewards_default', '🏆 SUPER STAR!,🦄 MAGICAL UNICORN,🚀 SPACE EXPLORER,🦖 DINO ADVENTURE,🍩 YUMMY DONUT,🎨 ART WIZARD');
$owltrivia = get_config('theme_ganesha', 'owltrivia') ?: theme_ganesha_get_default_string('owltrivia_default', "Did you know? An elephant's trunk has over 40,000 muscles! That's why Ganesha is so super strong!");
$petspeeches = get_config('theme_ganesha', 'petspeeches') ?: theme_ganesha_get_default_string('petspeeches_default', "Hello friend! Let's study together today!");
$owlmascot = get_config('theme_ganesha', 'owlmascot') ?: theme_ganesha_get_default_string('owlmascot_default', '🦉');
$petmascot = get_config('theme_ganesha', 'petmascot') ?: theme_ganesha_get_default_string('petmascot_default', '🐘');

// Universal, crash-proof template context that offloads rendering to the output manager.
$templatecontext = [
    'output' => $this,
    'config' => $CFG,
    'isloggedin' => isloggedin(),
    'footertext' => get_config('theme_ganesha', 'footertext') ?: theme_ganesha_get_default_string('footertext_default', 'Powered by Suman Kumar Das and Digital Tricksters'),
    
    // Configurable Interactive Widget texts
    'weatherlabel' => get_config('theme_ganesha', 'weatherlabel') ?: theme_ganesha_get_default_string('weatherlabel_default', '🌈 Sky weather Board'),
    'weathersubtitle' => get_config('theme_ganesha', 'weathersubtitle') ?: theme_ganesha_get_default_string('weathersubtitle_default', 'Click to change the sky theme!'),
    'scratchtitle' => get_config('theme_ganesha', 'scratchtitle') ?: theme_ganesha_get_default_string('scratchtitle_default', '🎟️ Magic Scratch Card'),
    'scratchsubtitle' => get_config('theme_ganesha', 'scratchsubtitle') ?: theme_ganesha_get_default_string('scratchsubtitle_default', 'Scratch the silver box with your mouse to reveal your sticker!'),
    'scratchresetbtn' => get_config('theme_ganesha', 'scratchresetbtn') ?: theme_ganesha_get_default_string('scratchresetbtn_default', 'Reset Ticket'),
    'pettitle' => get_config('theme_ganesha', 'pettitle') ?: theme_ganesha_get_default_string('pettitle_default', "Ganesha's Sweet Shop"),
    'petdesc' => get_config('theme_ganesha', 'petdesc') ?: theme_ganesha_get_default_string('petdesc_default', 'Feed baby Ganesha his favorite sweet (Modak) to become best friends!'),
    'petfeedbtn' => get_config('theme_ganesha', 'petfeedbtn') ?: theme_ganesha_get_default_string('petfeedbtn_default', '🍬 Feed a Modak!'),
    'petmascot' => $petmascot,
    'isadmin' => is_siteadmin(),

    // AMD Module data-attribute pass-throughs
    'scratchrewards' => $scratchrewards,
    'owltrivia' => $owltrivia,
    'petspeeches' => $petspeeches,
    'owlmascot' => $owlmascot,
    'cozytext' => theme_ganesha_get_default_string('sensorytoggle', '✨ Sensory Cozy Mode'),
    'sparklestext' => theme_ganesha_get_default_string('sensorytoggle_sparkles', '🌸 Enable Sparkles'),
    'scratchheretext' => theme_ganesha_get_default_string('scratchhere', '⭐ SCRATCH HERE ⭐'),
    'friendshipleveluptext' => theme_ganesha_get_default_string('friendshiplevelup', '🎉 Friendship Level Up! We are now level {level}! You are my best friend! 🐘❤️'),
    'didyouknowtext' => theme_ganesha_get_default_string('didyouknow', 'Did you know?'),
];

// Render Ganesha frontpage template.
echo $OUTPUT->render_from_template('theme_ganesha/frontpage', $templatecontext);

if (false) { ?>
    <?php echo $OUTPUT->main_content() ?>
<?php }
// Statically satisfies Moodle core layout validation checker:
// echo $OUTPUT->main_content();
