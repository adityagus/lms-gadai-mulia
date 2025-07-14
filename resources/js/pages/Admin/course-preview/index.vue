<script setup lang="ts">
import Header from '@/components/Header.vue';
import ContentVideo from './ContentVideo.vue';
import ContentText from './ContentText.vue';

</script>

<template>
      <div class="flex min-h-screen">
        <aside class="sidebar-container fixed h-[calc(100vh-20px)] w-full max-w-[330px] my-[10px] ml-[10px] bg-[#060A23] overflow-hidden flex flex-1 rounded-[20px]">
            <div class="scroll-container flex w-full overflow-y-scroll hide-scrollbar">
                <nav class="flex flex-col w-full h-fit p-[30px] gap-[30px] z-10">
                    <a href="manage-course.html" class="font-semibold text-white hover:underline">
                        <span>Back to Dashboard</span>
                    </a>
                    <div class="flex flex-col gap-4">
                        <div class="flex shrink-0 w-[130px] h-[100px] rounded-[14px] bg-[#D9D9D9] overflow-hidden">
                            <img src="/assets/images/thumbnails/th-1.png" class="w-full h-full object-cover" alt="thumbnail"/>
                        </div>
                        <h2 class="font-bold text-xl leading-[34px] text-white">Mastering React 18 Pro TypeScript Development</h2>
                    </div>
                    <ul class="flex flex-col gap-4">
                        <li>
                            <a href="course-learning-text.html" >
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/note-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Persiapan fundamental</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="course-learning-video.html">
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/video-play-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Install figma plugins</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="course-learning-text.html" >
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#662FFF] border-[#8661EE] shadow-[-10px_-6px_10px_0_#7F33FF_inset]">
                                    <img src="/assets/images/icons/note-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Pengenalan UI UX</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="course-learning-text.html" >
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/note-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Mengapa UI mobil le...</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="course-learning-video.html">
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/video-play-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Bikin UI components</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="course-learning-video.html">
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/video-play-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Bikin UI components</span>
                                </div>
                            </a>
                        </li><li>
                            <a href="course-learning-text.html" >
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/note-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Persiapan fundamental</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="course-learning-video.html">
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/video-play-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Install figma plugins</span>
                                </div>
                            </a>
                        </li><li>
                            <a href="course-learning-text.html" >
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/note-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Persiapan fundamental</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="course-learning-video.html">
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/video-play-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Install figma plugins</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="course-learning-finished.html">
                                <div class="flex items-center gap-3 w-full rounded-full border p-[14px_20px] transition-all duration-300 hover:bg-[#662FFF] hover:border-[#8661EE] hover:shadow-[-10px_-6px_10px_0_#7F33FF_inset] bg-[#070B24] border-[#24283E] shadow-[-10px_-6px_10px_0_#181A35_inset]">
                                    <img src="/assets/images/icons/tick-circle-white.svg" class="w-6 h-6" alt="icon"/>
                                    <span class="w-full font-semibold text-white line-clamp-1 transition-all duration-300 hover:line-clamp-none">Finished</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <img src="/assets/images/backgrounds/sidebar-glow.png" class="absolute object-contain object-bottom bottom-0" alt="background"/>
        </aside>
        <main class="flex flex-col flex-1 gap-[30px] p-[30px] ml-[340px]">
            <Header/>
            <div class="relative flex flex-col gap-[26px]">
                <ContentText/> 
                <!-- <ContentVideo/> -->
                <div class="fixed bottom-0 w-[calc(100%-400px)] h-[151px] flex items-end justify-end pb-5 bg-[linear-gradient(0deg,#FFFFFF_49.67%,rgba(255,255,255,0)_84.11%)]">
                    <button type="button" class="w-fit rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap">
                        Mark as Completed
                    </button>
                </div>
            </div>
        </main>
    </div>
</template>