<template>
    <div class="card flex items-center gap-5">
          <div class="relative flex shrink-0 w-[140px] h-[110px] ">
            <p class="absolute -top-[10px] -left-[10px] flex shrink-0 w-[30px] h-[30px] rounded-full items-center justify-center text-center bg-[#662FFF] text-white">
              <span class="font-bold text-sm leading-[21px]">{{ props.index }}</span>
            </p>
            <div class="rounded-[20px] bg-[#D9D9D9] overflow-hidden">
              <img
                :src="`/assets/images/thumbnails/cover-${props.type}.png`"
                class="w-full h-full object-cover"
                alt="thumbnail"
              />
            </div>
          </div>
          <div class="w-full">
            <h3 class="font-bold text-xl leading-[30px] line-clamp-1">
              {{props.title}}
            </h3>
            <div class="flex items-center gap-5">
              <div class="flex items-center gap-[6px] mt-[6px]">
                <img
                  src="/assets/images/icons/note-favorite-purple.svg"
                  class="w-5 h-5"
                  alt="icon"
                />
                <p class="text-[#838C9D]">{{ props.type }}</p>
              </div>
            </div>
          </div>
          <div class="flex justify-end items-center gap-3">
            <RouterLink
              :to="`/course/update-contents/${props.courseId}/${props.id}`"
              class="w-fit rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap hover:bg-gray-50 transition-colors"
            >
              Edit Content
            </RouterLink>
            <button
              type="button"
              @click="$emit('delete-content', props.id)"
              class="w-fit rounded-full p-[14px_20px] bg-[#FF435A] font-semibold text-white text-nowrap hover:bg-red-600 transition-colors"
            >
              Delete
            </button>
          </div>
        </div>
</template>

<script setup>
import { RouterLink } from 'vue-router';

const props = defineProps({
  id: {
    type: Number,
    default: 1
  },
  index: {
    type: Number,
    default: 1
  },
  type: {
    type: String,
    default: "Video"
  },
  title: {
    type: String,
    default: "Install VSCode di Windows"
  },
  courseId: {
    type: Number,
    default: 2
  }
});

const emit = defineEmits(['delete-content']);
</script>