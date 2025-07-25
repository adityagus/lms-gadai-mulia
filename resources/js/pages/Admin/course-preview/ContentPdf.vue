<template>
  <embed :src="pdfUrl" type="application/pdf" width="100%" height="500px" v-if="pdfUrl" />
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  content: {
    type: Object,
    default: () => ({})
  }
})

const imgUrl = process.env.MIX_IMG_URL || '';
const contentUrl = imgUrl + props.content.content ;
console.log("ContentPdf component loaded with content:", contentUrl);
const pdfUrl = ref(contentUrl || '')

watch(() => props.content, (newContent) => {
  pdfUrl.value = contentUrl || ''
}, { immediate: true })
</script>