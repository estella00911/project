# Jean's Project

## 1. Blog
- [Repository on the GitHub](https://github.com/estella00911/project/tree/main/blog)
- [Screenshots of Web Application Pages](#screenshots-of-web-application-blog)
- [Blog Demo](https://gentle-depths-67267.herokuapp.com/)
I'm using the MVC architecture with the Node.js framework - Express for the backend. I'm utilizing the Sequelize ORM for the MySQL database, and I'm incorporating the CKEditor 5 editor from a CDN to add and edit articles.

## 2. PHP Board
- [Screenshots of Web Application: Blog](#screenshots-of-web-application-php-board)
- [Repository on the GitHub](https://github.com/estella00911/project/tree/main/board)
- [Board Demo](http://project.estella00911.tw/board/index.php)
Deploy on `AWS EC2`, write the backend in `PHP`, use a `MySQL` relational database to link users and message content, create a login functionality using sessions, and, using the `GET` method, add errCode to the query string for backend error message notifications

## Screenshots of Web Application: Blog
### Home Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/1_landing_page.png?raw=true)
### Login Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/2_login_page.png?raw=true)
### Add Article Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/3_add_article_page.png?raw=true)
### Administrator Dashboard (with the ability to click on edit/delete buttons next to articles)
![](https://github.com/estella00911/project/raw/main/src_demo/blog/4_manager_side_landing_page.png?raw=true)
### Administrator's Article List Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/5_manager_side_list_page.png?raw=true)
### Single Article Page
![](https://github.com/estella00911/project/raw/main/src_demo/blog/6_single_article_page.png?raw=true)

## Screenshots of Web Application: PHP Board
![](https://github.com/estella00911/project/blob/main/src_demo/board/1_fisrtPage.gif?raw=true)
#### RWD
![](https://github.com/estella00911/project/blob/main/src_demo/board/10_RWD.gif?raw=true)
#### Register Page
![](https://github.com/estella00911/project/blob/main/src_demo/board/2_register.gif?raw=true)
#### Login Page
![](https://github.com/estella00911/project/blob/main/src_demo/board/3_login.gif?raw=true)
####Member Editing Function — Edit Nickname and Post Comments
![](https://github.com/estella00911/project/blob/main/src_demo/board/4_editNickAndAddComments.gif?raw=true)
#### Member Editing Function — Editing Only Own Comments
Members can only edit their own comments and are not allowed to edit others' comments freely.
![](https://github.com/estella00911/project/blob/main/src_demo/board/5_editOwnNoOthers.gif?raw=true)

#### Member Deletion Function — Deleting Only Own Comments
Members can only delete their own comments and are not allowed to delete others' comments freely.
![](https://github.com/estella00911/project/blob/main/src_demo/board/6_deleteOwnNoOthers.gif?raw=true)
#### Administrator Function — Modifying Comment Permissions
The administrator will change member ABC's permissions to prevent them from posting comments.
![](https://github.com/estella00911/project/blob/main/src_demo/board/7_adminLoginAndSuspendAbc.gif?raw=true)

#### User ABC, Suspended from Posting Comments
User ABC, who has been suspended from posting comments, cannot create new comments but can still edit and delete their existing comments
![](https://github.com/estella00911/project/blob/main/src_demo/board/8_suspendABCandAddEditDelete.gif?raw=true)
#### Administrator Function — Editing and Deleting Members' Comments at Will
![](https://github.com/estella00911/project/blob/main/src_demo/board/9_adminCanEditDeleteOtherComment.gif?raw=true)