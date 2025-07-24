<template>
  <div class="flex flex-col gap-5 w-full pb-[160px]">
    <!-- Video Player -->
    <div class="flex shrink-0 h-[calc(100vh-110px-104px)] rounded-[20px] overflow-hidden bg-black">
      <iframe
        v-if="videoUrl"
        class="w-full aspect-video"
        :src="videoUrl"
        :title="content.title || 'Video Player'"
        frameBorder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        sandbox="allow-scripts allow-same-origin"
        allowFullScreen="true"
      ></iframe>
      
      <!-- Fallback when no video URL -->
      <div v-else class="w-full flex items-center justify-center bg-gray-100">
        <div class="text-center">
          <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
          </svg>
          <p class="text-gray-500 mb-2">No video available</p>
          <p class="text-xs text-gray-400" v-if="content.content">Content: {{ content.content.substring(0, 100) }}...</p>
        </div>
      </div>
    </div>
    
    <!-- Video Title -->
    <div class="flex items-center justify-between gap-5">
      <h1 class="font-bold text-[32px] leading-[48px]">
        {{ content.title || 'Video Title' }}
      </h1>
    </div>
    
    <!-- Video Description (if available) -->
    <div v-if="content.description || content.content" class="prose max-w-none">
      <div v-html="content.description || content.content"></div>
    </div>
    
    <!-- Download Attachment if available -->
    <div class="flex justify-end" v-if="content.attachment">
      <a 
        :href="content.attachment" 
        target="_blank"
        class="btn bg-blue-500 py-2 px-5 rounded-lg text-white hover:bg-blue-400 transition-colors"
      >
        Download Resource
      </a>
    </div>
  </div>
</template>

<script setup>
import { defineProps, computed, onMounted } from 'vue';

const props = defineProps({
  content: {
    type: Object,
    default: () => ({})
  }
});

// Debug content data
onMounted(() => {
  console.log('ContentVideo received content:', props.content);
});

// Function to extract video URL and convert to embeddable format
const videoUrl = computed(() => {
  // Try different possible fields for video URL
  const url = props.content.video_url || props.content.url || props.content.content;
  
  console.log('Processing video URL:', url);
  
  if (!url) return null;
  
  // YouTube URL conversion
  if (url.includes('youtube.com/watch?v=')) {
    const videoId = url.split('v=')[1]?.split('&')[0];
    return `https://www.youtube.com/embed/${videoId}`;
  }
  
  // YouTube short URL conversion
  if (url.includes('youtu.be/')) {
    const videoId = url.split('youtu.be/')[1]?.split('?')[0];
    return `https://www.youtube.com/embed/${videoId}`;
  }
  
  // Vimeo URL conversion
  if (url.includes('vimeo.com/')) {
    const videoId = url.split('vimeo.com/')[1]?.split('?')[0];
    return `https://player.vimeo.com/video/${videoId}`;
  }
  
  // Check if it's already an embed URL
  if (url.includes('/embed/') || url.includes('player.vimeo.com')) {
    return url;
  }
  
  // If it looks like a video URL, return it as is
  if (url.includes('http') && (url.includes('.mp4') || url.includes('.webm') || url.includes('.ogg'))) {
    return url;
  }
  
  // For API content field that might contain HTML or text, check if it contains a URL
  const urlMatch = url.match(/https?:\/\/[^\s<>"]+/);
  if (urlMatch) {
    const extractedUrl = urlMatch[0];
    console.log('Extracted URL from content:', extractedUrl);
    // Process the extracted URL recursively
    if (extractedUrl.includes('youtube.com/watch?v=')) {
      const videoId = extractedUrl.split('v=')[1]?.split('&')[0];
      return `https://www.youtube.com/embed/${videoId}`;
    }
    if (extractedUrl.includes('youtu.be/')) {
      const videoId = extractedUrl.split('youtu.be/')[1]?.split('?')[0];
      return `https://www.youtube.com/embed/${videoId}`;
    }
    return extractedUrl;
  }
  
  return null;
});
</script>

<style scoped>
.prose {
  line-height: 1.7;
  color: #374151;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
  font-weight: bold;
  margin-top: 1.5em;
  margin-bottom: 0.5em;
  color: #111827;
}

.prose p {
  margin-bottom: 1em;
  text-align: justify;
}

.prose ul, .prose ol {
  margin-bottom: 1em;
  padding-left: 1.5em;
}

.prose li {
  margin-bottom: 0.5em;
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

.btn {
  display: inline-block;
  text-decoration: none;
}
</style>