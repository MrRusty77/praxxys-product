
# Back end exam for PRAXXYS

This is Laravel Vue TailwindCss web app built for the PRAXXYS exam.

## Prerequisites
Make sure you have installed all of the following prerequisites on your development machine:

* Composer - [Download & Install Cmposer](https://getcomposer.org/download/). 
* Node.js - [Download & Install Node.js](https://nodejs.org/en/download/) and the npm package manager. 

## Getting started

1. Clone the repository
```console
git clone https://github.com/MrRusty77/praxxys-product.git #for https
```
**OR**
```console
git@github.com:MrRusty77/praxxys-product.git #for SSH
```
**OR**

Direct download from git [project download](https://github.com/MrRusty77/praxxys-product).

3. Setup database
Create a new database name `products`

**AND**

Go to the project directory and rename `.env.local` to `.env`. Open the `.env` and change the following to your DB settings DB_DATABASE 

```html
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306

DB_USERNAME=root
DB_PASSWORD=
```

2. Install the package
In the project directory and open the terminal or CMD and type
```console
composer install
```

**AND**

```console
npm install
```

3. Creating database tables
In the project directory and open the terminal or CMD and type
```console
php artisan migrate
```

4. Seeding tables
In the project directory and open the terminal or CMD and type
```console
php artisan db:seed --class=DatabaseSeeder
```

6. Running the web site
In the project directory and open the terminal or CMD and type
```console
php artisan php artisan serve
```

7. Accessing the web app
Go to http://127.0.0.1:8000 to access the web app

```text
the defualt user
Username: User1
Password: User1
```

## Local videos link

```console
http://127.0.0.1:8000/videos/video_zero.mp4
http://127.0.0.1:8000/videos/video_one.mp4
http://127.0.0.1:8000/videos/video_two.mp4
```
