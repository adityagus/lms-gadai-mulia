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

const baseURL = process.env.APP_URL
console.log("baseURL new", baseURL);
export const apiInstance = axios.create({
  baseURL,
  timeout: 10000,
})

const authURL = process.env.APP_URL
export const apiInstanceAuth = axios.create({
  baseURL: authURL,
  timeout: 3000,
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
