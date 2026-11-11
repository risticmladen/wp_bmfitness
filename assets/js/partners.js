/**
 * Partner carousel: native swipe/scroll with progressive autoplay.
 */
(function () {
	'use strict';

	document.querySelectorAll('[data-partners-slider]').forEach(function (slider) {
		var track = slider.querySelector('.partners-track');
		if (!track || !track.children.length) return;

		var motion = window.matchMedia('(prefers-reduced-motion: reduce)');
		var hovered = false;
		var focused = false;
		var keyboardInteraction = false;
		var interacting = false;
		var timer;

		function hasOverflow() {
			return track.scrollWidth > track.clientWidth + 2;
		}

		function schedule() {
			window.clearTimeout(timer);
			if (!motion.matches && !hovered && !focused && !interacting && !document.hidden && hasOverflow()) {
				timer = window.setTimeout(function () { move(1); }, 2500);
			}
		}

		function move(direction) {
			var max = track.scrollWidth - track.clientWidth;
			var position = track.scrollLeft;
			var step = track.children[0].getBoundingClientRect().width + (parseFloat(window.getComputedStyle(track).columnGap) || 0);
			var destination = position + direction * step;
			if (direction > 0 && position >= max - 2) destination = 0;
			if (direction < 0 && position <= 2) destination = max;
			track.scrollTo({
				left: Math.max(0, Math.min(max, destination)),
				behavior: motion.matches ? 'instant' : 'smooth'
			});
			schedule();
		}

		function update() {
			schedule();
		}

		slider.addEventListener('pointerenter', function (event) {
			if (event.pointerType === 'mouse') { hovered = true; schedule(); }
		});
		slider.addEventListener('pointerleave', function (event) {
			if (event.pointerType === 'mouse') { hovered = false; schedule(); }
		});
		document.addEventListener('keydown', function (event) {
			if (event.key === 'Tab') keyboardInteraction = true;
		});
		slider.addEventListener('focusin', function () {
			focused = keyboardInteraction;
			schedule();
		});
		slider.addEventListener('focusout', function (event) {
			focused = keyboardInteraction && slider.contains(event.relatedTarget);
			schedule();
		});
		// Touch focus can persist after a swipe; only keyboard focus pauses autoplay.
		slider.addEventListener('pointerdown', function () {
			keyboardInteraction = false;
			focused = false;
			interacting = true;
			schedule();
		});
		window.addEventListener('pointerup', function () { interacting = false; schedule(); });
		window.addEventListener('pointercancel', function () { interacting = false; schedule(); });
		track.addEventListener('scroll', schedule, { passive: true });
		track.addEventListener('wheel', schedule, { passive: true });
		track.addEventListener('keydown', function (event) {
			if (event.target !== track) return;
			if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
				event.preventDefault();
				keyboardInteraction = true;
				focused = true;
				move(event.key === 'ArrowRight' ? 1 : -1);
			}
		});
		document.addEventListener('visibilitychange', schedule);
		motion.addEventListener('change', update);
		if ('ResizeObserver' in window) {
			new ResizeObserver(update).observe(track);
		} else {
			window.addEventListener('resize', update);
		}
		update();
	});
})();
