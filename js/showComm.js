const commentPost = btn => {
  
let main_post_el = btn.closest('.single-post')
let comments = main_post_el.querySelector('.single-post .hide-form')
let postComm = main_post_el.querySelector('.post-comments')
 
if(comments.style.display === 'block') {
   comments.style.display = 'none'
   postComm.style.display = 'none'
  }
else {
   comments.style.display = 'block'
   postComm.style.display = 'block'
  }
}

let popup = document.querySelector('.popup')

const chProfil = btn => {
    popup.style.display = 'block'
}
const x = btn => {
    popup.style.display = 'none'
}
