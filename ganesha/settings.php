<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    // Custom theme settings page.
    $settings = new admin_settingpage('themesettingganesha', get_string('configtitle', 'theme_ganesha'));

    // 1. Primary Playful Color
    $name = 'theme_ganesha/primarycolor';
    $title = get_string('primarycolor', 'theme_ganesha');
    $description = get_string('primarycolor_desc', 'theme_ganesha');
    $default = '#ff7e36'; // Playful warm orange
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $settings->add($setting);

    // 2. Secondary Playful Color
    $name = 'theme_ganesha/secondarycolor';
    $title = get_string('secondarycolor', 'theme_ganesha');
    $description = get_string('secondarycolor_desc', 'theme_ganesha');
    $default = '#ffc83b'; // Bouncy warm yellow
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $settings->add($setting);

    // 3. Playful Accent Color (Sky Blue)
    $name = 'theme_ganesha/accentcolor';
    $title = get_string('accentcolor', 'theme_ganesha');
    $description = get_string('accentcolor_desc', 'theme_ganesha');
    $default = '#4bb3fd'; // Sky blue
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $settings->add($setting);

    // 4. Custom Hero Title
    $name = 'theme_ganesha/herotitle';
    $title = get_string('herotitle', 'theme_ganesha');
    $description = get_string('herotitle_desc', 'theme_ganesha');
    $default = 'Namaste, Adventurer! Let\'s Explore!';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 5. Custom Hero Subtitle
    $name = 'theme_ganesha/herosubtitle';
    $title = get_string('herosubtitle', 'theme_ganesha');
    $description = get_string('herosubtitle_desc', 'theme_ganesha');
    $default = 'Every lesson is a magical step on your learning journey. What quest will we start today?';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 6. Sensory Toggle Default Mode
    $name = 'theme_ganesha/sensorymode';
    $title = get_string('sensorymode', 'theme_ganesha');
    $description = get_string('sensorymode_desc', 'theme_ganesha');
    $default = 'sparkle';
    $choices = [
        'sparkle' => get_string('sparkle_mode', 'theme_ganesha'),
        'cozy' => get_string('cozy_mode', 'theme_ganesha')
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // 7. Mascot Happiness Level (changes expression)
    $name = 'theme_ganesha/mascotexpression';
    $title = get_string('mascotexpression', 'theme_ganesha');
    $description = get_string('mascotexpression_desc', 'theme_ganesha');
    $default = 'super_happy';
    $choices = [
        'super_happy' => get_string('mascot_super_happy', 'theme_ganesha'),
        'studious' => get_string('mascot_studious', 'theme_ganesha'),
        'playful' => get_string('mascot_playful', 'theme_ganesha')
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // 8. Toggle Show Quick Links
    $name = 'theme_ganesha/showquicklinks';
    $title = get_string('showquicklinks', 'theme_ganesha');
    $description = get_string('showquicklinks_desc', 'theme_ganesha');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // 9. Toggle Show Mascot
    $name = 'theme_ganesha/showmascot';
    $title = get_string('showmascot', 'theme_ganesha');
    $description = get_string('showmascot_desc', 'theme_ganesha');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // 10. Toggle Show Progress Bar
    $name = 'theme_ganesha/showprogress';
    $title = get_string('showprogress', 'theme_ganesha');
    $description = get_string('showprogress_desc', 'theme_ganesha');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // 11. Custom Quest Section Heading
    $name = 'theme_ganesha/questheading';
    $title = get_string('questheading', 'theme_ganesha');
    $description = get_string('questheading_desc', 'theme_ganesha');
    $default = 'Today\'s Active Quests';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 12. Custom Site Name
    $name = 'theme_ganesha/sitename';
    $title = get_string('sitename', 'theme_ganesha');
    $description = get_string('sitename_desc', 'theme_ganesha');
    $default = 'Ganesha Academy';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 13. Dynamic Font Size Changer dropdown
    $name = 'theme_ganesha/fontsize';
    $title = get_string('fontsize', 'theme_ganesha');
    $description = get_string('fontsize_desc', 'theme_ganesha');
    $default = '16px';
    $choices = [
        '14px' => get_string('fontsize_small', 'theme_ganesha'),
        '16px' => get_string('fontsize_standard', 'theme_ganesha'),
        '18px' => get_string('fontsize_large', 'theme_ganesha'),
        '20px' => get_string('fontsize_extra_large', 'theme_ganesha')
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // 14. Custom Header Logo Upload (Moodle Filepicker API)
    $name = 'theme_ganesha/logo';
    $title = get_string('logo', 'theme_ganesha');
    $description = get_string('logo_desc', 'theme_ganesha');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, ['maxfiles' => 1, 'accepted_types' => ['image']]);
    $settings->add($setting);

    // 15. Custom Hero Mascot Upload (Moodle Filepicker API)
    $name = 'theme_ganesha/heroimage';
    $title = get_string('heroimage', 'theme_ganesha');
    $description = get_string('heroimage_desc', 'theme_ganesha');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'heroimage', 0, ['maxfiles' => 1, 'accepted_types' => ['image']]);
    $settings->add($setting);

    // 16. Custom Login Mascot Upload (Moodle Filepicker API)
    $name = 'theme_ganesha/loginimage';
    $title = get_string('loginimage', 'theme_ganesha');
    $description = get_string('loginimage_desc', 'theme_ganesha');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginimage', 0, ['maxfiles' => 1, 'accepted_types' => ['image']]);
    $settings->add($setting);

    // 17. Custom Footer Text
    $name = 'theme_ganesha/footertext';
    $title = get_string('footertext', 'theme_ganesha');
    $description = get_string('footertext_desc', 'theme_ganesha');
    $default = 'Powered by Suman Kumar Das and Digital Tricksters';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 18. Weather Board Title
    $name = 'theme_ganesha/weatherlabel';
    $title = get_string('weatherlabel', 'theme_ganesha');
    $description = get_string('weatherlabel_desc', 'theme_ganesha');
    $default = '🌈 Sky weather Board';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 19. Weather Board Subtitle
    $name = 'theme_ganesha/weathersubtitle';
    $title = get_string('weathersubtitle', 'theme_ganesha');
    $description = get_string('weathersubtitle_desc', 'theme_ganesha');
    $default = 'Click to change the sky theme!';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 20. Magic Scratch Card Title
    $name = 'theme_ganesha/scratchtitle';
    $title = get_string('scratchtitle', 'theme_ganesha');
    $description = get_string('scratchtitle_desc', 'theme_ganesha');
    $default = '🎟️ Magic Scratch Card';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 21. Magic Scratch Card Subtitle
    $name = 'theme_ganesha/scratchsubtitle';
    $title = get_string('scratchsubtitle', 'theme_ganesha');
    $description = get_string('scratchsubtitle_desc', 'theme_ganesha');
    $default = 'Scratch the silver box with your mouse to reveal your sticker!';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 22. Magic Scratch Card Reset Button Label
    $name = 'theme_ganesha/scratchresetbtn';
    $title = get_string('scratchresetbtn', 'theme_ganesha');
    $description = get_string('scratchresetbtn_desc', 'theme_ganesha');
    $default = 'Reset Ticket';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 23. Magic Scratch Card Rewards (Comma-separated list)
    $name = 'theme_ganesha/scratchrewards';
    $title = get_string('scratchrewards', 'theme_ganesha');
    $description = get_string('scratchrewards_desc', 'theme_ganesha');
    $default = '🏆 SUPER STAR!,🦄 MAGICAL UNICORN,🚀 SPACE EXPLORER,🦖 DINO ADVENTURE,🍩 YUMMY DONUT,🎨 ART WIZARD';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 24. Speech Owl Mascot Emoji/Character
    $name = 'theme_ganesha/owlmascot';
    $title = get_string('owlmascot', 'theme_ganesha');
    $description = get_string('owlmascot_desc', 'theme_ganesha');
    $default = '🦉';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 25. Speech Owl Trivia List (Textarea)
    $name = 'theme_ganesha/owltrivia';
    $title = get_string('owltrivia', 'theme_ganesha');
    $description = get_string('owltrivia_desc', 'theme_ganesha');
    $default = "Did you know? An elephant's trunk has over 40,000 muscles! That's why Ganesha is so super strong!\nDid you know? Honey never spoils! You could eat 3000-year-old honey!\nDid you know? Bananas are berries, but strawberries aren't!\nDid you know? Wombat poop is cube-shaped! This stops it from rolling away!\nDid you know? A day on Venus is longer than a year on Venus!\nDid you know? Cows have best friends and get stressed when they are separated!\nDid you know? Octopuses have three hearts and blue blood!\nDid you know? Sea otters hold hands while sleeping so they don't drift apart!\nDid you know? Sloths can hold their breath longer than dolphins can!\nDid you know? Dolphins sleep with one eye open to watch for sharks!";
    $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 26. Ganesha Virtual Pet Feeder Title
    $name = 'theme_ganesha/pettitle';
    $title = get_string('pettitle', 'theme_ganesha');
    $description = get_string('pettitle_desc', 'theme_ganesha');
    $default = "Ganesha's Sweet Shop";
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 27. Ganesha Virtual Pet Feeder Description
    $name = 'theme_ganesha/petdesc';
    $title = get_string('petdesc', 'theme_ganesha');
    $description = get_string('petdesc_desc', 'theme_ganesha');
    $default = 'Feed baby Ganesha his favorite sweet (Modak) to become best friends!';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 28. Ganesha Virtual Pet Feed Button Label
    $name = 'theme_ganesha/petfeedbtn';
    $title = get_string('petfeedbtn', 'theme_ganesha');
    $description = get_string('petfeedbtn_desc', 'theme_ganesha');
    $default = '🍬 Feed a Modak!';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 29. Ganesha Virtual Pet Emoji/Mascot
    $name = 'theme_ganesha/petmascot';
    $title = get_string('petmascot', 'theme_ganesha');
    $description = get_string('petmascot_desc', 'theme_ganesha');
    $default = '🐘';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);

    // 30. Ganesha Virtual Pet Speeches List (Textarea)
    $name = 'theme_ganesha/petspeeches';
    $title = get_string('petspeeches', 'theme_ganesha');
    $description = get_string('petspeeches_desc', 'theme_ganesha');
    $default = "Hello friend! Let's study together today!\nYum! That Modak was delicious! Thank you! 🍬\nOoh, that tickles my trunk! Hahaha!\nFriendship level up! We are best friends now! 🐘❤️\nAre you ready for your next study quest? Let's go!\nWow! You are feeding me so many delicious treats!\nLearning is a super fun adventure with you!\nYou are the smartest adventurer in the kingdom!";
    $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_TEXT);
    $settings->add($setting);
}



