# recipe

## Setup
Copy "env.example" and rename the copied file to ".env"

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

- [ ] 1. Refactor Inventory to Pantry
- [x] 2. Save recipes
- [ ] 3. Recommendation Engine
- [ ] 4. Ability to share pantries with other users
- [ ] 5. Multiple pantries (warning: will be extensive)
- [ ] 6. Share grocery lists
- [x] 7. Trending
- [ ] 8. Calendar/Meal Planning
- [ ] 9. Activity/Overview Screen (swap settings for that)
- [ ] 10. Redirect to HTTPS
- [ ] 11. Modify diets to only select one at a time
