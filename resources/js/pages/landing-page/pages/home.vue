<template>
  <!-- Navbar -->
  <nav class="w-full bg-white shadow fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
      <a href="/" class="flex items-center gap-2">
        <img src="/assets/images/logos/lms.png" alt="Beladiri" class="w-36">
        <!-- <span class="font-bold text-indigo-700 text-xl">Beladiri</span> -->
      </a>
      <div class="hidden md:flex gap-8">
        <a href="#about" class="text-gray-700 hover:text-indigo-600 font-medium">Tentang Kami</a>
        <a href="#courses" class="text-gray-700 hover:text-indigo-600 font-medium">Kursus</a>
        <a href="#testimonial" class="text-gray-700 hover:text-indigo-600 font-medium">Testimoni</a>
        <a href="#faq" class="text-gray-700 hover:text-indigo-600 font-medium">FAQ</a>
      </div>
      <a href="/sign-in" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition-colors">{{ idgrup ? "Dashboard" : 'Login' }}</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="landing-hero bg-gradient-to-br from-indigo-50 to-white min-h-screen flex flex-col justify-center items-center text-center px-4 pt-32" data-aos="fade-up" data-aos-duration="1500">
    <div class="max-w-2xl mx-auto py-20">
      <h1 class="text-4xl md:text-6xl font-extrabold text-indigo-800 mb-6 leading-tight">
        Selamat Datang di <span class="text-indigo-600">Beladiri</span>
      </h1>
      <p class="text-lg md:text-2xl text-gray-700 mb-8">
        Platform <strong>Belajar Mandiri</strong> (Beladiri) modern untuk pelatihan, kursus, dan pengembangan SDM berbasis digital. Mudah, aman, dan terintegrasi.
      </p>
      <a href="/sign-in" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition-colors text-lg">
        Lihat Kursus
      </a>
    </div>
    <!-- <div class="w-full flex justify-center">
      <img src="/assets/images/online-learning.svg" alt="Beladiri" class="max-w-md w-full h-auto" loading="lazy">
    </div> -->
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
  </section>

  <!-- Category Card Section -->
  <section id="categories" class="max-w-6xl mx-auto py-20 px-4" data-aos="fade-up" data-aos-duration="1500">
    <h2 class="text-3xl font-bold text-indigo-700 mb-8 text-center">Kategori Kursus</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
      <div class="bg-white rounded-lg shadow-lg flex flex-col items-center p-6">
        <h3 class="font-semibold text-indigo-700 mb-2">Marketing</h3>
        <p class="text-gray-600 text-center">Strategi pemasaran, branding, dan promosi digital untuk bisnis masa kini.</p>
      </div>
      <div class="bg-white rounded-lg shadow-lg flex flex-col items-center p-6">
        <h3 class="font-semibold text-indigo-700 mb-2">Programming</h3>
        <p class="text-gray-600 text-center">Belajar coding, pengembangan aplikasi, dan teknologi software modern.</p>
      </div>
      <div class="bg-white rounded-lg shadow-lg flex flex-col items-center p-6">
        <h3 class="font-semibold text-indigo-700 mb-2">Design</h3>
        <p class="text-gray-600 text-center">Desain grafis, UI/UX, dan kreativitas visual untuk kebutuhan digital.</p>
      </div>
      <div class="bg-white rounded-lg shadow-lg flex flex-col items-center p-6">
        <h3 class="font-semibold text-indigo-700 mb-2">Finance</h3>
        <p class="text-gray-600 text-center">Manajemen keuangan, investasi, dan akuntansi untuk masa depan.</p>
      </div>
    </div>
  </section>
  <!-- About Us Section -->
  <section id="about" class="max-w-5xl mx-auto py-20 px-4 text-center" data-aos="fade-up" data-aos-duration="1500">
    <h2 class="text-3xl font-bold text-indigo-700 mb-6">Tentang Kami</h2>
    <p class="text-lg text-gray-700 mb-4">Beladiri (Belajar Mandiri) adalah platform pembelajaran digital yang didedikasikan untuk meningkatkan kualitas SDM melalui pelatihan dan kursus online yang interaktif dan terintegrasi. Kami berkomitmen untuk memberikan pengalaman belajar terbaik dengan teknologi terkini dan dukungan penuh bagi para peserta.</p>
    <div class="flex flex-col md:flex-row gap-8 justify-center items-center mt-8">
      <div class="bg-white rounded-lg shadow p-6 w-full md:w-1/3">
        <h3 class="font-semibold text-indigo-600 mb-2">Visi</h3>
        <p>Mewujudkan SDM unggul melalui pembelajaran digital yang mudah diakses dan berkualitas.</p>
      </div>
      <div class="bg-white rounded-lg shadow p-6 w-full md:w-1/3">
        <h3 class="font-semibold text-indigo-600 mb-2">Misi</h3>
        <p>Menyediakan platform LMS yang inovatif, aman, dan terintegrasi untuk pelatihan dan pengembangan SDM.</p>
      </div>
    </div>
  </section>

  <!-- Courses Card Section -->
  <section id="courses" class="bg-indigo-50 py-20 px-4" data-aos="fade-up" data-aos-duration="1500">
    <div class="max-w-6xl mx-auto text-center mb-12">
      <h2 class="text-3xl font-bold text-indigo-700 mb-4">Kursus Populer</h2>
      <p class="text-gray-700">Pilih kursus terbaik sesuai kebutuhan Anda dan mulai belajar mandiri sekarang!</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
      <div v-for="course in courses" :key="course.id" class="w-full bg-white rounded-lg shadow-lg flex flex-col">
        <img
          :src="course.thumbnail_url || '/assets/images/online-learning.svg'"
          :alt="course.name"
          class="w-full h-48 object-cover rounded-t-lg"
        >
        <div class="p-6 flex flex-col items-center">
          <h3 class="font-semibold text-lg text-indigo-700 mb-2">{{ course.name }}</h3>
          <p class="text-gray-600 mb-4 text-center">{{ course.description }}</p>
          <a :href="`/courses/${course.id}`" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Lihat Detail</a>
        </div>
      </div>
      <div v-if="courses.length === 0" class="col-span-3 text-center text-gray-500 py-10">Belum ada kursus populer.</div>
    </div>
  </section>

  <!-- Testimonial Section -->
  <section id="testimonial" class="max-w-6xl mx-auto py-20 px-4" data-aos="fade-up" data-aos-duration="1500">
    <h2 class="text-3xl font-bold text-indigo-700 mb-8 text-center">Testimoni Peserta</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-700 italic mb-4">"Platform Beladiri sangat membantu saya dalam memahami materi secara praktis dan mudah!"</p>
        <div class="flex items-center gap-3">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="h-10 w-10 rounded-full">
          <span class="font-semibold text-indigo-600">Budi Santoso</span>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-700 italic mb-4">"Materi kursus sangat lengkap dan mudah dipahami. Sertifikat digitalnya juga langsung didapat!"</p>
        <div class="flex items-center gap-3">
          <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="h-10 w-10 rounded-full">
          <span class="font-semibold text-indigo-600">Siti Aminah</span>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-700 italic mb-4">"Dashboard dan laporan progres sangat membantu saya memantau perkembangan belajar."</p>
        <div class="flex items-center gap-3">
          <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="User" class="h-10 w-10 rounded-full">
          <span class="font-semibold text-indigo-600">Agus Wijaya</span>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="bg-indigo-50 py-20 px-4" data-aos="fade-up" data-aos-duration="1500">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-3xl font-bold text-indigo-700 mb-8 text-center">FAQ</h2>
      <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="font-semibold text-indigo-600 mb-2">Siapa saja yang bisa mengakses Beladiri?</h3>
          <p class="text-gray-700">Beladiri dapat diakses oleh seluruh karyawan dan peserta pelatihan yang telah terdaftar oleh admin perusahaan.</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="font-semibold text-indigo-600 mb-2">Bagaimana cara login ke platform?</h3>
          <p class="text-gray-700">Silakan klik tombol Login di pojok kanan atas dan masukkan username serta password yang sudah diberikan oleh admin.</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="font-semibold text-indigo-600 mb-2">Apakah materi bisa diakses kapan saja?</h3>
          <p class="text-gray-700">Ya, seluruh materi pelatihan dapat diakses kapan saja selama masa pelatihan berlangsung.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-indigo-900 text-white pt-12 pb-6 mt-20">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 px-4">
      <!-- Logo & Deskripsi -->
      <div class="flex flex-col items-start md:items-start">
        <img src="/assets/images/logos/lms.png" alt="Beladiri" class="w-32 mb-4">
        <p class="text-sm">Platform Belajar Mandiri (Beladiri) modern untuk pelatihan, kursus, dan pengembangan SDM berbasis digital.</p>
      </div>
      <!-- Navigasi -->
      <div>
        <h3 class="font-semibold text-lg mb-4">Navigasi</h3>
        <ul class="space-y-2">
          <li><a href="#about" class="hover:underline">Tentang Kami</a></li>
          <li><a href="#categories" class="hover:underline">Kategori Kursus</a></li>
          <li><a href="#courses" class="hover:underline">Kursus Populer</a></li>
          <li><a href="#testimonial" class="hover:underline">Testimoni</a></li>
          <li><a href="#faq" class="hover:underline">FAQ</a></li>
        </ul>
      </div>
      <!-- Kontak -->
      <div>
        <h3 class="font-semibold text-lg mb-4">Kontak</h3>
        <ul class="space-y-2 text-sm">
          <li>Email: <a href="mailto:info@gadaimulia.com" class="hover:underline">info@gadaimulia.com</a></li>
          <li>Telepon: <a href="tel:+622112345678" class="hover:underline">(021) 123-45678</a></li>
          <li>Alamat: <a href="https://g.co/kgs/rfm8rsp" class='hover:underline'>Kirana Three Office Tower, Jl. Boulevard Raya No.1 Lantai 15, Klp. Gading Tim., Kec. Klp. Gading, Jkt Utara, Daerah Khusus Ibukota Jakarta 14240</a></li>
        </ul>
      </div>
      <!-- Social Media -->
      <div>
        <h3 class="font-semibold text-lg mb-4">Ikuti Kami</h3>
        <div class="flex gap-4 mt-2">
          <a href="#" aria-label="Instagram" class="hover:text-indigo-300">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5a5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5zm5.25.75a1 1 0 1 1-2 0a1 1 0 0 1 2 0z"/></svg>
          </a>
          <a href="#" aria-label="Facebook" class="hover:text-indigo-300">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.522-4.477-10-10-10S2 6.478 2 12c0 5.019 3.676 9.163 8.438 9.877v-6.987h-2.54v-2.89h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89c1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.242 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.89h-2.33v6.987C18.324 21.163 22 17.019 22 12z"/></svg>
          </a>
          <a href="#" aria-label="LinkedIn" class="hover:text-indigo-300">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.75-.784-1.75-1.75s.784-1.75 1.75-1.75s1.75.784 1.75 1.75s-.784 1.75-1.75 1.75zm13.5 11.268h-3v-5.604c0-1.337-.026-3.063-1.868-3.063c-1.868 0-2.154 1.459-2.154 2.967v5.7h-3v-10h2.881v1.367h.041c.401-.761 1.381-1.563 2.841-1.563c3.039 0 3.601 2.002 3.601 4.604v5.592z"/></svg>
          </a>
        </div>
      </div>
    </div>
    <div class="border-t border-indigo-700 mt-10 pt-6 text-center text-sm text-indigo-300">&copy; 2025 Beladiri (Belajar Mandiri). All rights reserved.</div>
  </footer>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';
