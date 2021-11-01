# Jean's Project

## 部落格
https://gentle-depths-67267.herokuapp.com/

## 描述
希望可以做一個自己的部落格，紀錄學習的足跡。

## 進度
正在進行中，預計後續製作以下功能：
- [ ] 實作分類功能
- [ ] 實作 view more 功能
- [ ] 實作分頁機制
- [ ] 新增關於我頁面
- [ ] 新增文章分類頁面

## 功能
- [x] 登入機制，管理員才可以登入
     * 帳號：admin
     * 密碼：admin00911
- [x] 可以新增、編輯、刪除文章
- [x] 串接 CKEditor
- [x] 支援 RWD


### 運行環境
* 後端：Node.js、Express
* 資料庫：MySQL
* ORM 框架：Sequelize


## Demo
## 首頁
![](https://github.com/estella00911/project/raw/main/src_demo/blog/1_landing_page.png?raw=true)
## 登入頁面
![](https://github.com/estella00911/project/raw/main/src_demo/blog/2_login_page.png?raw=true)
## 新增文章頁面
![](https://github.com/estella00911/project/raw/main/src_demo/blog/3_add_article_page.png?raw=true)
## 管理員角度的首頁（可以點擊文章旁的編輯/刪除按鈕）
![](https://github.com/estella00911/project/raw/main/src_demo/blog/4_manager_side_landing_page.png?raw=true)
## 管理員角度的文章列表頁面
![](https://github.com/estella00911/project/raw/main/src_demo/blog/5_manager_side_list_page.png?raw=true)
## 單一文章頁面
![](https://github.com/estella00911/project/raw/main/src_demo/blog/6_single_article_page.png?raw=true)



## 技術
1. `Express`
2. ORM 框架——`Seqeulize`
3. `CSS` 預處理器（Scss）
4. `dotenv` 
5. `middleware` 做會員是否登入的權限檢查
6. 

## 心得記錄
1. [部署的過程紀錄](https://www.coderbridge.com/@estella00911/d9062ac8990a4200a2fe53138a843fde)

- [x] 部署到免費空間 heroku
- [x] 環境變數


## 架構
|-- index.js：路由
|-- .sequelizerc：變更設定檔位置及名稱，因為加入 `dotenv` 環境變數
|-- controllers
&nbsp; &nbsp; &nbsp; &nbsp; |-- user.js
&nbsp; &nbsp; &nbsp; &nbsp; |-- blog.js
|-- migrations
&nbsp; &nbsp; &nbsp; &nbsp; |-- 20210815074507-create-user.js
&nbsp; &nbsp; &nbsp; &nbsp; |-- 20210816113358-create-article.js
|-- public
&nbsp; &nbsp; &nbsp; &nbsp; |-- css：放 scss 檔案
&nbsp; &nbsp; &nbsp; &nbsp; |-- images：圖片、icon、背景圖
|-- config
&nbsp; &nbsp; &nbsp; &nbsp; |-- config.js
|-- models
&nbsp; &nbsp; &nbsp; &nbsp; |-- index.js
&nbsp; &nbsp; &nbsp; &nbsp; |-- user.js
&nbsp; &nbsp; &nbsp; &nbsp; |-- article.js
|-- scripts
&nbsp; &nbsp; &nbsp; &nbsp; |-- click.js：點擊文章列表中的文章，會導到該篇文章內容的 DOM
|-- views
&nbsp; &nbsp; &nbsp; &nbsp; |-- ejs 檔案，靜態頁面
|-- seeders

## 環境變數
作業中有使用到 [dotenv](https://www.npmjs.com/package/dotenv)，你可以將想要使用的環境變數，加到專案根目錄的 `.env` 中，就會自動被帶入環境變數中。

i. `DB_USERNAME`
ii. `DB_PASSWORD`
iii. `DB_PORT`
iv. `DB_DATABASE`
v. `SESSION_SECRET`

## 資料庫欄位
### Articles
| Field       | Type     | Length | Default | Key | Extra           |
|-------------|----------|--------|---------|-----|-----------------|
| id          | INT      | 11     |         | PRI | Auto\_increment |
| title       | VARCHAR  | 255    |         |     |                 |
| Category    | VARCHAR  | 255    |         |     |                 |
| Content     | TEXT     |        |         |     |                 |
| is\_deleted | TINYINT  | 1      |         |     |                 |
| createdAt   | DATETIME |        |         |     |                 |
| updatedAt   | DATETIME |        |         |     |                 |
| UserId      | INT      | 11     |         |     |                 |
| imageUrl    | VARCHAR  |        |         |     |                 |
### users
| Field                | Type     | Length | Default            | Key | Extra           |
|----------------------|----------|--------|--------------------|-----|-----------------|
| id                   | INT      | 11     |                    | PRI | auto\_increment |
| Username             | VARCHAR  | 64     |                    |     |                 |            |
| password             | VARCHAR  | 128    |                    |     |                 |
| created\_at          | DATETIME |        | CURRENT\_TIMESTAMP |     |                 |