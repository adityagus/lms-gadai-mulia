<template>
  <header class="flex items-center justify-between gap-[30px]">
    <div>
      <h1 class="font-extrabold text-[28px] leading-[42px]">Kelola Kelas</h1>
      <p class="text-[#838C9D] mt-[1]">Berikan masa depan terbaik untuk karyawan hebat Anda</p>
    </div>
    <div class="flex items-center gap-3">
      <!-- <RouterLink to="#" class="w-fit rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap">
        Import File
      </RouterLink> -->
      <RouterLink to="/courses/create" v-if='auth && (auth.idgrup === "JBT-032" || auth.idgrup === "JBT-038") && !loading'
        class="w-fit rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap">
        + Tambah Kelas 
      </RouterLink>
    </div>
  </header>
  <section id="CourseList" class="flex flex-col w-full rounded-[30px] p-[30px] gap-[30px]">

      <!-- Konten utama (CardCourses) saat data sudah siap -->
      <div v-for="item in courses" :key="item.id" v-if='!loading'>
          <CardCourses :id="item.id" :imageUrl="item.thumbnail_url" :name="item.name" :totalStudent="'12'"
            :category="item.category?.name" @delete-course='handleDelete' :readonly='!auth || (auth.idgrup !== "JBT-032" && auth.idgrup !== "JBT-038")' />
        </div>

      <!-- Konten loading (CardSkeleton) saat data sedang dimuat -->
      <template v-if='loading'>
        <div v-for="n in 5" :key='n'>
          <CardSkeleton />
        </div>
      </template>

    <div id="Pagination" class="flex items-center gap-3" v-if='courses.length > 0'>
      <button type="button" v-for='(key) in totalPages' :key='key' @click='goToPage(key)'
        class="flex shrink-0 w-9 h-9 rounded-full items-center justify-center text-center transition-all duration-300 hover:bg-[#662FFF] hover:text-white hover:border-0 bg-[#EAEAEA] text-[#662FFF]"
        :class="{'active': key==pagination}">
        <span class="font-semibold text-sm leading-[21px]">{{ key }}</span>
      </button>

    </div>
  </section>
</template>

<script setup>
import { RouterLink } from 'vue-router';
import CardCourses from './card.vue';
import axios from 'axios'
import { onMounted, ref } from 'vue';
import Swal from "sweetalert2";
import { deleteCourse, getCourses } from '@/services/courseService.js';
import { getSession } from '../../services/authService';
import CardSkeleton from '../../components/skeletons/CardSkeleton.vue';
// import { deleteCourse, getCourses } from './../../../services/courseService.js';

const courses = ref([])
const currentPage = ref(1);
const totalPages = ref(5);
const loading = ref(true); 
const pagination = ref(1);
const auth = ref(null);

// Fungsi untuk mengambil data kursus
const fetchCourses = async (page = 1) => {
    try {
      // console.log("Halaman", page);
      const result = await getCourses(page)
      // console.log("Hasil", result.data);
      courses.value = result.data
      totalPages.value = result.last_page
    } catch (error) {
      console.log("Terjadi kesalahan:", error);
    } finally {
      loading.value = false; // Setelah 500ms, hentikan loading dan tampilkan konten
    }
}

// Fungsi untuk menghapus kursus
const handleDelete = async (id) => {
  Swal.fire({
    title: "Apakah Anda yakin?",
    text: "Anda tidak dapat mengembalikan kursus ini!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#662FFF",
    cancelButtonColor: "#838C9D",
    confirmButtonText: "Ya, Hapus",
    cancelButtonText: "Batal"
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const res = await deleteCourse(id);
        if(res && (res.status == 200 || res.success)){
          Swal.fire({
            title: "Berhasil dihapus!",
            text: "Kursus telah dihapus.",
            icon: "success",
            confirmButtonColor: "#662FFF",
            timer: 1500
          });
          fetchCourses(pagination.value);
        }
      } catch (error) {
        console.log("Terjadi kesalahan:", error);
        Swal.fire({
          title: "Gagal!",
          text: "Gagal menghapus kursus.",
          icon: "error",
          confirmButtonColor: "#662FFF"
        });
      } 
    }
  });
}

onMounted(async () => {
  const [courses, resAuth] = await Promise.all([
    fetchCourses(currentPage.value),
    getSession()
  ]);
  // console.log("courses", courses);
  auth.value = resAuth.auth;
});

// Fungsi untuk pindah halaman
const goToPage = (page) => {
  currentPage.value = page;
  // console.log("currentPage.value", currentPage.value);
  pagination.value = page;
  loading.value = true;
  fetchCourses(page);
};

</script>
