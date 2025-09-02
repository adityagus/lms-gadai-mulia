"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_landing-page_pages_course-detail_vue"],{

/***/ "../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=script&setup=true&lang=js":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=script&setup=true&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "../node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-router */ "../node_modules/vue-router/dist/vue-router.mjs");
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { if (r) i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n;else { var o = function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); }; o("next", 0), o("throw", 1), o("return", 2); } }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'course-detail',
  setup: function setup(__props, _ref) {
    var __expose = _ref.expose;
    __expose();
    var route = (0,vue_router__WEBPACK_IMPORTED_MODULE_1__.useRoute)();
    var router = (0,vue_router__WEBPACK_IMPORTED_MODULE_1__.useRouter)();
    var loading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(true);
    var course = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(null);
    var contents = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)([]);
    var fetchCourseDetail = /*#__PURE__*/function () {
      var _ref2 = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee() {
        var courseId, response, _data$contents, data, _t;
        return _regenerator().w(function (_context) {
          while (1) switch (_context.p = _context.n) {
            case 0:
              _context.p = 0;
              courseId = route.params.id;
              _context.n = 1;
              return fetch("/api/courses/".concat(courseId));
            case 1:
              response = _context.v;
              if (!response.ok) {
                _context.n = 3;
                break;
              }
              _context.n = 2;
              return response.json();
            case 2:
              data = _context.v;
              course.value = data.course;
              contents.value = ((_data$contents = data.contents) === null || _data$contents === void 0 ? void 0 : _data$contents.data) || [];
              _context.n = 4;
              break;
            case 3:
              course.value = null;
            case 4:
              _context.n = 6;
              break;
            case 5:
              _context.p = 5;
              _t = _context.v;
              console.error('Error fetching course:', _t);
              course.value = null;
            case 6:
              _context.p = 6;
              loading.value = false;
              return _context.f(6);
            case 7:
              return _context.a(2);
          }
        }, _callee, null, [[0, 5, 6, 7]]);
      }));
      return function fetchCourseDetail() {
        return _ref2.apply(this, arguments);
      };
    }();
    var getContentTypeLabel = function getContentTypeLabel(type) {
      var types = {
        video: 'Video Pembelajaran',
        pdf: 'Dokumen PDF',
        text: 'Materi Teks',
        quiz: 'Kuis'
      };
      return types[type] || 'Materi';
    };
    var enrollCourse = function enrollCourse() {
      // Implement enrollment logic
      alert('Fitur pendaftaran akan segera tersedia!');
    };
    var previewCourse = /*#__PURE__*/function () {
      var _ref3 = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee2() {
        var courseId, response, data, _t2;
        return _regenerator().w(function (_context2) {
          while (1) switch (_context2.p = _context2.n) {
            case 0:
              _context2.p = 0;
              courseId = route.params.id;
              _context2.n = 1;
              return fetch("/api/preview-course/".concat(courseId));
            case 1:
              response = _context2.v;
              if (!response.ok) {
                _context2.n = 3;
                break;
              }
              _context2.n = 2;
              return response.json();
            case 2:
              data = _context2.v;
              // Handle preview logic - could open modal or navigate to preview page
              console.log('Preview data:', data);
              alert('Preview kursus akan segera tersedia!');
            case 3:
              _context2.n = 5;
              break;
            case 4:
              _context2.p = 4;
              _t2 = _context2.v;
              console.error('Error previewing course:', _t2);
            case 5:
              return _context2.a(2);
          }
        }, _callee2, null, [[0, 4]]);
      }));
      return function previewCourse() {
        return _ref3.apply(this, arguments);
      };
    }();
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.onMounted)(function () {
      fetchCourseDetail();
    });
    var __returned__ = {
      route: route,
      router: router,
      loading: loading,
      course: course,
      contents: contents,
      fetchCourseDetail: fetchCourseDetail,
      getContentTypeLabel: getContentTypeLabel,
      enrollCourse: enrollCourse,
      previewCourse: previewCourse,
      ref: vue__WEBPACK_IMPORTED_MODULE_0__.ref,
      onMounted: vue__WEBPACK_IMPORTED_MODULE_0__.onMounted,
      get useRoute() {
        return vue_router__WEBPACK_IMPORTED_MODULE_1__.useRoute;
      },
      get useRouter() {
        return vue_router__WEBPACK_IMPORTED_MODULE_1__.useRouter;
      }
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=template&id=4c0fdf17&scoped=true":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=template&id=4c0fdf17&scoped=true ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "../node_modules/vue/dist/vue.esm-bundler.js");
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }

