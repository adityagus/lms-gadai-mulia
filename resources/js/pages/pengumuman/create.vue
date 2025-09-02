<template>
  <div class="" v-if='isLoading'></div>
  <div class="w-full bg-white rounded-xl shadow-lg p-8 mt-8" v-else>
    <h1 class="text-2xl font-bold mb-6 text-sidebar">{{ isEditMode ? 'Edit' : 'Create' }} {{ name }}</h1>
    <div class="flex items-center mb-6 justify-center">
      <div v-for="(stepLabel, idx) in stepLabels" :key="idx" class="flex items-center">
        <div
          :class="['w-8 h-8 flex items-center justify-center rounded-full font-bold', step === idx + 1 ? 'bg-sidebar text-white' : 'bg-gray-200 text-sidebar']">
          {{ idx + 1 }}</div>
        <span class="ml-2 mr-4 font-semibold" :class="step === idx + 1 ? 'text-sidebar' : 'text-gray-400'">{{ stepLabel }}</span>
        <span v-if="idx < stepLabels.length - 1" class="w-8 h-1 bg-gray-200 rounded mx-2"></span>
      </div>
    </div>
    <form @submit.prevent="onSubmit" novalidate>
      <div v-show="step === 1">
        <div class="mb-4">
          <label class="block text-sm font-semibold mb-1" for="title">Judul <span class="text-red-500">*</span></label>
          <input v-model="title" id="title" type="text" class="w-full border rounded px-3 py-2 focus:outline-sidebar"
            :class="{ 'border-red-500': errors.title }" :placeholder="`Masukkan judul ${name.toLowerCase()}`" required />
          <span v-if="errors.title" class="text-xs text-red-500 mt-1">{{ errors.title }}</span>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-semibold mb-1" for="no_surat">Nomor Surat <span class="text-red-500">*</span></label>
          <input v-model="no_surat" id="no_surat" type="text" class="w-full border rounded px-3 py-2 focus:outline-sidebar"
            :class="{ 'border-red-500': errors.no_surat }" placeholder="Masukkan nomor surat" required />
          <span v-if="errors.no_surat" class="text-xs text-red-500 mt-1">{{ errors.no_surat }}</span>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-semibold mb-1" for="tgl_berlaku">Tanggal Berlaku <span class="text-red-500">*</span></label>
          <input v-model="tgl_berlaku" id="tgl_berlaku" type="date" class="w-full border rounded px-3 py-2 focus:outline-sidebar"
            :class="{ 'border-red-500': errors.tgl_berlaku }" required />
          <span v-if="errors.tgl_berlaku" class="text-xs text-red-500 mt-1">{{ errors.tgl_berlaku }}</span>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-semibold mb-1" for="type">Tipe {{ name }} <span class="text-red-500">*</span></label>
          <select v-model="submenu_id" id='submenu_id' class="w-full border rounded px-3 py-2 focus:outline-sidebar"
            :class="{ 'border-red-500': errors.submenu_id }" @change='handleTypeChange(submenu_id)' required>
            <option disabled value="">Pilih Tipe {{ name }}</option>
            <option v-for="typeDoc in typeDocuments" :key="typeDoc.id" :value="typeDoc.id">{{ typeDoc.name }}</option>
          </select>
          <span v-if="errors.type" class="text-xs text-red-500 mt-1">{{ errors.type }}</span>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-semibold mb-1" for="type">Tipe File <span class="text-red-500">*</span></label>
          <select v-model="type" id='type' class="w-full border rounded px-3 py-2 focus:outline-sidebar"
            :class="{ 'border-red-500': errors.type }" @change='handleTypeChange(submenu_id)' required>
            <option disabled value="">Pilih Tipe File</option>
            <option value='text'>Text</option>
            <option value='pdf'>PDF</option>
          </select>
          <span v-if="errors.type" class="text-xs text-red-500 mt-1">{{ errors.type }}</span>
        </div>
          <div class="flex flex-col gap-[10px]" v-if='type === "text"'>
      <label class="font-semibold">Content</label>
      <!-- <ckeditor :editor="editor" v-model="data" /> -->
      <ckeditor :editor="ClassicEditor" v-model="content" :config="editorConfig" @change="() =>{
        const data = editor.getData();
        console.log('data adalah', data);
        // Update the content field with the editor content
        content.value = data;
        console.log('Editor content changed:', content);
      }" />
      <!-- <ckeditor
        v-if="editor"
        v-model="data"
        :editor="editor"
        :config="config"
    /> -->
      <!-- {/* <div id="editor"></div> */} -->
      <!-- <CKEditor
            editor={ClassicEditor}
            config={}
          /> -->
          
          <span class="error-message text-[#FF435A]">
        {{ errors?.text }}
      </span>
    </div>
        <div>
          <!-- Tampilkan file lama jika mode edit dan file lama ada -->
          <div v-if="isEditMode && urlThumbnail" class="mb-2">
            <a :href="`/storage/${urlThumbnail}`" target="_blank" class="text-blue-500 underline">Lihat File Lama</a>
          </div>

          <!-- Input file baru -->
          <div class="mb-4">
            <label class="block text-sm font-semibold mb-1" for="file">
              Upload File PDF <span class="text-red-500">*</span>
            </label>
            <input id="file" type="file" accept="application/pdf" @change="onFileChange"
              class="w-full border rounded px-3 py-2 focus:outline-sidebar" :class="{ 'border-red-500': errors.file }"
              :required="!isEditMode" />
            <small class="block text-gray-500" v-if='isEditMode'>
              Boleh dikosongkan jika tidak ingin mengganti file
            </small>
            <span v-if="errors.file" class="text-xs text-red-500 mt-1 block">
              {{ errors.file }}
            </span>
            <span v-if="fileName" class="text-xs text-gray-500 mt-1 block">
              File: {{ fileName }}
            </span>
          </div>
        </div>
      </div>
      <div v-show="step === 2">
        <div class="flex flex-col gap-2">
          <AreaCheckbox v-for="area in areas" :key="area.id_area" :area="area" v-model:checked="regionals_id" />
        </div>
      </div>
      <div v-show="step === 3">
        <div class="mb-4">
          <label class="block text-sm font-semibold mb-1">Akses Jabatan</label>
          <div class="flex flex-col gap-2">
            <label v-for="jab in daftarJabatan" :key="jab.id" class="flex items-center gap-2">
              <input type="checkbox" :value="jab.id" v-model="kd_jabatan" /> {{ jab.nama }}
            </label>
          </div>
        </div>
      </div>
      <div class="flex gap-2 mt-6">
        <button v-if="step > 1" type="button" @click="prevStep"
          class="flex-1 py-2 rounded bg-gray-200 text-sidebar font-semibold hover:bg-gray-300 transition">Sebelumnya</button>
        <button v-if="step < 3" type="button" @click="nextStep"
          class="flex-1 py-2 rounded bg-sidebar text-white font-semibold hover:bg-purple-700 transition">Selanjutnya</button>
        <button v-if="step === 3" type="submit" :disabled="isSubmitting"
          class="flex-1 py-2 rounded bg-sidebar text-white font-semibold hover:bg-purple-700 transition">Simpan</button>
      </div>
      <div v-if="success" class="mt-4 text-green-600 text-sm font-semibold">{{ name }} berhasil disimpan!</div>
      <div v-if="submitError" class="mt-4 text-red-600 text-sm font-semibold">{{ submitError }}</div>
    </form>
  </div>
