<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

defined('MOODLE_INTERNAL') || die();

/**
 * Returns the main SCSS content for compiling the theme.
 *
 * @param \theme_config $theme
 * @return string
 */
function theme_ganesha_get_main_scss_content($theme) {
    global $CFG;

    // Load theme/boost/lib.php and theme/classic/lib.php to ensure core compiler functions are defined.
    $boostlib = $CFG->dirroot . '/theme/boost/lib.php';
    if (file_exists($boostlib)) {
        require_once($boostlib);
    }
    $classiclib = $CFG->dirroot . '/theme/classic/lib.php';
    if (file_exists($classiclib)) {
        require_once($classiclib);
    }

    $scss = '';

    // Fetch theme admin configs and inject them as SCSS variables.
    $primarycolor = get_config('theme_ganesha', 'primarycolor');
    $secondarycolor = get_config('theme_ganesha', 'secondarycolor');
    $accentcolor = get_config('theme_ganesha', 'accentcolor');

    $variables = [];
    if (!empty($primarycolor)) {
        $variables[] = '$primary-color: ' . $primarycolor . ';';
    }
    if (!empty($secondarycolor)) {
        $variables[] = '$secondary-color: ' . $secondarycolor . ';';
    }
    if (!empty($accentcolor)) {
        $variables[] = '$accent-color: ' . $accentcolor . ';';
    }
    $scss .= implode("\n", $variables) . "\n";

    // First, read pre.scss (variables and imports).
    $prefile = $CFG->dirroot . '/theme/ganesha/scss/pre.scss';
    if (file_exists($prefile)) {
        $scss .= file_get_contents($prefile);
    } else {
        // Fallback for standalone/local development environment structure.
        $localpre = __DIR__ . '/scss/pre.scss';
        if (file_exists($localpre)) {
            $scss .= file_get_contents($localpre);
        }
    }

    // Call the parent theme (Classic or Boost) core SCSS compiler function to get the complete stylesheet code base.
    if (function_exists('theme_classic_get_main_scss_content')) {
        $scss .= theme_classic_get_main_scss_content($theme);
    } else if (function_exists('theme_boost_get_main_scss_content')) {
        $scss .= theme_boost_get_main_scss_content($theme);
    } else {
        // Fallback if core function is somehow unavailable.
        $boost = theme_config::load('boost');
        $scss .= $boost->get_pre_scss_code();
    }

    // Read post.scss (overrides and custom styles).
    $postfile = $CFG->dirroot . '/theme/ganesha/scss/post.scss';
    if (file_exists($postfile)) {
        $scss .= file_get_contents($postfile);
    } else {
        // Fallback for standalone/local development.
        $localpost = __DIR__ . '/scss/post.scss';
        if (file_exists($localpost)) {
            $scss .= file_get_contents($localpost);
        }
    }

    return $scss;
}

/**
 * Hook to inject custom CSS classes or assets into the page layout.
 *
 * @param moodle_page $page
 */
