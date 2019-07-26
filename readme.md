# Batch Image Importer

## Installation
### Installing packages
after cloning the project install packages.
```bash
composer install
```

### Database configuration
edit the `.env` file and update your database credential.
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```  

### Creating tables
run below command to create tables.
```bash
php artisan migrate
```

### Link storage folder
create a symbolic link to `storage/public`.
```bash
php artisan storage:link
```

## Run application
on local environment you can run below command:
```bash
php artisan serve
```

then visit `http://localhost:8000` on your favorite browser.

### API urls
we have just one API for this application, the url is `http://localhost:8000/api/pictures`.

the default limit is `10` but you can increase/decrease the `limit` as a query string (maximum limit is `20`)