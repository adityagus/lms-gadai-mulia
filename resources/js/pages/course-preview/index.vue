<script setup>
import Header from '@/components/Header.vue';
import ContentVideo from './ContentVideo.vue';
import ContentText from './ContentText.vue';
import ContentPdf from './ContentPdf.vue';
import ContentForm from './ContentForm.vue';
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import { useRoute, useRouter, onBeforeRouteLeave } from 'vue-router';
import { getCourseById } from '@/services/courseService';
import Swal from 'sweetalert2';

const route = useRoute();
const router = useRouter();

// Reactive data
const course = ref({});
const contents = ref([]);
const loading = ref(true);
const error = ref(null);
const currentContentIndex = ref(0);
const isCurrentFormSubmitted = ref(false);

// Computed properties
const courseId = computed(() => route.params.id || route.params.courseId);
const currentContent = computed(() => contents.value[currentContentIndex.value] || {});
const isLastContent = computed(() => currentContentIndex.value === contents.value.length - 1);

const isFormContent = (type) => {
  return type === 'form' || type === 'google_form' || type === 'quiz';
};

const handleFormSubmittedChange = (val) => {
  isCurrentFormSubmitted.value = val;
};

// Check if form is submitted before internal navigation
const checkFormSubmitBeforeNavigate = (onProceed) => {
  if (isFormContent(currentContent.value?.type) && !isCurrentFormSubmitted.value) {
    Swal.fire({
      title: 'Formulir Belum Di-submit!',
      html: 'Anda wajib mengisi dan mengirimkan (submit) Google Form terlebih dahulu sebelum melanjutkan ke materi berikutnya.<br><br><small class="text-gray-500">Jika Anda sudah menekan tombol Kirim di dalam form atau membukanya di tab baru, klik <b>Saya Sudah Submit & Lanjutkan</b>.</small>',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#662FFF',
      cancelButtonColor: '#838C9D',
      confirmButtonText: 'Lewati',
      cancelButtonText: 'Kembali ke Form'
    }).then((result) => {
      if (result.isConfirmed) {
        isCurrentFormSubmitted.value = true;
        onProceed();
      }
    });
  } else {
    onProceed();
  }
};

// Route leave guard (bila user klik menu lain di sidebar luar atau tombol back browser)
onBeforeRouteLeave((to, from, next) => {
  if (isFormContent(currentContent.value?.type) && !isCurrentFormSubmitted.value) {
    Swal.fire({
      title: 'Formulir Belum Di-submit!',
      html: 'Anda wajib mengisi dan mengirimkan (submit) Google Form terlebih dahulu sebelum melanjutkan ke materi berikutnya.<br><br><small class="text-gray-500">Jika Anda sudah menekan tombol Kirim di dalam form atau membukanya di tab baru, klik <b>Saya Sudah Submit & Lanjutkan</b>.</small>',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#662FFF',
      cancelButtonColor: '#838C9D',
      confirmButtonText: 'Lewati',
      cancelButtonText: 'Kembali ke Form'
    }).then((result) => {
      if (result.isConfirmed) {
        isCurrentFormSubmitted.value = true;
        next();
      } else {
        next(false);
      }
    });
  } else {
    next();
  }
});

