# E-commerce API

A RESTful API for an simple e-commerce task built with Laravel. This API allows you to manage products and orders with features like stock management, order processing, and stock updates.

## Features

- **Product Management**
  - Create, read, update, and delete products
  - Track product stock
  - Paginated product listing

- **Order Processing**
  - Create new orders with multiple products
  - Update order status
  - Automatic stock management
  - Order history and tracking

- **Built with**
  - Laravel 10.x
  - MySQL
  - RESTful API Design
  - Service Layer Architecture
  - Event-driven architecture for stock management

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7+

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/Mustafa-Nassar444/7P_Laravel_Task.git
   cd 7P_Laravel_Task
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Create and configure `.env` file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Update `.env` with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```
   This will create the necessary tables and populate the products table with sample data.

6. Start the development server:
   ```bash
   php artisan serve
   ```

## API Endpoints

### Products

- `GET /api/products` - List all products (paginated)
- `POST /api/products` - Create a new product
- `GET /api/products/{id}` - Get a specific product
- `PUT /api/products/{id}` - Update a product
- `DELETE /api/products/{id}` - Delete a product

### Orders

- `POST /api/orders` - Create a new order
- `GET /api/orders/{id}` - Get order details
- `PUT /api/orders/{id}` - Update order status
- `DELETE /api/orders/{id}` - Cancel/delete an order

## Example Requests

### Create a Product
```http
POST /api/products
Content-Type: application/json

{
    "name": "Laptop",
    "price": 999.99,
    "stock": 10
}
```

### Create an Order
```http
POST /api/orders
Content-Type: application/json

{
    "customer_name": "John Doe",
    "products": [
        {
            "id": 1,
            "quantity": 2
        },
        {
            "id": 2,
            "quantity": 1
        }
    ]
}
```

### Update Order Status
```http
PUT /api/orders/1
Content-Type: application/json

{
    "status": "completed"
}
```

## Error Handling

The API returns appropriate HTTP status codes and JSON responses for errors:

- `200` - Success
- `201` - Resource created
- `400` - Bad request (validation errors)
- `404` - Resource not found
- `500` - Server error



## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
