<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page Wisata</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <header class="topbar">
    <div class="topbar-left">
      <span class="brand">Komodo National Park</span>
    </div>

    <div class="topbar-center">
      <nav class="main-nav">
        <ul>
          <li><a href="#beranda">Beranda</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#">Obyek Wisata</a></li>
          <li><a href="#">Fasilitas Wisata</a></li>
          <li><a href="#paket">Paket Wisata</a></li>
          <li><a href="#">Museum Niang Komodo</a></li>
          <li><a href="#paket">Pemesanan</a></li>
          <li><a href="#">Galery</a></li>
          <li><a href="cek_pesanan.php">Pesanan Saya</a></li>
        </ul>
      </nav>
    </div>

    <div class="topbar-right">
      <button class="burger" id="burgerBtn" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
      <a class="btn-book" href="#paket">Booking Now</a>
    </div>
  </header>

  <nav class="mobile-nav" id="mobileNav">
    <ul>
      <li><a href="#beranda">Beranda</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#">Obyek Wisata</a></li>
      <li><a href="#">Fasilitas Wisata</a></li>
      <li><a href="#paket">Paket Wisata</a></li>
      <li><a href="#">Museum Niang Komodo</a></li>
      <li><a href="#paket">Pemesanan</a></li>
      <li><a href="#">Galery</a></li>
      <li><a href="cek_pesanan.php">Pesanan Saya</a></li>
    </ul>
  </nav>

  <main>

    <section class="snap-section hero-section" id="beranda">
      <div class="hero-card">
        <img src="images/1.jpg" alt="Banner Wisata" class="hero-image">
        <div class="hero-text animate-on-scroll slide-left">
          <h1>The World's<br>Hidden<br>Paradise</h1>
        </div>
      </div>
    </section>

    <section class="snap-section paket-section" id="paket">
      <div class="activity-block">
        <div class="animate-on-scroll slide-left">
          <h2 class="section-title">Kegiatan Wisata</h2>
          <p class="activity-desc">
            Beberapa aktivitas seru yang bisa kamu nikmati di Komodo National Park.
          </p>
        </div>

        <div class="activity-scroll animate-on-scroll slide-right">
          <div class="activity-card"><div class="activity-image"><img src="images/6.jpg"></div></div>
          <div class="activity-card"><div class="activity-image"><img src="images/7.jpg"></div></div>
          <div class="activity-card"><div class="activity-image"><img src="images/8.jpg"></div></div>
          <div class="activity-card"><div class="activity-image"><img src="images/9.jpg"></div></div>
          <div class="activity-card"><div class="activity-image"><img src="images/10.jpg"></div></div>
        </div>
      </div>

      <div class="animate-on-scroll slide-left">
        <h2 class="section-title">Paket</h2>
      </div>

      <div class="paket-scroll animate-on-scroll slide-right">

        <article class="paket-card">
          <div class="paket-image"><img src="images/2.jpg"></div>
          <h3>1 Day Trip Phinisi Boat</h3>
          <p class="paket-desc">Fullday With Sunset Trip</p>
          <span class="paket-price-badge">Rp.1,500,000</span>
          <a class="btn-book" href="pemesanan.php?paket=1 Day Trip Phinisi Boat">Pesan Paket</a>
        </article>

        <article class="paket-card">
          <div class="paket-image"><img src="images/3.jpg"></div>
          <h3>2 Days 1 Night</h3>
          <p class="paket-desc">Kapal Phinisi Kelas Deluxe</p>
          <span class="paket-price-badge">Rp.3,000,000</span>
          <a class="btn-book" href="pemesanan.php?paket=2 Days 1 Night">Pesan Paket</a>
        </article>

        <article class="paket-card">
          <div class="paket-image"><img src="images/4.jpg"></div>
          <h3>3 Hari 2 Malam</h3>
          <p class="paket-desc">Live On Board and Superior Phinisi</p>
          <span class="paket-price-badge">Rp.2.650.000</span>
          <a class="btn-book" href="pemesanan.php?paket=3 Hari 2 Malam">Pesan Paket</a>
        </article>

        <article class="paket-card">
          <div class="paket-image"><img src="images/5.jpg"></div>
          <h3>1 Day Trip Speedboat</h3>
          <p class="paket-desc">6 Destinasi Premium</p>
          <span class="paket-price-badge">Rp.1,450,000</span>
          <a class="btn-book" href="pemesanan.php?paket=1 Day Trip Speedboat">Pesan Paket</a>
        </article>

      </div>
    </section>

    <section class="snap-section about-section" id="about">
      <div class="about-layout">
        <div class="about-media animate-on-scroll slide-left">
          <iframe src="https://www.youtube.com/embed/B95MRLYcazM" allowfullscreen></iframe>
        </div>
        
        <div class="about-text animate-on-scroll slide-right">
          <h2>About Us</h2>
          <p>
            Pulau Komodo adalah pulau di Nusa Tenggara Timur<br>
            yang merupakan bagian dari Taman Nasional Komodo,<br>
            Situs Warisan Dunia UNESCO dan habitat asli komodo.
          </p>
          <a class="btn-contact">Contact</a>
        </div>
      </div>
    </section>

  </main>

  <footer>© 2025 Landing Page Wisata</footer>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, { threshold: 0.3 });

      document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
      });

      const burgerBtn = document.getElementById('burgerBtn');
      const mobileNav = document.getElementById('mobileNav');

      burgerBtn.addEventListener('click', () => {
        mobileNav.classList.toggle('open');
        burgerBtn.classList.toggle('open');
      });

      mobileNav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
          mobileNav.classList.remove('open');
          burgerBtn.classList.remove('open');
        });
      });
    });
  </script>

</body>
</html>

