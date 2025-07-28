<template>
  <div id="Breadcrumb" class="flex items-center gap-5 *:after:content-['/'] *:after:ml-5">
    <span class="last-of-type:after:content-[''] last-of-type:font-semibold">
      Manage Course
    </span>
    <span class="last-of-type:after:content-[''] last-of-type:font-semibold">
      Course
    </span>
    <span class="last-of-type:after:content-[''] last-of-type:font-semibold">
      {{ isEditMode ? 'Edit Content' : 'Add Content' }}
    </span>
  </div>
  <header class="flex items-center justify-between gap-[30px]">
    <div class="flex items-center gap-[30px]">
      <div class="flex shrink-0 w-[150px] h-[100px] rounded-[20px] overflow-hidden bg-[#D9D9D9]">
        <img src="/assets/images/thumbnails/th-1.png" class="w-full h-full object-cover" alt="thumbnail" />
      </div>
      <div>
        <h1 class="font-extrabold text-[28px] leading-[42px]">
          {{ isEditMode ? 'Edit Content' : 'Add Content' }}
        </h1>
        <p class="text-[#838C9D] mt-[1]">
          {{ isEditMode ? 'Update the content for the course' : 'Give a best content for the course' }}
        </p>
      </div>
    </div>
  </header>
  <form @submit.prevent='onSubmit' class="flex flex-col w-[930px] rounded-[30px] p-[30px] gap-[30px] bg-[#F8FAFB]">
    <div class="flex flex-col gap-[10px]">
      <label for="title" class="font-semibold">
        Content Title
      </label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
        <img src="/assets/images/icons/note-favorite-black.svg" class="w-6 h-6" alt="icon" />
        <input type="text" name="title" v-model="title" id="title"
          class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          placeholder="Write better name for your course" />
      </div>
      <span class="error-message text-[#FF435A]">
        {{ errors?.title }}
      </span>
    </div>
    <div class="flex flex-col gap-[10px]">
      <label for="type" class="font-semibold">
        Select Type
      </label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
        <img src="/assets/images/icons/crown-black.svg" class="w-6 h-6" alt="icon" />
        <select name="type" id="type" v-model='type'
          class="appearance-none outline-none w-full py-3 px-2 -mx-2 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent">
          <option value="" hidden>
            Choose content type
          </option>
          <option value="text">Text</option>
          <option value="video">Video</option>
          <option value="pdf">PDF</option>
        </select>
        <img src="/assets/images/icons/arrow-down.svg" class="w-6 h-6" alt="icon" />
      </div>
      <span class="error-message text-[#FF435A]">
        {{ errors?.type }}
      </span>
    </div>
    <div class="flex flex-col gap-[10px]" v-if='type === "video"'>
      <label for="video" class="font-semibold">
        Youtube Video ID
      </label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
        <img src="/assets/images/icons/bill-black.svg" class="w-6 h-6" alt="icon" />
        <input type="text" name="video" v-model="youtubeId" id="video"
          class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          placeholder="Write tagline for better copy" />
      </div>
    </div>
    <div class="flex flex-col gap-[10px]" v-if='type === "pdf"'>
      <label for="pdf" class="font-semibold">
        Upload PDF
      </label>
      <div
        class="flex items-center w-full rounded-full border border-[#CFDBEF] gap-3 px-5 transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF]">
        <img src="/assets/images/icons/bill-black.svg" class="w-6 h-6" alt="icon" />
        <input type='file' name="pdf" id="pdf" v-bind='pdf'
          class="appearance-none outline-none w-full py-3 font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent"
          placeholder="Write tagline for better copy" @change='onFileChange'/>
      </div>
      <span class="error-message text-[#FF435A]">
        {{ errors?.pdf }}
      </span>
    </div>
    <!-- <div class="flex flex-col gap-[10px]">
                    <label for="desc" class="font-semibold">Description</label>
                    <div class="flex w-full rounded-[20px] border border-[#CFDBEF] gap-3 p-5  transition-all duration-300 focus-within:ring-2 focus-within:ring-[#662FFF] ring-2 ring-[#FF435A]">
                        <img src="/assets/images/icons/note-black.png" class="w-6 h-6" alt="icon"/>
                        <textarea name="desc" id="desc" rows="5" class="appearance-none outline-none w-full font-semibold placeholder:font-normal placeholder:text-[#838C9D] !bg-transparent" placeholder="Explain what this course about"></textarea>
                    </div>
                    <span class="error-message text-[#FF435A]">The description is required</span>
                </div> -->
    <div class="flex flex-col gap-[10px]" v-if='type === "text"'>
      <label class="font-semibold">Content Text</label>
      <!-- <ckeditor :editor="editor" v-model="data" /> -->
      <ckeditor :editor="ClassicEditor" v-model="text" :config="editorConfig" />
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
          
          <span class="error-message text-[#FF435A]">
        {{ errors?.text }}
      </span>
    </div>
    <div class="flex items-center gap-[14px]">
      <button type="submit" class="w-full rounded-full border border-[#060A23] p-[14px_20px] font-semibold text-nowrap">
        {{ isEditMode ? 'Update as Draft' : 'Save as Draft' }}
      </button>
      <button type="submit" class="w-full rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap">
        {{ isEditMode ? 'Update Content Now' : 'Add Content Now' }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, reactive, watchEffect, onMounted } from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue';
