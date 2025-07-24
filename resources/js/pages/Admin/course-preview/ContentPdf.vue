<template>
  <div class="flex flex-col gap-5 max-w-[800px] pb-[160px]">
    <h1 class="font-bold text-[32px] leading-[48px]">
      {{ content.title || 'Content Title' }}
    </h1>

    <!-- Download Attachment if available -->
    <div class="flex justify-end" v-if="content.attachment || content.pdf_url">
      <a :href="content.attachment || content.pdf_url" target="_blank"
        class="btn bg-red-500 py-2 px-5 rounded-lg text-white hover:bg-red-400 transition-colors">
        Download Lampiran
      </a>
    </div>

    <!-- PDF Viewer with PDF.js -->
    <div v-if="content.pdf_url || content.attachment" class="pdf-container">
      <!-- PDF Controls -->
      <div class="pdf-controls-top">
        <div class="flex justify-between items-center">
          <div class="flex gap-2 items-center">
            <button @click="previousPage" :disabled="currentPage <= 1"
              class="btn bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
            </button>
            
            <span class="px-3 py-1 bg-gray-100 rounded text-sm">
              {{ currentPage }} / {{ totalPages }}
            </span>
            
            <button @click="nextPage" :disabled="currentPage >= totalPages"
              class="btn bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>

            <div class="ml-4 flex gap-2 items-center">
              <button @click="zoomOut" :disabled="scale <= 0.5"
                class="btn bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
              </button>
              
              <span class="px-2 py-1 bg-gray-100 rounded text-sm">
                {{ Math.round(scale * 100) }}%
              </span>
              
              <button @click="zoomIn" :disabled="scale >= 3"
                class="btn bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
              </button>
            </div>
          </div>

          <div class="flex gap-2">
            <button @click="openPdfInNewTab" 
              class="btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
              <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
              </svg>
              Buka di Tab Baru
            </button>
            <button @click="downloadPdf" 
              class="btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
              <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Download PDF
            </button>
          </div>
        </div>
      </div>

      <!-- PDF Viewer Canvas -->
      <div class="pdf-viewer-wrapper" ref="pdfViewerContainer">
        <div v-if="loading" class="loading-overlay">
          <div class="loading-spinner"></div>
          <p class="text-gray-600 mt-4">Loading PDF...</p>
        </div>
        
        <div v-if="error" class="error-overlay">
          <svg class="w-16 h-16 mx-auto text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
          <p class="text-red-600 mb-2">Failed to load PDF</p>
          <p class="text-gray-500 text-sm">{{ error }}</p>
          <button @click="loadPdf" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            Try Again
          </button>
        </div>

        <canvas 
          v-show="!loading && !error"
          ref="pdfCanvas"
          class="pdf-canvas"
          :style="{ transform: `scale(${scale})`, transformOrigin: 'top left' }"
        ></canvas>
      </div>

      <!-- PDF Status -->
      <div class="pdf-status">
        <div class="flex justify-between items-center text-sm text-gray-500">
          <span>PDF Document</span>
          <span v-if="!loading && !error">{{ Math.round(renderProgress) }}% rendered</span>
        </div>
      </div>
    </div>

    <!-- Content Description -->
    <article v-if="content.body || content.content" id="Content-wrapper" class="prose max-w-none">
      <div v-if="content.body" v-html="content.body"></div>
      <div v-else-if="content.content" v-html="content.content"></div>
    </article>

    <!-- No Content Available -->
    <div v-else-if="!content.pdf_url && !content.attachment" class="text-center py-8">
      <div class="bg-gray-100 rounded-lg p-8">
        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="text-gray-500 text-lg">No PDF content available</p>
        <p class="text-gray-400 text-sm mt-2">Please upload a PDF file to view it here</p>
      </div>
    </div>
  </div>
</template><script setup>
import { defineProps, ref, onMounted, onUnmounted, nextTick, watch } from 'vue';

// Import PDF.js and worker for Vite/Webpack compatibility

import * as pdfjsLib from 'pdfjs-dist';
import pdfjsWorker from 'pdfjs-dist/build/pdf.worker.js?url';
pdfjsLib.GlobalWorkerOptions.workerSrc = pdfjsWorker;

// Debug versi pdfjs-dist dan worker
// console.log('pdfjs-dist version:', pdfjsLib.version);
// console.log('pdfjs-dist workerSrc:', pdfjsLib.GlobalWorkerOptions.workerSrc);

const props = defineProps({
  content: {
    type: Object,
    default: () => ({})
  }
});



console.log("props.content", props.content);

// Reactive data
const pdfCanvas = ref(null);
const pdfViewerContainer = ref(null);
const pdfDocument = ref(null);
const currentPage = ref(1);
const totalPages = ref(0);
const scale = ref(1.0);
const loading = ref(false);
const error = ref(null);
const renderProgress = ref(0);

// PDF.js rendering context
let renderContext = null;

// Get PDF URL
const getPdfUrl = () => {
  return "https://mozilla.github.io/pdf.js/web/compressed.tracemonkey-pldi-09.pdf";
};


