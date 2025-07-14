<template>
  <li class="me-2" v-for="(menu, index) in menu">
    <a href="#" @click="changeMenu(menu.name)"
      class="inline-flex items-center justify-center border-b-2 border-transparent rounded-t-lg hover:border-gray-300 dark:hover:text-gray-300 group rounded-lg px-4 py-2"
      :class='{
        "bg-gray-200": menu.name.toLowerCase() != menuActive,
        "bg-blue-300": menu.name.toLowerCase() == menuActive,
        "text-blue-600": menu.name.toLowerCase() == menuActive
      }'>
      <!-- <img src="../../../../../public/assets/images/icons/submenu/all.svg" alt=""> -->
      <img src="#/" alt="">
      {{ menu.name }} 
    </a>

  </li>
</template>




<script setup>
import { ref } from "vue"

let menuActive = ref('all');

const changeMenu = (menuName) => {
  menuActive.value = menuName.toLowerCase();
  console.log(menuActive);
}


defineProps({
  menu: {
    type: Array,
    required: true
  }
})

</script>