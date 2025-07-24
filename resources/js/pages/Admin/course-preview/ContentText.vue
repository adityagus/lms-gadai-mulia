<template>
  <div class="flex flex-col gap-5 max-w-[800px] pb-[160px]">
    <h1 class="font-bold text-[32px] leading-[48px]">
      {{ content.title || 'Content Title' }}
    </h1>

    <!-- Download Attachment if available -->
    <div class="flex justify-end" v-if="content.attachment">
      <a :href="content.attachment" target="_blank"
        class="btn bg-red-500 py-2 px-5 rounded-lg text-white hover:bg-red-400 transition-colors">
        Download Lampiran
      </a>
    </div>

    <!-- Content Body -->
    <article id="Content-wrapper" class="prose max-w-none">
      <div v-if="content.body" v-html="content.body"></div>
      <div v-else-if="content.content" v-html="content.content"></div>
      <div v-else class="text-center py-8">
        <p class="text-gray-500">No content available</p>
      </div>
    </article>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  content: {
    type: Object,
    default: () => ({})
  }
});
</script>

<style scoped>
.prose {
  line-height: 1.7;
  color: #374151;
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

/* Custom styling for specific elements */
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
  display: inline-block;
  text-decoration: none;
}
</style>