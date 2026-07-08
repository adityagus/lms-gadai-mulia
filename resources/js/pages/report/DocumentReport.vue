<template>
  <div class="p-0 w-full min-h-screen bg-gray-50 report-body">
    <div class="w-full py-8 px-4">

      <!-- Header Section -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
          <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">Laporan Dokumen</h1>
          <p class="mt-1 text-sm text-gray-500">Rekap data dokumen-dokumen yang ada pada sistem.</p>
        </div>
        <button @click="exportToExcel" :disabled="exporting"
          :class="['text-white px-4 py-2 rounded-lg font-medium text-sm flex items-center gap-2 transition duration-200 shadow-sm', exporting ? 'bg-indigo-400 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700 hover:shadow-md']">
          <svg v-if="exporting" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
          </svg>
          <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
          </svg>
          {{ exporting ? 'Mengunduh...' : 'Export Excel' }}
        </button>
      </div>

      <!-- Search, Sort & Rows Per Page Filters -->
      <div
        class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">

        <!-- Search Input -->
        <div class="relative w-full md:max-w-xs">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </span>
          <input v-model="searchQuery" type="text" placeholder="Cari judul, nomor surat, atau jabatan..."
            class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
        </div>

        <!-- Sort and Rows Selectors -->
        <div class="flex flex-wrap items-center gap-4 w-full md:w-auto justify-between md:justify-end">

          <div class="flex items-center gap-2">
            <span class="text-xs text-gray-500 font-semibold">Tampilkan:</span>
            <select v-model="perPage"
              class="border border-gray-200 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white transition cursor-pointer">
              <option :value="10">10 baris</option>
              <option :value="25">25 baris</option>
              <option :value="50">50 baris</option>
              <option :value="100">100 baris</option>
            </select>
          </div>

        </div>
      </div>

      <!-- Stats Table Card -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full min-w-[900px] border-collapse">
            <thead>
              <tr
                class="bg-gray-50 border-b border-gray-100 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <th class="py-4 px-4 text-center w-12">No</th>
                <th class="py-4 px-4 min-w-[250px]">Jabatan</th>
                <th class="py-4 px-4 min-w-[150px]">Wilayah</th>
                <th class="py-4 px-4 whitespace-nowrap">Tanggal Upload</th>
                <th class="py-4 px-4 whitespace-nowrap">Ketentuan Dokumen</th>
                <th class="py-4 px-4 whitespace-nowrap">Tanggal Berlaku</th>
                <th class="py-4 px-4 whitespace-nowrap min-w-[150px]">Nomor Surat</th>
                <th class="py-4 px-4 min-w-[200px]">Perihal/Judul</th>
                <th class="py-4 px-4 text-center whitespace-nowrap">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr v-for="(item, idx) in paginatedData" :key="idx" class="hover:bg-gray-50/50 transition">
                <td class="py-3 px-4 text-center text-sm font-medium text-gray-500">{{ startRow + idx }}</td>
                <td class="py-3 px-4 text-sm text-gray-900 font-medium">{{ item.position
                  || '-' }}</td>
                <td class="py-3 px-4 text-sm text-gray-500">{{ item.pt || '-' }}</td>
                <td class="py-3 px-4 text-sm text-gray-500 whitespace-nowrap">{{ formatDate(item.tanggal_upload) }}</td>
                <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap text-center">
                  <span
                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-purple-800 border border-gray-200">
                    {{ item.ketentuan_dokumen || '-' }}
                  </span>
                </td>
                <td class="py-3 px-4 text-sm text-gray-500 whitespace-nowrap">{{ formatDate(item.tanggal_berlaku) }}
                </td>
                <td class="py-3 px-4 text-sm font-medium text-gray-700 whitespace-nowrap">{{ item.nomor_surat || '-' }}
                </td>
                <td class="py-3 px-4 text-sm text-gray-900 font-semibold" :title="item.perihal_judul">{{
                  item.perihal_judul || '-' }}</td>
                <td class="py-3 px-4 text-center whitespace-nowrap">
                  <span
                    :class="['inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border', item.status === 'Active' ? 'bg-green-50 text-green-700 border-green-100' : 'bg-red-50 text-red-700 border-red-100']">
                    {{ item.status }}
                  </span>
                </td>
              </tr>
              <tr>
                <td colspan="9" class="text-center py-4">

                  <div v-if="loading" class="mt-8 text-center text-indigo-600 font-medium">
                    <svg class="animate-spin h-8 w-8 mx-auto mb-2 text-indigo-600" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                      </path>
                    </svg>
                    Memuat data laporan...
                  </div>
                  <div v-if="error"
                    class="mt-8 p-4 bg-red-50 border border-red-100 text-red-600 text-center rounded-xl font-medium">
                    {{ error }}
                  </div>
                </td>
              </tr>
              <!-- Loading State -->
              <tr v-if="paginatedData.length === 0 && !loading">
                <td colspan="9" class="py-12 text-center text-gray-400">
                  <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  <p class="text-sm font-medium">Laporan kosong atau tidak ditemukan</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="filteredData.length > 0"
          class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
          <div class="text-xs text-gray-500 font-medium">
            Menampilkan {{ startRow }} - {{ endRow }} dari {{ filteredData.length }} baris
          </div>
          <div class="flex items-center gap-1.5">
            <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
              class="p-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-500 disabled:opacity-50 transition cursor-pointer">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <button v-for="p in visiblePages" :key="p" @click="changePage(p)"
              :class="['px-3 py-1 text-xs font-semibold rounded-lg border transition cursor-pointer', currentPage === p ? 'bg-indigo-600 border-indigo-600 text-white shadow-sm' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50']">
              {{ p }}
            </button>
            <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
              class="p-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-500 disabled:opacity-50 transition cursor-pointer">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import axios from 'axios';

