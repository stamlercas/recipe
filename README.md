# recipe

## Setup
Rename "env.example" to ".env"

Change the database settings in the .env file

Run the following commands:
```
composer install
php artisan key:generate
php artisan migrate
npm install
npm run dev
```


To start a server, run
```
php artisan serve
```
from the project directory.

## Need Done:

- [ ] 1. Rename InventoryController to PantryController
- [ ] 2. Save recipes
- [ ] 3. Recommendation Engine
