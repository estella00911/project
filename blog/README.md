# Jean's Project

## Blog
[Jean's Blog](https://gentle-depths-67267.herokuapp.com/)

## Descrption
Blog for documenting learning experiences

## Progress
In progress, the following features are planned for future development:
- [ ] Implement category functionality
- [ ] Implement "view more" functionality
- [x] Implement pagination mechanism
- [ ] Add article category page
- [ ] CKEditor editor, for writing code blocks

## Functionality
- [x] Login mechanism, only administrators can log in
     * Username: admin
     * Password: admin00911
- [x] Ability to add, edit, and delete articles
- [x] Integrate CKEditor API
- [x] Support for Responsive Web Design (RWD)
- [x] Implementation of pagination mechanism

### Environment
* Back-end: Node.js、Express
* Database: MySQL
* ORM Framework: Sequelize
* Front-end: HTML、CSS、JavaScript

## Demo
## Home Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/1_landing_page.png?raw=true)
## Login Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/2_login_page.png?raw=true)
## Add Article Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/3_add_article_page.png?raw=true)
## Administrator Dashboard (with the ability to click on edit/delete buttons next to articles)
![](https://github.com/estella00911/project/raw/main/src_demo/blog/4_manager_side_landing_page.png?raw=true)
## Administrator's Article List Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/5_manager_side_list_page.png?raw=true)
## Single Article Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/6_single_article_page.png?raw=true)

## Technologies
1. Framework for Node.js：`Express`
2. Node.js ORM Framework: `Seqeulize`
3. CSS Preprocessor: `Scss`
4. `dotenv`: Used to store sensitive information in environment variables
5. `Middleware`: Used for checking user authentication and permissions, such as whether a member is logged in.

Technologies
Framework for Node.js: Express
Node.js ORM Framework: Sequelize
CSS Preprocessor: Scss
dotenv: Used to store sensitive information in environment variables
Middleware: Used for checking user authentication and permissions, such as whether a member is logged in.

## 心得記錄
1. [Deployment Process Documentation](https://www.coderbridge.com/@estella00911/d9062ac8990a4200a2fe53138a843fde)
- [x] [Deploy to free hosting on Heroku](https://www.coderbridge.com/@estella00911/d9062ac8990a4200a2fe53138a843fde)
- [x] [Environment Variables](https://estella00911.coderbridge.io/2021/08/20/dotenv/)


## Architecture
|-- index.js: Routes
|-- .sequelizerc：Change configuration file location and name due to the addition of `dotenv` environment variables
|-- controllers
&nbsp; &nbsp; &nbsp; &nbsp; |-- user.js
&nbsp; &nbsp; &nbsp; &nbsp; |-- blog.js
|-- migrations
&nbsp; &nbsp; &nbsp; &nbsp; |-- 20210815074507-create-user.js
&nbsp; &nbsp; &nbsp; &nbsp; |-- 20210816113358-create-article.js
|-- public
&nbsp; &nbsp; &nbsp; &nbsp; |-- css: Contains SCSS files
&nbsp; &nbsp; &nbsp; &nbsp; |-- images: Images, icons, background images
|-- config
&nbsp; &nbsp; &nbsp; &nbsp; |-- config.js
|-- models
&nbsp; &nbsp; &nbsp; &nbsp; |-- index.js
&nbsp; &nbsp; &nbsp; &nbsp; |-- user.js
&nbsp; &nbsp; &nbsp; &nbsp; |-- article.js
|-- scripts
&nbsp; &nbsp; &nbsp; &nbsp; |-- click.js：Clicking on an article in the article list leads to the corresponding article's DOM
|-- views
&nbsp; &nbsp; &nbsp; &nbsp; |-- ejs Static pages
|-- seeders

## environment variables
In the project, you can utilize the [`dotenv`](https://www.npmjs.com/package/dotenv) package. Just add the desired environment variables to the `.env` file in the project's root directory, and they will be automatically incorporated into the environment variables.
i. `DB_USERNAME`
ii. `DB_PASSWORD`
iii. `DB_HOST`
iv. `PORT`
iv. `DB_DATABASE`
v. `SQL_PORT`

## database fields
### Articles
| Field       | Type     | Length | Default | Key | Extra           |
|-------------|----------|--------|---------|-----|-----------------|
| id          | INT      | 11     |         | PRI | Auto\_increment |
| title       | VARCHAR  | 255    |         |     |                 |
| Category    | VARCHAR  | 255    |         |     |                 |
| Content     | TEXT     |        |         |     |                 |
| is\_deleted | TINYINT  | 1      |         |     |                 |
| UserId      | INT      | 11     |         |     |                 |
| CategoryId      | INT      | 11     |         |     |                 |
| imageUrl    | VARCHAR  |        |         |     |                 |
| createdAt   | DATETIME |        |         |     |                 |
| updatedAt   | DATETIME |        |         |     |                 |

### users
| Field                | Type     | Length | Default            | Key | Extra           |
|----------------------|----------|--------|--------------------|-----|-----------------|
| id                   | INT      | 11     |                    | PRI | auto\_increment |
| Username             | VARCHAR  | 64     |                    |     |                 |            |
| password             | VARCHAR  | 128    |                    |     |                 |
| created\_at          | DATETIME |        | CURRENT\_TIMESTAMP |     |                 |

### Categories
| Field       | Type     | Length | Default | Key | Extra           |
|-------------|----------|--------|---------|-----|-----------------|
| id          | INT      | 11     |         | PRI | Auto\_increment |
| name       | VARCHAR  | 255    |         |     |                 |
| createdAt   | DATETIME |        |         |     |                 |
| updatedAt   | DATETIME |        |         |     |                 |