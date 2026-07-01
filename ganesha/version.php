<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2026060203;             // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires  = 2021051700;             // Requires Moodle 3.11 or later.
$plugin->component = 'theme_ganesha';        // Full name of the plugin (must match folder name).
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = '1.1.8';
$plugin->dependencies = [
    'theme_boost' => 2021051700              // Standard Boost dependency.
];
