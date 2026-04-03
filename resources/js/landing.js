/**
 * Landing Page Alpine.js Components
 * ============================================
 * Custom components for school landing page animations
 */

document.addEventListener('alpine:init', () => {
    /**
     * Navbar Component
     * Handles scroll-based visibility and glass effect
     */
    Alpine.data('navbar', () => ({
        hidden: false,
        scrolled: false,
        lastScrollY: 0,
        mobileMenuOpen: false,

        init() {
            this.handleScroll();
            window.addEventListener('scroll', () => this.handleScroll(), { passive: true });
        },

        handleScroll() {
            const currentScrollY = window.scrollY;

            // Add glass effect when scrolled
            this.scrolled = currentScrollY > 50;

            // Hide navbar on scroll down, show on scroll up
            if (currentScrollY > this.lastScrollY && currentScrollY > 150) {
                this.hidden = true;
            } else {
                this.hidden = false;
            }

            this.lastScrollY = currentScrollY;
        },

        toggleMobileMenu() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
        },

        closeMobileMenu() {
            this.mobileMenuOpen = false;
        }
    }));

    /**
     * Counter Animation Component
     * Animates number counting up when in viewport
     */
    Alpine.data('counter', (target, suffix = '') => ({
        count: 0,
        target: parseInt(target) || 0,
        suffix: suffix,
        animated: false,
        duration: 2500,

        get displayValue() {
            return this.count.toLocaleString() + this.suffix;
        },

        animateCount() {
            if (this.animated) return;
            this.animated = true;

            const startTime = performance.now();
            const startValue = 0;

            const updateCount = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / this.duration, 1);

                // Easing function for smooth animation
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);

                this.count = Math.floor(easeOutQuart * this.target);

                if (progress < 1) {
                    requestAnimationFrame(updateCount);
                } else {
                    this.count = this.target;
                }
            };

            requestAnimationFrame(updateCount);
        }
    }));

    /**
     * Scroll Reveal Component
     * Triggers animation when element enters viewport
     */
    Alpine.data('scrollReveal', (delay = 0) => ({
        shown: false,
        delay: delay,

        reveal() {
            if (!this.shown) {
                setTimeout(() => {
                    this.shown = true;
                }, this.delay);
            }
        }
    }));

    /**
     * Stat Counter with Scroll Reveal
     * Combined component to avoid getter issues with spreading
     */
    Alpine.data('statCounter', (target, suffix = '', delay = 0) => ({
        // Counter properties
        count: 0,
        target: parseInt(target) || 0,
        suffix: suffix,
        animated: false,
        duration: 2500,

        // Scroll reveal properties
        shown: false,
        delay: delay,

        get displayValue() {
            return this.count.toLocaleString() + this.suffix;
        },

        reveal() {
            if (!this.shown) {
                setTimeout(() => {
                    this.shown = true;
                }, this.delay);
            }
        },

        animateCount() {
            if (this.animated) return;
            this.animated = true;

            const startTime = performance.now();

            const updateCount = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / this.duration, 1);

                const easeOutQuart = 1 - Math.pow(1 - progress, 4);

                this.count = Math.floor(easeOutQuart * this.target);

                if (progress < 1) {
                    requestAnimationFrame(updateCount);
                } else {
                    this.count = this.target;
                }
            };

            requestAnimationFrame(updateCount);
        }
    }));

    /**
     * Login Dropdown Component
     */
    Alpine.data('loginDropdown', () => ({
        open: false,

        toggle() {
            this.open = !this.open;
        },

        close() {
            this.open = false;
        }
    }));

    /**
     * Parallax Effect Component
     * Creates subtle parallax movement on scroll
     */
    Alpine.data('parallax', (speed = 0.5) => ({
        offset: 0,
        speed: speed,

        init() {
            window.addEventListener('scroll', () => this.handleScroll(), { passive: true });
        },

        handleScroll() {
            const scrolled = window.scrollY;
            this.offset = scrolled * this.speed;
        }
    }));

    /**
     * Typewriter Effect Component
     */
    Alpine.data('typewriter', (texts, typingSpeed = 100, deletingSpeed = 50, pauseTime = 2000) => ({
        displayText: '',
        texts: texts,
        currentTextIndex: 0,
        currentCharIndex: 0,
        isDeleting: false,
        isPaused: false,

        init() {
            this.type();
        },

        type() {
            const currentText = this.texts[this.currentTextIndex];

            if (!this.isDeleting) {
                this.displayText = currentText.substring(0, this.currentCharIndex + 1);
                this.currentCharIndex++;

                if (this.currentCharIndex === currentText.length) {
                    this.isPaused = true;
                    setTimeout(() => {
                        this.isPaused = false;
                        this.isDeleting = true;
                        this.type();
                    }, pauseTime);
                    return;
                }
            } else {
                this.displayText = currentText.substring(0, this.currentCharIndex - 1);
                this.currentCharIndex--;

                if (this.currentCharIndex === 0) {
                    this.isDeleting = false;
                    this.currentTextIndex = (this.currentTextIndex + 1) % this.texts.length;
                }
            }

            const speed = this.isDeleting ? deletingSpeed : typingSpeed;
            setTimeout(() => this.type(), speed);
        }
    }));

    /**
     * Scroll Progress Component
     * Shows scroll progress at the top of the page
     */
    Alpine.data('scrollProgress', () => ({
        progress: 0,

        init() {
            window.addEventListener('scroll', () => this.updateProgress(), { passive: true });
        },

        updateProgress() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            this.progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        }
    }));

    /**
     * Back to Top Component
     */
    Alpine.data('backToTop', () => ({
        visible: false,

        init() {
            window.addEventListener('scroll', () => this.checkVisibility(), { passive: true });
        },

        checkVisibility() {
            this.visible = window.scrollY > 500;
        },

        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    }));

    /**
     * Feature Card Hover Effect
     */
    Alpine.data('featureCard', () => ({
        isHovered: false,
        mouseX: 0,
        mouseY: 0,

        handleMouseMove(event) {
            const rect = event.currentTarget.getBoundingClientRect();
            this.mouseX = event.clientX - rect.left;
            this.mouseY = event.clientY - rect.top;
        },

        handleMouseEnter() {
            this.isHovered = true;
        },

        handleMouseLeave() {
            this.isHovered = false;
        }
    }));
});
