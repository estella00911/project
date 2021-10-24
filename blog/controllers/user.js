require('dotenv').config()

const bcrypt = require('bcrypt')
const db = require('../models')

const saltRounds = 10
const { User } = db

const userController = {
  register: (req, res) => {
    res.render('register')
  },
  handleRegister: (req, res) => {
    const { username, password } = req.body

    if (!username || !password) {
      req.flash('errorMessage', 'Please input missing fields')
      return res.redirect('back')
    } else if (!req.session.username) {
      req.flash('errorMessage', 'You are not authorized to register')
      return res.redirect('back')
    }

    bcrypt.hash(password, saltRounds, async(err, hash) => {
      if (err) {
        req.flash('errorMessage', err.toString())
        return res.redirect('back')
      }
      const user = await User.create({
        username,
        password: hash
      })
      req.session.username = username
      req.session.UserId = user.id
      res.redirect('/')
      req.flash('errorMessage', 'the username provided is already registered')
      res.redirect('back')
    })
  },
  login: (req, res) => {
    res.render('login')
  },
  handleLogin: async(req, res) => {
    const { username, password } = req.body

    if (!username || !password) {
      req.flash('errorMessage', 'Please input missing fields')
      return res.redirect('back')
    }

    const user = await User.findOne({
      where: {
        username
      }
    })

    if (!user) {
      req.flash('errorMessage', 'the username provided is not registered')
      return res.redirect('back')
    }

    bcrypt.compare(password, user.password, (err, result) => {
      if (err || !result) {
        req.flash('errorMessage', 'Incorrect Password')
        return res.redirect('back')
      }
      req.session.UserId = user.id
      req.session.username = user.username
      return res.redirect('/')
    })
  },
  logout: async(req, res) => {
    await req.session.destroy()
    await res.redirect('/')
  }
}

module.exports = userController
