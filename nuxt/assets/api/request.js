import axios from 'axios'
import {
  Message
} from '../js/message';
const http = axios.create({
  baseURL: "http://blog.com/api/",
  // timeout: 15000,
  headers: {
    "Content-Type": "application/json",
  }
});
http.interceptors.request.use(
  config => {
    return config;
  },
  error => {
    return Promise.reject(error);
  })

http.interceptors.response.use(
  res => {
    const {
      code,
      msg,
      data
    } = res.data;
    if (!Message(parseInt(code), msg, data)) {
      return false
    }
    return res.data
  },
  error => {
    return Promise.reject(error)
  }
)
export function request(url, params = {}, method = "post") {
  return new Promise((resolve, reject) => {
    http({
      url: url,
      method: method,
      data: params,
    }).then(res => {
      resolve(res);
    }).catch(err => {
      reject(err);
    });
  });
}

export default {
  request,
}
