<template>
  <div class="w-full flex flex-col gap-2 justify-center">
    <div v-if="isLoading" class="flex items-center justify-center p-12 text-purple-700 font-medium">
      <svg class="animate-spin h-6 w-6 text-purple-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
      </svg>
      <!-- Memuat PDF Watermark NIK & Nama... -->
    </div>
    <embed v-else-if="pdfUrl" :src="pdfUrl + '#toolbar=0&navpanes=0'" type="application/pdf" width="100%" height="550px"
      class="rounded-xl border border-gray-200 shadow-sm mt-16" />
  </div>
</template>

<script setup>
import { ref, watch, onUnmounted } from 'vue'
import { createWatermarkedPdf, downloadWatermarkedPdf } from '@/utils/pdfWatermark'

const props = defineProps({
  content: {
    type: String,
    default: () => ''
  }
})

const pdfUrl = ref('')
const originalPdfUrl = ref('')
const isLoading = ref(false)
let currentBlobUrl = null

function cleanBlob() {
  if (currentBlobUrl) {
    URL.revokeObjectURL(currentBlobUrl)
    currentBlobUrl = null
  }
}

onUnmounted(() => {
  cleanBlob()
})

watch(() => props.content, async (newContent) => {
  cleanBlob()
  if (!newContent) {
    pdfUrl.value = ''
    originalPdfUrl.value = ''
    return
  }

  const rawBase = process.env.MIX_IMG_URL ?? 'NULL ENV MIX_IMG_URL'
  const base = rawBase.endsWith('/') ? rawBase : rawBase + '/'

  let targetUrl = ''
  if (newContent.startsWith('http://') || newContent.startsWith('https://')) {
    targetUrl = newContent
  } else {
    const cleanPath = newContent.replace(/^\/?(storage\/aktif\/|aktif\/)?/, '')
    targetUrl = base + cleanPath
  }

  originalPdfUrl.value = targetUrl
  isLoading.value = true

  try {
    const { blobUrl } = await createWatermarkedPdf(targetUrl)
    currentBlobUrl = blobUrl
    pdfUrl.value = blobUrl
  } catch (err) {
    console.error('Failed to create watermarked PDF for viewer, using original:', err)
    pdfUrl.value = targetUrl
  } finally {
    isLoading.value = false
  }
}, { immediate: true })
</script>