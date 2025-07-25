<template>
  <header class="flex items-center justify-between gap-[30px]">
    <div>
      <h1 class="font-extrabold text-[28px] leading-[42px]">Manage Courses</h1>
      <p class="text-[#838C9D] mt-[1]">Give the best future for your great employees</p>
    </div>
    <div class="flex items-center gap-3">
      <RouterLink to="#" class="w-fit rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap">
        Import File
      </RouterLink>
      <RouterLink to="/admin/courses/create"
        class="w-fit rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap">
        New Course
      </RouterLink>
    </div>
  </header>
  <section id="CourseList" class="flex flex-col w-full rounded-[30px] p-[30px] gap-[30px]">


      <!-- Main content (CardCourses) when data is ready -->
      <div v-for="item in courses" :key="item.id" v-if='!loading'>
          <CardCourses :id="item.id" :imageUrl="item.thumbnail_url" :name="item.name" :totalStudent="'12'"
            :category="item.category?.name" @delete-course='handleDelete' />
        </div>

      <!-- Loading content (CardSkeleton) while data is loading -->
      <template v-if='loading'>
        <div v-for="n in 5" :key='n'>
          <CardSkeleton />
        </div>
      </template>
    <!-- <CardCourses id='item.id' name/>
    <CardCourses />
    <CardCourses /> -->

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
import CardSkeleton from './CardSkeleton.vue';
import Swal from "sweetalert2";
import { getCourses } from './../../../services/courseService.js';




console.log("test");
const courses = ref([])
const currentPage = ref(1);
const totalPages = ref(5);
const loading = ref(true); 
const pagination = ref(1);
let initSecond = ref(1000);


const fetchCourses = async (page = 1) => {
  // console.log('initsecond', page);
  setTimeout( async () => {
    try {
      console.log("page", page);
      const result = await getCourses(page)
      console.log("result", result.data);
      courses.value = result.data
      totalPages.value = result.last_page
    } catch (error) {
      console.log("ERROR", error);
    } finally {
      loading.value = false; // After 2 seconds, stop loading and show actual content
      initSecond.value = 500
      // resolve();
    }
  }, initSecond.value);
}

const handleDelete = async (id) => {
  console.log('tesss');
  Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this course!",
  icon: "warning",
  height: 100,
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then(async (result) => {
  if (result.isConfirmed) {
    
     try {
      const result = await axios.delete(`http://127.0.0.1:8000/api/courses/${id}`)
      
      if(result.data.status == 200){
        Swal.fire({
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success",
          timer: 1500
        });
        
        fetchCourses(pagination.value);
        
      }
    
      throw new Error({'message': "Tidak dapat dikirim"});
      
      
    } catch (error) {
      console.log("ERROR", error);
    } 
  }
});
}

onMounted(() => {
  fetchCourses(currentPage.value);
});
// Function to handle page change
const goToPage = (page) => {
  currentPage.value = page;
  console.log("currentPage.value", currentPage.value);
  pagination.value = page;
  loading.value = true;
  fetchCourses(page);
};


</script>
