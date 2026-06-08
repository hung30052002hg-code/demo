/**
 * CHUS TEA - Premium Bubble Tea E-Commerce
 * Main Application JavaScript
 */

(function () {
    'use strict';

    // =====================================================
    // CONFIG
    // =====================================================
    const cssLink = document.querySelector('link[rel="stylesheet"][href*="style.css"]')?.getAttribute('href') || '';
    const cssPath = cssLink.split('?')[0];
    const BASE_URL = cssPath.replace('public/css/style.css', '') || '/Shoptrasua/';

    // =====================================================
    // 1. INTERSECTION OBSERVER - SCROLL ANIMATIONS
    // =====================================================
    function initScrollAnimations() {
        const elements = document.querySelectorAll('[data-animate]');
        if (!elements.length) return;

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const delay = el.dataset.delay || 0;
                        setTimeout(() => {
                            el.classList.add('animated');
                        }, parseInt(delay));
                        observer.unobserve(el);
                    }
                });
            },
            {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px',
            }
        );

        elements.forEach((el) => {
            el.classList.add('animate-on-scroll');
            observer.observe(el);
        });
    }

    // =====================================================
    // 2. MOBILE MENU
    // =====================================================
    function initMobileMenu() {
        const menuBtn = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');
        const closeBtn = document.getElementById('mobileMenuClose');
        const backdrop = document.getElementById('mobileMenuBackdrop');

        if (!menuBtn || !menu) return;

        function openMenu() {
            menu.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            menu.classList.remove('active');
            document.body.style.overflow = '';
        }

        menuBtn.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (backdrop) backdrop.addEventListener('click', closeMenu);

        // Close on nav link click
        menu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', closeMenu);
        });

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && menu.classList.contains('active')) {
                closeMenu();
            }
        });
    }

    // =====================================================
    // 3. AJAX CART OPERATIONS
    // =====================================================
    function addToCart(productId, quantity = 1, size = 'M') {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        formData.append('size', size);

        fetch(BASE_URL + 'index.php?controller=cart&action=add', {
            method: 'POST',
            body: formData,
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    updateCartBadge(data.cartCount);
                    showToast(data.message || 'Đã thêm vào giỏ hàng!', 'success');
                } else {
                    showToast(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch((err) => {
                console.error(err);
                showToast('Không thể kết nối đến máy chủ!', 'error');
            });
    }

    function addToCartWithOptions(productId, quantity = 1, size = 'M', ice = '100%', sugar = '100%', toppings = []) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        formData.append('size', size);
        formData.append('ice', ice);
        formData.append('sugar', sugar);
        toppings.forEach(id => {
            formData.append('toppings[]', id);
        });

        fetch(BASE_URL + 'index.php?controller=cart&action=add', {
            method: 'POST',
            body: formData,
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    updateCartBadge(data.cartCount);
                    showToast(data.message || 'Đã thêm vào giỏ hàng!', 'success');
                } else {
                    showToast(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch((err) => {
                console.error(err);
                showToast('Không thể kết nối đến máy chủ!', 'error');
            });
    }

    function updateCartQuantity(productId, quantity) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch(BASE_URL + 'index.php?controller=cart&action=update', {
            method: 'POST',
            body: formData,
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    updateCartBadge(data.cartCount);
                    if (data.lineTotal !== undefined) {
                        const lineTotalEl = document.querySelector(`[data-line-total="${productId}"]`);
                        if (lineTotalEl) lineTotalEl.textContent = formatPrice(data.lineTotal);
                    }
                    if (data.cartTotal !== undefined) {
                        const cartTotalEl = document.getElementById('cartTotal');
                        const subtotalEl = document.getElementById('cartSubtotal');
                        if (cartTotalEl) cartTotalEl.textContent = formatPrice(data.cartTotal);
                        if (subtotalEl) subtotalEl.textContent = formatPrice(data.cartTotal);
                    }
                    showToast('Cập nhật giỏ hàng thành công!', 'success');
                } else {
                    showToast(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch((err) => {
                console.error(err);
                showToast('Lỗi kết nối máy chủ!', 'error');
            });
    }

    function removeFromCart(productId) {
        const formData = new FormData();
        formData.append('product_id', productId);

        fetch(BASE_URL + 'index.php?controller=cart&action=remove', {
            method: 'POST',
            body: formData,
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    updateCartBadge(data.cartCount);
                    // Remove item element with animation
                    const itemEl = document.querySelector(`[data-cart-item="${productId}"]`);
                    if (itemEl) {
                        itemEl.style.transform = 'translateX(100%)';
                        itemEl.style.opacity = '0';
                        setTimeout(() => {
                            itemEl.remove();
                            // Check if cart is empty
                            const remaining = document.querySelectorAll('[data-cart-item]');
                            if (remaining.length === 0) {
                                location.reload();
                            }
                        }, 300);
                    }
                    if (data.cartTotal !== undefined) {
                        const cartTotalEl = document.getElementById('cartTotal');
                        const subtotalEl = document.getElementById('cartSubtotal');
                        if (cartTotalEl) cartTotalEl.textContent = formatPrice(data.cartTotal);
                        if (subtotalEl) subtotalEl.textContent = formatPrice(data.cartTotal);
                    }
                    showToast('Đã xoá sản phẩm khỏi giỏ hàng!', 'success');
                } else {
                    showToast(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch((err) => {
                console.error(err);
                showToast('Lỗi kết nối máy chủ!', 'error');
            });
    }

    function updateCartBadge(count) {
        const badge = document.getElementById('cartBadge');
        if (!badge) return;

        badge.textContent = count;
        if (count > 0) {
            badge.style.transform = 'scale(0)';
            badge.classList.remove('scale-0');
            badge.classList.add('scale-100');
            requestAnimationFrame(() => {
                badge.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    badge.style.transform = 'scale(1)';
                }, 200);
            });
        } else {
            badge.classList.remove('scale-100');
            badge.classList.add('scale-0');
        }
    }

    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
    }

    // Expose cart functions globally
    window.addToCart = addToCart;
    window.addToCartWithOptions = addToCartWithOptions;
    window.updateCartQuantity = updateCartQuantity;
    window.removeFromCart = removeFromCart;

    // =====================================================
    // 4. TOAST NOTIFICATION SYSTEM
    // =====================================================
    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const icons = {
            success: `<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            error: `<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            info: `<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        };

        const toast = document.createElement('div');
        toast.className = `toast toast-${type} rounded-xl px-5 py-4 backdrop-blur-xl flex items-center gap-3 shadow-2xl`;
        toast.innerHTML = `
            ${icons[type] || icons.info}
            <p class="text-sm font-medium flex-1">${message}</p>
            <button onclick="this.parentElement.classList.add('toast-exit');setTimeout(()=>this.parentElement.remove(),300)" 
                    class="opacity-50 hover:opacity-100 transition-opacity ml-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;

        container.appendChild(toast);

        // Auto remove after 3.5s
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('toast-exit');
                setTimeout(() => toast.remove(), 300);
            }
        }, 3500);
    }

    window.showToast = showToast;

    // =====================================================
    // 5. QUANTITY SELECTOR
    // =====================================================
    function initQuantityControls() {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-qty-btn]');
            if (!btn) return;

            const action = btn.dataset.qtyBtn;
            const container = btn.closest('[data-qty-container]');
            if (!container) return;

            const input = container.querySelector('[data-qty-input]');
            if (!input) return;

            let value = parseInt(input.value) || 1;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 99;

            if (action === 'minus' && value > min) {
                value--;
            } else if (action === 'plus' && value < max) {
                value++;
            }

            input.value = value;

            // Trigger change event for cart updates
            input.dispatchEvent(new Event('change', { bubbles: true }));

            // Button press animation
            btn.style.transform = 'scale(0.85)';
            setTimeout(() => {
                btn.style.transform = '';
            }, 150);
        });

        // Handle manual input
        document.addEventListener('change', (e) => {
            const input = e.target.closest('[data-qty-input]');
            if (!input) return;

            let value = parseInt(input.value) || 1;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 99;

            value = Math.max(min, Math.min(max, value));
            input.value = value;

            // If in cart, update via AJAX
            const productId = input.dataset.productId;
            if (productId) {
                updateCartQuantity(productId, value);
            }
        });
    }

    // =====================================================
    // 6. STICKY HEADER SHADOW ON SCROLL
    // =====================================================
    function initStickyHeader() {
        const navbar = document.getElementById('navbar');
        if (!navbar) return;

        let lastScrollY = 0;
        let ticking = false;

        function onScroll() {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
            lastScrollY = window.scrollY;
            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(onScroll);
                ticking = true;
            }
        }, { passive: true });
    }

    // =====================================================
    // 7. SMOOTH SCROLL FOR ANCHOR LINKS
    // =====================================================
    function initSmoothScroll() {
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a[href^="#"]');
            if (!link) return;

            const target = document.querySelector(link.getAttribute('href'));
            if (!target) return;

            e.preventDefault();
            const navHeight = document.getElementById('navbar')?.offsetHeight || 80;
            const top = target.getBoundingClientRect().top + window.scrollY - navHeight - 20;
            window.scrollTo({ top, behavior: 'smooth' });
        });
    }

    // =====================================================
    // 8. LOGIN/REGISTER TAB SWITCHING
    // =====================================================
    function initTabSwitcher() {
        const tabBtns = document.querySelectorAll('[data-tab-btn]');
        const tabContents = document.querySelectorAll('[data-tab-content]');

        if (!tabBtns.length) return;

        tabBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                const target = btn.dataset.tabBtn;

                // Update buttons
                tabBtns.forEach((b) => b.classList.remove('tab-active'));
                btn.classList.add('tab-active');

                // Update content
                tabContents.forEach((c) => {
                    c.classList.remove('active');
                    if (c.dataset.tabContent === target) {
                        c.classList.add('active');
                    }
                });
            });
        });
    }

    // =====================================================
    // 9. PRODUCT SIZE SELECTOR
    // =====================================================
    function initSizeSelector() {
        document.addEventListener('change', (e) => {
            const radio = e.target.closest('input[name="size"]');
            if (!radio) return;

            const priceEl = document.getElementById('productPrice');
            if (!priceEl) return;

            const price = parseInt(radio.dataset.price) || 0;
            priceEl.textContent = formatPrice(price);
            priceEl.style.transform = 'scale(1.1)';
            setTimeout(() => {
                priceEl.style.transform = 'scale(1)';
            }, 200);
        });
    }

    // =====================================================
    // 10. SEARCH TOGGLE
    // =====================================================
    function initSearchToggle() {
        const toggle = document.getElementById('searchToggle');
        const searchBar = document.getElementById('searchBar');

        if (!toggle || !searchBar) return;

        toggle.addEventListener('click', () => {
            searchBar.classList.toggle('hidden');
            if (!searchBar.classList.contains('hidden')) {
                const input = searchBar.querySelector('input');
                if (input) {
                    setTimeout(() => input.focus(), 100);
                }
            }
        });

        // Close search on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !searchBar.classList.contains('hidden')) {
                searchBar.classList.add('hidden');
            }
        });
    }

    // =====================================================
    // 11. HERO PARALLAX EFFECT (SUBTLE)
    // =====================================================
    function initHeroParallax() {
        const hero = document.querySelector('.hero-section');
        if (!hero) return;

        let ticking = false;

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    const scrolled = window.scrollY;
                    const heroHeight = hero.offsetHeight;

                    if (scrolled < heroHeight) {
                        const bubbles = hero.querySelectorAll('.hero-bubble');
                        bubbles.forEach((bubble, i) => {
                            const speed = 0.03 + i * 0.01;
                            bubble.style.transform = `translateY(${scrolled * speed}px)`;
                        });

                        const content = hero.querySelector('.hero-content');
                        if (content) {
                            content.style.transform = `translateY(${scrolled * 0.15}px)`;
                            content.style.opacity = 1 - scrolled / heroHeight;
                        }
                    }
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }

    // =====================================================
    // 12. ADD TO CART BUTTON HANDLERS (Event Delegation)
    // =====================================================
    function initAddToCartButtons() {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-add-to-cart]');
            if (!btn) return;

            e.preventDefault();
            const productId = btn.dataset.addToCart;
            const quantityInput = document.querySelector('[data-qty-input]');
            const sizeInput = document.querySelector('input[name="size"]:checked');

            const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
            const size = sizeInput ? sizeInput.value : 'M';

            // Button animation
            btn.style.transform = 'scale(0.95)';
            const originalText = btn.innerHTML;
            btn.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
            btn.disabled = true;

            setTimeout(() => {
                addToCart(productId, quantity, size);
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.style.transform = '';
            }, 500);
        });
    }

    // =====================================================
    // 13. REMOVE FROM CART BUTTON HANDLERS
    // =====================================================
    function initRemoveFromCartButtons() {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-remove-from-cart]');
            if (!btn) return;

            e.preventDefault();
            const productId = btn.dataset.removeFromCart;
            removeFromCart(productId);
        });
    }

    // =====================================================
    // 14. PAGE LOAD ANIMATION
    // =====================================================
    function initPageLoad() {
        document.body.style.opacity = '0';
        requestAnimationFrame(() => {
            document.body.style.transition = 'opacity 0.4s ease';
            document.body.style.opacity = '1';
        });
    }
    // =====================================================
    // 13.5. THEME TOGGLE (LIGHT/DARK MODE)
    // =====================================================
    function initThemeToggle() {
        const toggleBtn = document.getElementById('themeToggle');
        if (!toggleBtn) return;

        toggleBtn.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // =====================================================
    // 13.6. HERO SLIDER CAROUSEL
    // =====================================================
    function initHeroSlider() {
        const slider = document.getElementById('hero-slider');
        if (!slider) return;

        const slides = slider.querySelectorAll('.hero-slide');
        const contents = document.querySelectorAll('.hero-content-item');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        const indicators = document.querySelectorAll('.slide-indicator');

        if (!slides.length) return;

        let currentIdx = 0;
        let slideInterval;

        function showSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            indicators.forEach(i => {
                i.classList.remove('bg-primary', 'w-8');
                i.classList.add('bg-white/20', 'w-3');
            });

            slides[index].classList.add('active');
            contents[index].classList.add('active');
            indicators[index].classList.remove('bg-white/20', 'w-3');
            indicators[index].classList.add('bg-primary', 'w-8');

            currentIdx = index;
        }

        function nextSlide() {
            let next = (currentIdx + 1) % slides.length;
            showSlide(next);
        }

        function prevSlide() {
            let prev = (currentIdx - 1 + slides.length) % slides.length;
            showSlide(prev);
        }

        function startAutoPlay() {
            stopAutoPlay();
            slideInterval = setInterval(nextSlide, 5000);
        }

        function stopAutoPlay() {
            if (slideInterval) clearInterval(slideInterval);
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                startAutoPlay();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                startAutoPlay();
            });
        }

        indicators.forEach(indicator => {
            indicator.addEventListener('click', () => {
                const to = parseInt(indicator.dataset.to) || 0;
                showSlide(to);
                startAutoPlay();
            });
        });

        startAutoPlay();
    }

    // =====================================================
    // INIT ALL ON DOM READY
    // =====================================================
    function init() {
        initPageLoad();
        initScrollAnimations();
        initMobileMenu();
        initStickyHeader();
        initSmoothScroll();
        initQuantityControls();
        initTabSwitcher();
        initSizeSelector();
        initSearchToggle();
        initHeroParallax();
        initAddToCartButtons();
        initRemoveFromCartButtons();
        initThemeToggle();
        initHeroSlider();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
