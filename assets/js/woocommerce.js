/**
 * Kulier Wood — WooCommerce page behaviors.
 * Quantity steppers with stock limits; gallery thumb focus.
 */
(function () {
	'use strict';

	document.addEventListener('click', function (e) {
		var btn = e.target.closest('.kw-qty-step');
		if (!btn) return;
		var wrap = btn.closest('.quantity');
		var input = wrap && wrap.querySelector('input.qty');
		if (!input) return;
		var step = parseFloat(input.step) || 1;
		var min = input.min !== '' ? parseFloat(input.min) : 0;
		var max = input.max !== '' && input.max !== '-1' ? parseFloat(input.max) : Infinity;
		var val = parseFloat(input.value) || 0;
		val = btn.dataset.dir === 'up' ? val + step : val - step;
		input.value = Math.min(Math.max(val, min), max);
		input.dispatchEvent(new Event('change', { bubbles: true }));
	});

	// Keyboard focus on variation/gallery thumbnails.
	document.querySelectorAll('.flex-control-thumbs img').forEach(function (thumb) {
		thumb.setAttribute('tabindex', '0');
		thumb.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				thumb.click();
			}
		});
	});
})();
