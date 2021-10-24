require('dotenv').config()
const express = require('express')
const path = require('path')
const bodyParser = require('body-parser')
const flash = require('connect-flash')
const session = require('express-session')
const moment = require('moment')

const shortDateFormat = 'YYYY-MM-DD HH:mm' // "ddd @ h:mmA"
const app = express()

const SESSION_SECRET = process.env.SESSION_SECRET || 'keyboard cat'
const port = process.env.PORT || 3000

const userController = require('./controllers/user')
const blogController = require('./controllers/blog')

app.set('views', './views')
app.set('view engine', 'ejs')
app.use('/public', express.static(`${__dirname}/public`))

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: true }))
app.use(flash())

app.set('trust proxy', 1) // trust first proxy
app.use(session({
  secret: SESSION_SECRET,
  resave: true, // original false
  saveUninitialized: true,
  cookie: { maxAge: 60000 }
}))

app.use((req, res, next) => {
  res.locals.username = req.session.username
  res.locals.errorMessage = req.flash('errorMessage')
  res.locals.id = req.params.id
  app.locals.moment = moment
  app.locals.shortDateFormat = shortDateFormat
  // ejs: <%= moment(article.createdAt).format(shortDateFormat) %>
  next()
})

app.get('/scripts/click.js', (req, res) => {
  res.sendFile(path.join(`${__dirname}/scripts/click.js`))
})

function checkIsLogin(req, res, next) {
  // 沒有登入，導回首頁
  if (!req.session.username) {
    res.redirect('/')
    return
  }

  // 有登入，放行
  next()
}

app.get('/', blogController.homePage)
app.get('/scripts')
app.get('/login', userController.login)
app.post('/login', userController.handleLogin)
app.get('/logout', userController.logout)
app.get('/register', userController.register)
app.post('/register', userController.handleRegister)

app.get('/add-article', checkIsLogin, blogController.pageAdd)
app.post('/add-article', checkIsLogin, blogController.add)
app.get('/article/:id', blogController.articlePage)
app.get('/delete/:id', checkIsLogin, blogController.delete)
app.get('/update-article/:id', checkIsLogin, blogController.pageUpdate)
app.post('/update-article/:id', checkIsLogin, blogController.update)
app.get('/list-articles', blogController.list)
app.get('/blog-admin', checkIsLogin, blogController.blogAdmin)

app.listen(port, () => {
  console.log(`Example app listening at http://localhost:${port}`)
})