</template>

<script setup>
import CKEditor from '@ckeditor/ckeditor5-vue';
import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import { AnnouncementInfoSchema } from '@/utils/zodSchema'
import { createAnnouncement, updateAnnouncement, wizardSession, wizardStep, finishWizard, getDocumentById } from '@/services/announcementService'
import { getWilayah, getTypesByIdMenu, getJabatan, getCabang } from '@/services/masterService';
import AreaCheckbox from '@/components/AreaCheckbox.vue'
import axios from 'axios'
import { result } from 'lodash'
import Swal from 'sweetalert2'


const [route, router] = [useRoute(), useRouter()];
console.log("route", route);
const name = ref('');
const announcementId = route.params.id; // For update mode
console.log("announcementId:", announcementId);
const isEditMode = ref(!!announcementId);
console.log("isEditMode:", isEditMode);

const createType = ref(null); // default 1 kalau gak ada
console.log("Category create from route:", createType);

watch(createType, (newVal) => {
  console.log('newval', newVal);
  if (newVal == 1) {
    name.value = 'Pengumuman';
  } else if (newVal == 2) {
    name.value = 'Formulir';
  } else if (newVal == 3) {
    name.value = 'Report';
  } else {
    name.value = '';
  }
});


const step = ref(1)
const stepLabels = [name, 'Wilayah', 'Jabatan']
const daftarJabatan = ref([]);
const urlThumbnail = ref('');
const ckeditor = CKEditor.component
const editorConfig = {
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
  initialData: content == null ? "" : content,
};

