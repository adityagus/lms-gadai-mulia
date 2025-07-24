import axios from "axios"
import secureLocalStorage from "secure-ls"
// import { STORAGE_KEY } from "./const.js"

const baseURL = 'http://lms-gadai.test/api'
console.log('Base URL:', baseURL)
export const apiInstance = axios.create({
  baseURL,
  timeout: 5000
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
