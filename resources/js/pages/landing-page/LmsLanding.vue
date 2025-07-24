<template>
  <main class="landing-hero">
    <section class="hero-content">
      <h1 class="hero-title">Learning Management System (LMS) Modern &amp; Inovatif</h1>
      <p class="hero-desc">
        Platform pembelajaran digital untuk institusi, perusahaan, dan individu. Kelola kursus, materi, ujian, dan progres belajar dengan mudah, cepat, dan aman.
      </p>
      <a href="/sign-in" class="cta-btn">Mulai Belajar Sekarang</a>
    </section>
    <section class="features">
      <h2>Fitur Unggulan</h2>
      <ul>
        <li>✅ Manajemen Kursus &amp; Materi Interaktif</li>
        <li>✅ Progress Tracking &amp; Sertifikat Otomatis</li>
        <li>✅ Ujian Online &amp; Penilaian Otomatis</li>
        <li>✅ Dashboard Admin &amp; Laporan Lengkap</li>
        <li>✅ Mobile Friendly &amp; Akses 24/7</li>
        <li>✅ Integrasi API &amp; Keamanan Data</li>
      </ul>
    </section>
    <section class="seo-section">
      <h2>Apa itu LMS?</h2>
      <p>
        LMS (Learning Management System) adalah platform digital untuk mengelola, mendistribusikan, dan memantau proses pembelajaran secara online. Cocok untuk sekolah, universitas, pelatihan perusahaan, dan kursus online.
      </p>
      <h3>Keunggulan LMS Kami</h3>
      <ul>
        <li>Desain modern, responsif, dan mudah digunakan</li>
        <li>SEO friendly: struktur HTML, meta tag, dan kecepatan optimal</li>
        <li>Dukungan multi-bahasa dan aksesibilitas</li>
      </ul>
    </section>
  </main>
</template>

<script setup>
// SEO meta tag (gunakan vue-meta atau head di layout utama jika ada)
if (typeof document !== 'undefined') {
  document.title = 'LMS Modern & Inovatif - Platform Pembelajaran Digital';
  const metaDesc = document.querySelector('meta[name="description"]');
  if (metaDesc) {
    metaDesc.setAttribute('content', 'LMS modern, responsif, dan SEO friendly untuk pembelajaran online, manajemen kursus, ujian, dan sertifikat.');
  } else {
    const meta = document.createElement('meta');
    meta.name = 'description';
    meta.content = 'LMS modern, responsif, dan SEO friendly untuk pembelajaran online, manajemen kursus, ujian, dan sertifikat.';
    document.head.appendChild(meta);
  }
}
</script>

<style scoped>
.landing-hero {
  min-height: 100vh;
  background: linear-gradient(120deg, #662FFF 0%, #4F46E5 100%);
  color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  padding: 0 1rem 3rem 1rem;
}
.hero-content {
  max-width: 700px;
  text-align: center;
  margin-top: 80px;
}
.hero-title {
  font-size: 2.5rem;
  font-weight: 800;
  margin-bottom: 1rem;
  line-height: 1.2;
}
.hero-desc {
  font-size: 1.25rem;
  margin-bottom: 2rem;
  color: #e0e7ff;
}
.cta-btn {
  display: inline-block;
  background: #fff;
  color: #4F46E5;
  font-weight: 700;
  padding: 0.75rem 2rem;
  border-radius: 2rem;
  font-size: 1.1rem;
  box-shadow: 0 2px 8px rgba(80,60,200,0.08);
  transition: background 0.2s, color 0.2s;
  text-decoration: none;
}
.cta-btn:hover {
  background: #4F46E5;
  color: #fff;
}
.features {
  background: #fff;
  color: #222;
  border-radius: 1rem;
  margin: 2rem 0;
  padding: 2rem 1.5rem;
  max-width: 600px;
  box-shadow: 0 2px 12px rgba(80,60,200,0.08);
}
.features h2 {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
}
.features ul {
  list-style: none;
  padding: 0;
}
.features li {
  font-size: 1.1rem;
  margin-bottom: 0.7rem;
  display: flex;
  align-items: center;
}
.seo-section {
  max-width: 700px;
  background: #f8fafc;
  color: #222;
  border-radius: 1rem;
  padding: 2rem 1.5rem;
  margin-top: 2rem;
  box-shadow: 0 2px 12px rgba(80,60,200,0.06);
}
.seo-section h2, .seo-section h3 {
  color: #4F46E5;
  font-weight: 700;
}
@media (max-width: 600px) {
  .hero-title { font-size: 1.5rem; }
  .features, .seo-section { padding: 1rem; }
}
</style>
