<template>
      <div
        id="Breadcrumb"
        class="flex items-center gap-5 *:after:content-['/'] *:after:ml-5"
      >
        <span class="last-of-type:after:content-[''] last-of-type:font-semibold">
          Manage Course
        </span>
        <span class="last-of-type:after:content-[''] last-of-type:font-semibold">
          Course
        </span>
        <span class="last-of-type:after:content-[''] last-of-type:font-semibold">
          Add Content
        </span>
      </div>
      <header class="flex items-center justify-between gap-[30px]">
        <div class="flex items-center gap-[30px]">
          <div class="flex shrink-0 w-[150px] h-[100px] rounded-[20px] overflow-hidden bg-[#D9D9D9]">
            <img
              src="/assets/images/thumbnails/th-1.png"
              class="w-full h-full object-cover"
              alt="thumbnail"
            />
          </div>
          <div>
            <h1 class="font-extrabold text-[28px] leading-[42px]">
              Add Content
            </h1>
            <p class="text-[#838C9D] mt-[1]">
              Give a best content for the course
            </p>
          </div>
        </div>
      </header>
      <form
        action="manage-course-materi.html"
        class="flex flex-col w-[930px] rounded-[30px] p-[30px] gap-[30px] bg-[#F8FAFB]"
      >
        <div class="flex flex-col gap-[10px]">
          <label for="title" class="font-semibold">
            Content Title
          </label>
          <div class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
            <img
              src="/assets/images/icons/note-favorite-black.svg"
              class="w-6 h-6"
              alt="icon"
            />
            <input
              type="text"
              name="title"
              id="title"
              class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
              placeholder="Write better name for your course"
              required
            />
          </div>
        </div>
        <div class="flex flex-col gap-[10px]">
          <label for="type" class="font-semibold">
            Select Type
          </label>
          <div class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
            <img
              src="/assets/images/icons/crown-black.svg"
              class="w-6 h-6"
              alt="icon"
            />
            <select
              name="type"
              id="type"
              class="appearance-none outline-none w-full py-3 px-2 -mx-2 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
            >
              <option value="" hidden>
                Choose content type
              </option>
              <option value="">Text</option>
              <option value="">Video</option>
              <option value="">PDF</option>
            </select>
            <img
              src="/assets/images/icons/arrow-down.svg"
              class="w-6 h-6"
              alt="icon"
            />
          </div>
        </div>
        <div class="flex flex-col gap-[10px]">
          <label for="video" class="font-semibold">
            Youtube Video ID
          </label>
          <div class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
            <img
              src="/assets/images/icons/bill-black.svg"
              class="w-6 h-6"
              alt="icon"
            />
            <input
              type="text"
              name="video"
              id="video"
              class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
              placeholder="Write tagline for better copy"
            />
          </div>
        </div>
        <!-- <div class="flex flex-col gap-[10px]">
                    <label for="desc" class="font-semibold">Description</label>
                    <div class="flex w-full rounded-[20px] border border-[#CFDBEF] gap-3 p-5  transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF] ring-2 ring-[#FF435A]">
                        <img src="/assets/images/icons/note-black.png" class="w-6 h-6" alt="icon"/>
                        <textarea name="desc" id="desc" rows="5" class="appearance-none outline-none w-full font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent" placeholder="Explain what this course about"></textarea>
                    </div>
                    <span class="error-message text-[#FF435A]">The description is required</span>
                </div> -->
        <div class="flex flex-col gap-[10px]">
          <label class="font-semibold">Content Text</label>
          <!-- <ckeditor :editor="editor" v-model="data" /> -->
          <ckeditor :editor="ClassicEditor" v-model="editorData" :config="editorConfig" />
            <!-- <ckeditor
        v-if="editor"
        v-model="data"
        :editor="editor"
        :config="config"
    /> -->
          <!-- {/* <div id="editor"></div> */} -->
          <!-- <CKEditor
            editor={ClassicEditor}
            config={{
              toolbar: [
                "undo",
                "redo",
                "|",
                "heading",
                "|",
                "bold",
                "italic",
                "|",
                "link",
                "insertTable",
                "mediaEmbed",
                "|",
                "bulletedList",
                "numberedList",
                "indent",
                "outdent",
              ],
              plugins: [
                Bold,
                Essentials,
                Heading,
                Indent,
                IndentBlock,
                Italic,
                Link,
                List,
                MediaEmbed,
                Paragraph,
                Table,
                Undo,
              ],
              initialData: "<h1>Hello from CKEditor 5!</h1>",
            }}
          /> -->
        </div>
        <div class="flex items-center gap-[14px]">
          <button
            type="submit"
            class="w-full rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap"
          >
            Save as Draft
          </button>
          <button
            type="submit"
            class="w-full rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap"
          >
            Add Content Now
          </button>
        </div>
      </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const editorData = ref('<p>Isi awal editor</p>');

const editorConfig = {
  toolbar: [
    'heading', '|',
    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
    'undo', 'redo'
  ]
};
</script>

<script lang="ts">
export default {
  components: {
    ckeditor: CKEditor.component
  }
}
</script>
