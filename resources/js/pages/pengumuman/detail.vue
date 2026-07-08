<template>
  <!-- Modal Detail Card -->
  <OpenModalPDF ref="modalRef" v-model:showModal="showModal" v-model:selectedCard="selectedCard" />

  <div class='flex gap-2 items-center -mb-4 text-gray-400 text-xs'>
    <router-link to='/pengumuman' class='flex gap-2 items-center text-gray-400 text-xs cursor-pointer'>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
        class="w-4 h-4 text-sidebar">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7l-7 7 7 7" />
      </svg>
      Back to Pengumuman
    </router-link>
  </div>
  <h1 class="text-2xl font-bold text-sidebar">{{ detail.name }}</h1>
  <!-- Baris filter area dan layout menu -->
  <div class="flex items-center justify-between mb-4">
    <!-- Filter Area Tabs -->
    <div class="flex gap-2" v-if="auth?.cabang === '' || !auth?.cabang">
      <!-- START: AREA TAB DYNAMIC -->
      <button v-for="tab in memoTabs" :key="tab.kd_wilayah" @click="activeMemoTab = tab.kd_wilayah"
        :class="['px-3 py-1 rounded-lg font-semibold text-xs transition', activeMemoTab === tab.kd_wilayah ? 'bg-sidebar text-white shadow' : 'bg-white text-sidebar hover:bg-purple-100']">
        <span>{{ formatWilayahName(tab.nm_wilayah) }}</span>
      </button>
      <!-- END: AREA TAB DYNAMIC -->
    </div>
    <!-- Layout Menu Icon -->
    <div class="flex gap-2" v-if="auth?.cabang === ''">
      <button @click="viewMode = 'card'"
        :class="['px-3 py-1 rounded-lg font-semibold text-xs transition flex items-center gap-1', viewMode === 'card' ? 'bg-sidebar text-white shadow' : 'bg-white text-sidebar hover:bg-purple-100']">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
          <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
          <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
          <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
        </svg>
        Card
      </button>
      <button @click="viewMode = 'table'"
        :class="['px-3 py-1 rounded-lg font-semibold text-xs transition flex items-center gap-1', viewMode === 'table' ? 'bg-sidebar text-white shadow' : 'bg-white text-sidebar hover:bg-purple-100']">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <rect x="3" y="6" width="18" height="2" rx="1" stroke-width="2" />
          <rect x="3" y="11" width="18" height="2" rx="1" stroke-width="2" />
          <rect x="3" y="16" width="18" height="2" rx="1" stroke-width="2" />
        </svg>
        Table
      </button>
    </div>
  </div>

  <!-- Card Layout -->
  <div v-if="viewMode === 'card'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <div v-for="(item, idx) in filteredCards" :key="item.submenu_id"
      class="relative rounded-2xl bg-white shadow-xl p-0 flex flex-col justify-between overflow-hidden group announcement-card border border-gray-200 hover:border-sidebar transition"
      @click="openDetail(item)">
      <div class="absolute inset-0 opacity-10 pointer-events-none pattern-bg"></div>
      <div class="flex flex-col gap-2 z-10 p-6">
        <div class="flex items-center gap-3 mb-3">
          <div
            class="rounded-tr-lg rounded-bl-3xl bg-sidebar p-2 absolute -top-1 -right-0 flex items-center justify-center flex-shrink-0">
            <img :src="detail.icon" class="w-8 h-8 filter-white-svg" alt="icon" />
            <!-- <img :src="item.icon" class="w-8 h-8 filter-white-svg" alt="icon" /> -->
          </div>
          <span
            class="text-sidebar text-lg font-bold transition-all duration-300 mt-3 hover:line-clamp-none cursor-pointer"
            :title="item.title">{{ item.title }}</span>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 flex flex-col gap-2 mb-2 border border-gray-100">
          <div class="flex justify-between items-center">
            <span class="text-xs font-semibold text-gray-500">Nomor Surat</span>
            <span class="text-xs font-bold text-sidebar line-clamp-1 relative group">
              {{ item.no_surat }}
              <span v-if="item.no_surat && item.no_surat.length > 20"
                class="absolute left-0 top-full mt-1 w-max bg-white border border-gray-300 shadow-lg rounded px-2 py-1 text-xs text-sidebar opacity-0 group-hover:opacity-100 transition pointer-events-none z-30">
                {{ item.no_surat }}
              </span>
            </span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-xs font-semibold text-gray-500">Tanggal Berlaku</span>
            <span class="text-xs font-bold text-sidebar">{{ item.tgl_berlaku }}</span>
          </div>
        </div>
        <div class="text-xs text-gray-500 mb-16">Terakhir update: <br><span class="font-semibold text-sidebar">{{
          item.dateLastUpdate
        }}</span></div>
        <!-- Tombol aksi di tengah bawah -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-4 mt-2 justify-center items-center w-max"
          v-if='auth && (auth.idgrup == "JBT-032" || auth.idgrup === "JBT-037" || auth.idgrup === "JBT-039" || auth.idgrup === "JBT-040")'>
          <router-link :to="{ name: 'information-document-update', params: { id: item.id } }" @click.stop
            class="bg-white rounded-full px-4 py-2 shadow hover:bg-purple-100 transition group/edit flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-5 h-5 text-sidebar group-hover/edit:text-purple-700">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 3.487a2.1 2.1 0 1 1 2.97 2.97L8.91 17.38a2.1 2.1 0 0 1-.88.53l-3.07.92a.525.525 0 0 1-.65-.65l.92-3.07a2.1 2.1 0 0 1 .53-.88L16.862 3.487z" />
            </svg>
            <span class="text-xs font-semibold text-sidebar">Edit</span>
          </router-link>
          <button @click.stop="deleteAnnouncement(item)"
            class="bg-red-100 rounded-full px-4 py-2 shadow hover:bg-red-200 transition group/delete flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-5 h-5 text-red-600 group-hover/delete:text-red-800">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="text-xs font-semibold text-red-600">Archive</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Table/List Layout -->
  <div v-else>
    <div class="datatable bg-white mb-16">
      <vue3-datatable :rows="tableRows" :columns="tableCols" :totalRows="tableRows.length" :search="search"
        :sortable="true" :selectRowOnClick="true" @row-click='handleRowClick'>
        <template #tglBerlaku="{ value }">
          <div class="text-xs text-gray-700 text-center">{{ value?.tglBerlakuFormatted || '-' }}</div>
        </template>
        <template #lastUpdate="{ value }">
          <span class="text-xs font-medium text-gray-700">{{ value?.dateLastUpdate || '-' }}</span>
        </template>
        <template #action="{ value }">
          <div class="flex gap-2 justify-center items-center" v-if="value">
            <button @click.stop="router.push({ name: 'information-document-update', params: { id: value?.id } })"
              class="bg-white border border-sidebar text-sidebar px-2 py-1 rounded shadow hover:bg-purple-100 transition text-xs font-semibold inline-flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-3 h-3">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.862 3.487a2.1 2.1 0 1 1 2.97 2.97L8.91 17.38a2.1 2.1 0 0 1-.88.53l-3.07.92a.525.525 0 0 1-.65-.65l.92-3.07a2.1 2.1 0 0 1 .53-.88L16.862 3.487z" />
              </svg>
              Edit
            </button>
            <button @click.stop="deleteAnnouncementFromTable(value?.id)"
              class="bg-red-100 border border-red-300 text-red-600 px-2 py-1 rounded shadow hover:bg-red-200 transition text-xs font-semibold inline-flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-3 h-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Archive
            </button>
          </div>
        </template>
      </vue3-datatable>
    </div>
  </div>
  <!-- ...existing code... -->
