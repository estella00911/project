const db = require('../models')

const { Article } = db
const { User } = db

const blogController = {
  homePage: async(req, res) => {
    const article = await Article.findAll({
      where: {
        is_deleted: null
      },
      order: [['id', 'DESC']],
      include: User
      // offset: 5,
      // limit: 5
    })
    // console.log(JSON.stringify(article,null,4))
    res.render('index', {
      article
    })
  },
  pageAdd: (req, res) => {
    res.render('add_article')
  },
  add: async(req, res) => {
    const { title, category, content, imageUrl } = req.body
    const { UserId, username } = req.session

    if (!title || !category || !content || !imageUrl) {
      req.flash('errorMessage', 'Please input missing fields')
      return res.redirect('back')
    }

    try {
      await User.findOne({
        where: {
          username
        }
      })
    } catch (err) {
      console.log('not found!') // 沒有登入，也就是 !user 會跳出的錯誤訊息
      req.flash('errorMessage', 'Please login before add a new post') // req.session.username 與資料庫 User 不符
      res.redirect('back')
      return
    }

    try {
      await Article.create({
        title,
        category,
        content,
        UserId,
        imageUrl
      }, {
        include: [
          { model: User }
        ]
      })
      res.redirect('/')
    } catch (err) {
      req.flash('errorMessage', err.toString())
    }
  },
  articlePage: async(req, res) => {
    const article = await Article.findOne({
      where: {
        id: req.params.id,
        is_deleted: null
      }
    })

    res.render('article_page', {
      article
    })
  },
  delete: async(req, res) => {
    const { UserId } = req.session
    try {
      const article = await Article.findOne({
        where: {
          id: req.params.id,
          UserId
        }
      })
      await article.update({
        is_deleted: 1
      })
      res.redirect('/')
    } catch (err) {
      res.redirect('back')
    }
  },
  pageUpdate: async(req, res) => {
    try {
      const article = await Article.findOne({
        where: {
          id: req.params.id
        }
      })
      res.render('update_article', {
        article
      })
    } catch (err) {
      res.redirect('back')
    }
  },
  update: async(req, res) => {
    const { title, category, content } = req.body
    const { UserId } = req.session
    try {
      const article = await Article.findOne({
        where: {
          id: req.params.id,
          UserId
        }
      })
      await article.update({
        title,
        category,
        content
      })
      await res.redirect('/')
    } catch (err) {
      req.flash('errorMessage', 'You are not authorized to edit this post')
      res.redirect('back')
    }
  },
  list: async(req, res) => {
    try {
      const article = await Article.findAll({
        where: {
          is_deleted: null
        },
        order: [['id', 'DESC']],
        include: User
      })
      res.render('list_articles', {
        article
      })
    } catch (err) {
      console.log(err.toString())
    }
  },
  blogAdmin: async(req, res) => {
    try {
      const article = await Article.findAll({
        where: {
          is_deleted: null
        },
        order: [['id', 'DESC']],
        include: User
      })
      res.render('blog_admin', {
        article
      })
    } catch (err) {
      console.log(err.toString())
    }
  }
}

module.exports = blogController