const data = ref([]);
const loading = ref(false);
const error = ref('');
const exporting = ref(false);

const searchQuery = ref('');
const currentPage = ref(1);
const perPage = ref(10);

watch([searchQuery, perPage], () => {
  currentPage.value = 1;
});

const fetchReport = async () => {
  loading.value = true;
  error.value = '';
  try {
    const response = await axios.get('/api/v1/report/documents');
    if (response.data && response.data.success) {
      data.value = response.data.data;
    } else {
      error.value = 'Gagal memuat data laporan dokumen.';
    }
  } catch (err) {
    console.error(err);
    error.value = 'Terjadi kesalahan saat menghubungi server.';
  } finally {
    loading.value = false;
  }
};

const filteredData = computed(() => {
  if (!searchQuery.value.trim()) return data.value;
  const q = searchQuery.value.toLowerCase().trim();
  return data.value.filter(item =>
    item.perihal_judul?.toLowerCase().includes(q) ||
    item.nomor_surat?.toLowerCase().includes(q) ||
    item.position?.toLowerCase().includes(q) ||
    item.pt?.toLowerCase().includes(q)
  );
});

const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  return filteredData.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredData.value.length / perPage.value) || 1);

const startRow = computed(() => {
  if (filteredData.value.length === 0) return 0;
  return (currentPage.value - 1) * perPage.value + 1;
});

const endRow = computed(() => {
  const end = currentPage.value * perPage.value;
  return end > filteredData.value.length ? filteredData.value.length : end;
});

const visiblePages = computed(() => {
  const total = totalPages.value;
  const current = currentPage.value;
  const pages = [];
  let start = Math.max(1, current - 2);
  let end = Math.min(total, start + 4);
  if (end - start < 4) start = Math.max(1, end - 4);
  for (let i = start; i <= end; i++) pages.push(i);
  return pages;
});

const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) currentPage.value = page;
};

const formatDate = (dateStr) => {
  if (!dateStr) return '-';
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', {
    day: 'numeric', month: 'short', year: 'numeric'
  });
};

const exportToExcel = async () => {
  if (filteredData.value.length === 0 || exporting.value) return;
  try {
    exporting.value = true;
    const response = await axios.post('/api/v1/report/documents/export-excel', {
      data: filteredData.value
    }, {
      responseType: 'blob'
    });

    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", `laporan_dokumen_${new Date().getTime()}.xlsx`);
    document.body.appendChild(link);
    link.click();
    link.remove();
  } catch (err) {
    console.error(err);
    alert('Gagal mengekspor data ke Excel.');
  } finally {
    exporting.value = false;
  }
};

onMounted(() => {
  fetchReport();
});
</script>
