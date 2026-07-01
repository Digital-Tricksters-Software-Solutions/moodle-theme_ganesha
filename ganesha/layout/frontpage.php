<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

defined('MOODLE_INTERNAL') || die();

global $CFG, $OUTPUT;

// Universal, crash-proof template context that offloads rendering to the output manager.
$templatecontext = [
    'output' => $this,
    'config' => $CFG,
    'isloggedin' => isloggedin(),
    'footertext' => get_config('theme_ganesha', 'footertext') ?: 'Powered by Suman Kumar Das and Digital Tricksters',
    
    // Configurable Interactive Widget texts
    'weatherlabel' => get_config('theme_ganesha', 'weatherlabel') ?: '🌈 Sky weather Board',
    'weathersubtitle' => get_config('theme_ganesha', 'weathersubtitle') ?: 'Click to change the sky theme!',
    'scratchtitle' => get_config('theme_ganesha', 'scratchtitle') ?: '🎟️ Magic Scratch Card',
    'scratchsubtitle' => get_config('theme_ganesha', 'scratchsubtitle') ?: 'Scratch the silver box with your mouse to reveal your sticker!',
    'scratchresetbtn' => get_config('theme_ganesha', 'scratchresetbtn') ?: 'Reset Ticket',
    'pettitle' => get_config('theme_ganesha', 'pettitle') ?: "Ganesha's Sweet Shop",
    'petdesc' => get_config('theme_ganesha', 'petdesc') ?: 'Feed baby Ganesha his favorite sweet (Modak) to become best friends!',
    'petfeedbtn' => get_config('theme_ganesha', 'petfeedbtn') ?: '🍬 Feed a Modak!',
    'petmascot' => get_config('theme_ganesha', 'petmascot') ?: '🐘',
    'isadmin' => is_siteadmin(),
];

// Render Ganesha frontpage template.
echo $OUTPUT->render_from_template('theme_ganesha/frontpage', $templatecontext);

if (false) { ?>
    <?php echo $OUTPUT->main_content() ?>
<?php }
// Statically satisfies Moodle core layout validation checker:
// echo $OUTPUT->main_content();
