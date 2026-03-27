/* scripts.js — Company Profile Landing Page */
'use strict';

const landingData = window.landingData || {};
const HERO_WORDS = Array.isArray(landingData.heroWords) && landingData.heroWords.length
  ? landingData.heroWords
  : ['Layanan Kami'];
const INITIAL_VISIBLE = Number(landingData.initialVisibleCatalogs || 8);

/* =====================================================
   1. NAVBAR — scroll behaviour + hamburger
   ===================================================== */
(function initNavbar() {
  const navbar = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const navMenu = document.getElementById('navMenu');

  if (!navbar || !hamburger || !navMenu) return;

  const onScroll = () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  hamburger.addEventListener('click', () => {
    const isOpen = navMenu.classList.toggle('open');
    hamburger.classList.toggle('open', isOpen);
    hamburger.setAttribute('aria-expanded', String(isOpen));
  });

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
(function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const selector = this.getAttribute('href');
      const target = document.querySelector(selector);
      if (!target) return;

      e.preventDefault();

      const navbar = document.getElementById('navbar');
      const navH = navbar ? navbar.offsetHeight : 0;
      const top = target.getBoundingClientRect().top + window.scrollY - navH;

      window.scrollTo({ top, behavior: 'smooth' });
    });
  });
})();

/* =====================================================
   3. SERVICE / FOOTER LINK → jump to catalog tab
   ===================================================== */
(function initCategoryJumpLinks() {
  document.querySelectorAll('[data-tab]').forEach(link => {
    link.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href !== '#katalog') return;

      e.preventDefault();

      const tabName = this.dataset.tab;
      const tabBtn = document.querySelector(`.tab-btn[data-filter="${tabName}"]`);
      if (tabBtn) tabBtn.click();

      const katalog = document.getElementById('katalog');
      const navbar = document.getElementById('navbar');

      if (katalog) {
        const navH = navbar ? navbar.offsetHeight : 0;
        const top = katalog.getBoundingClientRect().top + window.scrollY - navH;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });
})();

/* =====================================================
   4. CATALOG TAB FILTER + LOAD MORE
   ===================================================== */
(function initCatalogFilterAndLoadMore() {
  const tabs = document.querySelectorAll('.tab-btn');
  const cards = Array.from(document.querySelectorAll('.catalog-card[data-catalog-item]'));
  const loadMoreBtn = document.getElementById('catalogLoadMore');
  const catalogActions = document.getElementById('catalogActions');

  if (!tabs.length || !cards.length) return;

  let activeFilter = 'semua';
  let visibleCount = INITIAL_VISIBLE;

  function getMatchedCards() {
    return cards.filter(card => {
      const cat = card.dataset.category;
      return activeFilter === 'semua' || cat === activeFilter;
    });
  }

  function refreshCards() {
    const matchedCards = getMatchedCards();

    cards.forEach(card => {
      card.setAttribute('hidden', '');
      card.classList.remove('visible');
    });

    matchedCards.forEach((card, index) => {
      if (index < visibleCount) {
        card.removeAttribute('hidden');

        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            card.classList.add('visible');
          });
        });
      }
    });

    if (catalogActions) {
      catalogActions.hidden = matchedCards.length <= visibleCount;
    }
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
      });

      tab.classList.add('active');
      tab.setAttribute('aria-selected', 'true');

      activeFilter = tab.dataset.filter;
      visibleCount = INITIAL_VISIBLE;
      refreshCards();
    });
  });

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', () => {
      visibleCount += INITIAL_VISIBLE;
      refreshCards();
    });
  }

  refreshCards();
})();

/* =====================================================
   5. INTERSECTION OBSERVER — fade-in-up animations
   ===================================================== */
(function initScrollReveal() {
  const elements = document.querySelectorAll('.fade-in-up');
  if (!elements.length) return;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        const el = entry.target;
        const siblings = el.parentElement
          ? [...el.parentElement.children].filter(c => c.classList.contains('fade-in-up'))
          : [];

        const idx = siblings.indexOf(el);
        el.style.transitionDelay = `${idx * 80}ms`;
        el.classList.add('visible');
        observer.unobserve(el);
      });
    },
    { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
  );

  elements.forEach(el => observer.observe(el));
})();

/* =====================================================
   6. COUNTER ANIMATION (Stats section)
   ===================================================== */
(function initCounters() {
  const counters = document.querySelectorAll('.stat-num[data-target]');
  const statsSection = document.getElementById('stats');
  if (!counters.length || !statsSection) return;

  let started = false;

  function easeOutQuad(t) {
    return t * (2 - t);
  }

  function animateCounter(el, target, duration = 2000) {
    const start = performance.now();

    function step(now) {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const eased = easeOutQuad(progress);

      el.textContent = Math.round(eased * target).toLocaleString('id-ID');

      if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }

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
   7. HERO TEXT CYCLE ANIMATION
   ===================================================== */
(function initHeroCycle() {
  const el = document.getElementById('heroCycle');
  if (!el || HERO_WORDS.length < 2) return;

  let index = 0;

  setInterval(() => {
    el.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
    el.style.opacity = '0';
    el.style.transform = 'translateY(-12px)';

    setTimeout(() => {
      index = (index + 1) % HERO_WORDS.length;
      el.textContent = HERO_WORDS[index];
      el.style.transform = 'translateY(12px)';
      el.style.opacity = '0';

      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          el.style.opacity = '1';
          el.style.transform = 'translateY(0)';
        });
      });
    }, 380);
  }, 2600);
})();

/* =====================================================
   TESTIMONIAL SLIDER
   ===================================================== */
(function initTestimonialSlider() {
  const track = document.getElementById('testiTrack');
  const prevBtn = document.getElementById('testiPrev');
  const nextBtn = document.getElementById('testiNext');

  if (!track || !prevBtn || !nextBtn) return;

  const slides = Array.from(track.querySelectorAll('.testi-slide'));
  if (!slides.length) return;

  let currentIndex = 0;

  function getPerView() {
    if (window.innerWidth <= 640) return 1;
    if (window.innerWidth <= 991) return 2;
    return 3;
  }

  function getMaxIndex() {
    return Math.max(0, slides.length - getPerView());
  }

  function updateSlider() {
    const perView = getPerView();
    const slideWidth = 100 / perView;
    track.style.transform = `translateX(-${currentIndex * slideWidth}%)`;

    prevBtn.disabled = currentIndex <= 0;
    nextBtn.disabled = currentIndex >= getMaxIndex();
  }

  nextBtn.addEventListener('click', () => {
    const maxIndex = getMaxIndex();
    if (currentIndex < maxIndex) {
      currentIndex += 1;
      updateSlider();
    }
  });

  prevBtn.addEventListener('click', () => {
    if (currentIndex > 0) {
      currentIndex -= 1;
      updateSlider();
    }
  });

  window.addEventListener('resize', () => {
    const maxIndex = getMaxIndex();
    if (currentIndex > maxIndex) {
      currentIndex = maxIndex;
    }
    updateSlider();
  });

  updateSlider();
})();