const loadPdf = async () => {
  const pdfUrl = await getPdfUrl();
  console.log("pdfUrl", pdfUrl);
  if (!pdfUrl) {
    error.value = 'No PDF URL provided';
    resetCanvas();
    return;
  }

  // Destroy previous PDF if exists
  if (pdfDocument.value) {
    try { await pdfDocument.value.destroy(); } catch {}
    pdfDocument.value = null;
  }

  loading.value = true;
  error.value = null;
  renderProgress.value = 0;
  resetCanvas();

  try {
    console.log('Loading PDF from:', pdfUrl);
    const loadingTask = pdfjsLib.getDocument(pdfUrl);

    loadingTask.onProgress = (progress) => {
  if (progress.total > 0) {
    renderProgress.value = Math.min((progress.loaded / progress.total) * 50, 100); // Ensure progress doesn't exceed 100%
  }
};

    pdfDocument.value = await loadingTask.promise;
    totalPages.value = pdfDocument.value.numPages;
    currentPage.value = 1;
    console.log('PDF loaded successfully. Total pages:', totalPages.value);
    await renderPage(1);
  } catch (err) {
    console.error('Error loading PDF:', err);
    error.value = 'Gagal memuat PDF: ' + (err.message || err);
    resetCanvas();
  } finally {
    loading.value = false;
  }
};


// Render specific page
const renderPage = async (pageNumber) => {
  console.log(pdfDocument);
  if (!pdfDocument.value) {
    error.value = 'PDF document not loaded.';
    resetCanvas();
    return;
  }
  if (!pdfCanvas.value) {
    error.value = 'Canvas not found.';
    return;
  }
  try {
    const page = await pdfDocument.value.getPage(pageNumber);
    const canvas = pdfCanvas.value;
    const context = canvas.getContext('2d');
    if (!context) {
      error.value = 'Failed to get canvas context.';
      return;
    }

    // Calculate viewport with current scale
    const viewport = page.getViewport({ scale: scale.value });

    // Set canvas dimensions
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Clear canvas
    context.clearRect(0, 0, canvas.width, canvas.height);

    // Render page
    renderContext = {
      canvasContext: context,
      viewport: viewport
    };

    const renderTask = page.render(renderContext);
    await renderTask.promise;
    
    // Update progress and error state
    // renderProgress.value = 100; // Ensure progress doesn't exceed 100%
    error.value = null;
    console.log(`Page ${pageNumber} rendered successfully`);
  } catch (err) {
    console.error('Error rendering page:', err);
    error.value = `Gagal menampilkan halaman ${pageNumber}: ${err.message || err}`;
    resetCanvas();
  }
};


// Reset canvas and state
function resetCanvas() {
  const canvas = pdfCanvas.value;
  if (canvas) {
    const ctx = canvas.getContext('2d');
    if (ctx) {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
    canvas.width = 1;
    canvas.height = 1;
  }
  renderProgress.value = 0;
}


// Navigation methods
const nextPage = async () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
    await renderPage(currentPage.value);
  }
};

const previousPage = async () => {
  if (currentPage.value > 1) {
    currentPage.value--;
    await renderPage(currentPage.value);
  }
};

// Zoom methods
const zoomIn = async () => {
  if (scale.value < 3) {
    scale.value = Math.min(scale.value + 0.25, 3);
    await renderPage(currentPage.value);
  }
};

const zoomOut = async () => {
  if (scale.value > 0.5) {
    scale.value = Math.max(scale.value - 0.25, 0.5);
    await renderPage(currentPage.value);
  }
};

// Open PDF in new tab
const openPdfInNewTab = () => {
  const pdfUrl = getPdfUrl();
  if (pdfUrl) {
    window.open(pdfUrl, '_blank');
  }
};

// Download PDF
const downloadPdf = () => {
  const pdfUrl = getPdfUrl();
  if (pdfUrl) {
    const link = document.createElement('a');
    link.href = pdfUrl;
    link.download = props.content.title || 'document.pdf';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }
};

// Keyboard navigation
const handleKeydown = (event) => {
  switch (event.key) {
    case 'ArrowLeft':
    case 'ArrowUp':
      event.preventDefault();
      previousPage();
      break;
    case 'ArrowRight':
    case 'ArrowDown':
      event.preventDefault();
      nextPage();
      break;
    case '+':
    case '=':
      event.preventDefault();
      zoomIn();
      break;
    case '-':
      event.preventDefault();
      zoomOut();
      break;
  }
};

// Watch for content changes
watch(() => props.content, async (newContent, oldContent) => {
  if (newContent && (newContent.pdf_url || newContent.attachment) && 
      (newContent.pdf_url !== oldContent?.pdf_url || newContent.attachment !== oldContent?.attachment)) {
    await nextTick();
    await loadPdf();
  }
}, { immediate: true });

// Lifecycle hooks
onMounted(async () => {
  document.addEventListener('keydown', handleKeydown);
  await nextTick();
  if (getPdfUrl()) {
    await loadPdf();
  }
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown);
  if (pdfDocument.value) {
    try { pdfDocument.value.destroy(); } catch {}
    pdfDocument.value = null;
  }
  resetCanvas();
});

