# Jean's Project

## PHP Board
http://project.estella00911.tw/board/index.php

### Description
Creating a simple message board using PHP and MySQL, including PHP's built-in session-based login system, allowing member permission modification, and addressing common security vulnerabilities.

### Functionality

- Members:
Members can register and log in to the message board to view message content.
They can post new messages, edit their display name, and edit or delete their own messages.
Administrators:

- Administrators can post new messages.
They have the authority to edit and delete messages from other members.
Additionally, administrators can access the backend to modify member message permissions (allowing or suspending message posting privileges).

### Environment
* Backend Language: PHP
* Database: MySQL 5.7.35
* Upload to Server: FileZilla (FTP)
* Database Configuration and Management: phpMyAdmin, Sequel Pro
* Web Server: Apache

### Screenshots of Web Application: PHP Board
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

### Technologies
1. `PHP` with built-in `Session` mechanism.
2. Utilizing `MySQL`:
 - Employing a relational database for messages with the ability to associate messages with users (using left join)
 - Implementing pagination concepts using `limit` and `offset`
4. Implementing `Responsive Web Design (RWD)` using `media queries`.
5. Setting up a `LAMP` environment on `Amazon Web Services (AWS) EC2` with `Ubuntu server` and uploading files using `FileZilla (FTP)`.

### 權限
| Role          | Username | Password | Description                                          |
|---------------|----------|----------|------------------------------------------------------|
| Administrator | admin    | admin01  | Can edit and delete any message, and modify member message posting permissions. |
| Suspended User | aaa      | aaa      | A suspended user who cannot post new messages.      |
| Regular Member | qqq      | qqq      | Can add, edit, and delete messages.                  |

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
| Cannot\_add\_comment | TINYINT  | 1      | 0                  |     |  1 (True, indicating the user cannot post new messages)<br>0 (False, indicating the user can post new messages)  |
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

|- index.php: The main page of the message board.
|- login.php: The login page.
|- register.php: The registration page.
|- logout.php: The page for handling logout functionality.
|- handle_add_comment.php: Handles the functionality for adding new comments.
|- handle_delete_comment.php: Handles the functionality for deleting comments.
|- handle_update_comment.php: Handles the functionality for updating comments.
|- handle_update_user.php: Handles the functionality for editing display names.
|- handle_register.php: Handles the functionality for user registration.
|- handle_login.php: Handles the functionality for user login.
|- handle_suspend.php: Handles the functionality for suspending users.
|- index_admin.php: The backend for managing user permissions.
|- style.css: The CSS file.
|- resources: A folder for storing images.
```
<hr>
