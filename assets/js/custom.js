/*
 * Innovare — small front-end script.
 *
 * Intentionally minimal:
 *  - toggles `.is-scrolled` on the sticky navbar
 *  - closes the mobile navbar after clicking a link
 *  - lights up the active in-page anchor on the Services page
 *  - applies Bootstrap's `was-validated` to the contact form
 *  - smooth-scrolls hash links with sticky-header offset compensation
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var navbar = document.querySelector('.innovare-navbar');
		var navCollapse = document.getElementById('innovare-primary-nav');

		if (navbar) {
			var lastScrolled = false;
			var onScroll = function () {
				var scrolled = window.scrollY > 4;
				if (scrolled !== lastScrolled) {
					navbar.classList.toggle('is-scrolled', scrolled);
					lastScrolled = scrolled;
				}
			};
			window.addEventListener('scroll', onScroll, { passive: true });
			onScroll();
		}

		// Close mobile menu after tapping a non-dropdown link.
		if (navCollapse) {
			navCollapse.querySelectorAll('a.nav-link:not(.dropdown-toggle), a.dropdown-item').forEach(function (link) {
				link.addEventListener('click', function () {
					if (window.innerWidth < 992 && navCollapse.classList.contains('show')) {
						var bsCollapse = window.bootstrap && window.bootstrap.Collapse
							? window.bootstrap.Collapse.getOrCreateInstance(navCollapse)
							: null;
						if (bsCollapse) { bsCollapse.hide(); }
					}
				});
			});
		}

		// Active anchor highlight for services-nav (matches #anchor sections).
		var servicesNav = document.querySelector('.innovare-services-page .services-nav');
		if (servicesNav) {
			var anchorLinks = servicesNav.querySelectorAll('a[href^="#"]');
			var sections = Array.prototype.map.call(anchorLinks, function (a) {
				return document.querySelector(a.getAttribute('href'));
			}).filter(Boolean);

			if ('IntersectionObserver' in window && sections.length) {
				var io = new IntersectionObserver(function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							var id = entry.target.id;
							anchorLinks.forEach(function (a) {
								a.classList.toggle('is-active', a.getAttribute('href') === '#' + id);
							});
						}
					});
				}, { rootMargin: '-30% 0px -60% 0px', threshold: 0 });
				sections.forEach(function (s) { io.observe(s); });
			}
		}

		// Bootstrap validation for fallback contact form.
		document.querySelectorAll('form.innovare-contact-form').forEach(function (form) {
			form.addEventListener('submit', function (e) {
				if (!form.checkValidity()) {
					e.preventDefault();
					e.stopPropagation();
				}
				form.classList.add('was-validated');
			}, false);
		});

		// Sticky-header offset for hash navigation.
		document.querySelectorAll('a[href^="#"]').forEach(function (a) {
			a.addEventListener('click', function (e) {
				var href = a.getAttribute('href');
				if (!href || href === '#' || href.length < 2) { return; }
				var target = document.querySelector(href);
				if (!target) { return; }
				e.preventDefault();
				var headerHeight = navbar ? navbar.getBoundingClientRect().height : 0;
				var top = target.getBoundingClientRect().top + window.scrollY - headerHeight - 16;
				window.scrollTo({ top: top, behavior: 'smooth' });
				history.pushState(null, '', href);
			});
		});
	});
})();
