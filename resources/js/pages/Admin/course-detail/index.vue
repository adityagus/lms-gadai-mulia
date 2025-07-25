<template>
  <div id="Breadcrumb" class="flex items-center gap-5 *:after:content-['/'] *:after:ml-5">
    <span class="last-of-type:after:content-[''] last-of-type:font-semibold">
      Dashboard
    </span>
    <span class="last-of-type:after:content-[''] last-of-type:font-semibold">
      <RouterLink to="/admin/courses">Manage Course</RouterLink>
    </span>
    <span class="last-of-type:after:content-[''] last-of-type:font-semibold">
      Details
    </span>
  </div>
  <header class="flex items-center justify-between gap-[30px]">
    <div>
      <h1 class="font-extrabold text-[28px] leading-[42px]">
        {{ course?.name }}
      </h1>
    </div>
    <div class="flex items-center gap-3">
      <RouterLink :to="`/admin/courses/${course?.id}/edit`" class="w-fit rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap">
        Edit Course
      </RouterLink>
      <RouterLink :to="`/admin/course/${course?.id}/preview`"
        class="w-fit rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap">
        Preview Course
      </RouterLink>
    </div>
  </header>
  <section id="CourseInfo" class="flex gap-[50px]">
    <div id="Thumbnail" class="flex shrink-0 w-[480px] h-[250px] rounded-[20px] bg-[#D9D9D9] overflow-hidden">
      <img :src="course?.thumbnail_url" class="w-full h-full object-cover" alt="thumbnail" />
    </div>
    <div class="grid grid-cols-2 gap-5 w-full">
      <div class="flex flex-col rounded-[20px] border border-[#CFDBEF] p-5 gap-4">
        <img src="/assets/images/icons/profile-2user-purple.svg" class="w-8 h-8" alt="icon" />
        <p class="font-semibold"> 0 Students</p>
      </div>
      <div class="flex flex-col rounded-[20px] border border-[#CFDBEF] p-5 gap-4">
        <img src="/assets/images/icons/crown-purple.svg" class="w-8 h-8" alt="icon" />
        <p class="font-semibold">{{ course?.category?.name }}</p>
      </div>
      <div class="flex flex-col rounded-[20px] border border-[#CFDBEF] p-5 gap-4">
        <img src="/assets/images/icons/note-favorite-purple.svg" class="w-8 h-8" alt="icon" />
        <p class="font-semibold">0 Contents</p>
      </div>
      <div class="flex flex-col rounded-[20px] border border-[#CFDBEF] p-5 gap-4">
        <img src="/assets/images/icons/cup-purple.svg" class="w-8 h-8" alt="icon" />
        <p class="font-semibold">Certificate</p>
      </div>
    </div>
  </section>
  <TableContentPage :contents="contents" :courseId="course.id"/>
</template>

<script setup>
import { RouterLink, useRoute } from 'vue-router';
import TableContentPage from './table-content.vue';
import { getCourseByIdPagination } from '@/services/courseService';
import { onMounted, ref, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { mutateContentSchema } from '../../../utils/zodSchema';

// interface Props {
//   id: number
//   index: number
//   type: string
//   title: string
//   courseId: number
// }

const { handleSubmit, isSubmitting, values, errors } = useForm({
  validationSchema: mutateContentSchema
});
const route = useRoute();


const course = ref({});
const contents = ref({});
const props = defineProps({
  id: {
    type: Number,
    default: 1
  },
  index: {
    type: Number,
    default: 1
  },
  type: {
    type: String,
    default: "Video"
  },
  title: {
    type: String,
    default: "Install VSCode di Windows"
  },
  courseId: {
    type: Number,
    default: 2
  }
})

onMounted(async () => {
  try {
    const result = await getCourseByIdPagination(route.params.id);
    console.log("result", result);
    course.value = result.course;
    contents.value = result.contents;
    console.log("contents", contents);
  } catch (error) {
    console.log(error);
  }
});

// const props = withDefaults(defineProps<Props>(), {
//   id: 1,
//   index: 1,
//   type: "Video",
//   title: "Install VSCode di Windows",
//   courseId: 2,
// })

</script>