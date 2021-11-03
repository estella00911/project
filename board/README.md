# Jean's Project

## 留言板：
http://project.estella00911.tw/board/index.php
### 描述
利用 PHP 及 MySQL 製作一個簡易的留言板，其中包含 PHP 內建的 Session 登入機制、修改會員的留言權限、常見的資安漏洞。

### 功能
- 會員：
會員可以透過註冊及登入留言板後，看見留言內容，另外還可以可以新增留言、編輯暱稱，且編輯與刪除自己的留言，。
- 管理員：
可以新增留言，也可以編輯及刪除其他會員的留言，另外還可以進入後台，修改會員的留言權限（可以發布留言以及被停權不可以發表留言）。

### 運行環境
* 後端語言：PHP
* 資料庫：MySQL5.7.35
* 上傳至 server 時，使用 FileZilla（FTP）
* 設定、查看、管理資料庫：phpMyAdmin、Sequel Pro
* Apache server（網頁伺服器）
### Demo
![](https://github.com/estella00911/project/blob/main/src_demo/board/1_fisrtPage.gif?raw=true)
#### RWD
![](https://github.com/estella00911/project/blob/main/src_demo/board/10_RWD.gif?raw=true)
#### 註冊
![](https://github.com/estella00911/project/blob/main/src_demo/board/2_register.gif?raw=true)
#### 登入
![](https://github.com/estella00911/project/blob/main/src_demo/board/3_login.gif?raw=true)
#### 會員編輯功能——編輯暱稱、發布留言
![](https://github.com/estella00911/project/blob/main/src_demo/board/4_editNickAndAddComments.gif?raw=true)
#### 會員編輯功能——僅能編輯自己的留言
會員僅可編輯自己的留言，不能隨意編輯他人留言
![](https://github.com/estella00911/project/blob/main/src_demo/board/5_editOwnNoOthers.gif?raw=true)

#### 會員刪除功能——僅能刪除自己的留言
會員僅可刪除自己的留言，不可以任意刪除他人留言。
![](https://github.com/estella00911/project/blob/main/src_demo/board/6_deleteOwnNoOthers.gif?raw=true)
#### 管理員功能——更改留言的權限
管理員將會員 abc 權限改為不能發布留言。
![](https://github.com/estella00911/project/blob/main/src_demo/board/7_adminLoginAndSuspendAbc.gif?raw=true)

#### 被留言停權的使用者 abc
被留言停權的使用者 abc 不能發布新留言，但可以編輯與刪除舊的留言。
![](https://github.com/estella00911/project/blob/main/src_demo/board/8_suspendABCandAddEditDelete.gif?raw=true)
#### 管理員功能——可以任意編輯與刪除會員的留言
![](https://github.com/estella00911/project/blob/main/src_demo/board/9_adminCanEditDeleteOtherComment.gif?raw=true)

### 技術
1. `PHP` 內建 `Session` 機制
2. 使用 `MySQL`
 - 在留言上使用關聯式資料庫可以找到 user（`left join`）
 - 使用 `limit`、`offset` 的分頁概念 
4. 使用 `media query` 實現 RWD
5. 在 `Amazon Web Services (AWS) EC2` 的 `Ubuntu server` 建置 `LAMP` 環境，然後用 `FileZilla` 上傳檔案（`FTP`） 

### 權限
| 身份      | 帳號    | 密碼      | 敘述|
|---------|-------|---------|---------|
| 管理員     | admin | admin01 |可以任意編輯、刪除留言，並可以修改會員發布留言的權限|
| 遭停權的使用者 | aaa   | aaa     |被停權的使用者，無法發布新的留言|
| 一般會員    | qqq   | qqq     |可以新增、編輯、修改留言|

### 資料庫欄位
#### users
| Field                | Type     | Length | Default            | Key | Extra           |
|----------------------|----------|--------|--------------------|-----|-----------------|
| id                   | INT      | 11     |                    | PRI | auto\_increment |
| Username             | VARCHAR  | 64     |                    |     |                 |
| nickname             | VARCHAR  | 128    |                    |     |                 |
| password             | VARCHAR  | 128    |                    |     |                 |
| created\_at          | DATETIME |        | CURRENT\_TIMESTAMP |     |                 |
| status               | VARCHAR  | 64     | User               |     |                 |
| Cannot\_add\_comment | TINYINT  | 1      | 0                  |     |   1（= `True`, 意即不能新增留言）<br> 0（= `false`，可新增留言）              |
#### comments

| Field       | Type     | Length | Allow null | Key | Default | Extra           |
|-------------|----------|--------|------------|-----|---------|-----------------|
| id          | INT      | 11     |            | PRI |         | Auto\_increment |
| username    | VARCHAR  | 64     |            |     |         |                 |
| content     | TEXT     |        |            |     |         |                 |
| created\_at | DATETIME |        |            |     |         |                 |
| is\_deleted | TINYINT  | 1      | yes        |     |      NULL    |                 |

### 檔案介紹
```

|- index.php：留言版主頁
|- login.php：登入頁面
|- register.php：註冊頁面
|- logout.php：處理登出功能
|- handle_add_comment.php：處理新增留言的功能
|- handle_delete_comment.php：處理刪除留言的功能
|- handle_update_comment.php：處理修改留言的功能
|- handle_update_user.php：處理編輯暱稱的功能
|- handle_register.php：處理註冊的功能
|- handle_login.php：處理登入的功能
|- handle_suspend.php：處理遭停權的使用者功能
|- index_admin.php：後台管理使用者權限
|- style.css：CSS file
|- resources：放置圖片的資料夾。
```
<hr>