const nextStep = async function () {
  // Simpan data step ke session
  let payload = {};
  if (step.value === 1) {
    payload = { ...values };
  } else if (step.value === 3) {
    payload = { regionals_id: regionals_id.value };
  } else if (step.value === 2) {
    payload = { kd_jabatan: kd_jabatan.value };
  }
  await wizardStep(step.value, payload);
  if (step.value < 3) step.value++;
}

const loadContentData = async () => {
  const data = await getDocumentById(announcementId);
  const result = data.data
  console.log('Loaded document data:', result);

  title.value = result.title;
  no_surat.value = result.no_surat;
  tgl_berlaku.value = result.tgl_berlaku;
  submenu_id.value = result.submenu_id;
  kd_jabatan.value = (result.akses_jabatan || [])
    .map(item => item.kd_jbt) || [];
  regionals_id.value = (result.document_regional || [])
    .map(item => item.regional_id) || [];
  urlThumbnail.value = result.url;
  content.value = result.content;
  type.value = result.type;

  console.log("regionals_id", regionals_id.value, kd_jabatan.value);

  // Set createType and name label based on loaded document's menu
  createType.value = result.menu.id_menu;
  if (createType.value === 1) {
    name.value = 'Pengumuman';
  } else if (createType.value === 2) {
    name.value = 'Formulir';
  } else if (createType.value === 3) {
    name.value = 'Report';
  } else {
    name.value = '';
  }

  console.log('kd_jabatan after loading document data:', kd_jabatan.value);

  if (step.value === 1) {
    // Load data for step 1
  } else if (step.value === 2) {
    // Load data for step 2
  } else if (step.value === 3) {
    // Load data for step 3
  }
}

function prevStep() {
  if (step.value > 1) step.value--
}
console.log("Category create from route:", createType);
const success = ref(false)
const submitError = ref('')
const file = ref(null)
const fileName = ref('')
const typeDocuments = ref('')
const areas = ref([
  { id_area: 'ho', nm_area: 'HO', children: [] },
  {
    id_area: 'jaya', nm_area: 'Jaya', children: [
      { id_area: 'kl', nm_area: 'KL', children: [] },
      { id_area: 'ku', nm_area: 'Ku', children: [] }
    ]
  },
  {
    id_area: 'jabar', nm_area: 'Jabar', children: [
      { id_area: 'hi', nm_area: 'HI', children: [] },
      { id_area: 'bogor', nm_area: 'Bogor', children: [] }
    ]
  },
  {
    id_area: 'kepri', nm_area: 'Kepri', children: [
      { id_area: 'batam', nm_area: 'Batam Center', children: [] },
      { id_area: 'batuaji', nm_area: 'Batu Aji', children: [] }
    ]
  }
]);

const submenu = ref('')

const { handleSubmit, isSubmitting, values, errors, defineField } = useForm({
  validationSchema: toTypedSchema(AnnouncementInfoSchema),
  initialValues: {
    submenu_id: '',
    title: '',
    no_surat: '',
    dokumen: null,
    type: '',
    content: '',
    tgl_berlaku: '',
    regionals_id: [],
    kd_jabatan: []
  }
});

// const fieldNames = [
//   'title',
//   'no_surat',
//   'tgl_berlaku',
//   'submenu',
//   'submenu_id',
//   'regionals_id',
//   'dokumen'
// ];
// const fields = {}
// fieldNames.forEach(key => {
//   const [value, attrs] = defineField(key)
//   fields[key] = { value, attrs }
// })

