/**
 * Kulier Wood — global behaviors.
 * Mobile menu, cart count sync, image reveal (reduced-motion aware).
 */
(function () {
	'use strict';
	document.documentElement.classList.add('js');

	// Mobile menu (mirrors "Mobile navigation · Open state" frame).
	var toggle = document.querySelector('.kw-menu-toggle');
	var close = document.querySelector('.kw-menu-close');
	var menu = document.getElementById('kw-mobile-menu');
	var savedOverflow = '';
	var background = document.querySelectorAll('.kw-header, .kw-site-main, .kw-footer');

	function setBackgroundInert(value) {
		background.forEach(function (element) { element.inert = value; });
	}

	function trapFocus(e, container) {
		if (e.key !== 'Tab') return;
		var links = Array.from(container.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select, textarea, [tabindex="0"]')).filter(function (el) { return el.getClientRects().length; });
		if (!links.length) return;
		var first = links[0];
		var last = links[links.length - 1];
		if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
		if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
	}

	function openMenu() {
		if (!menu) return;
		menu.hidden = false;
		savedOverflow = document.body.style.overflow;
		document.body.style.overflow = 'hidden';
		setBackgroundInert(true);
		if (toggle) toggle.setAttribute('aria-expanded', 'true');
		if (close) close.focus();
	}

	function closeMenu() {
		if (!menu) return;
		menu.hidden = true;
		document.body.style.overflow = savedOverflow;
		setBackgroundInert(false);
		if (toggle) {
			toggle.setAttribute('aria-expanded', 'false');
			toggle.focus();
		}
	}

	if (toggle) toggle.addEventListener('click', openMenu);
	if (close) close.addEventListener('click', closeMenu);
	if (menu) menu.addEventListener('click', function (e) { if (e.target.closest('a[href]')) closeMenu(); });
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && menu && !menu.hidden) closeMenu();
		if (menu && !menu.hidden) trapFocus(e, menu);
	});
	window.matchMedia('(min-width: 1025px)').addEventListener('change', function (e) { if (e.matches && menu && !menu.hidden) closeMenu(); });

	// Restrained image reveal per the design's motion spec.
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var targets = document.querySelectorAll('.kw-reveal');
	if (!reduce && 'IntersectionObserver' in window && targets.length) {
		var io = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-visible');
						entry.target.classList.remove('is-pending');
						io.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.15 }
		);
		targets.forEach(function (t) { if (t.getBoundingClientRect().top > window.innerHeight) t.classList.add('is-pending'); io.observe(t); });
	} else {
		targets.forEach(function (t) { t.classList.add('is-visible'); });
	}

	// Keep header cart count in sync after WooCommerce AJAX updates.
	function refreshCartCount() {
		var el = document.querySelector('.kw-cart-count');
		if (!el || !window.kulierData) return;
		fetch(kulierData.ajaxUrl + '?action=kulier_cart_count', { credentials: 'same-origin', cache: 'no-store' })
			.then(function (res) { if (!res.ok) throw new Error('Cart count unavailable'); return res.json(); })
			.then(function (res) {
				if (res.success && res.data && Number.isFinite(Number(res.data.count))) {
					var count = Number(res.data.count);
					el.textContent = count;
					el.classList.toggle('is-empty', !count);
				}
			}).catch(function () { /* Keep the server-rendered count when the network is unavailable. */ });
	}

	if (window.jQuery) jQuery(document.body).on('wc_fragments_refreshed added_to_cart removed_from_cart updated_wc_div updated_cart_totals', refreshCartCount);
	['wc-blocks_added_to_cart', 'wc-blocks_removed_from_cart'].forEach(function (event) { document.body.addEventListener(event, refreshCartCount); });
	window.addEventListener('pageshow', refreshCartCount);

	function imageError(img) {
		if (img.parentElement.querySelector('.kw-image-error')) return;
		var note = document.createElement('span');
		note.className = 'kw-image-error';
		note.textContent = 'This image could not load. ';
		if (img.closest('a')) {
			note.textContent += 'You can still open this item.';
			img.parentElement.appendChild(note);
			return;
		}
		var retry = document.createElement('button');
		retry.type = 'button';
		retry.textContent = 'Retry image';
		retry.addEventListener('click', function (e) {
			e.preventDefault();
			e.stopPropagation();
			note.remove();
			var source = new URL(img.currentSrc || img.src, location.href);
			source.searchParams.set('retry', Date.now());
			img.removeAttribute('srcset');
			img.src = source.href;
		});
		note.appendChild(retry);
		img.parentElement.appendChild(note);
	}
	document.addEventListener('error', function (e) { if (e.target.tagName === 'IMG') imageError(e.target); }, true);
	document.querySelectorAll('img').forEach(function (img) { if (img.complete && !img.naturalWidth) imageError(img); });

	var dialog = document.querySelector('.kw-product-dialog');
	if (dialog && typeof dialog.showModal === 'function') {
		var dialogBody = dialog.querySelector('.kw-product-dialog__body');
		var request;
		var lastTrigger;
		var dialogOverflow;
		dialog.querySelector('.kw-detail-close').addEventListener('click', function () { dialog.close(); });
		dialog.addEventListener('click', function (e) {
			var box = dialog.getBoundingClientRect();
			if (e.target === dialog && (e.clientX < box.left || e.clientX > box.right || e.clientY < box.top || e.clientY > box.bottom)) dialog.close();
		});
		dialog.addEventListener('close', function () {
			if (request) request.abort();
			document.body.style.overflow = dialogOverflow;
			if (lastTrigger) lastTrigger.focus();
		});
		document.addEventListener('click', function (e) {
			var link = e.target.closest('a[data-product-detail]');
			if (!link || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || new URL(link.href).origin !== location.origin) return;
			e.preventDefault();
			lastTrigger = link;
			if (request) request.abort();
			request = new AbortController();
			var activeRequest = request;
			dialogOverflow = document.body.style.overflow;
			document.body.style.overflow = 'hidden';
			dialog.removeAttribute('aria-labelledby');
			dialogBody.replaceChildren();
			var loading = document.createElement('p');
			loading.textContent = 'Loading product details…';
			dialogBody.appendChild(loading);
			dialog.showModal();
			fetch(link.href, { signal: activeRequest.signal, credentials: 'same-origin' })
				.then(function (res) { if (!res.ok) throw new Error('Product unavailable'); return res.text(); })
				.then(function (html) {
					if (activeRequest.signal.aborted) return;
					var page = new DOMParser().parseFromString(html, 'text/html');
					var detail = page.querySelector('.kw-detail');
					if (!detail) throw new Error('Product unavailable');
					detail.querySelectorAll('.kw-detail__commerce, .kw-detail__content, script').forEach(function (el) { el.remove(); });
					var media = detail.querySelector('.kw-detail__media');
					var img = media && (media.querySelector('.wp-post-image') || media.querySelector('img'));
					if (img) { img = img.cloneNode(true); img.loading = 'eager'; media.replaceChildren(img); }
					var heading = detail.querySelector('h1');
					if (heading) { heading.id = 'kw-dialog-product-title'; dialog.setAttribute('aria-labelledby', heading.id); }
					var back = detail.querySelector('.kw-detail__nav a');
					if (back) back.addEventListener('click', function (event) { event.preventDefault(); dialog.close(); });
					var purchase = document.createElement('a');
					purchase.href = link.href;
					purchase.className = 'kw-detail__purchase-link';
					purchase.textContent = 'View price & purchase';
					detail.querySelector('.kw-detail__info').appendChild(purchase);
					dialogBody.replaceChildren(detail);
					dialog.scrollTop = 0;
				})
				.catch(function (error) {
					if (error.name === 'AbortError') return;
					var message = document.createElement('p');
					message.textContent = 'Product details could not load. ';
					var fallback = document.createElement('a');
					fallback.href = link.href;
					fallback.textContent = 'Open product page';
					message.appendChild(fallback);
					dialogBody.replaceChildren(message);
				});
		});
	}
})();