</template>

<script setup>
import axios from 'axios';
import { softDeleteAnnouncement } from '@/services/announcementService';
import OpenModalPDF from '@/components/openModalPDF.vue';
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import Vue3Datatable from '@bhplugin/vue3-datatable';
import { getDetailAnnouncement, getLastDocumentPreview } from '@/services/announcementService';
import { getSession } from '@/services/authService';
import { getWilayah } from '@/services/masterService';
import { recordDocumentView } from '@/services/documentViewService';
import Swal from 'sweetalert2';

const route = useRoute();
const router = useRouter();

const detail = ref({});
const title = ref({})
const icon = ref({})
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

const formatWilayahName = (name) => {
  if (!name) return '';
  const lower = name.toLowerCase();
  if (lower === 'all') return 'All';
  if (lower === 'jakarta') return 'Jaya';
  if (lower === 'jawa barat') return 'Jabar';
  if (lower === 'kepri') return 'Kepri';

  return name.split(' ')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
    .join(' ');
};

const filteredCards = computed(() => {
  const tab = activeMemoTab.value;
  const allCards = cards.value || [];

  if (tab === 'all') return allCards;

  return allCards.filter(card => {
    if (!Array.isArray(card.document_regional)) return false;
    return card.document_regional.some(dr => {
      if (dr.regional_id === undefined || dr.regional_id === null) return false;
      const regionalStr = dr.regional_id.toString();
      // 1. Direct match with region ID (e.g. 2 === 2)
      if (regionalStr === tab.toString()) return true;

      // 2. Pad branch/area code to 4 digits and check the region digit (e.g. 509 -> "0509" -> matches region 5)
      const padded = regionalStr.padStart(4, '0');
      return padded.length === 4 && padded.charAt(1) === tab.toString();
    });
  });
});

