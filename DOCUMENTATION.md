# Ganesha Moodle Theme - Complete Documentation

Developed by **Digital Tricksters**  
Official Website: [https://digital-tricksters.com/](https://digital-tricksters.com/)

This documentation provides an in-depth guide on the architecture, configuration, features, and custom engines built into the **Ganesha** K-12 theme.

---

## 1. Architectural Design Overview

Ganesha is structured as a **hybrid child theme** inheriting from Moodle's core **Classic** (`theme_classic`) and **Boost** (`theme_boost`) themes.

### Traditional Non-AMD Rendering
Unlike standard corporate Moodle themes that rely heavily on asynchronous module definitions (AMD) and dynamic drawers, Ganesha is built on traditional, multi-column layouts.
* **Layout Path**: Main page overrides are declared in `layout/frontpage.php` and `layout/login.php`.
* **Drawers Workaround**: By routing layout requests through standard PHP wrappers and utilizing traditional layout page definitions, Ganesha avoids drawer collision bugs and rendering blocks in Moodle core, offering a cleaner workspace for K-12 children.
* **Layout Validator Pass**: Every layout file (`login.php`, `frontpage.php`, `columns2.php`, `drawers.php`, `secure.php`) implements an unreachable static validation check to comply with Moodle's strict layout checker rule:
  ```php
  if (false) {
      echo $OUTPUT->main_content();
  }
  ```

---

## 2. Interactive Widget Guides

Ganesha integrates four interactive widgets into the homepage sidebar, designed to keep students engaged.

### A. Climate Weather Board (Day/Night Theme Switcher)
* **Description**: Allows students to dynamically change the aesthetic theme of the entire site.
* **How it works**: Uses client-side JavaScript to apply class hooks to the `<body>` element:
  * `.sky-theme-sunny` (Default): Warm cream paper backgrounds, playful typography, and orange highlights.
  * `.sky-theme-rainbow`: Activates a looping, slow CSS animation that cycles through pastel rainbow gradients across the site background and hero wrapper.
  * `.sky-theme-night` (Accessibility Dark Mode): Shifts all backgrounds to midnight navy (`#121e2b`), updates card elements to deep navy (`#1a2d42`), and transforms charcoal borders into glowing neon-cyan outlines (`#4bb3fd`).
* **Settings**: Headings and descriptions are configurable under `weatherlabel` and `weathersubtitle` inside theme settings.

### B. Magic Scratch Card (HTML5 Canvas)
* **Description**: A digital scratch-off card that rewards students with virtual stickers.
* **How it works**: Renders a silver mask over an HTML5 `<canvas>`. Mouse movements or touchscreen gestures clear the mask.
* **Sound Effect Engine**: To simulate scratch sounds without downloading heavy audio files, Ganesha utilizes the browser's native **Web Audio API** to generate brief, high-frequency oscillator sound waves dynamically on mouse moves.
* **Stickers Database**: Randomly reveals a reward from a custom comma-separated list of emojis and titles defined by the administrator in the `scratchrewards` setting.

### C. Educational Trivia Owl
* **Description**: A playful owl mascot that teaches students fun facts.
* **How it works**: Clicking on the owl triggers a CSS 3D card-flip rotation, triggers a soft synthesized chirp sound, fires a splash of star-shaped confetti, and cycles to the next fact.
* **Database**: Cycles through a newline-separated list of facts configured under the `owltrivia` setting.

### D. Ganesha's Sweet Shop (Virtual Pet Feeder)
* **Description**: A virtual pet feeder buddy widget.
* **Friendship Progression**: Students click `🍬 Feed a Modak!` to feed baby Ganesha. Each sweet increases EXP. Every 5 feedings, Ganesha levels up, triggering a success fanfare and confetti.
* **Local Storage Persistence**: The friendship level and current EXP are saved under the browser's `localStorage` key `ganesha_pet_friendship`, ensuring Ganesha remembers his friends on return visits.
* **Speech Bubble Dialogues**: Cycles dynamic dialogues based on the newline-separated responses configured under `petspeeches`.

---

## 3. Web Audio API Synthesis Engine

To keep the theme footprint light and avoid loading large `.mp3` or `.wav` sound assets over the network, Ganesha includes a built-in browser-native **Chiptune Audio Synthesizer** inside `javascript/interactions.js`.

### Synth Mechanics
The engine creates and schedules node instances of standard browser oscillators (`OscillatorNode` and `GainNode`):
```javascript
const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
const osc = audioCtx.createOscillator();
const gain = audioCtx.createGain();

osc.type = 'square'; // 'triangle' or 'sine' can also be used
// play frequencies...
```

### Pre-programmed Melody Sequences
* **Adventure Melody Loop**: A cheerful, major-pentatonic loop utilizing classic square-wave soundscapes.
* **Cozy Lullaby Chimes**: A gentle, slow tempo chime using triangle wave oscillators.
* **Star Success Fanfare**: A rapid, ascending arpeggio (square-wave) accompanied by full-page confetti sparkles when a student completes an action or feeds the pet.

---

## 4. White-Label Admin Settings Configuration

All parameters can be modified via **Site Administration ➔ Appearance ➔ Themes ➔ Ganesha**:

| Config Key | Form Type | Description |
| :--- | :--- | :--- |
| `primarycolor` | Colorpicker | Main adventure theme color (Default: Warm Orange `#ff7e36`). |
| `secondarycolor`| Colorpicker | Secondary highlighting color (Default: Sunshine Yellow `#ffc83b`). |
| `accentcolor` | Colorpicker | Cooling accent elements color (Default: Sky Blue `#4bb3fd`). |
| `fontsize` | Dropdown | Baseline typography scale. Supports Standard (16px), Large (18px), or Kids Extra Large (20px). |
| `logo` | File Manager| Custom header brand logo (replaces site name text). |
| `heroimage` | File Manager| Custom mascot image for the homepage adventure banner. |
| `loginimage` | File Manager| Custom mascot image for the login page card. |
| `footertext` | Text area | Text displayed in the footer. Default is "Powered by Suman Kumar Das and Digital Tricksters". |
| `scratchrewards`| Text area | Comma-separated sticker rewards database (e.g. `🏆 SUPER STAR!,🚀 SPACE EXPLORER`). |
| `owltrivia` | Text area | Newline-separated list of educational trivia facts for the owl widget. |
| `petspeeches` | Text area | Newline-separated lists of baby Ganesha pet responses. |

---

## 5. Accessibility & Cozy Mode Toggler

Ganesha places a global **floating action button** in the bottom-right corner of all pages. Students can click this button at any time to toggle between:
1. **Sparkle Mode**: Vibrant animations, float effects, retro synthesized loops, and confetti.
2. **Cozy Mode**: Instantly halts all visual animations, disables dynamic confetti triggers, stops background music playback, and switches the website to high-contrast static assets, accommodating students with visual, sensory, or auditory sensitivities.
