<template>
  <div class="flex justify-end mb-4 gap-2">
    <router-link :to="{ name: 'information-document-create', query: { type: category}}" v-if='auth && (auth.idgrup == "JBT-032" || auth.idgrup === "JBT-037" || auth.idgrup === "JBT-039" || auth.idgrup === "JBT-040")'
      class="px-4 py-2 bg-sidebar text-white rounded-lg font-semibold shadow hover:bg-purple-700 transition" :id>
      + Create <span>{{ category == 1 ? 'Pengumuman' : category == 2 ? 'Formulir' : 'Report' }}</span>
    </router-link>
    <router-link :to="{ name: 'archive-pengumuman', query: { submenu_id: category } }" v-if='auth && (auth.idgrup == "JBT-032" || auth.idgrup === "JBT-037" || auth.idgrup === "JBT-039" || auth.idgrup === "JBT-040")' 
      class="px-4 py-2 bg-gray-200 text-sidebar rounded-lg font-semibold shadow hover:bg-gray-300 transition flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
      </svg>


      Archive
    </router-link>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <div v-for="(item, idx) in cards" :key="item.title"
      class="relative rounded-2xl bg-white shadow-xl p-0 flex flex-col justify-between overflow-hidden group statistik-card border border-gray-200 hover:border-sidebar transition">
      <div class="absolute inset-0 opacity-10 pointer-events-none pattern-bg"></div>
      <div class="flex flex-col gap-2 z-10 p-6">
        <div class="flex items-center gap-3 mb-3">
          <div class="rounded-lg bg-sidebar p-2 flex items-center justify-center">
            <img :src="icons[idx]" class="w-8 h-8 filter-white-svg" alt="icon" />
          </div>
          <span class="text-sidebar text-lg font-bold">{{ item.name }}</span>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 flex flex-col gap-2 mb-2 border border-gray-100">
          <div class="flex justify-between items-center">
            <span class="text-xs font-semibold text-gray-500">Jumlah</span>
            <span class="text-2xl font-bold text-sidebar">{{ item.count_tipe_announcement ? item.count_tipe_announcement : 0 }}</span>
          </div>
        </div>
      </div>
      <div class="absolute right-2 bottom-8 text-[2rem] text-sidebar opacity-10 select-none pointer-events-none">
        <span v-if="item.title === 'Memo'">Memo</span>
        <span v-else-if="item.title === 'SK'">SK</span>
        <span v-else-if="item.title === 'SE'">SE</span>
        <span v-else-if="item.title === 'Juklak'">Juklak</span>
        <span v-else-if="item.title === 'Sop'">SOP</span>
        <span v-else-if="item.title === 'OJK'">OJK</span>
      </div>
      <button
        class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-sidebar text-sm font-semibold rounded-b-2xl text-white hover:bg-purple-700 transition z-10">
        <router-link :to="`detail-pengumuman/${item.id}`" :auth="auth">
          Selengkapnya
        </router-link>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 12H6.75m4.5-4.5l4.5 4.5-4.5 4.5" />
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { getAnnouncements } from '@/services/announcementService';
import { useRoute } from 'vue-router';
import { getSession } from '../../services/authService';

const cards = ref([]);

// get argument from route
const route = useRoute();
const category = route.meta.values || 1;
const auth = ref(null);
console.log("Category from route:", category);
// const cards = ref([
//   { title: 'Memo', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/document.svg' },
//   { title: 'SK', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/clipboard-document-check.svg' },
//   { title: 'SE', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/envelope.svg' },
//   { title: 'Juklak', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/book-open.svg' },
//   { title: 'Sop', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/adjustments-horizontal.svg' },
//   { title: 'OJK', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/shield-check.svg' },
// ])
const icons = ref([
  'https://unpkg.com/heroicons@2.0.13/24/solid/document.svg',
  'https://unpkg.com/heroicons@2.0.13/24/solid/clipboard-document-check.svg',
  'https://unpkg.com/heroicons@2.0.13/24/solid/envelope.svg',
  'https://unpkg.com/heroicons@2.0.13/24/solid/book-open.svg',
  'https://unpkg.com/heroicons@2.0.13/24/solid/adjustments-horizontal.svg',
  'https://unpkg.com/heroicons@2.0.13/24/solid/shield-check.svg'
]);


const fetchAnnouncement = async() => {
  try {
    const response = await getAnnouncements(category);
    // Jika response dari fetch, data bisa di response.json()
    cards.value = response.data;
    // Jika data masih undefined, coba cek response langsung
    if (!cards.value && response) {
      cards.value = response;
    }
    console.log("Fetched announcement data:", cards.value);

  } catch (error) {
    console.error('Error fetching announcements:', error);
  }
}

onMounted(async() => {
  const [resAnnouncement, resSession] = await Promise.all([
    fetchAnnouncement(),
    getSession()
  ]);
  auth.value = resSession.auth;
});

</script>

<style scoped>
.statistik-card {
  transition: box-shadow 0.2s, transform 0.2s;
}
.statistik-card:hover {
  box-shadow: 0 8px 32px 0 rgba(127, 51, 255, 0.37), 0 1.5px 6px 0 #7F33FF;
  transform: translateY(-2px) scale(1.03);
  border-color: #7F33FF;
}
.pattern-bg {
  background-image: url('https://www.toptal.com/designers/subtlepatterns/uploads/dot-grid.png');
  background-size: 40px 40px;
}
.bg-sidebar {
  background: #7F33FF;
}
.filter-white-svg {
  filter: brightness(0) invert(1);
}
</style>
