<script setup>
import axios from "axios";
import Swal from "sweetalert2";
import { reactive, ref, defineProps, onMounted } from "vue";
import { useForm, useField } from 'vee-validate';
import { createCourseSchema, updateCourseSchema } from "@/utils/zodSchema";
import { toTypedSchema } from '@vee-validate/zod';
import { useMutation, useQueryClient } from "@tanstack/vue-query";
import { createCourse, getCategories, getCourseById, updateCourse } from "@/services/courseService";
import { useRoute, useRouter } from "vue-router";


const categories = ref([])
const file = ref(null);
const imageUrl = ref(null);
const inputFileRef = ref(null);

const queryClient = useQueryClient();
const router = useRouter();
const route = useRoute();
const id = route.params.courseId;
console.log("Course ID:", id);
const edit = route.params.courseId ? true : false;
const course = ref({
  name: "",
  tagline: "",
  categoryId: null,
  description: "",
  is_popular: 0,
});

const triggerFileInput = () => {
  event.preventDefault(); // Prevent default action
  inputFileRef.value?.click(); // Trigg
  // inputFileRef.value?.click();
};

const mutateCreate = useMutation({
  mutationFn: (data) => createCourse(data)
})

const mutateUpdate = useMutation({
  mutationFn: (data) => updateCourse(id, data)
})

// Function untuk menangani perubahan pada file input
const onFileChange = (event) => {
  console.log("File changed:", event.target.files[0]);
  const selectedFile = event.target.files[0];
  if (selectedFile) {
    file.value = selectedFile;
    imageUrl.value = URL.createObjectURL(selectedFile);
    thumbnail.value = selectedFile;
  }
};


const { values, errors, handleSubmit, isSubmitting, defineField, register, setFieldValue } = useForm({
  validationSchema: toTypedSchema(edit ? updateCourseSchema : createCourseSchema),
  initialValues: {
    name: course.value.name || '',
    tagline: course.value.tagline || '',
    thumbnail: course.value.thumbnail || null,
    categoryId: course.value.categoryId || null,
    description: course.value.description || '',
    is_popular: course.value.is_popular || 0,
  },
});
const [name, nameAttrs] = defineField('name');
const [tagline, taglineAttrs] = defineField('tagline');
const [thumbnail, thumbnailAttrs] = defineField('thumbnail');
const [categoryId, categoryIdAttrs] = defineField('categoryId');
const [description, descriptionAttrs] = defineField('description');
const [isPopular, isPopularAttrs] = defineField('is_popular');


const onSubmit = handleSubmit(async (data) => {
  console.log("Submitted data:", data);
  const formData = new FormData();
  try {
    formData.append('name', data.name);
    formData.append('slug', data.name.toLowerCase().replace(/\s+/g, '-'));
    formData.append('thumbnail', file.value);
    formData.append('tagline', data.tagline);
    formData.append('description', data.description);
    formData.append('students', JSON.stringify([1, 2, 3]));
    formData.append('details', JSON.stringify({ info: 'Additional details' }));
    formData.append('category_id', data.categoryId);
    formData.append('is_popular', data.is_popular ? 1 : 0);

    // const result = await axios.post(
    //   "http://lms-gadai.test/api/courses/",
    //   value,
    //   {
    //     headers: {
    //       "Content-Type": "application/json",
    //     },
    //   }np
    // );
    
    
    
    
    for (let [key, value] of formData.entries()) {
      console.log(key, value);  // Log each key-value pair to ensure all fields are included
    }
    
    if(edit){
      await mutateUpdate.mutate({ courseId: id, formData: data });
    }else{
      await mutateCreate.mutate(formData);
    }
    
    router.push('/admin/courses');
    queryClient.invalidateQueries({ queryKey: ['courses'] });
    Swal.fire({
      title: "Success!",
      text: "Course created successfully.",
      icon: "success",
      timer: 1500,
    });
    // Redirect to the courses page without reloading
    // window.history.pushState(null, '', '/admin/courses');
  } catch (err) {
    console.dir(err);
    Swal.fire({
      title: "Error!",
      text: err.message,
      icon: "error",
      timer: 1500,
    });
  }

});

onMounted(async () => {
  try {
    const fetchCategories = await getCategories();
    categories.value = fetchCategories;

    if (route.params.courseId) {
      const fetchedCourse = await getCourseById(route.params.courseId);
      console.log("Fetched Course:", fetchedCourse);
      
      // Update course values directly
      course.value = { ...fetchedCourse };

      // Manually update form values
      setFieldValue("name", fetchedCourse.name);
      setFieldValue("tagline", fetchedCourse.tagline);
      setFieldValue("thumbnail", fetchedCourse.thumbnail);
      setFieldValue("categoryId", fetchedCourse.category_id);
      setFieldValue("description", fetchedCourse.description);
      setFieldValue("is_popular", fetchedCourse.is_popular);
    }


  } catch (error) {
    console.log(error);
  }
});


</script>

