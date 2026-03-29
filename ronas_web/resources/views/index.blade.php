<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  @php
    use Illuminate\Support\Str;

    $siteName = $settings['site_name'] ?? 'Company Profile';
    $siteTagline = $settings['site_tagline'] ?? 'Layanan Terpercaya';
    $siteDescription = $settings['site_description']
        ?? 'Temukan layanan dan katalog terbaik sesuai kebutuhan Anda dengan konsultasi cepat via WhatsApp.';
    $waNumber = $settings['whatsapp_number'] ?? '';

    $heroWords = $categories->pluck('name')->values()->all();
    $initialVisibleCatalogs = 8;

    $currentUrl = url()->current();
    $siteUrl = url('/');

    $seoTitle = $settings['seo_title']
        ?? ($siteName . ' | ' . $siteTagline);

    $seoDescription = $settings['seo_description']
        ?? $siteDescription;

    $logoPath = $settings['logo_url'] ?? '';
    $ogImagePath = $settings['og_image'] ?? '';

    $logoUrl = !empty($logoPath)
        ? (Str::startsWith($logoPath, ['http://', 'https://']) ? $logoPath : asset(ltrim($logoPath, '/')))
        : asset('uploads/settings/default-logo.png');

    $ogImage = !empty($ogImagePath)
        ? (Str::startsWith($ogImagePath, ['http://', 'https://']) ? $ogImagePath : asset(ltrim($ogImagePath, '/')))
        : $logoUrl;

    $email = $settings['email'] ?? '';
    $phoneRaw = $settings['phone'] ?? '';
    $phoneClean = preg_replace('/\D+/', '', $phoneRaw);
    $address = $settings['address'] ?? '';
    $instagramUrl = $settings['instagram_url'] ?? '';
    $facebookUrl = $settings['facebook_url'] ?? '';

    $sameAs = array_values(array_filter([
        $instagramUrl,
        $facebookUrl,
    ]));

    if (!function_exists('catalogThemeClass')) {
        function catalogThemeClass($slug) {
            $allowed = ['otomotif', 'alat-berat', 'properti', 'travel'];
            return in_array($slug, $allowed, true) ? $slug : 'default';
        }
    }

    if (!function_exists('catalogIconClass')) {
        function catalogIconClass($catalog, $category, $slug) {
            if (!empty($category?->icon)) {
                return $category->icon;
            }

            if (!empty($catalog->icon)) {
                return $catalog->icon;
            }

            return match ($slug) {
                'otomotif' => 'ti ti-car',
                'alat-berat' => 'ti ti-bulldozer',
                'properti' => 'ti ti-building-estate',
                'travel' => 'ti ti-plane',
                default => 'ti ti-package',
            };
        }
    }

    if (!function_exists('testimonialInitial')) {
        function testimonialInitial($name) {
            return strtoupper(mb_substr(trim($name ?: 'U'), 0, 1));
        }
    }
  @endphp

  <title>{{ $seoTitle }}</title>
  <meta name="description" content="{{ $seoDescription }}" />

  @if(!app()->environment('production'))
    <meta name="robots" content="noindex,nofollow">
  @else
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
  @endif

  <link rel="canonical" href="{{ $currentUrl }}" />

  <meta property="og:locale" content="id_ID" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="{{ $seoTitle }}" />
  <meta property="og:description" content="{{ $seoDescription }}" />
  <meta property="og:url" content="{{ $currentUrl }}" />
  <meta property="og:site_name" content="{{ $siteName }}" />
  <meta property="og:image" content="{{ $ogImage }}" />

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $seoTitle }}" />
  <meta name="twitter:description" content="{{ $seoDescription }}" />
  <meta name="twitter:image" content="{{ $ogImage }}" />

  <link rel="icon" href="{{ $logoUrl }}" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style">

  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

  <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $siteName,
        'url' => $siteUrl,
        'logo' => $logoUrl,
        'image' => $ogImage,
        'description' => $siteDescription,
        'email' => $email ?: null,
        'telephone' => $phoneRaw ?: null,
        'sameAs' => !empty($sameAs) ? $sameAs : null,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
  </script>

  <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => $siteName,
        'url' => $siteUrl,
        'inLanguage' => 'id-ID',
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
  </script>

  <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => 'Katalog Produk & Layanan ' . $siteName,
        'itemListElement' => $catalogs->values()->map(function ($catalog, $index) {
            return [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $catalog->title,
                'url' => url('/#katalog'),
            ];
        })->all(),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
  </script>

  @if(!empty($address) || !empty($phoneRaw) || !empty($email))
    <script type="application/ld+json">
      {!! json_encode([
          '@context' => 'https://schema.org',
          '@type' => 'LocalBusiness',
          'name' => $siteName,
          'url' => $siteUrl,
          'image' => $ogImage,
          'telephone' => $phoneRaw ?: null,
          'email' => $email ?: null,
          'address' => !empty($address) ? [
              '@type' => 'PostalAddress',
              'streetAddress' => $address,
              'addressCountry' => 'ID',
          ] : null,
      ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
  @endif

  <script>
    window.landingData = {
      heroWords: @json($heroWords),
      initialVisibleCatalogs: {{ $initialVisibleCatalogs }}
    };
  </script>
</head>

<body>

  <!-- ===== NAVBAR ===== -->
  <header class="navbar" id="navbar">
    <div class="container navbar__inner">
      <a href="/" class="navbar__logo">{{ $siteName }}</a>

      <nav class="navbar__nav" id="navMenu">
        <a href="/">Beranda</a>
        <a href="#layanan">Layanan</a>
        <a href="#katalog">Katalog</a>
        <a href="#tentang">Tentang Kami</a>
        <a href="#kontak">Kontak</a>
      </nav>

      @if(!empty($waNumber))
        <a
          href="https://api.whatsapp.com/send/?phone={{ $waNumber }}&text={{ urlencode('Halo, saya ingin informasi lebih lanjut') }}"
          class="btn btn--accent navbar__cta"
          target="_blank"
          rel="noopener"
        >
          Hubungi Kami
        </a>
      @endif

      <button class="navbar__hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false" type="button">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>

  <main>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero" id="beranda">
      <div class="hero__bg"></div>

      <div class="container hero__content">
        <div class="hero__badge fade-in-up">
          <span>{{ $categories->count() }} Kategori Layanan</span>
          <span class="divider">|</span>
          <span>100+ Produk</span>
          <span class="divider">|</span>
          <span>Terpercaya</span>
        </div>

        <h1 class="hero__title fade-in-up">
          Solusi Terpercaya untuk<br />
          <span class="hero__cycle" id="heroCycle">{{ $categories->first()->name ?? 'Layanan' }}</span>
        </h1>

        <p class="hero__sub fade-in-up">
          {{ $settings['hero_description'] ?? 'Kami menghadirkan produk dan layanan berkualitas tinggi di berbagai kategori untuk membantu kebutuhan Anda dengan solusi terbaik.' }}
        </p>

        <div class="hero__cta fade-in-up">
          <a href="#layanan" class="btn btn--accent btn--lg">Lihat Layanan Kami</a>

          @if(!empty($waNumber))
            <a
              href="https://api.whatsapp.com/send/?phone={{ $waNumber }}&text={{ urlencode('Halo, saya ingin konsultasi mengenai layanan Anda') }}"
              class="btn btn--outline btn--lg"
              target="_blank"
              rel="noopener"
            >
              <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path
                  d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                <path
                  d="M12 0C5.373 0 0 5.373 0 12c0 2.134.558 4.133 1.532 5.87L.057 23.012a.75.75 0 0 0 .931.931l5.142-1.475A11.952 11.952 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.96 0-3.793-.5-5.393-1.38l-.387-.215-4.01 1.151 1.152-3.91-.237-.401A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
              </svg>
              Hubungi via WhatsApp
            </a>
          @endif
        </div>
      </div>

      <div class="hero__scroll-indicator" aria-hidden="true">
        <span></span>
      </div>
    </section>

    <!-- ===== SERVICES SECTION ===== -->
    <section class="services section" id="layanan">
      <div class="container">
        <div class="section-header fade-in-up">
          <span class="section-tag">Apa yang Kami Tawarkan</span>
          <h2 class="section-title">Layanan Kami</h2>
          <p class="section-sub">Kami hadir dengan {{ $categories->count() }} kategori layanan unggulan</p>
        </div>

        <div class="services__grid">
          @forelse($categories as $category)
            @php
              $slug = $category->slug_name ?? Str::slug($category->name);
              $icon = $category->icon ?: match ($slug) {
                'otomotif' => 'ti ti-car',
                'alat-berat' => 'ti ti-crane',
                'properti' => 'ti ti-building-estate',
                'travel' => 'ti ti-plane-departure',
                default => 'ti ti-layout-grid',
              };
            @endphp

            <div class="service-card fade-in-up">
              <div class="service-card__icon"><i class="{{ $icon }}"></i></div>
              <h3>{{ strtoupper($category->name) }}</h3>
              <p>{{ $category->description ?: 'Layanan dan katalog terbaik sesuai kebutuhan Anda.' }}</p>
              <a href="#katalog" class="service-card__link" data-tab="{{ $slug }}">Lihat Katalog →</a>
            </div>
          @empty
            <div class="fade-in-up" style="grid-column: 1 / -1; text-align:center;">
              <p>Belum ada kategori layanan aktif.</p>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- ===== WHY US SECTION ===== -->
    <section class="why section" id="tentang">
      <div class="container">
        <div class="section-header fade-in-up">
          <span class="section-tag">Keunggulan Kami</span>
          <h2 class="section-title">Mengapa Memilih Kami?</h2>
        </div>

        <div class="why__grid">
          <div class="why-card fade-in-up">
            <div class="why-card__icon"><i class="ti ti-shield-check"></i></div>
            <h3>Produk Berkualitas</h3>
            <p>Setiap produk dan layanan kami melewati seleksi ketat untuk memastikan kualitas terbaik bagi pelanggan kami.</p>
          </div>

          <div class="why-card fade-in-up">
            <div class="why-card__icon"><i class="ti ti-message-dots"></i></div>
            <h3>Konsultasi Gratis</h3>
            <p>Tim kami siap membantu kapan saja, 7 hari seminggu, tanpa biaya untuk setiap pertanyaan Anda.</p>
          </div>

          <div class="why-card fade-in-up">
            <div class="why-card__icon"><i class="ti ti-lock"></i></div>
            <h3>Terpercaya</h3>
            <p>Pengalaman bertahun-tahun melayani pelanggan menjadikan kami mitra bisnis yang dapat diandalkan.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== CATALOG SECTION ===== -->
    <section class="catalog section" id="katalog">
      <div class="container">
        <div class="section-header fade-in-up">
          <span class="section-tag">Temukan Pilihan Terbaik</span>
          <h2 class="section-title">Katalog Produk &amp; Layanan</h2>
          <p class="section-sub">Temukan detail lengkap setiap layanan kami</p>
        </div>

        <div class="catalog__tabs fade-in-up" role="tablist">
          <button class="tab-btn active" data-filter="semua" role="tab" aria-selected="true">Semua</button>

          @foreach($categories as $category)
            <button
              class="tab-btn"
              data-filter="{{ $category->slug_name ?? Str::slug($category->name) }}"
              role="tab"
              aria-selected="false"
            >
              {{ $category->name }}
            </button>
          @endforeach
        </div>

        <div class="catalog__grid" id="catalogGrid">
          @forelse($catalogs as $catalog)
            @php
              $category = $catalog->category;
              $slug = $catalog->category_slug ?: Str::slug($category->name ?? 'lainnya');
              $theme = catalogThemeClass($slug);
              $iconClass = catalogIconClass($catalog, $category, $slug);

              $catalogImage = null;

              if (!empty($catalog->image_url)) {
                  $catalogImage = $catalog->image_url;
              } elseif (!empty($catalog->image)) {
                  $catalogImage = asset('storage/' . ltrim($catalog->image, '/'));
              }
            @endphp

            <div class="catalog-card fade-in-up" data-category="{{ $slug }}" data-catalog-item>
              <div class="catalog-card__media">
                <div class="catalog-card__img {{ $catalogImage ? 'has-image cat-image--' . $theme : 'cat--' . $theme }}">
                  @if($catalogImage)
                    <img
                      src="{{ $catalogImage }}"
                      alt="{{ $catalog->title }}"
                      class="catalog-card__photo"
                      loading="lazy"
                    >
                    <div class="catalog-card__img-overlay"></div>

                    <span class="catalog-card__img-icon">
                      <i class="{{ $iconClass }}"></i>
                    </span>
                  @else
                    <i class="{{ $iconClass }}"></i>
                  @endif
                </div>

                <span class="catalog-card__badge badge--{{ $theme }}">
                  {{ strtoupper($category->name ?? 'Lainnya') }}
                </span>

                <span class="catalog-card__price {{ is_null($catalog->price) ? 'price--contact' : '' }}">
                  {{ $catalog->formatted_price }}
                </span>
              </div>

              <div class="catalog-card__body">
                <h4>{{ strtoupper($catalog->title) }}</h4>

                <ul class="specs">
                  @forelse($catalog->specs as $catalogSpec)
                    <li>
                      <span class="specs__check">✓</span>
                      <span>{{ $catalogSpec->spec->spec_label }}: {{ $catalogSpec->spec_value }}</span>
                    </li>
                  @empty
                    @if(!empty($catalog->description))
                      <li>
                        <span class="specs__check">✓</span>
                        <span>{{ $catalog->description }}</span>
                      </li>
                    @endif
                  @endforelse
                </ul>

                @if(!empty($catalog->location))
                  <div class="catalog-card__loc">
                    <span>📍</span>
                    <span>{{ $catalog->location }}</span>
                  </div>
                @endif

                @if(!empty($waNumber))
                  <a
                    href="https://api.whatsapp.com/send/?phone={{ $waNumber }}&text={{ urlencode($catalog->whatsapp_text) }}"
                    class="btn btn--wa catalog-card__cta"
                    target="_blank"
                    rel="noopener"
                  >
                    Info via WhatsApp
                  </a>
                @endif
              </div>
            </div>
          @empty
            <div class="fade-in-up" style="grid-column: 1 / -1; text-align:center;">
              <p>Belum ada katalog aktif untuk ditampilkan.</p>
            </div>
          @endforelse
        </div>

        @if($catalogs->count() > $initialVisibleCatalogs)
          <div class="catalog__actions fade-in-up" id="catalogActions">
            <button type="button" class="btn btn--outline-dark" id="catalogLoadMore">
              Muat Lebih Banyak
            </button>
          </div>
        @endif
      </div>
    </section>

    <!-- ===== STATS ===== -->
    <section class="stats section" id="stats">
      <div class="container">
        <div class="stats__grid">
          <div class="stat-item fade-in-up">
            <h3><span class="stat-num" data-target="258">258</span><span class="stat-suffix">+</span></h3>
            <p>Produk Tersedia</p>
          </div>

          <div class="stat-item fade-in-up">
            <h3><span class="stat-num" data-target="{{ $categories->count() }}">{{ $categories->count() }}</span></h3>
            <p>Kategori Layanan</p>
          </div>

          <div class="stat-item fade-in-up">
            <h3><span class="stat-num" data-target="516">516</span><span class="stat-suffix">+</span></h3>
            <p>Pelanggan Puas</p>
          </div>

          <div class="stat-item fade-in-up">
            <h3><span class="stat-num" data-target="3">3</span><span class="stat-suffix">+</span></h3>
            <p>Tahun Pengalaman</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="testimonials section" id="testimoni">
      <div class="container">
        <div class="section-header fade-in-up">
          <span class="section-tag">Apa Kata Mereka</span>
          <h2 class="section-title">Testimoni Pelanggan</h2>
        </div>

        <div class="testimonials__slider-wrap fade-in-up">
          <button type="button" class="testimonials__nav testimonials__nav--prev" id="testiPrev" aria-label="Sebelumnya">
            <i class="ti ti-chevron-left"></i>
          </button>

          <div class="testimonials__viewport">
            <div class="testimonials__track" id="testiTrack">
              @forelse($testimonials as $testimonial)
                <div class="testi-slide">
                  <div class="testi-card fade-in-up">
                    <div class="testi-card__stars">
                      {{ $testimonial->stars ?: str_repeat('★', max(1, (int) ($testimonial->rating ?? 5))) }}
                    </div>

                    <p>
                      "{{ $testimonial->message }}"
                    </p>

                    <div class="testi-card__author">
                      @if(!empty($testimonial->image))
                        <img
                          src="{{ $testimonial->image_url }}"
                          alt="{{ $testimonial->customer_name }}"
                          class="testi-card__avatar"
                        >
                      @else
                        <div class="testi-card__avatar">
                          {{ testimonialInitial($testimonial->customer_name) }}
                        </div>
                      @endif

                      <div>
                        <strong>{{ $testimonial->customer_name }}</strong>
                        <span>
                          {{ $testimonial->customer_city ?: ($testimonial->customer_title ?: 'Pelanggan') }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              @empty
                <div style="width:100%; text-align:center;">
                  <p>Belum ada testimonial aktif.</p>
                </div>
              @endforelse
            </div>
          </div>

          <button type="button" class="testimonials__nav testimonials__nav--next" id="testiNext" aria-label="Berikutnya">
            <i class="ti ti-chevron-right"></i>
          </button>
        </div>
      </div>
    </section>

    <!-- ===== CTA BANNER ===== -->
    <section class="cta-banner section" id="kontak">
      <div class="container cta-banner__inner fade-in-up">
        <h2>Tertarik dengan Produk atau Layanan Kami?</h2>
        <p>Konsultasi gratis tanpa biaya. Tim kami siap membantu Anda.</p>

        @if(!empty($waNumber))
          <a
            href="https://api.whatsapp.com/send/?phone={{ $waNumber }}&text={{ urlencode('Halo, saya tertarik dengan layanan Anda') }}"
            class="btn btn--wa btn--lg"
            target="_blank"
            rel="noopener"
          >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
              <path
                d="M12 0C5.373 0 0 5.373 0 12c0 2.134.558 4.133 1.532 5.87L.057 23.012a.75.75 0 0 0 .931.931l5.142-1.475A11.952 11.952 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.96 0-3.793-.5-5.393-1.38l-.387-.215-4.01 1.151 1.152-3.91-.237-.401A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
            </svg>
            Hubungi Kami Sekarang
          </a>
        @endif
      </div>
    </section>

  </main>

  <!-- ===== FOOTER ===== -->
  <footer class="footer">
    <div class="container footer__top">
      <div class="footer__brand">
        <div class="footer__logo">{{ $siteName }}</div>
        <p>{{ $settings['site_description'] ?? 'Solusi lengkap untuk kebutuhan otomotif, alat berat, properti, dan travel Anda.' }}</p>

        <div class="footer__socials">
          <a href="{{ $settings['instagram_url'] ?? '' }}" aria-label="Instagram"><i class="ti ti-brand-instagram"></i></a>
          <a href="{{ $settings['facebook_url'] ?? '' }}" aria-label="Facebook"><i class="ti ti-brand-facebook"></i></a>
        </div>
      </div>

      <div class="footer__links">
        <div class="footer__col">
          <h4>Layanan</h4>
          @foreach($categories as $category)
            <a href="#katalog" data-tab="{{ $category->slug_name ?? Str::slug($category->name) }}">
              {{ $category->name }}
            </a>
          @endforeach
        </div>

        <div class="footer__col">
          <h4>Perusahaan</h4>
          <a href="#tentang">Tentang Kami</a>
          <a href="#kontak">Kontak</a>
          <a href="#katalog">Katalog</a>
        </div>

        <div class="footer__col">
          <h4>Kontak</h4>
          @if(!empty($settings['address'])) <a href="{{ $settings['address_url'] ?? '' }}">{{ $settings['address'] }}</a> @endif
          @if(!empty($settings['phone'])) <a href="#">{{ $settings['phone'] }}</a> @endif
          @if(!empty($settings['email'])) <a href="#">{{ $settings['email'] }}</a> @endif
          @if(!empty($waNumber)) <a href="https://api.whatsapp.com/send/?phone={{ $waNumber }}">WhatsApp</a> @endif
        </div>
      </div>
    </div>

    <div class="footer__bottom">
      © {{ date('Y') }} {{ $siteName }}. All rights reserved.
    </div>
  </footer>

  <!-- ===== FLOATING WHATSAPP BUTTON ===== -->
  <a href="https://api.whatsapp.com/send/?phone={{ $waNumber }}&text={{ urlencode('Halo, saya ingin konsultasi mengenai layanan Anda') }}"
    class="wa-float" id="waFloat" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
      <path d="M12 0C5.373 0 0 5.373 0 12c0 2.134.558 4.133 1.532 5.87L.057 23.012a.75.75 0 0 0 .931.931l5.142-1.475A11.952 11.952 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.96 0-3.793-.5-5.393-1.38l-.387-.215-4.01 1.151 1.152-3.91-.237-.401A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
    </svg>
  </a>

  <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>