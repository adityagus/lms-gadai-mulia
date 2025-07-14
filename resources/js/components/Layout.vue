<template>
  <div v-if='isManagerPreviewPage'>
    <router-view></router-view>
  </div>
  <div v-else>
    <Sidebar />
    <main class="flex flex-col flex-1 gap-[30px] p-[30px] ml-[290px]">
      <Header />
      <router-view></router-view>
      <!-- <Outlet/> -->
    </main>
  </div>
</template>

<script setup>
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import { useRoute } from 'vue-router';
import { watch } from 'vue'

const route = useRoute();
let isManagerPreviewPage = route.name === 'content-preview';
watch( () => route.path, (newPath, oldPath) => {
  isManagerPreviewPage = route.name === 'content-preview';
  console.log("🚀 ~ isManagerPreviewPage:", isManagerPreviewPage)
  console.log("newPath", newPath);
  console.log("oldPath", oldPath);
  
})

// const isStudentPreviewPage = computed(() =>
//   route.name === 'StudentPreview'
// );

</script>