<template>
  <header class="flex items-center justify-between gap-[30px]">
    <div>
      <h1 class="font-extrabold text-[28px] leading-[42px]">
        {{ !edit ? "Create " : "Update" }} Course
      </h1>
      <p class="text-[#838C9D] mt-[1]">{{ !edit ? "Create " : "Update" }} new future for company</p>
    </div>
    <div class="flex items-center gap-3">
      <Link href="#" class="w-fit rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap">
      Import from BWA
      </Link>
    </div>
  </header>
  <form @submit.prevent='onSubmit' class="flex flex-col w-[550px] rounded-[30px] p-[30px] gap-[30px] bg-[#F8FAFB]">
    <div class="flex flex-col gap-[10px]">
      <label htmlFor="title" class="font-semibold">Course Name</label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]"
        :class='{ "ring-2 ring-[#FF435A]": errors?.name }'>
        <img src="/assets/images/icons/note-favorite-black.svg" class="w-6 h-6" alt="icon" />
        <input type="text" name="title" id="title"
          class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          placeholder="Write better name for your course" v-model='name' v-bind="nameAttrs" />
      </div>
      <span class="error-message text-[#FF435A]">
        {{ errors?.name }}
      </span>
    </div>
    <div class="relative flex flex-col gap-[10px]">
      <label htmlFor="thumbnail" class="font-semibold">Add a Thumbnail</label>
      <div id="thumbnail-preview-container" :class="[
        'relative flex shrink-0 w-full h-[200px] rounded-[20px] border border-[#CFDBEF] overflow-hidden',
        errors.thumbnail ? 'ring-2 ring-[#FF435A]' : ''
      ]">
        <button @click='triggerFileInput' type="button" id="trigger-input" class="absolute top-0 left-0 w-full
          h-full flex justify-center items-center gap-3 z-0">
          <img src="/assets/images/icons/gallery-add-black.svg" class="w-6 h-6" alt="icon" />
          <span class="text-[#838C9D]">Add an attachment</span>
        </button>
        <img id="thumbnail-preview" :src="file !== null ? imageUrl : ''"
          :class="['w-full h-full object-cover', file == null ? 'hidden' : '']" alt="thumbnail" />
        <button type="button" id="delete-preview" class="absolute right-[10px] bottom-[10px] w-12 h-12 rounded-full z-10 hidden">
          <img src="/assets/images/icons/delete.svg" alt="delete" />
        </button>
      </div>
      <span class="error-message text-[#FF435A]">
        {{ errors?.thumbnail }}
      </span>
      <input ref="inputFileRef" @change='onFileChange' type="file" id="thumbnail" accept="image/*" v-bind='thumbnailAttrs'
        class="absolute bottom-0 left-1/4 -z-10" />
    </div>
    <!-- <button @click='increment'>Increment</button>
    <button @click='decrement'>Decrement</button>
    
    {{ value }} -->
    <div class="flex flex-col gap-[10px]">
      <label htmlFor="tagline" class="font-semibold">Course Tagline</label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]"
        :class='{ "ring-2 ring-[#FF435A]": errors?.tagline }'>
        <img src="/assets/images/icons/bill-black.svg" class="w-6 h-6" alt="icon" />
        <input type="text" name="tagline" id="tagline"
          class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          placeholder="Write tagline for better copy" v-model='tagline' v-bind="taglineAttrs" />
      </div>
      <span class="error-message text-[#FF435A]">
        {{ errors?.tagline }}
      </span>
    </div>
    <div class="flex flex-col gap-[10px]">
      <label htmlFor="category" class="font-semibold">Select Category</label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]"
        :class='{ "ring-2 ring-[#FF435A]": errors?.categoryId }'>
        <img src="/assets/images/icons/bill-black.svg" class="w-6 h-6" alt="icon" />
        <select name="category" id="category"
          class="appearance-none outline-none w-full py-3 px-2 -mx-2 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent ring-[#FF435A]"
          v-model="categoryId" v-bind="categoryIdAttrs">
          <option :value="categoryId == null ? categoryId : ''" selected>
            Choose content type
          </option>
          <!-- <pre>{{ categories }}</pre> -->
          <option :value="parseInt(category.id)" :key="category.id" v-for='category in categories'>{{ category.name }}</option>
        </select>
        <img src="/assets/images/icons/arrow-down.svg" class="w-6 h-6" alt="icon" />
      </div>
      <span class="error-message text-[#FF435A]">
        {{ errors?.categoryId }}
      </span>
    </div>
    <div class="flex flex-col gap-[10px]">
      <label htmlFor="desc" class="font-semibold">Description</label>
      <div
        class="flex w-full rounded-[20px] border border-[#CFDBEF] gap-3 p-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF] "
        :class='{ "ring-2 ring-[#FF435A]": errors?.description }'>
        <img src="/assets/images/icons/note-black.png" class="w-6 h-6" alt="icon" />
        <textarea name="desc" id="desc" rows="5"
          class="appearance-none outline-none w-full font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          placeholder="Explain what this course about" v-model="description" v-bind='descriptionAttrs'></textarea>
      </div>
      <span class="error-message text-[#FF435A]">
        {{ errors?.description }}
      </span>
    </div>
    <div class="flex items-center gap-[14px]">
      <button type="submit" class="w-full rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap">
        Save as Draft
      </button>
      <button type="submit" :disabled="edit ? mutateUpdate.isLoading : mutateCreate.isLoading"
        class="w-full rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap">
        {{ !edit ? "Create " : "Update" }} Now
      </button>
    </div>
  </form>
</template>



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
