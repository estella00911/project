const db = require('../models')

const { Article, User, Category } = db

const ARTICLES_PER_PAGE = 5;

const blogController = {
  homePage: async(req, res) => {
    let currentPage = req.query.page == undefined ? 1 : Number(req.query.page);
    offset = (parseInt(currentPage)-1)*5;
    const articles = await Article.findAndCountAll({
      offset,
      limit: ARTICLES_PER_PAGE,
      where: {
        is_deleted: null
      },
      order: [['id', 'DESC']],
      include: [
        { model: User },
        { model: Category}
      ]
    })
    let totalPosts = articles.count;
    let totalPage = Math.ceil(totalPosts/ARTICLES_PER_PAGE)
    // console.log('totalPage:',totalPage);
    // console.log('totalPosts:',totalPosts);
    // console.log('qery.page:', req.query.page);
    // console.log('var pagecurrent:', currentPage);
    let article = articles.rows;
    console.log(JSON.stringify(article,null,4))
    res.render('index', {
      article,
      currentPage,
      totalPage
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
    let currentPage = req.query.page == undefined ? 1 : Number(req.query.page);
    offset = (parseInt(currentPage)-1)*5;
    try {
      const articles = await Article.findAndCountAll({
        offset,
       limit: ARTICLES_PER_PAGE,
        where: {
          is_deleted: null
        },
        order: [['id', 'DESC']],
        include: User
      })
      let totalPosts = articles.count;
      let totalPage = Math.ceil(totalPosts/ARTICLES_PER_PAGE);
      let article = articles.rows;
      res.render('list_articles', {
        article,
        currentPage,
        totalPage
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
  },
  aboutMe: async(req, res) => {
    res.render('about_me')
  }
}

module.exports = blogController
