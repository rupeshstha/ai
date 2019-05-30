# Laravel Admin Panel
Made with 💖 by [Bikram Lama](https://bikramlama.com.np)

![](https://bikramlama.com.np/assets/cdn/admin_panel.png)

---
Laravel Admin & BREAD System (Browse, Read, Edit, Add, & Delete), supporting Laravel 5.5, 5.6, 5.7 and 5.8!

## Installation Steps
### 1. Add the DB Credentials & APP_URL
Make sure to create a new database and add your database credentials to your .env file:
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_admin
DB_USERNAME=root
DB_PASSWORD=
```
You will also want to update your website URL inside of the `APP_URL` variable inside the .env file:
```
APP_URL=http://localhost:8000
```
### 2. Import Database file
Import the `sql file` present in the project to mysql:
```
db_admin.sql
```
### 3. Setup Google Analytics Reporting
Make sure you give admin access to your google analytics to `analytics-api@embeded-dashboard.iam.gserviceaccount.com`
Copy the **View ID** from View Settings
Paste the **View ID** into `.env` file:
```
# Make sure to make : "analytics-api@embeded-dashboard.iam.gserviceaccount.com" admin of the google analytics.
ANALYTICS_VIEW_ID=157051864
```
### 4. Login Credentials
The login credentials for the admin panel are:
>**User :** `admin@admin.com`   
>**Pass :** `password`
