<template>
  <header class="flex items-center justify-between gap-[30px]">
    <div>
      <h1 class="font-extrabold text-[28px] leading-[42px]">List Courses</h1>
      <p class="text-[#838C9D] mt-[1]">Lihat daftar kursus</p>
    </div>
  </header>
  <section id="CourseList" class="flex flex-col w-full rounded-[30px] gap-[30px]">
    <!-- Main content (CardCourses) when data is ready -->
    <div v-for="item in courses" :key="item.id" v-if='!loading'>
      <div
        class="relative group cursor-pointer rounded-2xl bg-white border border-gray-200 shadow-md px-0 py-0 overflow-hidden transition-all duration-200 hover:shadow-xl hover:scale-[1.025] hover:border-[#662FFF]"
        @click="goToDetail(item.id)"
      >
        <div class="flex flex-col md:flex-row items-stretch">
          <div class="w-full md:w-48 h-40 md:h-auto flex-shrink-0 bg-gray-100 flex items-center justify-center overflow-hidden">
            <img :src="item.thumbnail_url" alt="thumbnail" class="object-cover w-full h-48 transition-transform duration-300 group-hover:scale-105" />
          </div>
          <div class="flex-1 flex flex-col justify-between p-5">
            <div>
              <div class="flex items-center gap-2 mb-2">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-[#F3E8FF] text-[#662FFF]">{{ item.category?.name || 'Uncategorized' }}</span>
                <span class="ml-auto text-xs text-gray-400">ID: {{ item.id }}</span>
              </div>
              <h2 class="font-bold text-lg text-[#2D1A5A] mb-1 line-clamp-2">{{ item.name }}</h2>
              <p class="text-sm text-gray-500 line-clamp-2 mb-2">{{ item.description || 'Tidak ada deskripsi.' }}</p>
            </div>
            <div class="flex items-center justify-between mt-4">
              <span class="text-xs text-gray-400">Created: {{ item.created_at ? item.created_at.split('T')[0] : '-' }}</span>
            </div>
          </div>
        </div>
        <div class="absolute inset-0 pointer-events-none rounded-2xl border-2 border-transparent group-hover:border-[#662FFF] transition-all duration-200"></div>
      </div>
    </div>

    <!-- Loading content (CardSkeleton) while data is loading -->
    <template v-if='loading'>
      <div v-for="n in 5" :key='n'>
        <CardSkeletonStudent />
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
import CardCourses from '../../courses/card.vue';
import { onMounted, ref } from 'vue';
import { getCourses } from '../../../services/courseService.js';
import { useRouter } from 'vue-router';
import CardSkeletonStudent from '../../../components/skeletons/CardSkeletonStudent.vue';

const router = useRouter();
const courses = ref([])
const currentPage = ref(1);
const totalPages = ref(5);
const loading = ref(true); 
const pagination = ref(1);

const fetchCourses = async (page = 1) => {
    try {
      const result = await getCourses(page)
      courses.value = result.data
      totalPages.value = result.last_page
    } catch (error) {
      console.log("ERROR", error);
    } finally {
      loading.value = false;
    }
}



const goToDetail = (id) => {
  router.push(`/student/courses/${id}`);
};

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
