import {createRouter, createWebHistory } from 'vue-router'
import Layout from '@/components/Layout.vue'
import TestVue from '@/components/test-vue.vue';
import Dashboard from '@/pages/Admin/Home/dashboard.vue';
import Course from '../pages/Admin/courses/index.vue';
import CourseDetail from '../pages/Admin/course-detail/index.vue';
import CourseCreate from '../pages/Admin/course-create/index.vue';
import CourseContentCreate from '@/pages/Admin/course-content-create/index.vue';
import ContentPreview from '@/pages/Admin/course-preview/index.vue';
import InformationDocument from '../pages/Admin/information/index.vue';
import SignIn from '@/pages/SignIn.vue';
import Main from 'pages/landing-page/layouts/Main.vue';
import Home from 'pages/landing-page/pages/home.vue';

console.log('masuk route');
const routes = [
  {
    path: '/',
    redirect: '/admin'
  },
  // {
  //   path: '/',
  //   component: Main,
  //   children: [
  //     {
  //       path: '',
  //       name: 'landingpage',
  //       component: Home 
  //     }
  //   ]
  // },
  // {
  //   path: '/',
  //   name: 'landingpage',
  //   component: Main 
  // },
  {
    path: '/sign-in',
    name: 'sign-in',
    component: SignIn,
  },
  {
    path: '/admin',
    component: Layout,
    children: [
      { 
        path: '',
        name: 'home',
        component: Dashboard 
      },
      {
        path: "/admin/courses/create",
        name: 'coursesCreate',
        component: CourseCreate
      },
      {
        path: "/admin/courses",
        name: 'courses',
        component: Course
      },
      {
        path: "/admin/courses/:id",
        name: "courseDetail",
        component: CourseDetail
      },
      {
        path: "/admin/course/create-contents",
        name: "content-create",
        component:CourseContentCreate
      },
      {
        path: "/admin/course/:id/preview/:idCourse",
        name: "content-preview",
        component: ContentPreview
      },
      {
        path: "/admin/information-document",
        name: 'information-document',
        component: InformationDocument
      },
      
      
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router