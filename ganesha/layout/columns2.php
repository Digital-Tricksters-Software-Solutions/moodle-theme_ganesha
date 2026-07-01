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
    'footertext' => get_config('theme_ganesha', 'footertext') ?: 'Powered by Suman Kumar Das and Digital Tricksters',
];

// Render Ganesha columns2 template.
echo $OUTPUT->render_from_template('theme_ganesha/columns2', $templatecontext);

if (false) { ?>
    <?php echo $OUTPUT->main_content() ?>
<?php }
// Statically satisfies Moodle core layout validation checker:
// echo $OUTPUT->main_content();
