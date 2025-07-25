<template>
      <div>
    <section
        id="CourseList"
        class="flex flex-col w-full rounded-[30px] p-[30px] gap-[30px] bg-[#F8FAFB]"
      >
        <div class="header flex items-center justify-between">
          <h2 class="font-bold text-[22px] leading-[33px]">
            Course Content
          </h2>
          <RouterLink
            :to="`/admin/course/create-contents/${courseId}`"
            class="w-fit rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap"
          >
            Add Content
          </RouterLink>
        </div>
          <ContentItem
            v-for="(content, index) in currentContents.data"
            :key="content?.id || index"
            :id="content?.id"
            :index="((currentContents.current_page - 1) * currentContents.per_page) + index + 1"
            :type="content?.type"
            :title="content?.title"
            :courseId="content?.course_id"
            @delete-content="handleDeleteContent"
          />

          <div id="Pagination" class="flex items-center gap-3" v-if='currentContents.last_page > 1'>
            <!-- Previous button -->
            <button 
              type="button" 
              @click='goToPage(pagination - 1)'
              :disabled="pagination === 1"
              class="flex shrink-0 w-9 h-9 rounded-full items-center justify-center text-center transition-all duration-300 hover:bg-[#662FFF] hover:text-white disabled:opacity-50 disabled:cursor-not-allowed bg-[#EAEAEA] text-[#662FFF]"
            >
              <span class="font-semibold text-sm leading-[21px]">‹</span>
            </button>

            <!-- Page numbers -->
            <button 
              type="button" 
              v-for='page in currentContents.last_page' 
              :key='page' 
              @click='goToPage(page)'
              class="flex shrink-0 w-9 h-9 rounded-full items-center justify-center text-center transition-all duration-300 hover:bg-[#662FFF] hover:text-white hover:border-0"
              :class="{
                'bg-[#662FFF] text-white': page === pagination,
                'bg-[#EAEAEA] text-[#662FFF]': page !== pagination
              }"
            >
              <span class="font-semibold text-sm leading-[21px]">{{ page }}</span>
            </button>

            <!-- Next button -->
            <button 
              type="button" 
              @click='goToPage(pagination + 1)'
              :disabled="pagination === currentContents.last_page"
              class="flex shrink-0 w-9 h-9 rounded-full items-center justify-center text-center transition-all duration-300 hover:bg-[#662FFF] hover:text-white disabled:opacity-50 disabled:cursor-not-allowed bg-[#EAEAEA] text-[#662FFF]"
            >
              <span class="font-semibold text-sm leading-[21px]">›</span>
            </button>
          </div>
          
        <!-- <div id="Pagination" class="flex items-center gap-3">
          <button
            type="button"
            class="flex shrink-0 w-9 h-9 rounded-full items-center justify-center text-center transition-all duration-300 hover:bg-[#662FFF] hover:text-white hover:border-0 bg-[#662FFF] text-white"
          >
            <span class="font-semibold text-sm leading-[21px]">1</span>
          </button>
          <button
            type="button"
            class="flex shrink-0 w-9 h-9 rounded-full items-center justify-center text-center transition-all duration-300 hover:bg-[#662FFF] hover:text-white hover:border-0 border border-[#060A23]"
          >
            <span class="font-semibold text-sm leading-[21px]">2</span>
          </button>
          <button
            type="button"
            class="flex shrink-0 w-9 h-9 rounded-full items-center justify-center text-center transition-all duration-300 hover:bg-[#662FFF] hover:text-white hover:border-0 border border-[#060A23]"
          >
            <span class="font-semibold text-sm leading-[21px]">3</span>
          </button>
          <button
            type="button"
            class="flex shrink-0 w-9 h-9 rounded-full items-center justify-center text-center transition-all duration-300 hover:bg-[#662FFF] hover:text-white hover:border-0 border border-[#060A23]"
          >
            <span class="font-semibold text-sm leading-[21px]">4</span>
          </button>
          <button
            type="button"
            class="flex shrink-0 w-9 h-9 rounded-full items-center justify-center text-center transition-all duration-300 hover:bg-[#662FFF] hover:text-white hover:border-0 border border-[#060A23]"
          >
            <span class="font-semibold text-sm leading-[21px]">5</span>
          </button>
        </div> -->
      </section>
    </div>
    
    <!-- Debug info (remove in production) -->
    <div class="mt-4 p-4 bg-gray-100 rounded text-xs" v-if="false">
      <h3 class="font-bold mb-2">Debug Info:</h3>
      <p>Current Page: {{ currentContents.current_page }}</p>
      <p>Last Page: {{ currentContents.last_page }}</p>
      <p>Per Page: {{ currentContents.per_page }}</p>
      <p>Total: {{ currentContents.total }}</p>
      <p>Pagination State: {{ pagination }}</p>
    </div>
</template>

<script setup>
import { getCourseByIdPagination } from '../../../services/courseService';
import { deleteContent } from '../../../services/contentService';
import ContentItem from './content-item.vue';
import { ref, defineProps, defineEmits, watch } from 'vue';
import Swal from 'sweetalert2';

const totalPages = ref(5);
const pagination = ref(1);
const currentContents = ref({});

const props = defineProps({
  contents: {
    type: Object,
    required: true
  },
  courseId: {
    type: [String, Number],
    required: true
  }
});

const emit = defineEmits(['update:contents']);

// Initialize current contents with props
currentContents.value = props.contents;

// Watch for changes in props.contents
watch(() => props.contents, (newContents) => {
  currentContents.value = newContents;
  if (newContents.current_page) {
    pagination.value = newContents.current_page;
  }
}, { immediate: true });

const fetchContent = async (page = 1) => {
  try {
    console.log("Fetching content for page:", props?.courseId, page);
    const result = await getCourseByIdPagination(props?.courseId, page);
    
    if (result && result.contents) {
      currentContents.value = result.contents;
      // Emit the updated contents to parent component
      emit('update:contents', result.contents);
      console.log("Fetched contents:", result.contents);
    }
  } catch (error) {
    console.error("Error fetching content:", error);
  }
};

const goToPage = async(page = 1) => {
  if (page !== pagination.value && page >= 1 && page <= (currentContents.value.last_page || 1)) {
    pagination.value = page;
    await fetchContent(page);
    console.log("Navigated to page:", page);
  }
}

const handleDeleteContent = async (contentId) => {
  console.log('Deleting content:', contentId);
  
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this content!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const response = await deleteContent(contentId);
        
        if (response) {
          Swal.fire({
            title: "Deleted!",
            text: "Content has been deleted.",
            icon: "success",
            timer: 1500
          });
          
          // Refresh content list
          await fetchContent(pagination.value);
        }
      } catch (error) {
        console.error("Error deleting content:", error);
        Swal.fire({
          title: "Error!",
          text: "Failed to delete content.",
          icon: "error"
        });
      }
    }
  });
}


</script>