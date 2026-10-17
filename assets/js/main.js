/**
 * Kulier Wood — global behaviors.
 * Mobile menu, cart count sync, image reveal (reduced-motion aware).
 */
(function () {
	'use strict';

	// Mobile menu (mirrors "Mobile navigation · Open state" frame).
	var toggle = document.querySelector('.kw-menu-toggle');
	var close = document.querySelector('.kw-menu-close');
	var menu = document.getElementById('kw-mobile-menu');

	function openMenu() {
		if (!menu) return;
		menu.hidden = false;
		document.body.style.overflow = 'hidden';
		if (toggle) toggle.setAttribute('aria-expanded', 'true');
		if (close) close.focus();
	}

	function closeMenu() {
		if (!menu) return;
		menu.hidden = true;
		document.body.style.overflow = '';
		if (toggle) {
			toggle.setAttribute('aria-expanded', 'false');
			toggle.focus();
		}
	}

	if (toggle) toggle.addEventListener('click', openMenu);
	if (close) close.addEventListener('click', closeMenu);
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && menu && !menu.hidden) closeMenu();
	});

	// Restrained image reveal per the design's motion spec.
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var targets = document.querySelectorAll('.kw-reveal');
	if (!reduce && 'IntersectionObserver' in window && targets.length) {
		var io = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-visible');
						io.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.15 }
		);
		targets.forEach(function (t) { io.observe(t); });
	} else {
		targets.forEach(function (t) { t.classList.add('is-visible'); });
	}

	// Keep header cart count in sync after WooCommerce AJAX updates.
	function refreshCartCount() {
		var el = document.querySelector('.kw-cart-count');
		if (!el || !window.jQuery) return;
		var frag = document.createElement('div');
		jQuery.ajax({
			url: kulierData.ajaxUrl,
			data: { action: 'kulier_cart_count', nonce: kulierData.cartNonce },
			method: 'POST'
		}).done(function (res) {
			if (res && typeof res.count !== 'undefined') {
				el.textContent = res.count;
				el.classList.toggle('is-empty', !res.count);
			}
		});
	}

	jQuery(document.body).on('wc_fragments_refreshed added_to_cart removed_from_cart', refreshCartCount);
})();