var _hoisted_1 = {
  "class": "min-h-screen bg-gray-50"
};
var _hoisted_2 = {
  key: 0,
  "class": "flex justify-center items-center h-screen"
};
var _hoisted_3 = {
  "class": "max-w-7xl mx-auto px-4 py-8"
};
var _hoisted_4 = {
  "class": "mb-6"
};
var _hoisted_5 = {
  "class": "bg-white rounded-lg shadow-lg overflow-hidden mb-8"
};
var _hoisted_6 = {
  "class": "md:flex"
};
var _hoisted_7 = {
  "class": "md:w-1/2"
};
var _hoisted_8 = ["src", "alt"];
var _hoisted_9 = {
  "class": "md:w-1/2 p-8"
};
var _hoisted_10 = {
  "class": "flex items-center mb-4"
};
var _hoisted_11 = {
  "class": "bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full"
};
var _hoisted_12 = {
  key: 0,
  "class": "ml-2 bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full"
};
var _hoisted_13 = {
  "class": "text-3xl font-bold text-gray-900 mb-4"
};
var _hoisted_14 = {
  "class": "text-lg text-indigo-600 font-medium mb-6"
};
var _hoisted_15 = {
  "class": "space-y-4 mb-8"
};
var _hoisted_16 = {
  "class": "flex items-center text-gray-600"
};
var _hoisted_17 = {
  "class": "flex items-center text-gray-600"
};
var _hoisted_18 = {
  "class": "bg-white rounded-lg shadow-lg p-8 mb-8"
};
var _hoisted_19 = {
  "class": "prose max-w-none"
};
var _hoisted_20 = {
  "class": "text-gray-700 leading-relaxed text-lg"
};
var _hoisted_21 = {
  "class": "bg-white rounded-lg shadow-lg p-8 mb-8"
};
var _hoisted_22 = {
  key: 0,
  "class": "space-y-4"
};
var _hoisted_23 = {
  "class": "flex items-center justify-between"
};
var _hoisted_24 = {
  "class": "flex items-center space-x-4"
};
var _hoisted_25 = {
  "class": "flex-shrink-0"
};
var _hoisted_26 = {
  "class": "w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-semibold"
};
var _hoisted_27 = {
  "class": "font-medium text-gray-900"
};
var _hoisted_28 = {
  "class": "text-sm text-gray-500"
};
var _hoisted_29 = {
  "class": "flex items-center space-x-2"
};
var _hoisted_30 = {
  key: 0,
  "class": "text-sm text-gray-500"
};
var _hoisted_31 = {
  key: 1,
  "class": "text-sm text-gray-500"
};
var _hoisted_32 = {
  key: 2,
  "class": "text-sm text-gray-500"
};
var _hoisted_33 = {
  key: 1,
  "class": "text-center py-8 text-gray-500"
};
var _hoisted_34 = {
  "class": "flex flex-col justify-center items-center h-screen text-center"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _$setup$course$catego, _$setup$contents;
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Loading State "), $setup.loading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_2, _cache[2] || (_cache[2] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "animate-spin rounded-full h-32 w-32 border-b-2 border-indigo-600"
  }, null, -1 /* CACHED */)]))) : $setup.course ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 1
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Course Detail Content "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Back Button "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[0] || (_cache[0] = function ($event) {
      return _ctx.$router.go(-1);
    }),
    "class": "flex items-center text-indigo-600 hover:text-indigo-800 font-medium"
  }, _cache[3] || (_cache[3] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "w-5 h-5 mr-2",
    fill: "none",
    stroke: "currentColor",
    viewBox: "0 0 24 24"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    "stroke-width": "2",
    d: "M15 19l-7-7 7-7"
  })], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Kembali ", -1 /* CACHED */)]))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Course Header "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Course Image "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $setup.course.thumbnail_url || '/assets/images/online-learning.svg',
    alt: $setup.course.name,
    "class": "w-full h-64 md:h-96 object-cover"
  }, null, 8 /* PROPS */, _hoisted_8)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Course Info "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_$setup$course$catego = $setup.course.category) === null || _$setup$course$catego === void 0 ? void 0 : _$setup$course$catego.name) || 'Kategori'), 1 /* TEXT */), $setup.course.is_popular ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_12, " ⭐ Populer ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h1", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.course.name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.course.tagline), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [_cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "w-5 h-5 mr-3",
    fill: "none",
    stroke: "currentColor",
    viewBox: "0 0 24 24"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    "stroke-width": "2",
    d: "M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"
  })], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.course.students_count || 0) + " Peserta", 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [_cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "w-5 h-5 mr-3",
    fill: "none",
    stroke: "currentColor",
    viewBox: "0 0 24 24"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    "stroke-width": "2",
    d: "M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
  })], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(((_$setup$contents = $setup.contents) === null || _$setup$contents === void 0 ? void 0 : _$setup$contents.length) || 0) + " Materi", 1 /* TEXT */)]), _cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "flex items-center text-gray-600"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "w-5 h-5 mr-3",
    fill: "none",
    stroke: "currentColor",
    viewBox: "0 0 24 24"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    "stroke-width": "2",
    d: "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Sertifikat Digital")], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" CTA Button "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "space-y-4"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: $setup.enrollCourse,
    "class": "w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition-colors"
  }, " Mulai Belajar Sekarang "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: $setup.previewCourse,
    "class": "w-full border border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-medium py-3 px-6 rounded-lg transition-colors"
  }, " Preview Kursus ")])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Course Description "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_18, [_cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", {
    "class": "text-2xl font-bold text-gray-900 mb-6"
  }, "Tentang Kursus", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.course.description), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Course Contents "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [_cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", {
    "class": "text-2xl font-bold text-gray-900 mb-6"
  }, "Materi Kursus", -1 /* CACHED */)), $setup.contents && $setup.contents.length > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_22, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.contents, function (content, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      key: content.id,
      "class": "border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition-colors"
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_26, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(index + 1), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", _hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(content.name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_28, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.getContentTypeLabel(content.type)), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_29, [content.type === 'video' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_30, _toConsumableArray(_cache[8] || (_cache[8] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
      "class": "w-4 h-4 inline mr-1",
      fill: "none",
      stroke: "currentColor",
      viewBox: "0 0 24 24"
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
      "stroke-linecap": "round",
      "stroke-linejoin": "round",
      "stroke-width": "2",
      d: "M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m6-9a2 2 0 11-4 0 2 2 0 014 0zM7 4a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2H7z"
    })], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Video ", -1 /* CACHED */)])))) : content.type === 'pdf' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_31, _toConsumableArray(_cache[9] || (_cache[9] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
      "class": "w-4 h-4 inline mr-1",
      fill: "none",
      stroke: "currentColor",
      viewBox: "0 0 24 24"
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
      "stroke-linecap": "round",
      "stroke-linejoin": "round",
      "stroke-width": "2",
      d: "M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
    })], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" PDF ", -1 /* CACHED */)])))) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_32, _toConsumableArray(_cache[10] || (_cache[10] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
      "class": "w-4 h-4 inline mr-1",
      fill: "none",
      stroke: "currentColor",
      viewBox: "0 0 24 24"
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
      "stroke-linecap": "round",
      "stroke-linejoin": "round",
      "stroke-width": "2",
      d: "M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
    })], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Teks ", -1 /* CACHED */)]))))])])]);
  }), 128 /* KEYED_FRAGMENT */))])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_33, _cache[11] || (_cache[11] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "w-16 h-16 mx-auto mb-4 text-gray-300",
    fill: "none",
    stroke: "currentColor",
    viewBox: "0 0 24 24"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    "stroke-width": "2",
    d: "M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
  })], -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", null, "Materi kursus belum tersedia", -1 /* CACHED */)])))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Course Features "), _cache[13] || (_cache[13] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"bg-white rounded-lg shadow-lg p-8\" data-v-4c0fdf17><h2 class=\"text-2xl font-bold text-gray-900 mb-6\" data-v-4c0fdf17>Apa yang Akan Anda Dapatkan</h2><div class=\"grid grid-cols-1 md:grid-cols-2 gap-6\" data-v-4c0fdf17><div class=\"flex items-start space-x-3\" data-v-4c0fdf17><svg class=\"w-6 h-6 text-green-500 mt-1\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" data-v-4c0fdf17><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" data-v-4c0fdf17></path></svg><div data-v-4c0fdf17><h3 class=\"font-medium text-gray-900\" data-v-4c0fdf17>Akses Seumur Hidup</h3><p class=\"text-gray-600\" data-v-4c0fdf17>Akses materi kursus kapan saja, dimana saja</p></div></div><div class=\"flex items-start space-x-3\" data-v-4c0fdf17><svg class=\"w-6 h-6 text-green-500 mt-1\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" data-v-4c0fdf17><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" data-v-4c0fdf17></path></svg><div data-v-4c0fdf17><h3 class=\"font-medium text-gray-900\" data-v-4c0fdf17>Sertifikat Digital</h3><p class=\"text-gray-600\" data-v-4c0fdf17>Dapatkan sertifikat setelah menyelesaikan kursus</p></div></div><div class=\"flex items-start space-x-3\" data-v-4c0fdf17><svg class=\"w-6 h-6 text-green-500 mt-1\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" data-v-4c0fdf17><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" data-v-4c0fdf17></path></svg><div data-v-4c0fdf17><h3 class=\"font-medium text-gray-900\" data-v-4c0fdf17>Materi Berkualitas</h3><p class=\"text-gray-600\" data-v-4c0fdf17>Materi disusun oleh ahli di bidangnya</p></div></div><div class=\"flex items-start space-x-3\" data-v-4c0fdf17><svg class=\"w-6 h-6 text-green-500 mt-1\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" data-v-4c0fdf17><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" data-v-4c0fdf17></path></svg><div data-v-4c0fdf17><h3 class=\"font-medium text-gray-900\" data-v-4c0fdf17>Progress Tracking</h3><p class=\"text-gray-600\" data-v-4c0fdf17>Pantau kemajuan belajar Anda secara real-time</p></div></div></div></div>", 1))])], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 2
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Error State "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, [_cache[14] || (_cache[14] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "w-16 h-16 text-gray-400 mb-4",
    fill: "none",
    stroke: "currentColor",
    viewBox: "0 0 24 24"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    "stroke-width": "2",
    d: "M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
  })], -1 /* CACHED */)), _cache[15] || (_cache[15] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", {
    "class": "text-2xl font-bold text-gray-900 mb-2"
  }, "Kursus Tidak Ditemukan", -1 /* CACHED */)), _cache[16] || (_cache[16] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": "text-gray-600 mb-6"
  }, "Maaf, kursus yang Anda cari tidak tersedia.", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return _ctx.$router.push('/');
    }),
    "class": "bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg"
  }, " Kembali ke Beranda ")])], 2112 /* STABLE_FRAGMENT, DEV_ROOT_FRAGMENT */))]);
}

