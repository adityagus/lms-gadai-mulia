<template>
  <section class="landing-hero bg-gradient-to-br from-indigo-50 to-white min-h-screen flex flex-col justify-center items-center text-center px-4">
    <div class="max-w-2xl mx-auto py-20">
      <h1 class="text-4xl md:text-6xl font-extrabold text-indigo-800 mb-6 leading-tight">
        Selamat Datang di <span class="text-indigo-600">LMS Gadai Mulia</span>
      </h1>
      <p class="text-lg md:text-2xl text-gray-700 mb-8">
        Platform <strong>Learning Management System</strong> modern untuk pelatihan, kursus, dan pengembangan SDM berbasis digital. Mudah, aman, dan terintegrasi.
      </p>
      <a href="/register" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition-colors text-lg">
        Daftar Sekarang
      </a>
    </div>
    <div class="w-full flex justify-center">
      <img src="/assets/images/online-learning.svg" alt="LMS Gadai Mulia" class="max-w-md w-full h-auto" loading="lazy">
    </div>
    <div class="mt-16 max-w-3xl mx-auto text-gray-600">
      <h2 class="text-2xl font-bold mb-4 text-indigo-700">Fitur Unggulan</h2>
      <ul class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <li class="bg-white rounded-lg shadow p-6">
          <h3 class="font-semibold text-lg mb-2 text-indigo-600">Kelas Online Interaktif</h3>
          <p>Belajar dengan video, dokumen, dan kuis interaktif yang mudah diakses kapan saja.</p>
        </li>
        <li class="bg-white rounded-lg shadow p-6">
          <h3 class="font-semibold text-lg mb-2 text-indigo-600">Manajemen Sertifikat</h3>
          <p>Otomatisasi penerbitan sertifikat digital setelah menyelesaikan kursus.</p>
        </li>
        <li class="bg-white rounded-lg shadow p-6">
          <h3 class="font-semibold text-lg mb-2 text-indigo-600">Dashboard & Laporan</h3>
          <p>Pantau progres belajar, statistik peserta, dan laporan aktivitas secara real-time.</p>
        </li>
      </ul>
    </div>
    <footer class="mt-20 text-gray-400 text-sm">&copy; 2025 LMS Gadai Mulia. All rights reserved.</footer>
  </section>
</template>

<script setup>
// SEO meta tags
if (typeof window === 'undefined') {
  // SSR
  useHead({
    title: 'LMS Gadai Mulia - Platform Learning Management System Modern',
    meta: [
      { name: 'description', content: 'LMS Gadai Mulia adalah platform Learning Management System modern untuk pelatihan, kursus, dan pengembangan SDM berbasis digital.' },
      { name: 'keywords', content: 'LMS, Learning Management System, kursus online, pelatihan, sertifikat, e-learning, Gadai Mulia' },
      { property: 'og:title', content: 'LMS Gadai Mulia - Platform Learning Management System Modern' },
      { property: 'og:description', content: 'Platform LMS modern untuk pelatihan, kursus, dan pengembangan SDM.' },
      { property: 'og:image', content: '/assets/images/online-learning.svg' },
      { property: 'og:type', content: 'website' },
    ]
  });
}
</script>

<style scoped>
.landing-hero {
  background: linear-gradient(135deg, #eef2ff 0%, #fff 100%);
}
</style>