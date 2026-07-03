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
