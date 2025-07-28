import { createRouter, createWebHistory } from "vue-router";
import Layout from "@/components/Layout";
import TestVue from "@/components/test-vue";
import Dashboard from "@/pages/Admin/Home/dashboard";
import Course from "../pages/Admin/courses/index";
import CourseDetail from "../pages/Admin/course-detail/index";
import CourseCreate from "../pages/Admin/course-create/index";
import CourseContentCreate from "@/pages/Admin/course-content-create/index";
import ContentPreview from "@/pages/Admin/course-preview/index";
import InformationDocument from "../pages/Admin/information/index";
import Pengumuman from "@/pages/Admin/pengumuman/statistikCard.vue"
import SignIn from "@/pages/SignIn";
import Main from "@/pages/landing-page/layouts/Main";
import Home from "@/pages/landing-page/pages/home";
import { getCategories, getCourseById } from "../services/courseService";
import courseStudent from "@/pages/Student/courses/index.vue";

console.log("masuk route");
const routes = [
    // {
    //     path: "/",
    //     redirect: "/sign-in",
    // },
    // handle 404 Not Found
    {
      path: "/:catchAll(.*)",
      name: "not-found",
      component: () => import("@/pages/NotFound.vue"),
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
    {
      path: '/',
      name: 'landingpage',
      component: Home
    },
    {
        path: "/sign-in",
        name: "sign-in",
        component: SignIn,
    },
    {
        path: "/admin",
        component: Layout,
        children: [
            {
                path: "",
                name: "home",
                component: Dashboard,
            },
            {
                path: "/admin/courses/create/",
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
                path: "/admin/courses/:courseId/edit",
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
                path: "/admin/courses",
                name: "courses",
                component: Course,
            },
            {
                path: "/admin/courses/:id",
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
                path: "/admin/course/create-contents/:courseId",
                name: "content-create",
                component: CourseContentCreate,
            },
            {
                path: "/admin/course/update-contents/:courseId/:contentId",
                name: "content-update",
                component: CourseContentCreate,
            },
            {
                path: "/admin/course/:id/preview",
                name: "content-preview",
                component: ContentPreview,
            },
            {
              path: "/admin/pengumuman",
              name: "pengumuman",
              component: Pengumuman
            },
            {
                path: "/admin/information-document",
                name: "information-document",
                component: InformationDocument,
            },
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
        }
    ]
  }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Middleware: Cek akses berdasarkan sessionStorage (atau localStorage)
router.beforeEach((to, from, next) => {
  // Ambil idgrup dari localStorage
  const idgrup = typeof window !== "undefined" && window.localStorage
    ? localStorage.getItem('idgrup')
    : null;
  console.log("idgrup", idgrup)
  
  // Jika user akses root dan sudah login, redirect otomatis
  if (to.path === '/sign-in' && idgrup) {
    if (idgrup === 'JBT-032') {
      return next({ path: '/admin' });
    } else {
      return next({ path: '/student/courses' });
    }
  }

  // Jika route ke /admin, hanya boleh jika idgrup JBT-032
  if (to.path.startsWith('/admin')) {
    if (idgrup === 'JBT-032') {
      next();
    } else {
      // Redirect ke student jika bukan admin
      return next({ path: '/student/courses' });
    }
  }
  // Jika route ke /student, hanya boleh jika idgrup bukan JBT-032
  else if (to.path.startsWith('/student')) {
    if (idgrup && idgrup !== 'JBT-032') {
      next();
    } else {
      // Redirect ke admin jika admin
      return next({ path: '/admin' });
    }
  } else {
    next();
  }
});

export default router;
