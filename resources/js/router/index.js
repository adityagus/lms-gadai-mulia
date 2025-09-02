import AdminMigrasiData from "@/pages/admin/MigrasiData.vue";
import { createRouter, createWebHistory } from "vue-router";
import Layout from "@/components/Layout";
import TestVue from "@/components/test-vue";
import Dashboard from "@/pages/Home/dashboard";
import Course from "../pages/courses/index";
import CourseDetail from "../pages/course-detail/index";
import CourseCreate from "../pages/course-create/index";
import CourseContentCreate from "@/pages/course-content-create/index";
import ContentPreview from "@/pages/course-preview/index";
import AnnonouncementInfo from "@/pages/pengumuman/statistikCard.vue"
import ArchivePengumuman from "@/pages/pengumuman/archive.vue"
import SignIn from "@/pages/SignIn";
import Main from "@/pages/landing-page/layouts/Main";
import Home from "@/pages/landing-page/pages/home";
import DetailPage from "@/pages/landing-page/pages/detail";
import { getCategories, getCourseById } from "../services/courseService";
import { getSession } from "../services/authService";
import courseStudent from "@/pages/Student/courses/index.vue";
import DetailPengumuman from "@/pages/pengumuman/detail.vue";
import PengumumanCreate from "@/pages/pengumuman/create.vue";
import CategoryManagement from "@/pages/master/category.vue";
import { values } from "lodash";

console.log("masuk route");
const routes = [
    // {
    //     path: "/",
    //     redirect: "/sign-in",
    // },
    // handle 404 Not Found
    // {
    //   path: "/:catchAll(.*)",
    //   name: "not-found",
    //   component: () => import("@/pages/NotFound.vue"),
    // },
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
    {
        path: "/",
        name: "landingpage",
        component: Home,
    },
    {
      path: "/detail-course/:id",
      name: "detailPage",
      component: DetailPage,
    },
    {
        path: "/sign-in",
        name: "sign-in",
        component: SignIn,
    },
    {
        path: "/",
        component: Layout,
        children: [
            {
                path: "",
                name: "home",
                component: Dashboard,
            },
            {
                path: "/courses/create/",
                name: "coursesCreate",
                loader: async () => {
                    console.log("categories route");
                    const categories = await getCategories();

                    return { categories };
                },
                // beforeEnter: async (to, from, next) => {
                //     console.log("categories", categories);
                //     // Store the categories in the route meta for access in the component
                //     to.params.categories = categories;
                //     next();
                // },
                component: CourseCreate,
            },
            {
                path: "/courses/:courseId/edit",
                name: "coursesEdit",
                beforeEnter: async (to, from, next) => {
                    const categories = await getCategories();
                    console.log("categories", categories);
                    // Store the categories in the route meta for access in the component
                    to.params.categories = categories;
                    next();
                },
                component: CourseCreate,
            },
            {
                path: "/courses",
                name: "courses",
                component: Course,
            },
            {
                path: "/courses/:id",
                name: "courseDetail",
                beforeEnter: async (to, from, next) => {
                    const course = await getCourseById(to.params.id);
                    // Store the categories in the route meta for access in the component
                    to.params.course = course;
                    next();
                },
                component: CourseDetail,
            },
            {
                path: "/course/create-contents/:courseId",
                name: "content-create",
                component: CourseContentCreate,
            },
            {
                path: "/course/update-contents/:courseId/:contentId",
                name: "content-update",
                component: CourseContentCreate,
            },
            {
                path: "/course/:id/preview",
                name: "content-admin-preview",
                component: ContentPreview,
            },
            {
                path: "/pengumuman",
                name: "pengumuman",
                meta: { values: 1 },
                component: AnnonouncementInfo,
            },
            {
                path: "/formulir",
                name: "formulir",
                meta: { values: 2 },
                component: AnnonouncementInfo,
            },
            {
                path: "/report",
                name: "report",
                meta: { values: 3 },
                component: AnnonouncementInfo,
            },
            {
                path: "/information-document/create",
                name: "information-document-create",
                component: PengumumanCreate,
            },
            {
                path: "/information-document/update/:id",
                name: "information-document-update",
                component: PengumumanCreate,
            },
            {
                path: "/detail-pengumuman/:id",
                name: "detail-pengumuman",
                component: DetailPengumuman,
            },
            {
                path: "/archive-pengumuman",
                name: "archive-pengumuman",
                component: ArchivePengumuman,
            },
            {
                path: "/admin/migrasi-data",
                name: "admin-migrasi-data",
                component: AdminMigrasiData,
            },
        ],
    },
    {
        path: "/master",
        component: Layout,
        children: [
          {
            path: "/master/categories",
            name: "categories",
            component: CategoryManagement,
          }
        ],
    },
    {
        path: "/student",
        component: Layout,
        children: [
            {
                path: "/student/courses",
                name: "studentCourses",
                component: courseStudent,
            },
            {
              path: "/student/courses/:id",
              name: "content-preview",
              component: ContentPreview,
            }
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return { el: to.hash, behavior: 'smooth' };
        }
        return { top: 0};
    }
});


async function getSessionAuth() {
  try {
    const res = await getSession();
    return res.auth; // sesuai response backend
  } catch (e) {
    return null;
  }
}

// Middleware: Cek akses berdasarkan sessionStorage (atau localStorage)
router.beforeEach(async(to, from, next) => {
  const auth = await getSessionAuth();
  // membuat variable global auth
  if (typeof window !== "undefined" && auth) {
    window.auth = auth;
  }else{
    window.auth = null;
  }
  if(to.path !== '/sign-in' && to.path !== '/' && to.name !== "detailPage" && !auth) {
    return next({ path: '/sign-in' });
  }
  
  // Ambil idgrup dari localStorage
  const idgrup = typeof window !== "undefined" && auth
    ? auth.idgrup
    : null;
  
  // Jika user akses root dan sudah login, redirect otomatis
  if (to.path === '/sign-in' && idgrup) {
    if (idgrup === 'JBT-032' || idgrup === 'JBT-038') {
      return next({ path: '/courses' });
    } else {
      return next({ path: '/student/courses' });
    }
  }

  // Jika route ke /courses, hanya boleh jika idgrup JBT-032
  if (to.path.startsWith('/courses')) {
    if (idgrup === 'JBT-032' || idgrup === 'JBT-038') {
      next();
    } else {
      // Redirect ke student jika bukan admin
      return next({ path: '/student/courses' });
    }
  }
  // Jika route ke /student, hanya boleh jika idgrup bukan JBT-032
  else if (to.path.startsWith('/student')) {
    if (idgrup && idgrup !== 'JBT-032' && idgrup !== 'JBT-038') {
      next();
    } else {
      // Redirect ke admin jika admin
      return next({ path: '/courses' });
    }
  } else {
    next();
  }
});

export default router;
