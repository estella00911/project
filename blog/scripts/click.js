const urlBase = 'https://gentle-depths-67267.herokuapp.com'
const articlePost = document.querySelectorAll('.article__post')
for (let i = 0; i < articlePost.length; i++) {
  articlePost[i].addEventListener('click', (e) => {
    location.href = `${urlBase}/article/${e.currentTarget.id}`
    console.log(`${urlBase}/article/${e.currentTarget.id}`)
  })
}
