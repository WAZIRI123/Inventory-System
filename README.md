# Inventory System

This is an inventory system that allows users to manage their inventory by adding, updating, and deleting items. It is built with Laravel for the backend and Vue.js for the frontend.

## Features

- Add new items to the inventory
- Update existing items in the inventory
- Delete items from the inventory
- Search for items by name or category
- View detailed information about each item, such as the name, description, category, quantity, and price

## Technologies Used

- Laravel
- Vue.js
- MySQL

## Installation

1. Clone the repository:
git clone https://github.com/WAZIRI123/Inventory-System.git


2. Install the required packages:

cd inventory-system
composer install
npm install



3. Create a new MySQL database for the application.

4. Copy the `.env.example` file to a new `.env` file:

cp .env.example .env


5. Update the `.env` file with your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password


6. Run the database migrations:

php artisan migrate


7. Compile the Vue.js frontend:

npm run dev


8. Run the application:
php artisan serve

9. Open http://localhost:8000 in your web browser.

## Usage

1. Click on the "Add Item" button to add a new item to the inventory.

2. Click on the "Edit" button next to an item to update its details.

3. Click on the "Delete" button next to an item to remove it from the inventory.

4. Use the search bar to search for items by name or category.

5. Click on an item to view its detailed information.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
