<template>
  <embed :src="pdfUrl + '#toolbar=0&navpanes=0'" type="application/pdf" width="100%" height="500px" class='mt-16' v-if="pdfUrl" />
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  content: {
    type: String,
    default: () => ''
  }
})

const imgUrl = process.env.MIX_IMG_URL || '';
console.log('imgUtl', imgUrl);
console.log("props.content", props.content);
const contentUrl = imgUrl + props.content ;
console.log("ContentPdf component loaded with content:", contentUrl);
const pdfUrl = ref(contentUrl || '')

watch(() => props.content, (newContent) => {
  pdfUrl.value = imgUrl + (newContent || '')
}, { immediate: true })
</script>