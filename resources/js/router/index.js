import { createRouter, createWebHistory } from "vue-router";
import Layout from "@/components/Layout";
import TestVue from "@/components/test-vue";
import Dashboard from "@/pages/Home/dashboard";
import Course from "../pages/courses/index";
import CourseDetail from "../pages/course-detail/index";
import CourseCreate from "../pages/course-create/index";
import CourseContentCreate from "@/pages/course-content-create/index";
import ContentPreview from "@/pages/course-preview/index";
import AnnonouncementInfo from "@/pages/pengumuman/statistikCard.vue";
import PengumumanPage from "@/pages/pengumuman/index.vue";
import FormulirPage from "@/pages/formulir/index.vue";
import ArchivePengumuman from "@/pages/pengumuman/archive.vue";
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
import AuditLog from "@/pages/admin/AuditLog.vue";
import DocumentReport from "@/pages/report/DocumentReport.vue";
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
                path: "/overview",
                name: "overview",
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
                path: "/lms",
                name: "lms",
                component: Course,
            },
            {
                path: "/kelas/:id",
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
                component: PengumumanPage,
            },
            {
                path: "/formulir",
                name: "formulir",
                meta: { values: 2 },
                component: FormulirPage,
            },
            {
                path: "/report",
                name: "report",
                meta: { values: 3 },
                component: AnnonouncementInfo,
            },
            {
                path: "/report/documents",
                name: "report-documents",
                component: DocumentReport,
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
            // {
            //     path: "/admin/migrasi-data",
            //     name: "admin-migrasi-data",
            //     component: AdminMigrasiData,
            // },
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
            },
            {
                path: "/master/audit-logs",
                name: "audit-logs",
                component: AuditLog,
            },
        ],
    },
    {
        path: "/report",
        component: Layout,
        children: [
            {
                path: "",
                name: "report",
                component: DocumentReport,
            },
            {
                path: "documents",
                name: "report-documents",
                component: DocumentReport,
            },
        ],
    },
    {
        path: "/student",
        component: Layout,
        children: [
            {
                path: "/student/lms",
                name: "studentCourses",
                component: courseStudent,
            },
            {
                path: "/student/kelas/:id",
                name: "content-preview",
                beforeEnter: async (to, from, next) => {
                    const course = await getCourseById(to.params.id);
                    // Store the categories in the route meta for access in the component
                    to.params.course = course;
                    next();
                },
                component: ContentPreview,
            },
        ],
    },
];

const getBaseUrl = () => {
    const baseEl = document.querySelector("base");
    if (baseEl && baseEl.getAttribute("href")) {
        const href = baseEl.getAttribute("href");
        try {
            if (href.startsWith("http://") || href.startsWith("https://")) {
                return new URL(href).pathname;
            }
            return href;
        } catch (e) {
            return href;
        }
    }
    return process.env.MIX_BASE_URL || "/";
};

const router = createRouter({
    history: createWebHistory(getBaseUrl()),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return { el: to.hash, behavior: "smooth" };
        }
        return { top: 0 };
    },
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
router.beforeEach(async (to, from, next) => {
    let auth = null;
    try {
        const resauth = await getSession();
        auth = resauth ? resauth.auth : null;
    } catch (e) {
        console.error("Session verification failed, treating as guest:", e);
    }

    // Jika tidak login dan bukan halaman public, redirect ke login
    const isPublic =
        ["/sign-in", "/", "/detail-course/" + to.params.id].includes(to.path) ||
        to.name === "detailPage" ||
        to.name === "sign-in" ||
        to.name === "landingpage";

    if (!auth && !isPublic) {
        return next({ name: "sign-in" });
    }

    // Jika sudah login dan akses /sign-in, redirect sesuai grup
    if ((to.name === "sign-in" || to.path === "/sign-in") && auth && auth.idgrup) {
        if (auth.idgrup === "JBT-032" || auth.idgrup === "JBT-038") {
            return next({ name: "lms" });
        } else {
            return next({ name: "studentCourses" });
        }
    }

    // Jika akses /courses, hanya admin
    if (to.path.startsWith("/lms") || to.name === "lms") {
        if (auth && (auth.idgrup === "JBT-032" || auth.idgrup === "JBT-038")) {
            return next();
        } else {
            return next({ name: "studentCourses" });
        }
    }

    // Default: lanjutkan
    return next();
});

export default router;