/***/ }),

/***/ "../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../node_modules/vue-loader/dist/stylePostLoader.js!../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../node_modules/vue-loader/dist/stylePostLoader.js!../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../node_modules/css-loader/dist/runtime/api.js */ "../node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.prose[data-v-4c0fdf17] {\r\n  max-width: none;\n}\n.prose p[data-v-4c0fdf17] {\r\n  margin-bottom: 1rem;\r\n  line-height: 1.75;\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "../node_modules/style-loader/dist/cjs.js!../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../node_modules/vue-loader/dist/stylePostLoader.js!../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ../node_modules/style-loader/dist/cjs.js!../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../node_modules/vue-loader/dist/stylePostLoader.js!../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_course_detail_vue_vue_type_style_index_0_id_4c0fdf17_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css */ "../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../node_modules/vue-loader/dist/stylePostLoader.js!../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_course_detail_vue_vue_type_style_index_0_id_4c0fdf17_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_course_detail_vue_vue_type_style_index_0_id_4c0fdf17_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/pages/landing-page/pages/course-detail.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/pages/landing-page/pages/course-detail.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _course_detail_vue_vue_type_template_id_4c0fdf17_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./course-detail.vue?vue&type=template&id=4c0fdf17&scoped=true */ "./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=template&id=4c0fdf17&scoped=true");
/* harmony import */ var _course_detail_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./course-detail.vue?vue&type=script&setup=true&lang=js */ "./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _course_detail_vue_vue_type_style_index_0_id_4c0fdf17_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css */ "./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css");
/* harmony import */ var D_Software_laragon_www_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../node_modules/vue-loader/dist/exportHelper.js */ "../node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,D_Software_laragon_www_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_course_detail_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_course_detail_vue_vue_type_template_id_4c0fdf17_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-4c0fdf17"],['__file',"resources/js/pages/landing-page/pages/course-detail.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=script&setup=true&lang=js":
/*!****************************************************************************************************!*\
  !*** ./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=script&setup=true&lang=js ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_course_detail_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_course_detail_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./course-detail.vue?vue&type=script&setup=true&lang=js */ "../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_course_detail_vue_vue_type_style_index_0_id_4c0fdf17_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css */ "../node_modules/style-loader/dist/cjs.js!../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../node_modules/vue-loader/dist/stylePostLoader.js!../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=style&index=0&id=4c0fdf17&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=template&id=4c0fdf17&scoped=true":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=template&id=4c0fdf17&scoped=true ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_course_detail_vue_vue_type_template_id_4c0fdf17_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_course_detail_vue_vue_type_template_id_4c0fdf17_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./course-detail.vue?vue&type=template&id=4c0fdf17&scoped=true */ "../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/landing-page/pages/course-detail.vue?vue&type=template&id=4c0fdf17&scoped=true");


/***/ })

}]);