<template>
  <div class="flex flex-col gap-5 pb-[160px]">
    <div class="header w-full flex justify-between items-center">
      <div class="title">
        <h1 class="font-bold text-[32px] leading-[48px] text-gray-700">
          {{ content.title || 'Content Title' }}
        </h1>
      </div>
      <!-- Download Attachment if available -->
      <div class="" v-if="content.lampiran || content.url">
        <a :href="`/storage/${content.lampiran || content.url}`" target="_blank"
          class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition cursor-pointer">
          Download Lampiran
        </a>
      </div>
    </div>

    <!-- Content Body -->
    <article id="Content-wrapper" class="ck-content max-w-none">
      <div v-if="content.body" v-html="content.body"></div>
      <div v-else-if="content.content" v-html="content.content"></div>
      <div v-else class="text-center py-8">
        <p class="text-gray-500">No content available</p>
      </div>
    </article>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  content: {
    type: Object,
    default: () => ({})
  }
});
</script>

<style scoped>

body{
    font-family: "Poppins";
    color: #060A23;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Hide scrollbar for Chrome, Safari, and Opera */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge, and Firefox */
.hide-scrollbar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;     /* Firefox */
}

.ck-content blockquote {
    display: block;
    margin-block-start: 1__qem;
    margin-block-end: 1em;
    margin-inline-start: 40px;
    margin-inline-end: 40px;
}

.ck-content strong, .ck-content b {
    font-weight: bold;
}

.ck-content i, .ck-content address {
    font-style: italic;
}

/* heading elements */

.ck-content h1 {
    display: block;
    font-size: 2em;
    margin-block-start: 0.67__qem;
    margin-block-end: 0.67em;
    margin-inline-start: 0;
    margin-inline-end: 0;
    font-weight: bold;
}

.ck-content h2 {
    display: block;
    font-size: 1.5em;
    margin-block-start: 0.83__qem;
    margin-block-end: 0.83em;
    margin-inline-start: 0;
    margin-inline-end: 0;
    font-weight: bold;
}

.ck-content h3 {
    display: block;
    font-size: 1.17em;
    margin-block-start: 1__qem;
    margin-block-end: 1em;
    margin-inline-start: 0;
    margin-inline-end: 0;
    font-weight: bold;
}

.ck-content h4 {
    display: block;
    margin-block-start: 1.33__qem;
    margin-block-end: 1.33em;
    margin-inline-start: 0;
    margin-inline-end: 0;
    font-weight: bold;
}

.ck-content h5 {
    display: block;
    font-size: .83em;
    margin-block-start: 1.67__qem;
    margin-block-end: 1.67em;
    margin-inline-start: 0;
    margin-inline-end: 0;
    font-weight: bold;
}

.ck-content h6 {
    display: block;
    font-size: .67em;
    margin-block-start: 2.33__qem;
    margin-block-end: 2.33em;
    margin-inline-start: 0;
    margin-inline-end: 0;
    font-weight: bold;
}

/* tables */

.ck-content table {
    display: table;
    border-collapse: separate;
    border-spacing: 2px;
    border-color: gray;
}

.ck-content .table table td{
    border: 1px solid #bfbfbf !important;
}

.ck-content thead {
    display: table-header-group;
    vertical-align: middle;
    border-color: inherit;
}

.ck-content tbody {
    display: table-row-group;
    vertical-align: middle;
    border-color: inherit;
}

.ck-content tfoot {
    display: table-footer-group;
    vertical-align: middle;
    border-color: inherit;
}

/* for tables without table section elements (can happen with XHTML or dynamically created tables) */
.ck-content table > tr {
    vertical-align: middle;
}

.ck-content col {
    display: table-column;
}

.ck-content colgroup {
    display: table-column-group;
}

.ck-content tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}

.ck-content td, .ck-content th {
    display: table-cell;
    vertical-align: inherit;
}

.ck-content th {
    font-weight: bold;
}

.ck-content caption {
    display: table-caption;
    text-align: center;
}

/* lists */

.ck-content ul, .ck-content menu, .ck-content dir {
    display: block;
    list-style-type: disc;
    margin-block-start: 1__qem;
    margin-block-end: 1em;
    margin-inline-start: 0;
    margin-inline-end: 0;
    padding-inline-start: 40px;
}

.ck-content ol {
    display: block;
    list-style-type: decimal;
    margin-block-start: 1__qem;
    margin-block-end: 1em;
    margin-inline-start: 0;
    margin-inline-end: 0;
    padding-inline-start: 40px;
}

.ck-content li {
    display: list-item;
    text-align: match-parent;
}

.ck-content ::marker {
    unicode-bidi: isolate;
    font-variant-numeric: tabular-nums;
    white-space: pre;
    text-transform: none;
}

.ck-content ul ul, .ck-content ol ul {
    list-style-type: circle;
}

.ck-content ol ol ul, .ck-content ol ul ul, .ck-content ul ol ul, .ck-content ul ul ul {
    list-style-type: square;
}

.ck-content a:any-link {
    color: blue;
    text-decoration: underline;
    cursor: auto;
}

.ck-content a:any-link:active {
    color: red;
}

.btn {
  display: inline-block;
  text-decoration: none;
}
</style>