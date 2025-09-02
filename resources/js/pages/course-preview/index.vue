<script setup>
import Header from '@/components/Header.vue';
import ContentVideo from './ContentVideo.vue';
import ContentText from './ContentText.vue';
import ContentPdf from './ContentPdf.vue';
import { ref, onMounted, computed, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getCourseById } from '@/services/courseService';

const route = useRoute();
const router = useRouter();

// Reactive data
const course = ref({});
const contents = ref([]);
const loading = ref(true);
const error = ref(null);
const currentContentIndex = ref(0);

// Computed properties
const courseId = computed(() => route.params.id || route.params.courseId);
const currentContent = computed(() => contents.value[currentContentIndex.value] || {});
const isLastContent = computed(() => currentContentIndex.value === contents.value.length - 1);


// Methods
const fetchCourseData = async () => {
  try {
    loading.value = true;
    console.log('Fetching course data for ID:', courseId.value);
    
    const response = await getCourseById(courseId.value);
    console.log('Course data response:', response);
    
    if (response.success || response.course) {
      // Handle different response structures
      const courseData = response.course || response.data;
      const contentsData = response.contents || courseData.contents || [];
      
      course.value = courseData;
      contents.value = Array.isArray(contentsData) ? contentsData : (contentsData.data || []);
      
      console.log('Course:', course.value);
      console.log('Course contents:', contents.value);
    } else {
      throw new Error(response.message || 'Failed to fetch course data');
    }
  } catch (err) {
    console.error('Error fetching course data:', err);
    error.value = err.message || 'Failed to load course data';
  } finally {
    loading.value = false;
  }
};

const contentData = {
  title: "Judul PDF",
  pdf_url: "http://lms-gadai.test/storage/uploads/content/M.2021.042-STAF_PENGGANTI_SEMENTARA.pdf",
  content: "<p>Ini adalah konten PDF yang akan ditampilkan.</p>",
  attachment: "http://lms-gadai.test/storage/uploads/content/M.2021.042-STAF_PENGGANTI_SEMENTARA.pdf"
};

const goToContent = (index) => {
  if (index >= 0 && index < contents.value.length) {
    currentContentIndex.value = index;
  }
};

const nextContent = () => {
  if (currentContentIndex.value < contents.value.length - 1) {
    currentContentIndex.value++;
  }
};

const markAsCompleted = () => {
  // Logic to mark content as completed
  console.log('Marking content as completed:', currentContent.value.id);
  
  if (!isLastContent.value) {
    nextContent();
  } else {
    // Course completed
    alert('Course completed! Congratulations!');
  }
};

const getContentIcon = (type) => {
  switch (type) {
    case 'video':
      return '/assets/images/icons/video-play-white.svg';
    case 'text':
      return '/assets/images/icons/note-white.svg';
    case 'pdf':
      return '/assets/images/icons/pdf-white.svg';
    case 'finished':
      return '';
    default:
      return '/assets/images/icons/note-white.svg';
  }
};

const goBack = () => {
  router.push('/courses');
};

// Lifecycle
onMounted(() => {
  if (courseId.value) {
    fetchCourseData();
  } else {
    error.value = 'Course ID not provided';
  }
});

// Watch for changes in contents to auto-select first content
watch(contents, (newContents) => {
  if (newContents.length > 0 && currentContentIndex.value === 0) {
    currentContentIndex.value = 0;
  }
}, { immediate: true });

</script>

