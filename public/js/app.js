/**
 * GreenHaven - Laravel Plant E-Commerce
 * Main JavaScript File
 */

// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    initQuantityInputs();
    initWishlistButtons();
    initToastMessages();
    initMobileMenu();
});

/**
 * Quantity Input Handlers
 */
function initQuantityInputs() {
    document.querySelectorAll('.quantity-input').forEach(container => {
        const input = container.querySelector('input[type="number"]');
        const minusBtn = container.querySelector('.minus');
        const plusBtn = container.querySelector('.plus');
        
        if (!input) return;

        if (minusBtn) {
            minusBtn.addEventListener('click', () => {
                let val = parseInt(input.value) || 1;
                if (val > 1) {
                    input.value = val - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }

        if (plusBtn) {
            plusBtn.addEventListener('click', () => {
                let val = parseInt(input.value) || 1;
                if (val < 99) {
                    input.value = val + 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }
    });
}

/**
 * Wishlist Toggle
 */
function initWishlistButtons() {
    document.querySelectorAll('.btn-wishlist, .btn-wishlist-detail').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            if (!productId) return;

            const icon = this.querySelector('i');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => {
                if (response.status === 401) {
                    return response.json().then(data => {
                        if (typeof toggleLoginModal === 'function') {
                            toggleLoginModal();
                        } else {
                            window.location.href = data.redirect || '/login';
                        }
                    });
                }
                return response.json();
            })
            .then(data => {
                if (!data || !data.success) return;

                const isAdded = data.status === 'added';

                // Update this button
                if (icon) {
                    if (isAdded) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                }
                this.classList.toggle('active', isAdded);

                // Update any other wishlist buttons for the same product
                document.querySelectorAll('.btn-wishlist[data-product-id="' + productId + '"], .btn-wishlist-detail[data-product-id="' + productId + '"]').forEach(otherBtn => {
                    if (otherBtn !== this) {
                        const otherIcon = otherBtn.querySelector('i');
                        if (otherIcon) {
                            if (isAdded) {
                                otherIcon.classList.remove('far');
                                otherIcon.classList.add('fas');
                            } else {
                                otherIcon.classList.remove('fas');
                                otherIcon.classList.add('far');
                            }
                        }
                        otherBtn.classList.toggle('active', isAdded);
                    }
                });

                // Update wishlist badge count
                const badge = document.getElementById('wishlist-badge');
                if (badge && data.count !== undefined) {
                    badge.textContent = data.count;
                }

                showToast(data.message, 'success');
            })
            .catch(error => console.error('Error:', error));
        });
    });
}

/**
 * Toast Notification
 */
function showToast(message, type = 'success') {
    const existing = document.querySelector('.toast-notification');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = `
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: ${type === 'success' ? '#1f2937' : '#ef4444'};
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        z-index: 9999;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    `;
    
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    requestAnimationFrame(() => {
        toast.style.transform = 'translateX(-50%) translateY(0)';
    });
    
    setTimeout(() => {
        toast.style.transform = 'translateX(-50%) translateY(100px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/**
 * Initialize Toast Messages from Session
 */
function initToastMessages() {
    const successMessage = document.querySelector('meta[name="success-message"]');
    const errorMessage = document.querySelector('meta[name="error-message"]');
    
    if (successMessage) {
        showToast(successMessage.content, 'success');
    }
    
    if (errorMessage) {
        showToast(errorMessage.content, 'error');
    }
}

/**
 * Mobile Menu Toggle
 */
function initMobileMenu() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileMenuBtn && navMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    }
}

/**
 * AJAX Helper for Laravel
 */
function ajax(url, method = 'GET', data = null) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    return fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: data ? JSON.stringify(data) : null
    })
    .then(response => response.json())
    .catch(error => console.error('Error:', error));
}

// Export functions for global access
window.GreenHaven = {
    showToast,
    ajax
};