const search = ref('');

const isAdmin = computed(() =>
  auth.value &&
  (
    auth.value.idgrup == 'JBT-032' ||
    auth.value.idgrup === 'JBT-037' ||
    auth.value.idgrup === 'JBT-039' ||
    auth.value.idgrup === 'JBT-040'
  )
);

const tableCols = computed(() => {
  const cols = [
    { field: 'id', title: 'ID', isUnique: true },
    { field: 'title', title: 'Judul' },
    { field: 'nomorSurat', title: 'Nomor Surat' },
    { field: 'tglBerlaku', title: 'Tanggal Berlaku', cellClass: 'text-center', headerClass: 'text-center justify-center' },
    { field: 'lastUpdate', title: 'Terakhir Diperbarui' }
  ];
  if (isAdmin.value) {
    cols.push({
      field: 'action',
      title: 'Aksi',
      sortable: false,
      type: 'html', // Tambahkan type html untuk render HTML content
      width: '180px'
    });
  }
  return cols;
});

const tableRows = computed(() => {
  console.log('Generating tableRows from filteredCards:', filteredCards.value);
  return filteredCards.value.map((item, index) => {
    const row = {
      id: item.id || item.id_pengumuman || item.submenu_id || index,
      title: item.title,
      nomorSurat: item.no_surat,
      tglBerlaku: item.tgl_berlaku_raw || '', // gunakan raw date (YYYY-MM-DD) untuk sorting kronologis
      tglBerlakuFormatted: item.tgl_berlaku || '-', // tampilkan format human-readable di tabel
      lastUpdate: item.updated_at || item.created_at || '', // gunakan raw timestamp/ISO date untuk sorting kronologis
      dateLastUpdate: item.dateLastUpdate || '-' // tampilkan format human-readable di tabel
    };

    // Tambahkan field action untuk admin (tombol HTML)


    console.log('Row created:', row);
    return row;
  });
});


async function openDetail(card) {
  console.log('Opening detail for card:', card);
  if (modalRef.value && modalRef.value.openModal) {
    modalRef.value.openModal(card);
    try {
      await Promise.all([
        getLastDocumentPreview(card.id),
        recordDocumentView(card.id)
      ]);
    } catch (err) {
      console.error('Failed to log document view or update preview history:', err);
    }
  }

  console.log('openDetail', modalRef.value, card)
}

function openDetailById(id) {
  console.log('openDetailById called with id:', id);
  console.log('filteredCards:', filteredCards.value);
  const card = filteredCards.value.find(item => item.id === id);
  console.log('Found card:', card);
  if (card) openDetail(card);
}

function handleRowClick(row) {
  console.log('Row clicked:', row);
  const card = filteredCards.value.find(item => item.id === row.id);
  if (card) {
    openDetail(card);
  }
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

const deleteAnnouncementFromTable = (id) => {
  console.log('deleteAnnouncementFromTable called with id:', id);

  // Cari item berdasarkan id dari filteredCards
  const item = filteredCards.value.find(card => {
    const cardId = card.id || card.id_pengumuman || card.submenu_id;
    return cardId == id;
  });

  if (item) {
    // Gunakan function deleteAnnouncement yang sudah ada
    deleteAnnouncement(item);
  } else {
    console.error('Item not found for deletion:', id);
    Swal.fire({
      title: "Error!",
      text: "Item not found!",
      icon: "error",
      timer: 1500
    });
  }
}

const showModal = ref(false)
const selectedCard = ref(null)
const viewMode = ref('card'); // 'card' atau 'table'

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
      title.value = result.title || 'Detail Pengumuman';
      icon.value = result.icon || 'https://unpkg.com/heroicons@2.0.13/24/solid/document.svg';
    }
    // Mapping agar field sesuai dengan template
    cards.value = items.map(item => ({
      ...item,
      id: item.id || item.id_pengumuman || item.submenu_id, // pastikan ada ID
      nomorSurat: item.nomorSurat || item.nomor_surat || item.nomor || '-',
      tanggalBerlaku: item.tgl_berlaku || '-',
      date: item.dateLastUpdate || '-',
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
      date: detail.value.dateLastUpdate ? detail.value.dateLastUpdate : '-',
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
  scrollbar-width: none;
  /* Firefox */
  -ms-overflow-style: none;
  /* IE 10+ */
}

.scrollbar-hidden::-webkit-scrollbar {
  display: none;
  /* Chrome/Safari/Webkit */
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
  scrollbar-width: none;
  /* Firefox */
  -ms-overflow-style: none;
  /* IE 10+ */
}

.scrollbar-hidden::-webkit-scrollbar {
  display: none;
  /* Chrome/Safari/Webkit */
}
</style>
