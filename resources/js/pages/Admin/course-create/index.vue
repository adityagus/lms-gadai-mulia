<template>
  <header class="flex items-center justify-between gap-[30px]">
    <div>
      <h1 class="font-extrabold text-[28px] leading-[42px]">
        New Course
      </h1>
      <p class="text-[#838C9D] mt-[1]">Create new future for company</p>
    </div>
    <div class="flex items-center gap-3">
      <Link href="#" class="w-fit rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap">
      Import from BWA
      </Link>
    </div>
  </header>
  <form @submit='' class="flex flex-col w-[550px] rounded-[30px] p-[30px] gap-[30px] bg-[#F8FAFB]">
    <div class="flex flex-col gap-[10px]">
      <label htmlFor="title" class="font-semibold">Course Name</label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
        <img src="/assets/images/icons/note-favorite-black.svg" class="w-6 h-6" alt="icon" />
        <input type="text" name="title" id="title"
          class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          placeholder="Write better name for your course" required v-model="course.name" />
      </div>
      <span class="error-message text-[#FF435A]">
        <!-- {{ errors?.name?.message }} -->
      </span>
    </div>
    <div class="relative flex flex-col gap-[10px]">
      <label htmlFor="thumbnail" class="font-semibold">Add a Thumbnail</label>
      <div id="thumbnail-preview-container" :class="[
        'relative flex shrink-0 w-full h-[200px] rounded-[20px] border border-[#CFDBEF] overflow-hidden'
      ]">
        <button 
        @click='triggerFileInput'
        type="button" id="trigger-input" class="absolute top-0 left-0 w-full
          h-full flex justify-center items-center gap-3 z-0">
          <img src="/assets/images/icons/gallery-add-black.svg" class="w-6 h-6" alt="icon" />
          <span class="text-[#838C9D]">Add an attachment</span>
        </button>
        <img id="thumbnail-preview" 
        :src="file !==null ? imageUrl : ''" 
        :class="['w-full h-full object-cover', file==null ? 'hidden' : '']" alt="thumbnail" /> 
        <button type="button" id="delete-preview" class="absolute right-[10px] bottom-[10px] w-12 h-12 rounded-full z-10 hidden">
          <img src="/assets/images/icons/delete.svg" alt="delete" />
        </button>
      </div>
      <!-- <span class="error-message text-[#FF435A]">
        { errors?.thumbnail?.message }
      </span> -->
      <input 
      ref="inputFileRef"
      @change='onFileChange'
      type="file" id="thumbnail" accept="image/*" class="absolute bottom-0 left-1/4 -z-10"/>
    </div>
    <!-- <button @click='increment'>Increment</button>
    <button @click='decrement'>Decrement</button>
    
    {{ value }} -->
    <div class="flex flex-col gap-[10px]">
      <label htmlFor="tagline" class="font-semibold">Course Tagline</label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
        <img src="/assets/images/icons/bill-black.svg" class="w-6 h-6" alt="icon" />
        <input type="text" name="tagline" id="tagline"
          class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          placeholder="Write tagline for better copy" />
      </div>
      <span class="error-message text-[#FF435A]">
        <!-- {{ errors?.tagline?.message }} -->
      </span>
    </div>
    <div class="flex flex-col gap-[10px]">
      <label htmlFor="category" class="font-semibold">Select Category</label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
        <img src="/assets/images/icons/bill-black.svg" class="w-6 h-6" alt="icon" />
        <select name="category" id="category"
          class="appearance-none outline-none w-full py-3 px-2 -mx-2 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          v-model="course.category_id">
          <option value="" hidden>Choose one category</option>
          <option value="1">Text</option>
          <option value="2">Video</option>
          <option value="3">PDf</option>
        </select>
        <img src="/assets/images/icons/arrow-down.svg" class="w-6 h-6" alt="icon" />
      </div>
      <span class="error-message text-[#FF435A]">
        <!-- {{ errors?.categoryId?.message }} -->
      </span>
    </div>
    <div class="flex flex-col gap-[10px]">
      <label htmlFor="desc" class="font-semibold">Description</label>
      <div
        class="flex w-full rounded-[20px] border border-[#CFDBEF] gap-3 p-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF] ring-2 ring-[#FF435A]">
        <img src="/assets/images/icons/note-black.png" class="w-6 h-6" alt="icon" />
        <textarea name="desc" id="desc" rows="5"
          class="appearance-none outline-none w-full font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          placeholder="Explain what this course about" v-model="course.about"></textarea>
      </div>
      <span class="error-message text-[#FF435A]">
        <!-- {{ errors?.categoryId?.message }} -->
      </span>
      <span class="error-message text-[#FF435A]">The description is required</span>
    </div>
    <div class="flex items-center gap-[14px]">
      <button type="submit" class="w-full rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap">
        Save as Draft
      </button>
      <button type="submit"
        class="w-full rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap">
        Create Now
      </button>
    </div>
  </form>
</template>

<script setup>
import axios from "axios";
import Swal from "sweetalert2";
import { reactive, ref } from "vue";

// Reactive references
const file = ref(null);
const imageUrl = ref(null);
const inputFileRef = ref(null);

const triggerFileInput = () => {
  event.preventDefault(); // Prevent default action
  inputFileRef.value?.click(); // Trigg
  // inputFileRef.value?.click();
};

// Function untuk menangani perubahan pada file input
const onFileChange = (event) => {
  console.log("File changed:", event.target.files[0]);
  const selectedFile = event.target.files[0];
  if (selectedFile) {
    file.value = selectedFile;
    console.log('imageURl1', imageUrl)
    imageUrl.value = URL.createObjectURL(selectedFile); // Menampilkan preview gambar
    course.thumbnail = imageUrl.value; // Update course thumbnail
    console.log('imageURl2', imageUrl)
  }
};

const value = ref(0);
const increment = () => {
  value.value++;
};

const decrement = () => {
  if (value.value > 0) {
    value.value--;
  }
};

const course = reactive({
  name: "",
  slug: `cobain${Math.random()}`,
  thumbnail: "thumbnail",
  about: "",
  category_id: "",
  is_popular: "1",
});

const createCourse = async () => {
  try {
    console.log("course.value", course);
    const result = await axios.post(
      "http://lms-gadai.test/api/courses/",
      course.value,
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    console.log(result);
    if (result.data.status == 200) {
      Swal.fire({
        title: "Created!",
        text: "Your file has been created.",
        icon: "success",
        timer: 1500,
      });

      //  window.location.href('/admin/course');
    }
  } catch (err) {
    console.dir(err);
    Swal.fire({
      title: "Error!",
      text: err.message,
      icon: "error",
      timer: 1500,
    });
  }

  console.log("course", course);
};
</script>

<!-- <template>
  <div>
    <input type="file" @change="handleFileChange" />
    <button @click="uploadFile">Upload</button>
    <p v-if="responseMsg">{{ responseMsg }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      selectedFile: null,
      responseMsg: '',
    };
  },
  methods: {
    handleFileChange(event) {
      this.selectedFile = event.target.files[0];
    },
    async uploadFile() {
      if (!this.selectedFile) return;

      const formData = new FormData();
      formData.append('file', this.selectedFile);

      try {
        const response = await axios.post('http://localhost:8000/api/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        this.responseMsg = response.data.message;
      } catch (error) {
        this.responseMsg = 'Upload gagal';
        console.error(error);
      }
    },
  },
};
</script> -->
