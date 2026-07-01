# 🐘 Ganesha Moodle Theme

[![Moodle Plugin](https://img.shields.io/badge/Moodle-3.11%20%7C%204.0%20%7C%204.1%20%7C%204.2%20%7C%205.0-orange.svg)](https://moodle.org/plugins/)
[![Maturity](https://img.shields.io/badge/Maturity-Stable-green.svg)](#)
[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

**Ganesha** is an ultra-cute, playful, and colorful theme tailored specifically for **K-12 learners** and classrooms. Built as a classic-boost hybrid layout, Ganesha swaps standard flat corporate dashboards for a tactile, hand-drawn 3D cartoon style, bouncy animations, simplified progress tracks, and interactive learning companions—all of which are **100% white-labeled and editable by administrators** directly inside the Moodle Theme Settings.

---

## 🎨 Key Features

### 1. 🌈 Climate Weather Board (Day/Night Theme Switcher)
Allows students to toggle the site background style dynamically on the homepage:
*   **Sunny Day**: Bright paper colors with clean layouts.
*   **Rainbow Mode**: Shifts the background to a slow, animated pastel rainbow gradient.
*   **Starry Night**: Full accessibility dark mode override featuring a deep midnight-navy background, twinkling stardust, and glowing neon-cyan cartoon borders.

### 2. 🎟️ Daily Magic Scratch Card
A browser-native HTML5 canvas scratchcard widget. Students use touch or mouse actions to rub off the silver coating to reveal cute reward stickers (e.g. `🦄 MAGICAL UNICORN`, `🚀 SPACE EXPLORER`).
*   **Synthesized Audio Feed**: Plays a retro scratching sound dynamic effect using the HTML5 Web Audio API.

### 3. 🦉 Educational Trivia Owl
A friendly companion widget that rotates and flips with confetti animations when clicked, cycling through fun space, science, and nature facts.

### 4. 🍬 Ganesha's Sweet Shop (Virtual Pet Feeder)
A gamified student buddy widget:
*   Students feed Ganesha sweet Modaks, which triggers a coin chime and star confetti.
*   Feedings generate Friendship EXP points, leveling up their friendship level.
*   Progress is persisted automatically in local storage (`localStorage`) so Ganesha remembers his friends.

### 5. 📻 Chiptune Synthesizer Radio
A lightweight audio player that generates retro video game melodies directly in the browser using raw oscillator waves via the Web Audio API—zero heavy mp3/wav audio download footprints required!

---

## ⚙️ 100% White-Label Administration

Every single string, emoji, list of reward stickers, owl mascot character, and pet dialogue is fully customizable by the administrator without touching a single line of code. Go to:
**Site Administration ➔ Appearance ➔ Themes ➔ Ganesha**

*   **Weather Board Title & Subtitle**
*   **Scratch Card Sticker Rewards** (Comma-separated list)
*   **Trivia Owl Database** (Newline-separated educational facts)
*   **Virtual Pet Dialogues** (Newline-separated speeches Ganesha says)
*   **Custom Brand Accent Colors**
*   **Base Typography Size** (Choose between Standard, Cozy, Playful Large, or Super Large for early readers)

---

## 🚀 Installation & Setup

### Option A: Installation via Moodle Admin (Recommended)
1.  Download the latest release zip package: `theme_ganesha.zip`.
2.  Log into your Moodle site as an Administrator.
3.  Navigate to **Site Administration ➔ Plugins ➔ Install plugins**.
4.  Upload the zip file and follow the onscreen upgrade steps.
5.  Purge your Moodle caches at **Site Administration ➔ Development ➔ Purge all caches** to trigger stylesheet compiles.

### Option B: Installation via Git
Clone this repository directly into your Moodle server's `theme` folder:
```bash
cd /path/to/your/moodle/theme
git clone https://github.com/your-username/theme_ganesha.git ganesha
```

---

## 🛠️ Technical Specifications
*   **Parent Theme**: Hybrid inheritance from `classic` and `boost`.
*   **JavaScript**: Traditional non-AMD scripts (`javascript/interactions.js`) to maximize performance and avoid draw-menu collision bugs.
*   **SCSS Compilation**: Dynamically compiled using Moodle's built-in compiler, injecting variables configured in admin settings.
*   **Accessibility**: Features an alternate calm "Cozy Mode" toggle that instantly freezes animations and sparkles to assist students with sensory sensitivities.
