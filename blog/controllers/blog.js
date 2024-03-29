const db = require('../models')

const { Article, User, Category } = db

const ARTICLES_PER_PAGE = 3;

const blogController = {
  homePage: async(req, res) => {
    let currentPage = req.query.page == undefined ? 1 : Number(req.query.page);
    offset = (parseInt(currentPage)-1)*ARTICLES_PER_PAGE;
    const articles = await Article.findAndCountAll({
      offset,
      limit: ARTICLES_PER_PAGE,
      where: {
        is_deleted: null
      },
      order: [['id', 'DESC']],
      include: [
        { model: User,
          attributes:['id', 'username']
        },
        { model: Category,
          attributes:['id', 'name']
        }
      ]
    })
    let totalPosts = articles.count;
    let totalPage = Math.ceil(totalPosts/ARTICLES_PER_PAGE)
    let article = articles.rows;
    // console.log(JSON.stringify(article,null,4));
    res.render('index', {
      article,
      currentPage,
      totalPage
    })
  },
  pageAdd: async(req, res) => {
    try {
      let categories = await Category.findAndCountAll();
      let totalCategories = categories.count;
      let category = categories.rows;
      console.log('typeof category',category[0].id);
      console.log('category:',JSON.stringify(category,null,4));
      res.render('add_article', {
        totalCategories,
        category
      });
    } catch(err) {
      console.log('err:',err.toString());
      return
    }
    // console.log(categories.rows);
    
  },
  add: async(req, res) => {
    const { title, CategoryId, content, imageUrl } = req.body
    const { UserId, username } = req.session

    if (!title || !CategoryId || !content || !imageUrl) {
      req.flash('errorMessage', 'Please input missing fields')
      return res.redirect('back')
    }
  //  / const hasUser = 0;
    // console.log("UserId"+ UserId);
    // console.log("username"+ username);
    // try {
    //   const user = await User.findOne({
    //     where: {
    //       id: UserId
    //     }
    //   })
    //   console.log("user.rows" +user.id);
    //   console.log("user.rows" +user.UserId);
    //   hasUser = 1;
    // } catch (err) {
    //   console.log('not found!') // 沒有登入，也就是 !user 會跳出的錯誤訊息
    //   req.flash('errorMessage', 'Please login before add a new post') // req.session.username 與資料庫 User 不符
    //   res.redirect('back')
    //   return
    // }
    const user = await User.findOne({
      where: {
        username
      }
    })

    if (!user) {
      req.flash('errorMessage', 'the username provided is not registered')
      return res.redirect('back')
    }

    try {
        const article = await Article.create({
          title,
          CategoryId,
          content,
          UserId,
          imageUrl, 
          createdAt: Date.now(),
          updatedAt: Date.now()
        }, {
          include: [
            { 
              model: User,
              attributes:['id', 'username']
            }
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
      },
      include: [
        { model: User,
          attributes:['id', 'username']
        },
        { model: Category,
          attributes:['id', 'name']
        }
      ]
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
    offset = (parseInt(currentPage)-1)*ARTICLES_PER_PAGE;
    try {
      const articles = await Article.findAndCountAll({
        offset,
        limit: ARTICLES_PER_PAGE,
        where: {
          is_deleted: null
        },
        order: [['id', 'DESC']],
        include: [
          { model: User,
            attributes:['id', 'username']
          },
          { model: Category,
            attributes:['id', 'name']
          }
        ]
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
    let currentPage = req.query.page == undefined ? 1 : Number(req.query.page);  
    try {
      const articles = await Article.findAndCountAll({
        where: {
          is_deleted: null
        },
        order: [['id', 'DESC']],
        include: [
          { model: User,
            attributes:['id', 'username']
          },
          { model: Category,
            attributes:['id', 'name']
          }
        ]
      })
      let totalPosts = articles.count;
      let totalPage = Math.ceil(totalPosts/ARTICLES_PER_PAGE);
      let article = articles.rows;
      res.render('blog_admin', {
        article,
        currentPage,
        totalPage
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
