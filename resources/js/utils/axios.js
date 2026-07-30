import axios from "axios"
// import secureLocalStorage from "secure-ls"
// import { STORAGE_KEY } from "./const.js"

axios.defaults.withCredentials = true
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

// Ambil CSRF token dari meta tag (jika ada)
const tokenMeta = document.querySelector('meta[name="csrf-token"]')
if (tokenMeta) {
  axios.defaults.headers.common["X-CSRF-TOKEN"] = tokenMeta.getAttribute("content")
}

const currentOrigin = typeof window !== 'undefined' ? window.location.origin : (process.env.APP_URL || '');
console.log("Axios currentOrigin:", currentOrigin);

export const apiInstance = axios.create({
  baseURL: currentOrigin,
  timeout: 10000,
  withCredentials: true,
})

export const apiInstanceAuth = axios.create({
  baseURL: currentOrigin,
  timeout: 10000,
  withCredentials: true,
})


// export const apiInstanceAuth = axios.create({
//   baseURL,
//   timeout: 3000
// })

// apiInstanceAuth.interceptors.request.use((config) => {
//   const session = secureLocalStorage.getItem(STORAGE_KEY)
  
//   if(!session){
//     return config
//   }
  
//   config.headers.Authorization = `JWT ${session.token}`
  
//   return config
// })