const [title] = defineField('title');
const [no_surat] = defineField('no_surat');
const [type] = defineField('type');
const [content] = defineField('content');
const [tgl_berlaku] = defineField('tgl_berlaku');
const [submenu_id] = defineField('submenu_id');
const [regionals_id] = defineField('regionals_id');
const [kd_jabatan] = defineField('kd_jabatan');
const [dokumen] = defineField('dokumen');

const isLoading = ref(true);
onMounted(async () => {
  const lastStep = ref(1);
  // jika udah ke load baru dipanggil
  try {
    const [resTypes, resAreas, restJabatan, wizardRes] = await Promise.all([
      getTypesByIdMenu(createType),
      getCabang(),
      getJabatan(),
      wizardSession()
    ]);

    
    daftarJabatan.value = restJabatan.map(j => ({ id: j.kd_jabatan, nama: j.nm_jabatan }));
    typeDocuments.value = resTypes;



  // cara ngambil ke database, gimana
  areas.value = resAreas.map(area => ({
    id_area: area.id_area,
    nm_area: area.nm_area,
    children: area.children ? area.children.map(child => ({
      id_area: child.id_area,
        nm_area: child.nm_area,
        children: []
      })) : []
    }));

    if (isEditMode.value) {
      await loadContentData();
      // karena createType berubah, reload types sesuai menu.id
      areas.value = await getCabang();
      typeDocuments.value = await getTypesByIdMenu(createType.value);
    }else{
      createType.value = route.query.type || 1; // default 1 kalau gak ada
      typeDocuments.value = await getTypesByIdMenu(createType.value);
    }

    const wizard = wizardRes.wizard || {};
    if (wizard[1]) { Object.assign(values, wizard[1]); lastStep.value = 1; }
    // Ambil regionals_id dari session wizard jika ada
    if (wizard[2]) {
      // Jika regionals_id sudah ada di session, pakai itu
      if (wizard[2].regionals_id && wizard[2].regionals_id.length > 0) {
        regionals_id.value = wizard[2].regionals_id;
      }
      lastStep.value = 2;
    }
    if (wizard[3]) { kd_jabatan.value = wizard[3].kd_jabatan || []; lastStep.value = 3; }
    step.value = lastStep.value;

    isLoading.value = false;
  } catch (error) {
    console.error(error);
  }
});



function handleTypeChange(submenuId) {
  submenu.value = typeDocuments.value.find(type => type.id === submenuId).name;
}


const onSubmit = async () => {
  success.value = false
  console.log('Submitting form:', values);
  submitError.value = ''

  // if (!validate()) return
  try {

    // Kirim data jabatan (step 3) ke session dulu
    await wizardStep(2, { kd_jabatan: kd_jabatan.value });
    // Baru trigger simpan wizard ke database


    const formData = new FormData()
    for (const key in values) {
      console.log('key', key, values[key]);
      if(key == 'dokumen' && !file.value) continue; // skip dokumen, ditangani terpisah
      
      if (Array.isArray(values[key])) {
        values[key].forEach(val => formData.append(key + '[]', val))
      } else {
        formData.append(key, values[key])
      }
    }

    console.log('isEditMode:', isEditMode.value);
    if (isEditMode.value) {
      await updateAnnouncement(formData, announcementId)
      Swal.fire({
            title: "Updated!",
            text: "Content has been updated.",
            icon: "success",
            timer: 1500
          });
    } else {
      await createAnnouncement(formData)
      Swal.fire({
            title: "Created!",
            text: "Content has been created.",
            icon: "success",
            timer: 1500
          });
    }

    await finishWizard();
    success.value = true
    router.push(`/detail-pengumuman/${values.submenu_id}`) // arahkan ke detail pengumuman sesuai tipe
  } catch (error) {
    console.log('error', error);
    submitError.value = 'Gagal menyimpan data!'
  }
}

function onFileChange(e) {
  const f = e.target.files[0]
  if (f) {
    file.value = f
    console.log('Selected file:', file.value);
    dokumen.value = file.value
    fileName.value = f.name
  } else {
    dokumen.value = null
    fileName.value = ''
  }
}
</script>

<style scoped>
.bg-sidebar {
  background: #7F33FF;
}
</style>
