<template>
  <router-link to='/pengumuman' class='flex gap-2 items-center -mb-4 text-gray-400 text-xs cursor-pointer'>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-sidebar">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7l-7 7 7 7" />
    </svg>
    Back to Pengumuman
  </router-link>
  <h1 class="text-2xl font-bold text-sidebar">{{ detail.name }}</h1>
  <div class="mb-2 -mt-4 flex gap-2" v-if="auth?.cabang === ''">
    <button v-for="tab in memoTabs" :key="tab.kd_wilayah" v-if='memoTabs.length > 1'
      @click="activeMemoTab = tab.kd_wilayah"
      :class="['px-3 py-1 rounded-lg font-semibold text-xs transition', activeMemoTab === tab.kd_wilayah ? 'bg-sidebar text-white shadow' : 'bg-white text-sidebar hover:bg-purple-100']">
      {{ tab.nm_wilayah }}
    </button>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <div v-for="(item, idx) in filteredCards" :key="item.submenu_id" class="relative rounded-2xl bg-white shadow-xl p-0 flex flex-col justify-between overflow-hidden group announcement-card border border-gray-200 hover:border-sidebar transition" @click="openDetail(item)">
      <div class="absolute inset-0 opacity-10 pointer-events-none pattern-bg"></div>
      <div class="absolute top-4 right-4 z-20 flex gap-2" v-if='auth && (auth.idgrup == "JBT-032" || auth.idgrup === "JBT-037" || auth.idgrup === "JBT-039" || auth.idgrup === "JBT-040")'>
        <router-link :to="{name: 'information-document-update', params: { id: item.id }}" @click.stop class="bg-white rounded-full p-2 shadow hover:bg-purple-100 transition group/edit" >
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-sidebar group-hover/edit:text-purple-700">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.1 2.1 0 1 1 2.97 2.97L8.91 17.38a2.1 2.1 0 0 1-.88.53l-3.07.92a.525.525 0 0 1-.65-.65l.92-3.07a2.1 2.1 0 0 1 .53-.88L16.862 3.487z" />
          </svg>
        </router-link>
        <button @click.stop="deleteAnnouncement(item)" class="bg-red-100 rounded-full p-2 shadow hover:bg-red-200 transition group/delete">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-600 group-hover/delete:text-red-800">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="flex flex-col gap-2 z-10 p-6">
        <div class="flex items-center gap-3 mb-3">
          <div class="rounded-lg bg-sidebar p-2 flex items-center justify-center flex-shrink-0">
            <img src="https://unpkg.com/heroicons@2.0.13/24/solid/document.svg" class="w-8 h-8 filter-white-svg" alt="icon" />
            <!-- <img :src="item.icon" class="w-8 h-8 filter-white-svg" alt="icon" /> -->
          </div>
          <span class="text-sidebar text-lg font-bold line-clamp-2 transition-all duration-300 hover:line-clamp-none cursor-pointer"  :title="item.title" >{{ item.title }}</span>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 flex flex-col gap-2 mb-2 border border-gray-100">
          <div class="flex justify-between items-center">
            <span class="text-xs font-semibold text-gray-500">Nomor Surat</span>
            <span class="text-xs font-bold text-sidebar line-clamp-1 relative group">
              {{ item.no_surat }}
              <span v-if="item.no_surat && item.no_surat.length > 20" class="absolute left-0 top-full mt-1 w-max bg-white border border-gray-300 shadow-lg rounded px-2 py-1 text-xs text-sidebar opacity-0 group-hover:opacity-100 transition pointer-events-none z-30">
                {{ item.no_surat }}
              </span>
            </span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-xs font-semibold text-gray-500">Tanggal Berlaku</span>
            <span class="text-xs font-bold text-sidebar">{{ item.tgl_berlaku }}</span>
          </div>
        </div>
        <div class="text-xs text-gray-500 mb-2">Terakhir update: <br><span class="font-semibold text-sidebar">{{ item.date }}</span></div>
      </div>
    </div>
  </div>

  <!-- Modal Detail Card -->
  <OpenModalPDF
    ref="modalRef"
    :cards="filteredCards"
    v-model:showModal="showModal"
    v-model:selectedCard="selectedCard"
  />
</template>

<script setup>
import axios from 'axios';
import { softDeleteAnnouncement } from '@/services/announcementService';
import OpenModalPDF from '@/components/openModalPDF.vue';
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getDetailAnnouncement } from '@/services/announcementService';
import { getSession } from '@/services/authService';
import { getWilayah } from '@/services/masterService';
import Swal from 'sweetalert2';

const route = useRoute();
const router = useRouter();

const detail = ref({});
const title = ref({})
const memoTabs = ref([]);
const activeMemoTab = ref('all')
const modalRef = ref(null);
const auth = ref(null);


