Prerequisites
Before you begin, ensure that you have the following installed:

PHP >= 8.1 (for Laravel)
Composer (for managing PHP dependencies)
Node.js >= 14.0 (for React and npm)
npm (Node package manager)
Git (for version control)

Step 2: Install Laravel Dependencies
cd Api
composer install

Step 3: Configure Database (if needed)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

Step 4: Run migrations to set up your database:
php artisan migrate

Step 5: Seeder
php artisan db:seed

Step-6: Run below command
./clean-up.sh

php artisan storage:link

php artisan jwt:secret



Frontend

Step 1: Install Frontend Dependencies
cd App
npm install

Step 2: Compile Assets
npm start
