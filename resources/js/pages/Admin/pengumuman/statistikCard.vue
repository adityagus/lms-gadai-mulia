<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
    <div v-for="(item, idx) in cards" :key="item.title" :class="['rounded-lg shadow p-4 flex flex-col justify-between relative overflow-hidden bg-sidebar', item.bg]">
      <div class="absolute inset-0 opacity-10 pointer-events-none pattern-bg"></div>
      <div class="flex items-center mb-2 relative z-10 justify-between w-full">
        <div class="">
          <div class="text-2xl font-bold text-white text-left">{{ item.count }}</div>
          <div class="text-lg font-semibold text-white text-left">{{ item.title }}</div>
        </div>
        <div class="">
          <img :src="item.icon" class="w-8 h-8 ml-3 filter-white-svg" alt="icon" />
        </div>
        
      </div>
      <button class="mt-auto w-full flex items-center justify-center gap-2 px-3 py-2 bg-white text-sm font-semibold rounded text-gray-700 hover:bg-gray-100 transition relative z-10">
        Selengkapnya
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 12H6.75m4.5-4.5l4.5 4.5-4.5 4.5" />
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const cards = ref([
  { title: 'Memo', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/document.svg' },
  { title: 'SK', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/clipboard-document-check.svg' },
  { title: 'SE', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/envelope.svg' },
  { title: 'Juklak', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/book-open.svg' },
  { title: 'Sop', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/adjustments-horizontal.svg' },
  { title: 'OJK', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/shield-check.svg' },
])
</script>

<style scoped>
.shadow {
  box-shadow: 0 2px 8px 0 rgba(0,0,0,0.08);
}
.grid-cols-4 {
  grid-template-columns: repeat(4, minmax(0, 1fr));
}
.pattern-bg {
  background-image: url('https://www.toptal.com/designers/subtlepatterns/uploads/dot-grid.png');
  background-size: 40px 40px;
}

.card-shadow {
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37), 0 1.5px 6px 0 #060A23;
}
.bg-sidebar {
  background: #7F33FF;
}

.filter-white-svg {
  filter: brightness(0) invert(1);
}
</style>