const idgrup = ref(localStorage.getItem('idgrup'));

const courses = ref([]);

onMounted(async () => {
  AOS.init({ once: true });
  
  try {
    const res = await fetch('/api/courses?is_popular=1');
    if (res.ok) {
      const data = await res.json();
      console.log("data", data);
      courses.value = Array.isArray(data) ? data : (data.data || []);
    }
  } catch (e) {
    courses.value = [];
  }
});

// SEO meta tags
if (typeof window === 'undefined') {
  // SSR
  useHead({
    title: 'Beladiri (Belajar Mandiri) - Platform Belajar Mandiri Modern',
    meta: [
      { name: 'description', content: 'Beladiri (Belajar Mandiri) adalah platform belajar mandiri modern untuk pelatihan, kursus, dan pengembangan SDM berbasis digital.' },
      { name: 'keywords', content: 'Beladiri, Belajar Mandiri, kursus online, pelatihan, sertifikat, e-learning, belajar mandiri' },
      { property: 'og:title', content: 'Beladiri (Belajar Mandiri) - Platform Belajar Mandiri Modern' },
      { property: 'og:description', content: 'Platform Beladiri modern untuk pelatihan, kursus, dan pengembangan SDM.' },
      { property: 'og:image', content: '/assets/images/online-learning.svg' },
      { property: 'og:type', content: 'website' },
    ]
  });
}
</script>

<style scoped>
/* *{
  scroll-behavior: smooth;
} */
/* scroll smooth while click */
html {
  scroll-behavior: smooth;
}

.landing-hero {
  background: linear-gradient(135deg, #eef2ff 0%, #fff 100%);
}
</style>