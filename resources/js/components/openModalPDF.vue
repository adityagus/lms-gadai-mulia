<template>
  <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white w-[1200px] rounded-2xl shadow-2xl p-0 relative flex flex-col max-h-[95vh]">
      <button @click="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl font-bold z-10">&times;</button>
      <div v-if="selectedCard" class="overflow-y-auto scrollbar-hidden px-8 pt-8 pb-2 flex-1 rounded-2xl" style="max-height:calc(95vh - 70px);">
        <div class="absolute top-0 left-0 w-full h-20 rounded-t-2xl">
          <div class="flex items-center gap-3 my-4 px-8 bg-white" id='header'>
            <div class="rounded-lg bg-sidebar p-2 flex items-center justify-center">
              <img src="https://unpkg.com/heroicons@2.0.13/24/solid/document.svg" class="w-8 h-8 filter-white-svg" alt="icon" />
              <!-- <img :src="selectedCard.icon" class="w-8 h-8 filter-white-svg" alt="icon" /> -->
            </div>
            <div class="flex justify-between w-full items-center">
              <div>
                <h2 class="font-bold text-md text-sidebar">{{ selectedCard.title }}</h2>
                <div class="text-xs text-gray-500">Tanggal: <span class="font-semibold text-sidebar">{{ selectedCard.date || '02.08.2025' }}</span></div>
              </div>
              <div class="bg-gray-50 rounded-lg p-3 flex flex-col mb-4 border border-gray-100">
                <div class="flex justify-between items-center gap-3">
                  <span class="text-xs font-semibold text-gray-500">Nomor Surat</span>
                  <span class="text-xs font-bold text-sidebar">{{ selectedCard.no_surat }}</span>
                </div>
                <div class="flex justify-between items-center gap-3">
                  <span class="text-xs font-semibold text-gray-500">Tanggal Berlaku</span>
                  <span class="text-xs font-bold text-sidebar">{{ selectedCard.tgl_berlaku }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="overflow-hidden rounded-2xl mx-10">
          <ContentPdf :content="selectedCard.url" class='h-[500px]' v-if='selectedCard.type === "pdf" || selectedCard.type === null'/>
          <ContentText :content="selectedCard" class='shadow-sm shadow-purple-600 mt-20 pb-3 px-3 border mx-2 rounded-lg' v-if='selectedCard.type === "text"'/>
        </div>
        <!-- {{ selectedCard.map(item => item.title) }}> -->
        <p class="text-gray-700 mb-4">{{ selectedCard.desc }}</p>
      </div>
      <div class="p-6 pt-2 border-t border-gray-100 bg-white z-10 rounded-2xl">
        <!-- <button @click="closeModal" class="w-full py-2 rounded bg-sidebar text-white font-semibold hover:bg-purple-700 transition">Tutup</button> -->
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineExpose } from 'vue';
import ContentPdf from '@/pages/course-preview/ContentPdf.vue';
import ContentText from '@/pages/course-preview/ContentText.vue';

const props = defineProps({
  cards: Array,
  showModal: Boolean,
  selectedCard: Object
});
const emit = defineEmits(['update:showModal', 'update:selectedCard']);



function closeModal() {
  emit('update:showModal', false);
  emit('update:selectedCard', null);
}

function openModal(card) {
  emit('update:showModal', true);
  emit('update:selectedCard', card);
}

defineExpose({ openModal });
</script>


<style scoped>
.announcement-card {
  transition: box-shadow 0.2s, transform 0.2s;
}
.announcement-card:hover {
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
.line-clamp-2 {
/* Untuk satu baris clamp nomor surat */
.line-clamp-1 {
  display: -webkit-box;
  line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
  display: -webkit-box;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
/* Hide scrollbar utility */
.scrollbar-hidden {
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE 10+ */
}
.scrollbar-hidden::-webkit-scrollbar {
  display: none; /* Chrome/Safari/Webkit */
}
</style>