<template>
  <div id="TopBar" class="flex items-center justify-between gap-[30px]">
    <div
      class="flex items-center w-full max-w-[450px] rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
      <button
        class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] text-left" @click="openSearch"
        placeholder="Search course, student, other file..." >
        <span class="font-semibold text-[#838C9D]">Cari Course...</span>
      </button>
      <img src="/assets/images/icons/search-normal.svg" class="w-6 h-6" alt="icon" />
    </div>
    
    <!-- Modal Search Algolia -->
    <div v-if="showSearch" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white rounded-xl shadow-lg p-6 w-[400px] relative">
        <button @click="closeSearch" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl font-bold">&times;</button>
        <ais-instant-search :search-client="searchClient" index-name="course_gadai_mulia">
          <ais-search-box
            placeholder="Ketik nama course..."
            autofocus
          />
          <ais-hits>
            <template #item="{ item }">
              <div
                class="flex items-center gap-2 py-1 px-2 hover:bg-gray-100 cursor-pointer"
                @click="gotoDetail(item)"
              >
                <img :src="item.thumbnail_url" alt="cover" class="w-10 h-10 object-cover rounded" v-if="item.thumbnail_url" />
                <div>
                  <div class="font-bold">{{ item.title }}</div>
                  <div class="text-xs text-gray-500">{{ item.tagline }}</div>
                  <div class="text-xs text-blue-500">{{ item.category }}</div>
                </div>
              </div>
            </template>
          </ais-hits>
        </ais-instant-search>
      </div>
    </div>

    <!-- Modal Course Detail -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white rounded-xl shadow-lg p-6 w-[350px] relative">
        <button @click="closeModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl font-bold">&times;</button>
        <div v-if="selectedCourse">
          <img :src="selectedCourse.thumbnail_url" alt="cover" class="w-20 h-20 object-cover rounded mb-3" v-if="selectedCourse.thumbnail_url" />
          <h2 class="font-bold text-lg mb-1">{{ selectedCourse.title }}</h2>
          <p class="text-sm text-gray-500 mb-2">{{ selectedCourse.tagline }}</p>
          <p class="mb-2">{{ selectedCourse.description }}</p>
          <span class="inline-block px-3 py-1 rounded bg-blue-100 text-blue-700 text-xs">{{ selectedCourse.category }}</span>
        </div>
      </div>
    </div>
    <!-- End: Modal Search Algolia Style -->

    <div class="relative flex items-center justify-end gap-[14px] group">
      <div class="text-right">
        <p class="font-semibold">{{ nama }}</p>
        <p class="text-sm leading-[21px] text-[#838C9D]">{{ idgrup }}</p>
      </div>
      <button type="button" id="profileButton" class="flex shrink-0 w-[50px] h-[50px] rounded-full overflow-hidden">
        <img src="/assets/images/photos/photo-1.png" class="w-full h-full object-cover" alt="profile photos" />
      </button>
      <div id="ProfileDropdown" class="absolute top-full hidden group-hover:block">
        <ul class="flex flex-col w-[200px] rounded-[20px] border border-[#CFDBEF] p-5 gap-4 bg-white mt-4">
          <li class="font-semibold">
            <a href="#">My Account</a>
          </li>
          <li class="font-semibold">
            <a href="#">Subscriptions</a>
          </li>
          <li class="font-semibold">
            <a href="#">Settings</a>
          </li>
          <li class="font-semibold">
            <a href="/sign-in" @click.prevent="logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, nextTick, onMounted } from 'vue';
import { AisInstantSearch, AisSearchBox, AisHits } from 'vue-instantsearch/vue3/es';
import { liteClient } from 'algoliasearch/lite';
import { useRouter } from 'vue-router';

const showSearch = ref(false);
const showModal = ref(false);
const selectedCourse = ref(null);
const router = useRouter()
const nama = ref('');
const idgrup = ref('');

// Cek route berdasarkan name
const routeByName = router.options.routes.find(r => r.name === 'courseDetail');
console.log(routeByName);


onMounted(() => {
  nama.value = localStorage.getItem('nama') || '';
  idgrup.value = localStorage.getItem('idgrup') || '';
});


const searchClient = liteClient('V18ENC6M06', 'ba2320edfb51ef55180c84457e397efd');

function openSearch() {
  showSearch.value = true;
  console.log(showSearch);
  nextTick(() => {
    const input = document.querySelector('.ais-SearchBox-input');
    if (input) input.focus();
  });
}
function closeSearch() {
  showSearch.value = false;
}
function gotoDetail(course) {
  router.push(`/admin/courses/${course.objectID}`);
  
  closeSearch();
}

function logout(){
  localStorage.removeItem('nama');
  localStorage.removeItem('idgrup');
  router.push('/sign-in');
}

function closeModal() {
  showModal.value = false;
  selectedCourse.value = null;
}

</script>