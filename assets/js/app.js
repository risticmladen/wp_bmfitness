/**
 * BM Fitness — main JavaScript.
 *
 * Vanilla JS only. No dependencies.
 */

(function () {
	'use strict';

	/* ───── Mobile menu toggle ───── */
	const toggle = document.getElementById('mobile-menu-toggle');
	const menu = document.getElementById('mobile-menu');
	const iconOpen = document.getElementById('menu-icon-open');
	const iconClose = document.getElementById('menu-icon-close');

	if (toggle && menu) {
		toggle.addEventListener('click', function () {
			const isOpen = !menu.classList.contains('hidden');
			menu.classList.toggle('hidden');
			iconOpen.classList.toggle('hidden');
			iconClose.classList.toggle('hidden');
			toggle.setAttribute('aria-expanded', String(!isOpen));
		});
	}

	/* ───── Desktop dropdown with leave delay ───── */
	var DROPDOWN_DELAY = 250; // ms — enough time to move mouse into submenu
	var dropdownTimers = new WeakMap();

	document.querySelectorAll('.nav-dropdown-parent').forEach(function (li) {
		var menu    = li.querySelector('.nav-dropdown-menu');
		var chevron = li.querySelector('.nav-dropdown-chevron');
		if (!menu) return;

		li.addEventListener('mouseenter', function () {
			// Cancel any pending hide timer.
			if (dropdownTimers.has(li)) {
				clearTimeout(dropdownTimers.get(li));
				dropdownTimers.delete(li);
			}
			menu.classList.remove('hidden');
			if (chevron) chevron.classList.add('rotate-180');
		});

		li.addEventListener('mouseleave', function () {
			var t = setTimeout(function () {
				menu.classList.add('hidden');
				if (chevron) chevron.classList.remove('rotate-180');
				dropdownTimers.delete(li);
			}, DROPDOWN_DELAY);
			dropdownTimers.set(li, t);
		});
	});

	/* ───── Mobile submenu toggles ───── */
	document.querySelectorAll('.mobile-submenu-toggle').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var submenu = this.closest('li').querySelector('.mobile-submenu');
			var chevron = this.querySelector('svg');
			var isOpen  = !submenu.classList.contains('hidden');

			submenu.classList.toggle('hidden');
			chevron.classList.toggle('rotate-180');
			this.setAttribute('aria-expanded', String(!isOpen));
		});
	});

	/* ───── Sticky header shadow on scroll ───── */
	const header = document.getElementById('site-header');
	if (header) {
		window.addEventListener('scroll', function () {
			if (window.scrollY > 10) {
				header.classList.add('shadow-md');
			} else {
				header.classList.remove('shadow-md');
			}
		}, { passive: true });
	}

	/* ───── Gallery slider ───── */
	document.querySelectorAll('.gallery-slider').forEach(function (slider) {
		var track   = slider.querySelector('.gallery-track');
		var slides  = slider.querySelectorAll('.gallery-slide');
		var dots    = slider.querySelectorAll('.gallery-dot');
		var btnPrev = slider.querySelector('.gallery-prev');
		var btnNext = slider.querySelector('.gallery-next');
		var total   = slides.length;
		var current = 0;
		var timer;

		if (total <= 1) return; // nothing to slide

		function goTo(index) {
			current = (index + total) % total;
			track.style.transform = 'translateX(-' + (current * 100) + '%)';
			dots.forEach(function (dot, i) {
				dot.style.opacity = i === current ? '1' : '0.4';
			});
		}

		function startAutoplay() {
			timer = setInterval(function () { goTo(current + 1); }, 5000);
		}

		function resetAutoplay() {
			clearInterval(timer);
			startAutoplay();
		}

		if (btnPrev) btnPrev.addEventListener('click', function () { goTo(current - 1); resetAutoplay(); });
		if (btnNext) btnNext.addEventListener('click', function () { goTo(current + 1); resetAutoplay(); });

		dots.forEach(function (dot) {
			dot.addEventListener('click', function () {
				goTo(parseInt(this.dataset.index, 10));
				resetAutoplay();
			});
		});

		// Touch / swipe support.
		var touchStartX = 0;
		slider.addEventListener('touchstart', function (e) {
			touchStartX = e.touches[0].clientX;
		}, { passive: true });
		slider.addEventListener('touchend', function (e) {
			var diff = touchStartX - e.changedTouches[0].clientX;
			if (Math.abs(diff) > 50) {
				goTo(diff > 0 ? current + 1 : current - 1);
				resetAutoplay();
			}
		});

		goTo(0);
		startAutoplay();
	});

	/* ───── Smooth scroll for anchor links ───── */
	document.querySelectorAll('a[href^="#"]').forEach(function (link) {
		link.addEventListener('click', function (e) {
			const target = document.querySelector(this.getAttribute('href'));
			if (target) {
				e.preventDefault();
				target.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}
		});
	});
})();
