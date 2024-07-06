# URL Shortener

This project is a URL shortening service built with plain PHP 8.3, utilizing a traditional MVC (Model-View-Controller) architecture. It simplifies long URLs into manageable links, making them easier to share and track.

## Features

- **MVC Architecture**: Organized in a classic and straightforward MVC structure for clear separation of concerns.
- **Tailwind CSS V3**: Stylish and responsive design using Tailwind CSS V3.
- **PHPUnit and Mockery**: Comprehensive testing with PHPUnit and Mockery to ensure reliability and performance.

## Project Structure

### Views

- Contains all HTML files.
- Styled with Tailwind CSS V3 for a modern and responsive user interface.

### Models

- Responsible for data retrieval and manipulation.
- Each model corresponds to a database table, handling data operations.

### Controllers

- Bridge between models and views.
- Fetch data using models and pass it to views for rendering.

### Seeders

- Utilize an interface and abstract class to enforce a consistent structure.
- All seeders are created in the `AppSeeder` file, which calls a common function for seeding operations.

### Migrations

- Similar to seeders, migrations are structured with an interface and abstract class.
- The `AppMigration` file manages all migrations, providing functions for creating and dropping tables.

## Commands

- **Seed the Database**: `composer seed`
- **Migrate the Tables**: `composer migrate`
- **Drop All Tables**: `composer migrate:drop`
- **Fresh Migration and Seeding**: `composer migrate:fresh --seed`

## Getting Started

1. Clone the repository to your local machine.
2. Copy `config.example.php` to `config.php` and update it with your database credentials.
3. Run `composer install` to install dependencies.
4. Run `npm i` to install dependencies.
5. Use the provided commands to set up your database.

## Testing

Tests are written using PHPUnit and Mockery. Run the tests with:

```bash
composer test
```

## Examples

![Example 1](examples/example-1.png)
![Example 2](examples/example-2.png)