// Methods
const fetchCourseData = async () => {
  try {
    loading.value = true;
    console.log('Fetching course data for ID:', courseId.value);

    const response = await getCourseById(courseId.value);
    console.log('Course data response:', response);

    if (response.success || response.course) {
      const courseData = response.course || response.data;
      const contentsData = response.contents || courseData.contents || [];

      course.value = courseData;
      contents.value = Array.isArray(contentsData) ? contentsData : (contentsData.data || []);
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

const goToContent = (index) => {
  if (index >= 0 && index < contents.value.length) {
    if (index === currentContentIndex.value) return;
    checkFormSubmitBeforeNavigate(() => {
      isCurrentFormSubmitted.value = false;
      currentContentIndex.value = index;
    });
  }
};

const nextContent = () => {
  if (currentContentIndex.value < contents.value.length - 1) {
    checkFormSubmitBeforeNavigate(() => {
      isCurrentFormSubmitted.value = false;
      currentContentIndex.value++;
    });
  }
};

const markAsCompleted = () => {
  checkFormSubmitBeforeNavigate(() => {
    console.log('Marking content as completed:', currentContent.value.id);
    if (!isLastContent.value) {
      isCurrentFormSubmitted.value = false;
      currentContentIndex.value++;
    } else {
      Swal.fire({
        title: 'Selamat!',
        text: 'Anda telah menyelesaikan seluruh materi kelas ini!',
        icon: 'success',
        confirmButtonColor: '#662FFF'
      });
    }
  });
};

const getContentIcon = (type) => {
  switch (type) {
    case 'video':
      return '/assets/images/icons/video-play-white.svg';
    case 'text':
      return '/assets/images/icons/note-white.svg';
    case 'pdf':
      return '/assets/images/icons/pdf-white.svg';
    case 'form':
    case 'google_form':
    case 'quiz':
      return '/assets/images/icons/note-white.svg';
    case 'finished':
      return '';
    default:
      return '/assets/images/icons/note-white.svg';
  }
};

const goBack = () => {
  checkFormSubmitBeforeNavigate(() => {
    router.history?.back() || router.push({ name: 'lms' });
  });
};

const handleBeforeUnload = (e) => {
  if (isFormContent(currentContent.value?.type) && !isCurrentFormSubmitted.value) {
    e.preventDefault();
    e.returnValue = 'Formulir belum di-submit. Yakin ingin meninggalkan halaman ini?';
  }
};

// Lifecycle
onMounted(() => {
  window.addEventListener('beforeunload', handleBeforeUnload);
  if (courseId.value) {
    fetchCourseData();
  } else {
    error.value = 'Course ID not provided';
  }
});

onUnmounted(() => {
  window.removeEventListener('beforeunload', handleBeforeUnload);
});

watch(() => route.params.id, (newId, oldId) => {
  if (newId !== oldId) {
    fetchCourseData();
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
        <button @click="fetchCourseData"
          class="px-4 py-2 bg-[#662FFF] text-white rounded-lg hover:bg-[#5521cc] transition-colors">
          Try Again
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <template v-else>
      <!-- Sidebar -->
      <aside
        class="sidebar-container fixed h-[calc(100vh-20px)] w-full max-w-[330px] my-[10px] ml-[10px] bg-[#060A23] overflow-hidden flex flex-1 rounded-[20px]">
        <div class="scroll-container flex w-full overflow-y-scroll hide-scrollbar">
          <nav class="flex flex-col w-full h-fit p-[30px] gap-[30px] z-10">
            <button @click="goBack" class="font-semibold text-white hover:underline text-left">
              <span>← Kembali ke Kelas</span>
            </button>

            <!-- Course Info -->
            <div class="flex flex-col gap-4">
              <div class="flex shrink-0 w-[130px] h-[100px] rounded-[14px] bg-[#D9D9D9] overflow-hidden">
                <img :src="course.thumbnail_url || course.thumbnail || '/assets/images/thumbnails/th-1.png'"
                  class="w-full h-full object-cover" :alt="course.name || 'Course Thumbnail'" />
              </div>
              <h2 class="font-bold text-xl leading-[34px] text-white">
                {{ course.name || 'Course Title' }}
              </h2>
            </div>

            <!-- Course Contents -->
            <ul class="flex flex-col gap-4" v-if="contents.length > 0">
              <li v-for="(content, index) in contents" :key="content.id">
                <button @click="goToContent(index)" class="w-full text-left">
                  <div
                    class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset]"
                    :class="{
                      'bg-[#662FFF] border-[#8661EE] shadow-[-10px_-6px_10px_0_#7F33FF_inset]': index === currentContentIndex,
                      'bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]': index !== currentContentIndex
                    }">
                    <img :src="getContentIcon(content.type)" class="w-6 h-6" alt="icon" />
                    <span
                      class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">
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
        <img src="/assets/images/backgrounds/sidebar-glow.png" class="absolute object-contain object-bottom bottom-0"
          alt="background" />
      </aside>

      <!-- Main Content Area -->
      <main class="flex flex-col flex-1 gap-[30px] p-[30px] ml-[340px] mb-12">
        <Header />

        <div class="relative flex flex-col gap-[26px]" v-if="currentContent.id">
          <!-- Dynamic Content Rendering -->
          <ContentText v-if="currentContent.type === 'text'" :content="currentContent" />
          <ContentVideo v-else-if="currentContent.type === 'video'" :content="currentContent" />
          <ContentPdf v-else-if="currentContent.type === 'pdf'" :content="currentContent.content" />
          <ContentForm
            v-else-if="currentContent.type === 'form' || currentContent.type === 'google_form' || currentContent.type === 'quiz' || (currentContent.url && currentContent.url.includes('google.com/forms'))"
            :content="currentContent" @form-submitted-change="handleFormSubmittedChange" />


          <!-- Action Button -->
          <div
            class="fixed bottom-0 w-[calc(100%-400px)] h-[151px] flex items-end justify-end pb-5 bg-[linear-gradient(0deg,#FFFFFF_49.67%,rgba(255,255,255,0)_84.11%)]">
            <button type="button" @click="markAsCompleted"
              class="w-fit rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap hover:bg-[#5521cc] transition-colors">
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