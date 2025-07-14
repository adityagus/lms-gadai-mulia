<template>
  <div>
    <div class="card flex items-center gap-5">
      <div
        class="flex shrink-0 w-[140px] h-[110px] rounded-[20px] bg-[#D9D9D9] overflow-hidden"
      >
        <img
          :src="imageUrl"
          class="w-full h-full object-cover"
          alt="thumbnail"
        />
      </div>
      <div class="w-full">
        <h3 class="font-bold text-xl leading-[30px] line-clamp-1">
          {{ name }}
        </h3>
        <div class="flex items-center gap-5">
          <div class="flex items-center gap-[6px] mt-[6px]">
            <img
              src="/assets/images/icons/profile-2user-purple.svg"
              class="w-5 h-5"
              alt="icon"
            />
            <p class="text-[#838C9D]">{{ totalStudent }} Students</p>
          </div>
          <div class="flex items-center gap-[6px] mt-[6px]">
            <img
              src="/assets/images/icons/crown-purple.svg"
              class="w-5 h-5"
              alt="icon"
            />
            <p class="text-[#838C9D]">{{ category }}</p>
          </div>
        </div>
      </div>
      <div class="flex justify-end items-center gap-3">
        <RouterLink
          :to="`/admin/courses/${id}`"
          class="w-fit rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap"
        >
          Manage
        </RouterLink>
        <button type='button'
          @click="deleteCourse(`${id}`)"
          class="w-fit rounded-full border bg-rose-400 text-red-600 p-[14px_20px] font-semibold text-nowrap"
        >
          Delete
        </button>
      </div>
    </div>
  </div>
</template>

<!-- <script setup lang='ts'>

defineOptions({
  name: 'CardCourse'
})

const props = withDefaults(defineProps<{
  id?: any,
  imageUrl?: any,
  name?: any,
  totalStudent?: any,
  category?: any
}>(), {
  id: 1,
  imageUrl: '/assets/images/thumbnails/th-2.png',
  name: 'HTMX JavaScript 2020',
  totalStudent: '554',
  category: 'Marketing'
})
console.log(props);
</script> -->

<script setup>
import axios from "axios";
import { Button } from "primevue";
import { RouterLink } from "vue-router";

const emit = defineEmits(['delete-course'])

const deleteCourse = (id) => {
  emit('delete-course',id);  // Emit the delete-course event with the course ID
};

// const deleteCourse = async (id) => {
//   console.log('tesss');
//   Swal.fire({
//   title: "Are you sure?",
//   text: "You won't be able to revert this course!",
//   icon: "warning",
//   height: 100,
//   showCancelButton: true,
//   confirmButtonColor: "#3085d6",
//   cancelButtonColor: "#d33",
//   confirmButtonText: "Yes, delete it!"
// }).then(async (result) => {
//   if (result.isConfirmed) {
    
//      try {
//       const result = await axios.delete(`http://127.0.0.1:8000/api/courses/${id}`)
      
//       if(result.data.status == 200){
//         Swal.fire({
//           title: "Deleted!",
//           text: "Your file has been deleted.",
//           icon: "success",
//           timer: 1500
//         });
//       }
    
//       throw new Error({'message': "Tidak dapat dikirim"});
      
      
//     } catch (error) {
//       console.log("ERROR", error);
//     } 
//   }
// });
// }


defineProps({
  id: {
    type: Number,
    default: 1
  },
  imageUrl: {
    type: String,
    default: '/assets/images/thumbnails/th-2.png'
  },
  name: {
    type: String,
    default: "HTMX JavaScript 2020"
  },
  totalStudent: {
    type: String,
    default: "320"
  },
  category: {
    type: String,
    default: "Programming"
  },
})
</script>