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
 * Ganesha theme helper functions and hooks library.
 *
 * @package     theme_ganesha
 * @copyright   2026 Ganesha Theme
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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

    $sitename = get_config('theme_ganesha', 'sitename') ?: theme_ganesha_get_default_string('sitename_default', 'Ganesha Academy');
    $herotitle = get_config('theme_ganesha', 'herotitle');
    $herosubtitle = get_config('theme_ganesha', 'herosubtitle');
    $questheading = get_config('theme_ganesha', 'questheading');

    // Fetch lists from Ganesha theme admin config and pass to Javascript dynamically
    $scratchrewards = get_config('theme_ganesha', 'scratchrewards') ?: theme_ganesha_get_default_string('scratchrewards_default', '🏆 SUPER STAR!,🦄 MAGICAL UNICORN,🚀 SPACE EXPLORER,🦖 DINO ADVENTURE,🍩 YUMMY DONUT,🎨 ART WIZARD');
    $owltrivia = get_config('theme_ganesha', 'owltrivia') ?: theme_ganesha_get_default_string('owltrivia_default', "Did you know? An elephant's trunk has over 40,000 muscles! That's why Ganesha is so super strong!");
    $petspeeches = get_config('theme_ganesha', 'petspeeches') ?: theme_ganesha_get_default_string('petspeeches_default', "Hello friend! Let's study together today!");
    $owlmascot = get_config('theme_ganesha', 'owlmascot') ?: theme_ganesha_get_default_string('owlmascot_default', '🦉');
    $petmascot = get_config('theme_ganesha', 'petmascot') ?: theme_ganesha_get_default_string('petmascot_default', '🐘');

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
    $js .= "var brandAnchors = document.querySelectorAll('.navbar-brand'); brandAnchors.forEach(function(el) { el.setAttribute('href', " . json_encode($CFG->wwwroot . '/index.php') . "); }); ";
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

    // Inject custom ES/AMD module JavaScript for playful K-12 interactions.
    $page->requires->js_call_amd('theme_ganesha/interactions', 'init');
}





/**
 * Serves layout images and custom icons for theme_ganesha.
 */
function theme_ganesha_get_image_url($imagename) {
    global $CFG;
    return new moodle_url($CFG->wwwroot . '/theme/ganesha/pix/' . $imagename);
}
