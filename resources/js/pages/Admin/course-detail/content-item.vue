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
              to="/"
              class="w-fit rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap"
            >
              Edit Content
            </RouterLink>
            <button
              type="button"
              class="w-fit rounded-full p-[14px_20px] bg-[#FF435A] font-semibold text-white text-nowrap"
            >
              Delete
            </button>
          </div>
        </div>
</template>

<script setup lang='ts'>
import { RouterLink } from 'vue-router';

interface Props {
  id?: number
  index?: number
  type?: string
  title?: string
  courseId?: number
}

const props = withDefaults(defineProps<Props>(), {
  id: 1,
  index: 1,
  type: "Video",
  title: "Install VSCode di Windows",
  courseId: 2,
})
</script>