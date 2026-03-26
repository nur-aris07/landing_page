/* scripts.js — Company Profile Landing Page */
'use strict';

const WA_PHONE = '62XXXXXXXXXX';
const WA_BASE  = `https://api.whatsapp.com/send/?phone=${WA_PHONE}&text=`;

/* =====================================================
   1. NAVBAR — scroll behaviour + hamburger
   ===================================================== */
(function initNavbar() {
  const navbar    = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const navMenu   = document.getElementById('navMenu');

  // Scroll: add 'scrolled' class
  const onScroll = () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Hamburger toggle
  hamburger.addEventListener('click', () => {
    const isOpen = navMenu.classList.toggle('open');
    hamburger.classList.toggle('open', isOpen);
    hamburger.setAttribute('aria-expanded', String(isOpen));
  });

  // Close menu on nav link click
  navMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      navMenu.classList.remove('open');
      hamburger.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
    });
  });
})();

/* =====================================================
   2. SMOOTH SCROLL for anchor links
   ===================================================== */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (!target) return;
    e.preventDefault();
    const navH = document.getElementById('navbar').offsetHeight;
    const top  = target.getBoundingClientRect().top + window.scrollY - navH;
    window.scrollTo({ top, behavior: 'smooth' });
  });
});

/* =====================================================
   3. SERVICE CARD → jump to catalog tab
   ===================================================== */
document.querySelectorAll('.service-card__link[data-tab]').forEach(link => {
  link.addEventListener('click', function (e) {
    e.preventDefault();
    const tabName = this.dataset.tab;
    // Activate the correct tab
    const tabBtn = document.querySelector(`.tab-btn[data-filter="${tabName}"]`);
    if (tabBtn) tabBtn.click();
    // Scroll to katalog section
    const katalog = document.getElementById('katalog');
    if (katalog) {
      const navH = document.getElementById('navbar').offsetHeight;
      const top  = katalog.getBoundingClientRect().top + window.scrollY - navH;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  });
});

/* =====================================================
   4. CATALOG TAB FILTER
   ===================================================== */
(function initCatalogFilter() {
  const tabs  = document.querySelectorAll('.tab-btn');
  const cards = document.querySelectorAll('.catalog-card');

  function filterCards(filter) {
    cards.forEach(card => {
      const cat = card.dataset.category;
      const show = filter === 'semua' || cat === filter;
      if (show) {
        card.removeAttribute('hidden');
        // Trigger re-animation
        card.classList.remove('visible');
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            card.classList.add('fade-in-up', 'visible');
          });
        });
      } else {
        card.setAttribute('hidden', '');
      }
    });
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
      });
      tab.classList.add('active');
      tab.setAttribute('aria-selected', 'true');
      filterCards(tab.dataset.filter);
    });
  });

  // Start with "Semua" visible
  filterCards('semua');
})();

/* =====================================================
   5. WHATSAPP DYNAMIC LINKS for catalog cards
   ===================================================== */
document.querySelectorAll('.catalog-card__cta[data-product]').forEach(btn => {
  const product = btn.dataset.product;
  const msg = encodeURIComponent(
    `Halo, saya ingin informasi mengenai ${product}`
  );
  btn.href = `${WA_BASE}${msg}`;
});

/* =====================================================
   6. INTERSECTION OBSERVER — fade-in-up animations
   ===================================================== */
(function initScrollReveal() {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // Stagger children inside grids
          const el = entry.target;
          const siblings = el.parentElement
            ? [...el.parentElement.children].filter(c => c.classList.contains('fade-in-up'))
            : [];
          const idx = siblings.indexOf(el);
          el.style.transitionDelay = `${idx * 80}ms`;
          el.classList.add('visible');
          observer.unobserve(el);
        }
      });
    },
    { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
  );

  document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));
})();

/* =====================================================
   7. COUNTER ANIMATION (Stats section)
   ===================================================== */
(function initCounters() {
  const counters = document.querySelectorAll('.stat-num[data-target]');
  let started    = false;

  function easeOutQuad(t) { return t * (2 - t); }

  function animateCounter(el, target, duration = 2000) {
    const start = performance.now();
    function step(now) {
      const elapsed  = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const eased    = easeOutQuad(progress);
      el.textContent = Math.round(eased * target).toLocaleString('id-ID');
      if (progress < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  const statsSection = document.getElementById('stats');
  if (!statsSection) return;

  const observer = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting && !started) {
        started = true;
        counters.forEach(el => {
          animateCounter(el, parseInt(el.dataset.target, 10));
        });
        observer.disconnect();
      }
    },
    { threshold: 0.3 }
  );
  observer.observe(statsSection);
})();

/* =====================================================
   8. HERO TEXT CYCLE ANIMATION
   ===================================================== */
(function initHeroCycle() {
  const el       = document.getElementById('heroCycle');
  if (!el) return;
  const words    = ['Otomotif', 'Alat Berat', 'Properti', 'Travel'];
  let   index    = 0;

  setInterval(() => {
    el.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
    el.style.opacity    = '0';
    el.style.transform  = 'translateY(-12px)';

    setTimeout(() => {
      index = (index + 1) % words.length;
      el.textContent      = words[index];
      el.style.transform  = 'translateY(12px)';
      el.style.opacity    = '0';

      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          el.style.opacity   = '1';
          el.style.transform = 'translateY(0)';
        });
      });
    }, 380);
  }, 2600);
})();