function theme_ganesha_page_init(moodle_page $page) {
    global $CFG;
    
    // Add custom K-12 assets, Google fonts, and playful favicon.
    $page->requires->css(new moodle_url('https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Quicksand:wght@300..700&display=swap'));
    
    // Inject custom vanilla non-AMD JavaScript for playful interactions (like confetti and sensory toggle).
    $page->requires->js(new moodle_url($CFG->wwwroot . '/theme/ganesha/javascript/interactions.js'));

    // Fetch theme visibility and font size settings and apply via CSS injection.
    $showquicklinks = get_config('theme_ganesha', 'showquicklinks');
    $showmascot = get_config('theme_ganesha', 'showmascot');
    $showprogress = get_config('theme_ganesha', 'showprogress');
    $fontsize = get_config('theme_ganesha', 'fontsize') ?: '16px';
    
    $css = '';
    $css .= 'html, body { font-size: ' . $fontsize . ' !important; } ';
    if ($showquicklinks === '0') {
        $css .= '.ganesha-quick-links { display: none !important; } ';
    }
    if ($showmascot === '0') {
        $css .= '.mascot-image-wrapper { display: none !important; } ';
    }
    if ($showprogress === '0') {
        $css .= '.ganesha-progress-container { display: none !important; } ';
    }

    // Dynamic brand text, logo, welcome text, and mascot image injection from site administration settings.
    $sitename = get_config('theme_ganesha', 'sitename') ?: 'Ganesha Academy';
    $herotitle = get_config('theme_ganesha', 'herotitle');
    $herosubtitle = get_config('theme_ganesha', 'herosubtitle');
    $questheading = get_config('theme_ganesha', 'questheading');

    // Fetch lists from Ganesha theme admin config and pass to Javascript dynamically
    $scratchrewards = get_config('theme_ganesha', 'scratchrewards') ?: '🏆 SUPER STAR!,🦄 MAGICAL UNICORN,🚀 SPACE EXPLORER,🦖 DINO ADVENTURE,🍩 YUMMY DONUT,🎨 ART WIZARD';
    $owltrivia = get_config('theme_ganesha', 'owltrivia');
    if (empty($owltrivia)) {
        $owltrivia = "Did you know? An elephant's trunk has over 40,000 muscles! That's why Ganesha is so super strong!\n" .
                     "Did you know? Honey never spoils! You could eat 3000-year-old honey!\n" .
                     "Did you know? Bananas are berries, but strawberries aren't!\n" .
                     "Did you know? Wombat poop is cube-shaped! This stops it from rolling away!\n" .
                     "Did you know? A day on Venus is longer than a year on Venus!\n" .
                     "Did you know? Cows have best friends and get stressed when they are separated!\n" .
                     "Did you know? Octopuses have three hearts and blue blood!\n" .
                     "Did you know? Sea otters hold hands while sleeping so they don't drift apart!\n" .
                     "Did you know? Sloths can hold their breath longer than dolphins can!\n" .
                     "Did you know? Dolphins sleep with one eye open to watch for sharks!";
    }
    $petspeeches = get_config('theme_ganesha', 'petspeeches');
    if (empty($petspeeches)) {
        $petspeeches = "Hello friend! Let's study together today!\n" .
                       "Yum! That Modak was delicious! Thank you! 🍬\n" .
                       "Ooh, that tickles my trunk! Hahaha!\n" .
                       "Friendship level up! We are best friends now! 🐘❤️\n" .
                       "Are you ready for your next study quest? Let's go!\n" .
                       "Wow! You are feeding me so many delicious treats!\n" .
                       "Learning is a super fun adventure with you!\n" .
                       "You are the smartest adventurer in the kingdom!";
    }
    $owlmascot = get_config('theme_ganesha', 'owlmascot') ?: '🦉';
    $petmascot = get_config('theme_ganesha', 'petmascot') ?: '🐘';

    // Retrieve uploaded stored files via Moodle's native theme file serving API.
    $customlogo = $page->theme->setting_file_url('logo', 'logo');
    $customheroimage = $page->theme->setting_file_url('heroimage', 'heroimage');
    $customloginimage = $page->theme->setting_file_url('loginimage', 'loginimage');

    // Build the dynamic injection Javascript.
    $js = '';

    // Inject dynamic client-side widget configurations safely
    $js .= "window.GaneshaRewardsRaw = " . json_encode($scratchrewards) . "; ";
    $js .= "window.GaneshaTriviaRaw = " . json_encode($owltrivia) . "; ";
    $js .= "window.GaneshaSpeechesRaw = " . json_encode($petspeeches) . "; ";
    $js .= "window.GaneshaOwlMascot = " . json_encode($owlmascot) . "; ";
    $js .= "window.GaneshaPetMascot = " . json_encode($petmascot) . "; ";

    
    // Inject the custom font size and component hide variables safely using DOM elements to avoid PHP core method errors.
    if (!empty($css)) {
        $js .= "var style = document.createElement('style'); style.textContent = " . json_encode($css) . "; document.head.appendChild(style); ";
    }

    // 1. Logo & Site Name Branding
    if (!empty($customlogo)) {
        $js .= "var b = document.querySelectorAll('.navbar-brand'); b.forEach(function(el) { el.innerHTML = '<img src=\"' + " . json_encode($customlogo) . " + '\" alt=\"Logo\" style=\"max-height: 40px; border-radius: 8px;\">'; }); ";
    } else if (!empty($sitename)) {
        $js .= "var b = document.querySelectorAll('.navbar-brand span'); b.forEach(function(el) { el.textContent = " . json_encode($sitename) . "; }); ";
    }

    // 2. Banner Texts
    if (!empty($herotitle)) {
        $js .= "var t = document.querySelector('.hero-title'); if (t) t.textContent = " . json_encode($herotitle) . "; ";
    }
    if (!empty($herosubtitle)) {
        $js .= "var s = document.querySelector('.hero-subtitle'); if (s) s.textContent = " . json_encode($herosubtitle) . "; ";
    }
    if (!empty($questheading)) {
        $js .= "var q = document.querySelector('.ganesha-quests-header h3'); if (q) q.textContent = '📚 ' + " . json_encode($questheading) . "; ";
    }

    // 3. Custom Graphics (Homepage Hero Banner & Login Mascot)
    if (!empty($customheroimage)) {
        $js .= "var h = document.querySelector('.mascot-image-wrapper img'); if (h) h.src = " . json_encode($customheroimage) . "; ";
    }
    if (!empty($customloginimage)) {
        $js .= "var l = document.querySelector('.ganesha-login-mascot'); if (l) { l.src = " . json_encode($customloginimage) . "; l.setAttribute('data-peekaboo', " . json_encode($customloginimage) . "); } ";
    }

    if (!empty($js)) {
        $page->requires->js_init_code("
            (function() {
                function runInjection() {
                    " . $js . "
                }
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', runInjection);
                } else {
                    runInjection();
                }
            })();
        ");
    }
}





/**
 * Serves layout images and custom icons for theme_ganesha.
 */
function theme_ganesha_get_image_url($imagename) {
    global $CFG;
    return new moodle_url($CFG->wwwroot . '/theme/ganesha/pix/' . $imagename);
}
