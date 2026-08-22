/**
 * Ganesha Theme Playful K-12 Interactions (AMD ES Module).
 *
 * @module     theme_ganesha/interactions
 * @copyright  2026 Ganesha Theme
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([], function() {
    'use strict';

    var Confetti = {
        canvas: null,
        ctx: null,
        particles: [],
        colors: ['#ff7e36', '#ffc83b', '#4bb3fd', '#ff758f', '#51cb82', '#b5179e'],
        active: false,

        init: function() {
            if (!document.getElementById('confetti-canvas')) {
                var c = document.createElement('canvas');
                c.id = 'confetti-canvas';
                document.body.appendChild(c);
            }
            this.canvas = document.getElementById('confetti-canvas');
            if (this.canvas) {
                this.ctx = this.canvas.getContext('2d');
                this.resizeCanvas();
                window.addEventListener('resize', this.resizeCanvas.bind(this));
            }
        },

        resizeCanvas: function() {
            if (this.canvas) {
                this.canvas.width = window.innerWidth;
                this.canvas.height = window.innerHeight;
            }
        },

        spawn: function(x, y) {
            this.init();
            var count = 60;
            for (var i = 0; i < count; i++) {
                this.particles.push({
                    x: x || window.innerWidth / 2,
                    y: y || window.innerHeight / 2,
                    size: Math.random() * 8 + 6,
                    color: this.colors[Math.floor(Math.random() * this.colors.length)],
                    speedX: (Math.random() - 0.5) * 12,
                    speedY: (Math.random() - 0.5) * 12 - 5,
                    gravity: 0.25,
                    rotation: Math.random() * 360,
                    rotationSpeed: (Math.random() - 0.5) * 10,
                    opacity: 1
                });
            }
            if (!this.active) {
                this.active = true;
                this.animate();
            }
        },

        animate: function() {
            var self = Confetti;
            if (!self.canvas || self.particles.length === 0) {
                self.active = false;
                return;
            }

            self.ctx.clearRect(0, 0, self.canvas.width, self.canvas.height);

            for (var i = self.particles.length - 1; i >= 0; i--) {
                var p = self.particles[i];
                p.x += p.speedX;
                p.y += p.speedY;
                p.speedY += p.gravity;
                p.rotation += p.rotationSpeed;
                p.opacity -= 0.015;

                self.ctx.save();
                self.ctx.translate(p.x, p.y);
                self.ctx.rotate(p.rotation * Math.PI / 180);
                self.ctx.globalAlpha = p.opacity;
                self.ctx.fillStyle = p.color;
                
                // Draw square confetti
                self.ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size);
                self.ctx.restore();

                if (p.opacity <= 0 || p.y > self.canvas.height) {
                    self.particles.splice(i, 1);
                }
            }

            requestAnimationFrame(self.animate);
        }
    };

    var ChiptuneRadio = {
        audioCtx: null,
        currentSource: null,
        isPlaying: false,
        activeChannel: null,
        
        init: function() {
            if (!this.audioCtx) {
                var AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (AudioContextClass) {
                    this.audioCtx = new AudioContextClass();
                }
            }
        },
        
        playTone: function(frequency, type, startTime, duration, volume) {
            if (!this.audioCtx) return;
            
            var osc = this.audioCtx.createOscillator();
            var gainNode = this.audioCtx.createGain();
            
            osc.connect(gainNode);
            gainNode.connect(this.audioCtx.destination);
            
            osc.type = type || 'square';
            osc.frequency.setValueAtTime(frequency, startTime);
            
            gainNode.gain.setValueAtTime(volume || 0.1, startTime);
            gainNode.gain.exponentialRampToValueAtTime(0.0001, startTime + duration - 0.02);
            
            osc.start(startTime);
            osc.stop(startTime + duration);
        },
        
        playMelody: function(notes, type, volume) {
            this.init();
            this.stop();
            
            if (this.audioCtx.state === 'suspended') {
                this.audioCtx.resume();
            }
            
            this.isPlaying = true;
            var tempo = 130; // BPM
            var quarterNoteDuration = 60 / tempo;
            
            var self = this;
            var noteIndex = 0;
            
            function playNextNote() {
                if (!self.isPlaying) return;
                
                if (noteIndex >= notes.length) {
                    noteIndex = 0;
                }
                
                var note = notes[noteIndex];
                if (note.freq > 0) {
                    self.playTone(note.freq, type, self.audioCtx.currentTime, note.dur * quarterNoteDuration, volume);
                }
                
                noteIndex++;
                self.currentSource = setTimeout(playNextNote, note.dur * quarterNoteDuration * 1000);
            }
            
            playNextNote();
        },
        
        stop: function() {
            this.isPlaying = false;
            if (this.currentSource) {
                clearTimeout(this.currentSource);
                this.currentSource = null;
            }
            document.querySelectorAll('.radio-btn').forEach(function(b) {
                b.classList.remove('active');
            });
        },
        
        toggleChannel: function(channel, btn) {
            this.init();
            
            if (this.activeChannel === channel) {
                this.stop();
                this.activeChannel = null;
                btn.classList.remove('active');
                return;
            }
            
            document.querySelectorAll('.radio-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            
            btn.classList.add('active');
            this.activeChannel = channel;
            
            var C4 = 261.63, D4 = 293.66, E4 = 329.63, F4 = 349.23, G4 = 392.00, A4 = 440.00, B4 = 493.88;
            var C5 = 523.25, D5 = 587.33, E5 = 659.25, G5 = 783.99, A5 = 880.00;
            
            if (channel === 'melody') {
                // Happy Adventure Loop (Square wave)
                var notes = [
                    {freq: C4, dur: 0.5}, {freq: E4, dur: 0.5}, {freq: G4, dur: 0.5}, {freq: C5, dur: 0.5},
                    {freq: G4, dur: 0.5}, {freq: E4, dur: 0.5}, {freq: C4, dur: 1.0},
                    {freq: D4, dur: 0.5}, {freq: F4, dur: 0.5}, {freq: A4, dur: 0.5}, {freq: D5, dur: 0.5},
                    {freq: A4, dur: 0.5}, {freq: F4, dur: 0.5}, {freq: D4, dur: 1.0}
                ];
                this.playMelody(notes, 'square', 0.05);
            } else if (channel === 'chime') {
                // Soft Cozy Chimes (Triangle wave)
                var notes = [
                    {freq: E5, dur: 1.0}, {freq: G5, dur: 1.0}, {freq: A5, dur: 1.0}, {freq: G5, dur: 1.0},
                    {freq: E5, dur: 1.0}, {freq: D5, dur: 1.0}, {freq: C5, dur: 2.0}
                ];
                this.playMelody(notes, 'triangle', 0.08);
            } else if (channel === 'sparkle') {
                // Star Success Fanfare (Sine wave)
                var notes = [
                    {freq: C4, dur: 0.2}, {freq: E4, dur: 0.2}, {freq: G4, dur: 0.2}, {freq: C5, dur: 0.6}
                ];
                this.playMelody(notes, 'sine', 0.1);
                var self = this;
                setTimeout(function() {
                    if (self.activeChannel === 'sparkle') {
                        btn.classList.remove('active');
                        self.activeChannel = null;
                        self.stop();
                    }
                }, 1200);
            }
        }
    };

    var SkyWeather = {
        setTheme: function(theme, btn) {
            var body = document.body;
            body.classList.remove('sky-theme-sunny', 'sky-theme-rainbow', 'sky-theme-starry');
            
            document.querySelectorAll('.sky-selector-widget .radio-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            
            btn.classList.add('active');
            
            if (theme === 'sunny') {
                body.classList.add('sky-theme-sunny');
            } else if (theme === 'rainbow') {
                body.classList.add('sky-theme-rainbow');
            } else if (theme === 'starry') {
                body.classList.add('sky-theme-starry');
            }
        }
    };

    return {
        init: function() {
            var container = document.getElementById('quests');
            var rewardsRaw = container ? container.getAttribute('data-rewards') : '';
            var triviaRaw = container ? container.getAttribute('data-trivia') : '';
            var speechesRaw = container ? container.getAttribute('data-speeches') : '';
            var owlMascot = container ? container.getAttribute('data-owlmascot') : '🦉';
            var petMascotVal = container ? container.getAttribute('data-petmascot') : '🐘';
            var cozyText = container ? container.getAttribute('data-cozytext') : '✨ Sensory Cozy Mode';
            var sparklesText = container ? container.getAttribute('data-sparklestext') : '🌸 Enable Sparkles';
            var scratchHereText = container ? container.getAttribute('data-scratchheretext') : '⭐ SCRATCH HERE ⭐';
            var friendshipLevelUpText = container ? container.getAttribute('data-friendshipleveluptext') : '🎉 Friendship Level Up! We are now level {level}! You are my best friend! 🐘❤️';
            var didYouKnowText = container ? container.getAttribute('data-didyouknowtext') : 'Did you know?';
            
            // Expose Confetti globally for inline onclick actions
            window.GaneshaConfetti = Confetti;
            window.GaneshaChiptune = ChiptuneRadio;
            window.GaneshaSky = SkyWeather;

            // Setup dynamic floating sensory Cozy Mode button if not present in the DOM
            if (!document.querySelector('.sensory-toggle-btn')) {
                var floatingBtn = document.createElement('button');
                floatingBtn.className = 'btn btn-adventure-secondary sensory-toggle-btn floating-sensory-btn';
                floatingBtn.innerHTML = cozyText;
                document.body.appendChild(floatingBtn);
            }

            // 1. Sensory Mode Setup (Cozy vs Sparkle)
            var currentMode = localStorage.getItem('ganesha_sensory_mode') || 'sparkle';
            var body = document.body;
            var toggleBtns = document.querySelectorAll('.sensory-toggle-btn');
            
            function applySensoryMode(mode) {
                if (mode === 'cozy') {
                    body.classList.add('sensory-cozy');
                    toggleBtns.forEach(function(btn) {
                        btn.classList.add('cozy');
                        btn.innerHTML = sparklesText;
                    });
                } else {
                    body.classList.remove('sensory-cozy');
                    toggleBtns.forEach(function(btn) {
                        btn.classList.remove('cozy');
                        btn.innerHTML = cozyText;
                    });
                }
            }
            applySensoryMode(currentMode);

            // Sensory Toggle Event Delegation
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('sensory-toggle-btn')) {
                    e.preventDefault();
                    if (body.classList.contains('sensory-cozy')) {
                        localStorage.setItem('ganesha_sensory_mode', 'sparkle');
                        applySensoryMode('sparkle');
                        Confetti.spawn(e.clientX, e.clientY);
                    } else {
                        localStorage.setItem('ganesha_sensory_mode', 'cozy');
                        applySensoryMode('cozy');
                    }
                }
            });

            // 2. Confetti on Task Complete
            document.addEventListener('click', function(e) {
                if (e.target && (e.target.closest('.completion-dialog button') || e.target.closest('.activity-item .btn-outline-success') || e.target.closest('.btn-success'))) {
                    Confetti.spawn(e.clientX, e.clientY);
                }
            });

            // 3. Password Peek-a-boo (Login Page Mascot)
            var passwordField = document.querySelector('#password, input[type="password"]');
            var mascotImg = document.querySelector('.ganesha-login-mascot');
            var mascotContainer = document.querySelector('.login-mascot-container');

            if (passwordField && mascotImg) {
                var originalSrc = mascotImg.getAttribute('src');
                var peekabooSrc = mascotImg.getAttribute('data-peekaboo');

                passwordField.addEventListener('focus', function() {
                    if (peekabooSrc) {
                        mascotImg.setAttribute('src', peekabooSrc);
                    }
                    mascotImg.classList.add('covering-eyes');
                    if (mascotContainer) mascotContainer.classList.add('covering');
                });

                passwordField.addEventListener('blur', function() {
                    mascotImg.setAttribute('src', originalSrc);
                    mascotImg.classList.remove('covering-eyes');
                    if (mascotContainer) mascotContainer.classList.remove('covering');
                });
            }

            // Parse raw settings variables passed from Moodle PHP
            var rewardsList = [];
            if (rewardsRaw) {
                rewardsList = rewardsRaw.split(',').map(function(item) {
                    var trimmed = item.trim();
                    var firstEmoji = trimmed.match(/^[\uD800-\uDBFF][\uDC00-\uDFFF]|^[\u2600-\u27BF]|^./u);
                    if (firstEmoji) {
                        var emoji = firstEmoji[0];
                        var name = trimmed.substring(emoji.length).trim();
                        return {emoji: emoji, name: name};
                    }
                    return {emoji: '⭐', name: trimmed};
                });
            }
            if (rewardsList.length === 0) {
                rewardsList = [
                    {emoji: '🏆', name: 'SUPER STAR!'},
                    {emoji: '🦄', name: 'MAGICAL UNICORN'},
                    {emoji: '🚀', name: 'SPACE EXPLORER'},
                    {emoji: '🦖', name: 'DINO ADVENTURE'},
                    {emoji: '🍩', name: 'YUMMY DONUT'},
                    {emoji: '🎨', name: 'ART WIZARD'}
                ];
            }

            var triviaList = [];
            if (triviaRaw) {
                triviaList = triviaRaw.split('\n').map(function(l) { return l.trim(); }).filter(function(l) { return l.length > 0; });
            }
            if (triviaList.length === 0) {
                triviaList = [
                    "Did you know? An elephant's trunk has over 40,000 muscles! That's why Ganesha is so super strong!",
                    "Did you know? Honey never spoils! You could eat 3000-year-old honey!",
                    "Did you know? Bananas are berries, but strawberries aren't!",
                    "Did you know? Wombat poop is cube-shaped! This stops it from rolling away!",
                    "Did you know? A day on Venus is longer than a year on Venus!"
                ];
            }

            var petSpeeches = [];
            if (speechesRaw) {
                petSpeeches = speechesRaw.split('\n').map(function(l) { return l.trim(); }).filter(function(l) { return l.length > 0; });
            }
            if (petSpeeches.length === 0) {
                petSpeeches = [
                    "Hello friend! Let's study together today!",
                    "Yum! That Modak was delicious! Thank you! 🍬",
                    "Ooh, that tickles my trunk! Hahaha!",
                    "Friendship level up! We are best friends now! 🐘❤️"
                ];
            }

            // Apply mascots to DOM Elements dynamically
            var owlMascotEl = document.querySelector('.fact-mascot');
            if (owlMascotEl) owlMascotEl.innerText = owlMascot;
            var petMascotEl = document.querySelector('.modak-mascot');
            if (petMascotEl) petMascotEl.innerText = petMascotVal;

            // 4. Scratch Card Controller
            var ScratchCard = {
                canvas: null,
                ctx: null,
                isDrawing: false,
                
                init: function() {
                    this.canvas = document.getElementById('scratch-canvas');
                    if (!this.canvas) return;
                    this.ctx = this.canvas.getContext('2d');
                    this.reset();
                    this.bindEvents();
                },
                
                reset: function() {
                    if (!this.canvas || !this.ctx) return;
                    
                    var prize = rewardsList[Math.floor(Math.random() * rewardsList.length)];
                    var label = document.querySelector('.scratch-prize-label');
                    if (label) {
                        label.innerHTML = '<span style="font-size:2.2rem;">' + prize.emoji + '</span><span style="font-size:0.75rem; margin-top:2px; font-weight:800; color:#ff7e36;">' + prize.name + '</span>';
                    }
                    
                    this.ctx.globalCompositeOperation = 'source-over';
                    this.ctx.fillStyle = '#b5c6d0';
                    this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
                    
                    this.ctx.font = '700 13px Fredoka, sans-serif';
                    this.ctx.fillStyle = '#ffffff';
                    this.ctx.textAlign = 'center';
                    this.ctx.fillText(scratchHereText, this.canvas.width / 2, this.canvas.height / 2 + 5);
                },
                
                scratch: function(x, y) {
                    if (!this.ctx) return;
                    
                    this.ctx.globalCompositeOperation = 'destination-out';
                    this.ctx.beginPath();
                    this.ctx.arc(x, y, 16, 0, Math.PI * 2);
                    this.ctx.fill();
                    
                    // Realistic scratch chime synthesizer tick
                    if (Math.random() < 0.18 && window.GaneshaChiptune) {
                        window.GaneshaChiptune.playTone(880 + (Math.random() - 0.5) * 200, 'sine', window.GaneshaChiptune.audioCtx.currentTime, 0.02, 0.02);
                    }
                },
                
                bindEvents: function() {
                    var self = this;
                    if (!this.canvas) return;
                    
                    var getCoords = function(e) {
                        var rect = self.canvas.getBoundingClientRect();
                        var touch = e.touches ? e.touches[0] : e;
                        return {
                            x: touch.clientX - rect.left,
                            y: touch.clientY - rect.top
                        };
                    };
                    
                    var onStart = function(e) {
                        e.preventDefault();
                        self.isDrawing = true;
                        var coords = getCoords(e);
                        self.scratch(coords.x, coords.y);
                    };
                    
                    var onMove = function(e) {
                        if (!self.isDrawing) return;
                        e.preventDefault();
                        var coords = getCoords(e);
                        self.scratch(coords.x, coords.y);
                    };
                    
                    var onEnd = function() {
                        self.isDrawing = false;
                    };
                    
                    this.canvas.addEventListener('mousedown', onStart);
                    this.canvas.addEventListener('mousemove', onMove);
                    this.canvas.addEventListener('mouseup', onEnd);
                    this.canvas.addEventListener('mouseleave', onEnd);
                    
                    this.canvas.addEventListener('touchstart', onStart);
                    this.canvas.addEventListener('touchmove', onMove);
                    this.canvas.addEventListener('touchend', onEnd);
                }
            };
            window.GaneshaScratch = ScratchCard;
            ScratchCard.init();

            // 5. Speech Owl Controller
            var OwlController = {
                factIndex: 0,
                cycleFact: function(e) {
                    var mascotEl = document.querySelector('.fact-bubble-widget .fact-mascot');
                    var textEl = document.querySelector('.fact-bubble-widget .fact-text');
                    if (!textEl) return;
                    
                    // Play double high-pitch synthesizer chirp
                    if (window.GaneshaChiptune) {
                        var ctx = window.GaneshaChiptune.audioCtx;
                        if (ctx) {
                            window.GaneshaChiptune.playTone(660, 'triangle', ctx.currentTime, 0.04, 0.03);
                            setTimeout(function() {
                                window.GaneshaChiptune.playTone(987, 'sine', ctx.currentTime + 0.04, 0.05, 0.03);
                            }, 40);
                        }
                    }
                    
                    // Bounce and flip the mascot character
                    if (mascotEl) {
                        mascotEl.style.transform = 'rotate(360deg) scale(1.3)';
                        setTimeout(function() {
                            mascotEl.style.transform = '';
                        }, 400);
                    }
                    
                    // Confetti spawn
                    if (window.GaneshaConfetti && e) {
                        window.GaneshaConfetti.spawn(e.clientX, e.clientY);
                    }
                    
                    // Increment trivia cycle
                    this.factIndex = (this.factIndex + 1) % triviaList.length;
                    var rawText = triviaList[this.factIndex];
                    
                    if (rawText.indexOf(didYouKnowText) === 0) {
                        textEl.innerHTML = '<strong>' + didYouKnowText + '</strong>' + rawText.substring(didYouKnowText.length);
                    } else {
                        textEl.innerHTML = rawText;
                    }
                }
            };
            window.GaneshaOwl = OwlController;

            // 6. Virtual Pet Feeder companion
            var PetController = {
                level: 1,
                exp: 0,
                
                init: function() {
                    var savedLevel = localStorage.getItem('ganesha_pet_level');
                    var savedExp = localStorage.getItem('ganesha_pet_exp');
                    if (savedLevel) this.level = parseInt(savedLevel);
                    if (savedExp) this.exp = parseInt(savedExp);
                    this.updateUI();
                },
                
                feed: function(e) {
                    var mascotEl = document.querySelector('.modak-mascot');
                    var bubbleEl = document.getElementById('pet-speech-bubble');
                    if (!bubbleEl) return;
                    
                    // Play sweet retro chiptune chimes
                    if (window.GaneshaChiptune) {
                        var ctx = window.GaneshaChiptune.audioCtx;
                        if (ctx) {
                            window.GaneshaChiptune.playTone(523.25, 'square', ctx.currentTime, 0.08, 0.04);
                            setTimeout(function() {
                                window.GaneshaChiptune.playTone(659.25, 'square', ctx.currentTime + 0.08, 0.08, 0.04);
                                setTimeout(function() {
                                    window.GaneshaChiptune.playTone(987.77, 'square', ctx.currentTime + 0.16, 0.15, 0.04);
                                }, 80);
                            }, 80);
                        }
                    }
                    
                    // Bouncy 3D feedback animation
                    if (mascotEl) {
                        mascotEl.style.transform = 'scale(1.4) translateY(-12px) rotate(8deg)';
                        setTimeout(function() {
                            mascotEl.style.transform = '';
                        }, 300);
                    }
                    
                    // Star confetti trigger
                    if (window.GaneshaConfetti && e) {
                        window.GaneshaConfetti.spawn(e.clientX, e.clientY);
                    }
                    
                    // Friendship EXP increment
                    this.exp += 1;
                    var levelUp = false;
                    if (this.exp >= 5) {
                        this.exp = 0;
                        this.level += 1;
                        levelUp = true;
                        localStorage.setItem('ganesha_pet_level', this.level);
                    }
                    localStorage.setItem('ganesha_pet_exp', this.exp);
                    
                    // Dynamic dialogue rendering
                    if (levelUp) {
                        bubbleEl.innerHTML = '"' + friendshipLevelUpText.replace('{level}', this.level) + '"';
                        if (window.GaneshaChiptune) {
                            setTimeout(function() {
                                var t = window.GaneshaChiptune.audioCtx.currentTime;
                                window.GaneshaChiptune.playTone(523.25, 'sine', t, 0.1, 0.06);
                                window.GaneshaChiptune.playTone(659.25, 'sine', t + 0.1, 0.1, 0.06);
                                window.GaneshaChiptune.playTone(783.99, 'sine', t + 0.2, 0.1, 0.06);
                                window.GaneshaChiptune.playTone(1046.5, 'sine', t + 0.3, 0.4, 0.08);
                            }, 300);
                        }
                    } else {
                        var speech = petSpeeches[Math.floor(Math.random() * petSpeeches.length)];
                        bubbleEl.innerHTML = '"' + speech + '"';
                    }
                    
                    this.updateUI();
                },
                
                updateUI: function() {
                    var lvl = document.getElementById('buddy-level');
                    var exp = document.getElementById('buddy-exp');
                    if (lvl) lvl.innerText = this.level;
                    if (exp) exp.innerText = this.exp;
                }
            };
            window.GaneshaPet = PetController;
            PetController.init();
        }
    };
});