import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import axios from 'axios';
import { useMutation } from '@tanstack/vue-query';
import { createContent, getContentsByCourseId, updateContent, getContentById } from '../../../services/contentService';
import { mutateContentSchema } from '../../../utils/zodSchema';
import { useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import { useRoute, useRouter } from 'vue-router';

const editorData = ref('<p>Isi awal editor</p>');
// const content = reactive({
//   "title": "",
//   "type": "",
//   "content": "",
//   "order": 0,
// })

const { handleSubmit, isSubmitting, values, errors, defineField } = useForm({
  validationSchema: toTypedSchema(mutateContentSchema),
  initialValues: {
    title: '',
    type: '',
    content: '',
    order: 0,
    youtubeId: '',
    pdf: null,
    text: '',
    course_id: courseId // Tambahkan course_id ke initial values
  }
});

const file = ref(null);
const pdfUrl = ref(null);
const content = ref(null);

const [title] = defineField('title');
const [type] = defineField('type');
const [pdf] = defineField('pdf');
const [text] = defineField('text');
const [youtubeId] = defineField('youtubeId');
const [quiz] = defineField('quiz');
const [route, router] = [useRoute(), useRouter()];
console.log('Route params:', route.params);
const courseId = route.params.courseId;
const contentId = route.params.contentId; // For update mode
const contentById = ref([]);
const isEditMode = ref(!!contentId);

const countContent = async () => {
  contentById.value = await getContentsByCourseId(courseId);
  return contentById.value.length + 1;
};

// Load content data for edit mode
const loadContentData = async () => {
  if (isEditMode.value) {
    try {
      const content = await getContentById(contentId);
      
      // Update form values based on content type
      title.value = content.title;
      type.value = content.type;
      
      if (content.type === 'text') {
        text.value = content.content;
      } else if (content.type === 'video') {
        youtubeId.value = content.content;
      } else if (content.type === 'pdf') {
        // For PDF, you might need to handle file differently
        // This depends on how your API returns the PDF data
      }
      
    } catch (error) {
      console.error('Error loading content:', error);
    }
  }
};

// Load content data when component mounts
onMounted(() => {
  loadContentData();
});


const mutateCreate = useMutation({
  mutationFn: async (data) => await createContent(data)
});

const mutateUpdate = useMutation({
  mutationFn: async (data) => await updateContent(data)
})


const editorConfig = {
  toolbar: [
    'heading', '|',
    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
    'undo', 'redo'
  ]
};

const onFileChange = (event) => {
  console.log("File changed:", event.target.files[0]);
  const selectedFile = event.target.files[0];
  if (selectedFile) {
    file.value = selectedFile;
    pdfUrl.value = URL.createObjectURL(selectedFile);
    content.value = selectedFile;
  }
};

// const changeType = (event) => {
//   console.log()
//   const selectedType = event.target.value;

//   if(selectedType === 'video') {
//     youtubeId = ''; // Reset video field if type is video
//   } else if (selectedType === 'pdf') {
//     pdf = ''; // Reset video field if type is pdf
//   }else if (selectedType === 'text') {
//     text = ''; // Reset text field if type is text
//   }else{
//     quiz = ''
//   }

//   // You can add additional logic here based on the selected type
// };

const onSubmit = handleSubmit(async () => {
  const formData = new FormData();
  try {
    
    formData.append('title', values.title);
    formData.append('type', values.type);
    formData.append('course_id', courseId); // Ensure course_id is included
    if (values.type === 'text') {
      formData.append('content', values.text);
    } else if (values.type === 'video') {
      formData.append('content', values.youtubeId);
    } else if (values.type === 'pdf' && file.value) {
      formData.append('content', file.value);
    } else if (values.type === 'quiz') {
      formData.append('content', values.quiz);
    }
    formData.append('order', await countContent());
    

    // Debug: Log data yang akan dikirim
    console.log('Is Edit Mode:', isEditMode.value);
    console.log('Content ID:', contentId);

    // Validasi content berdasarkan type
    if (formData.type === 'text' && !formData.content) {
      console.error('Text content is required');
      return;
    }
    
    if (formData.type === 'video' && !formData.content) {
      console.error('Video URL is required');
      return;
    }

    if (isEditMode.value) {
      // Update existing content - tidak perlu order
      formData.id = parseInt(contentId);
      console.log('Updating content with data:', formData);
      await mutateUpdate.mutateAsync(formData);
      console.log('Content updated successfully');
    } else {
      // Create new content - perlu order
      formData.order = await countContent();
      console.log('Creating content with data:', formData);
      await mutateCreate.mutateAsync(formData);
      console.log('Content created successfully');
    }

    // Redirect back to course detail
    router.push(`/admin/courses/${courseId}`);
  } catch (error) {
    console.error('Error saving content:', error);
    console.error('Error response:', error.response?.data);
    // Handle error, e.g., show an error message
  }
});

const ckeditor = CKEditor.component

// export default {
//   components: {
//     ckeditor: CKEditor.component
//   }
// }

</script>
