import {
  emotion
} from './emotion.js';

export function changeEmotion(str) {
  return str.replace(/\[[\u4E00-\u9FA5]{1,4}\]/gi, (words) => {
    let word = words.replace(/\[|\]/gi, '')
    let index = emotion.indexOf(word)
    if (index !== -1) {
      // return `<img src="http://blog.com/upload/img/emotion/${index}.png" align="middle">`
      return `<img src="https://api.lpya.cn/HtBlog/public/upload/img/emotion/${index}.png" alt="${str}" align="middle">`
    } else {
      return words
    }
  })
}