</script>

<style scoped>
.pdf-container {
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  background: white;
}

.pdf-controls-top {
  padding: 1rem;
  background: #f8f9fa;
  border-bottom: 1px solid #e2e8f0;
}

.pdf-viewer-wrapper {
  position: relative;
  width: 100%;
  min-height: 600px;
  max-height: 800px;
  overflow: auto;
  background: #f5f5f5;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 20px;
}

.pdf-canvas {
  max-width: 100%;
  height: auto;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  background: white;
  transition: transform 0.2s ease-in-out;
}

.loading-overlay,
.error-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  z-index: 10;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #662FFF;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.pdf-status {
  padding: 0.75rem 1rem;
  background: #f8f9fa;
  border-top: 1px solid #e2e8f0;
}

.prose {
  line-height: 1.7;
  color: #374151;
  margin-top: 2rem;
}

.prose h1,
.prose h2,
.prose h3,
.prose h4,
.prose h5,
.prose h6 {
  font-weight: bold;
  margin-top: 1.5em;
  margin-bottom: 0.5em;
  color: #111827;
}

.prose h1 {
  font-size: 2em;
}

.prose h2 {
  font-size: 1.5em;
}

.prose h3 {
  font-size: 1.25em;
}

.prose p {
  margin-bottom: 1em;
  text-align: justify;
}

.prose ul,
.prose ol {
  margin-bottom: 1em;
  padding-left: 1.5em;
}

.prose li {
  margin-bottom: 0.5em;
}

.prose blockquote {
  border-left: 4px solid #662FFF;
  padding-left: 1em;
  margin: 1em 0;
  font-style: italic;
  background: #f8f9fa;
  padding: 1em;
  border-radius: 0.5em;
}

.prose code {
  background: #f1f5f9;
  padding: 0.2em 0.4em;
  border-radius: 0.25em;
  font-size: 0.9em;
  color: #dc2626;
}

.prose pre {
  background: #f1f5f9;
  padding: 1em;
  border-radius: 0.5em;
  overflow-x: auto;
  margin: 1em 0;
}

.prose pre code {
  background: none;
  padding: 0;
  color: #374151;
}

.prose img {
  max-width: 100%;
  height: auto;
  border-radius: 0.5em;
  margin: 1em 0;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.prose table {
  width: 100%;
  border-collapse: collapse;
  margin: 1em 0;
}

.prose th,
.prose td {
  border: 1px solid #e2e8f0;
  padding: 0.75em;
  text-align: left;
}

.prose th {
  background: #f8f9fa;
  font-weight: bold;
}

.prose a {
  color: #662FFF;
  text-decoration: underline;
}

.prose a:hover {
  color: #5521cc;
}

.prose strong {
  font-weight: bold;
  color: #111827;
}

.prose em {
  font-style: italic;
}

.prose hr {
  border: none;
  height: 1px;
  background: #e2e8f0;
  margin: 2em 0;
}

.prose .highlight {
  background: #fef3cd;
  padding: 0.2em 0.4em;
  border-radius: 0.25em;
}

.btn {
  display: inline-flex;
  align-items: center;
  text-decoration: none;
  cursor: pointer;
  border: none;
  font-family: inherit;
  font-size: inherit;
  transition: all 0.2s ease-in-out;
}

.btn:focus {
  outline: 2px solid #662FFF;
  outline-offset: 2px;
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn:disabled:hover {
  transform: none;
}

.btn:hover:not(:disabled) {
  transform: translateY(-1px);
}

/* Responsive design */
@media (max-width: 768px) {
  .pdf-viewer-wrapper {
    min-height: 400px;
    max-height: 500px;
    padding: 10px;
  }
  
  .pdf-controls-top .flex {
    flex-direction: column;
    gap: 0.75rem;
    align-items: stretch;
  }
  
  .pdf-controls-top .flex > div:first-child {
    order: 2;
  }
  
  .pdf-controls-top .flex > div:last-child {
    order: 1;
    justify-content: center;
  }

  .pdf-controls-top .flex .flex {
    flex-wrap: wrap;
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .pdf-controls-top .flex .flex {
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
  }

  .pdf-controls-top .flex .flex > div {
    display: flex;
    gap: 0.5rem;
  }
}

/* Print support */
@media print {
  .pdf-controls-top,
  .pdf-status {
    display: none;
  }
  
  .pdf-container {
    border: none;
    box-shadow: none;
  }
  
  .pdf-viewer-wrapper {
    background: white;
    box-shadow: none;
  }
}

/* Accessibility improvements */
.btn:focus-visible {
  outline: 2px solid #662FFF;
  outline-offset: 2px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
  .pdf-container {
    border: 2px solid #000;
  }
  
  .loading-spinner {
    border-top-color: #000;
  }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  .pdf-canvas {
    transition: none;
  }
  
  .loading-spinner {
    animation: none;
  }
  
  .btn {
    transition: none;
  }
}
</style>