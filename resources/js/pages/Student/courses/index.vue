<template>
  <header class="flex items-center justify-between gap-[30px]">
    <div>
      <h1 class="font-extrabold text-[28px] leading-[42px]">My Courses</h1>
      <p class="text-[#838C9D] mt-[1]">Lihat daftar kursus yang kamu ikuti</p>
    </div>
  </header>
  <section id="CourseList" class="flex flex-col w-full rounded-[30px] p-[30px] gap-[30px]">
    <!-- Main content (CardCourses) when data is ready -->
    <div v-for="item in courses" :key="item.id" v-if='!loading'>
      <div class="relative">
        <CardCourses 
          :id="item.id" 
          :imageUrl="item.thumbnail_url" 
          :name="item.name" 
          :totalStudent="item.total_student || '-'"
          :category="item.category?.name"
          readOnly
        />
        <router-link
          :to="`/student/courses/${item.id}/preview`"
          class="absolute top-4 right-4 bg-[#662FFF] text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-[#5521cc] transition-colors"
        >
          Open
        </router-link>
      </div>
    </div>

    <!-- Loading content (CardSkeleton) while data is loading -->
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
import CardCourses from '../../Admin/courses/card.vue';
import CardSkeleton from '../../Admin/courses/CardSkeleton.vue';
import { onMounted, ref } from 'vue';
import { getCourses } from '../../../services/courseService.js';

const courses = ref([])
const currentPage = ref(1);
const totalPages = ref(5);
const loading = ref(true); 
const pagination = ref(1);
let initSecond = ref(1000);

const fetchCourses = async (page = 1) => {
  setTimeout( async () => {
    try {
      const result = await getCourses(page)
      courses.value = result.data
      totalPages.value = result.last_page
    } catch (error) {
      console.log("ERROR", error);
    } finally {
      loading.value = false;
      initSecond.value = 500
    }
  }, initSecond.value);
}

onMounted(() => {
  fetchCourses(currentPage.value);
});

const goToPage = (page) => {
  currentPage.value = page;
  pagination.value = page;
  loading.value = true;
  fetchCourses(page);
};
</script>