<template>
    <div class="flex min-h-screen">
        <!-- Loading State -->
        <div v-if="loading" class="flex items-center justify-center w-full h-screen">
            <div class="text-center">
                <div class="animate-spin rounded-full h-32 w-32 border-b-2 border-[#662FFF] mx-auto mb-4"></div>
                <p class="text-gray-600">Loading course content...</p>
            </div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="flex items-center justify-center w-full h-screen">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-red-600 mb-4">Error Loading Course</h2>
                <p class="text-gray-600 mb-4">{{ error }}</p>
                <button 
                    @click="fetchCourseData" 
                    class="px-4 py-2 bg-[#662FFF] text-white rounded-lg hover:bg-[#5521cc] transition-colors"
                >
                    Try Again
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <template v-else>
            <!-- Sidebar -->
            <aside class="sidebar-container fixed h-[calc(100vh-20px)] w-full max-w-[330px] my-[10px] ml-[10px] bg-[#060A23] overflow-hidden flex flex-1 rounded-[20px]">
                <div class="scroll-container flex w-full overflow-y-scroll hide-scrollbar">
                    <nav class="flex flex-col w-full h-fit p-[30px] gap-[30px] z-10">
                        <button 
                            @click="goBack" 
                            class="font-semibold text-white hover:underline text-left"
                        >
                            <span>← Back to Dashboard</span>
                        </button>
                        
                        <!-- Course Info -->
                        <div class="flex flex-col gap-4">
                            <div class="flex shrink-0 w-[130px] h-[100px] rounded-[14px] bg-[#D9D9D9] overflow-hidden">
                                <img 
                                    :src="course.thumbnail_url || course.thumbnail || '/assets/images/thumbnails/th-1.png'" 
                                    class="w-full h-full object-cover" 
                                    :alt="course.name || 'Course Thumbnail'"
                                />
                            </div>
                            <h2 class="font-bold text-xl leading-[34px] text-white">
                                {{ course.name || 'Course Title' }}
                            </h2>
                        </div>

                        <!-- Course Contents -->
                        <ul class="flex flex-col gap-4" v-if="contents.length > 0">
                            <li v-for="(content, index) in contents" :key="content.id">
                                <button 
                                    @click="goToContent(index)"
                                    class="w-full text-left"
                                >
                                    <div 
                                        class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset]"
                                        :class="{
                                            'bg-[#662FFF] border-[#8661EE] shadow-[-10px_-6px_10px_0_#7F33FF_inset]': index === currentContentIndex,
                                            'bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]': index !== currentContentIndex
                                        }"
                                    >
                                        <img 
                                            :src="getContentIcon(content.type)" 
                                            class="w-6 h-6" 
                                            alt="icon"
                                        />
                                        <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">
                                            {{ content.title }}
                                        </span>
                                    </div>
                                </button>
                            </li>
                        </ul>

                        <!-- Empty State -->
                        <div v-else class="text-center py-8">
                            <p class="text-gray-400">No content available for this course</p>
                        </div>
                    </nav>
                </div>
                <img src="/assets/images/backgrounds/sidebar-glow.png" class="absolute object-contain object-bottom bottom-0" alt="background"/>
            </aside>

            <!-- Main Content Area -->
            <main class="flex flex-col flex-1 gap-[30px] p-[30px] ml-[340px] mb-12">
                <Header/>
                
                <div class="relative flex flex-col gap-[26px]" v-if="currentContent.id">
                    <!-- Dynamic Content Rendering -->
                    <ContentText 
                        v-if="currentContent.type === 'text'" 
                        :content="currentContent"
                    />
                    <ContentVideo 
                        v-else-if="currentContent.type === 'video'" 
                        :content="currentContent"
                    />
                    <ContentPdf
                        v-else-if="currentContent.type === 'pdf'" 
                        :content="currentContent.content"/>
                    

                    <!-- Action Button -->
                    <div class="fixed bottom-0 w-[calc(100%-400px)] h-[151px] flex items-end justify-end pb-5 bg-[linear-gradient(0deg,#FFFFFF_49.67%,rgba(255,255,255,0)_84.11%)]">
                        <button 
                            type="button" 
                            @click="markAsCompleted"
                            class="w-fit rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap hover:bg-[#5521cc] transition-colors"
                        >
                            <span v-if="!isLastContent">Mark as Completed & Continue</span>
                            <span v-else>Complete Course</span>
                        </button>
                    </div>
                </div>

                <!-- No Content Selected -->
                <div v-else class="flex items-center justify-center h-96">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-600 mb-4">Select Content to Start Learning</h2>
                        <p class="text-gray-500">Choose a lesson from the sidebar to begin</p>
                    </div>
                </div>
            </main>
        </template>
    </div>
</template>