const cards = ref([]);
// const cards = ref([
//   { title: 'Title text memo ...', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/document.svg', desc: 'Memo text detail ...', date: '02.08.2025', type: 'text', nomorSurat: '001/MEMO/2025', tanggalBerlaku: '02.08.2025' },
//   { title: 'Title voice memo ...', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/envelope.svg', desc: 'Memo voice detail ...', date: '02.08.2025', type: 'voice', nomorSurat: '002/VOICE/2025', tanggalBerlaku: '02.08.2025' },
//   { title: 'Title draw memo ...', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/book-open.svg', desc: 'Memo draw detail ...', date: '02.08.2016', type: 'draw', nomorSurat: '003/DRAW/2016', tanggalBerlaku: '02.08.2016' },
//   { title: 'Title text memo ...', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/document.svg', desc: 'Memo text detail ...', date: '02.08.2016', type: 'text', nomorSurat: '004/MEMO/2016', tanggalBerlaku: '02.08.2016' },
//   { title: 'Title voice memo ...', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/envelope.svg', desc: 'Memo voice detail ...', date: '02.08.2016', type: 'voice', nomorSurat: '005/VOICE/2016', tanggalBerlaku: '02.08.2016' },
//   { title: 'Title draw memo ...', count: 0, icon: 'https://unpkg.com/heroicons@2.0.13/24/solid/book-open.svg', desc: 'Memo draw detail ...', date: '02.08.2016', type: 'draw', nomorSurat: '006/DRAW/2016', tanggalBerlaku: '02.08.2016' },
// ])

const filteredCards = computed(() => {
  const tab = activeMemoTab.value;
  const allCards = cards.value || [];
  
  if (tab === 'all') return allCards;

  return allCards.filter(card =>
    Array.isArray(card.document_regional) &&
    card.document_regional.some(dr => dr.regional_id.toString().charAt(0) == tab)
  );
});

function openDetail(card) {
  if (modalRef.value && modalRef.value.openModal) {
    modalRef.value.openModal(card);
  }
  
  console.log('openDetail', modalRef.value, card)
}

const deleteAnnouncement = (item) => {
  // archive
  
  Swal.fire({
    title: "Are you sure archive?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, archive it!"
  }).then(async (result) => {
    if (result.isConfirmed) {
      // Soft delete (archive)
      softDeleteAnnouncement(item.id_pengumuman || item.id)
        .then(() => {
          // Hapus dari list
          cards.value = cards.value.filter(c => (c.id_pengumuman || c.id) !== (item.id_pengumuman || item.id));
          Swal.fire({
            title: "Archived!",
            text: "Content has been archived.",
            icon: "success",
            timer: 1500
          });
        });
    }
    })
    .catch(() => {
      Swal.fire({
        title: "Error!",
        text: "Failed to archive data!",
        icon: "error",
        timer: 1500
      });
    });
}

const showModal = ref(false)
const selectedCard = ref(null)

// Prevent background scroll when modal is open
watch(showModal, (val) => {
  if (val) {
    document.body.classList.add('overflow-hidden');
  } else {
    document.body.classList.remove('overflow-hidden');
  }
});



onMounted(async () => {
  try {
    const [result, resultAreas, resSession] = await Promise.all([
      getDetailAnnouncement(route.params.id),
      getWilayah(),
      getSession()
    ]);
    
    auth.value = resSession.auth
    console.log('areas', resultAreas)
    let items = [];
    if (Array.isArray(result)) {
      items = result;
      console.log('items', items)
      detail.value = result[0] || {};
    } else {
      items = result.items || [];
      detail.value = result.detail || result;
      title.value = result.title || result.judul || 'Detail Pengumuman';
    }
    // Mapping agar field sesuai dengan template
    cards.value = items.map(item => ({
      ...item,
      nomorSurat: item.nomorSurat || item.nomor_surat || item.nomor || '-',
      tanggalBerlaku: item.tanggalBerlaku || item.tanggal_berlaku || item.tanggal || '-',
      date: item.date || item.updated_at || item.tanggal_update || '-',
      title: item.title || item.judul || '-',
      icon: item.icon || '/default-icon.svg',
      desc: item.desc || item.keterangan || item.deskripsi || '',
      type: item.type,
    }));
    // Untuk detail utama, mapping juga
    detail.value = {
      ...detail.value,
      name: detail.value.name || detail.value.title || detail.value.judul || '-',
      nomorSurat: detail.value.nomorSurat || detail.value.nomor_surat || detail.value.nomor || '-',
      tanggalBerlaku: detail.value.tanggalBerlaku || detail.value.tanggal_berlaku || detail.value.tanggal || '-',
      date: detail.value.date || detail.value.updated_at || detail.value.tanggal_update || '-',
      desc: detail.value.desc || detail.value.keterangan || detail.value.deskripsi || '',
    };
    
    memoTabs.value = [
      { kd_wilayah: 'all', nm_wilayah: 'All' },
      ...resultAreas,
    ]
    console.log("result areas", memoTabs);
    console.log("result announcement", cards.value, detail.value);
    console.log("detail announcement", detail.value);
  } catch (error) {
    console.log(error);
  }
});


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

