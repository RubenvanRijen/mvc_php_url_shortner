# Url shortner

This project is made with plain php in the basic and old MVC structure.

For testing there is used PHPUnit and Mockery.

# Views

Here you can find all the html files. The styling has been made with tailwind.css V3.

# Models

Here you can find all the models and which get and retrieve the data per table.

# Controllers

Here you can find all the controllers which use the models to get the data and return the views with the data.

# Seeders

The setup is made with an interface and abstract class to force a certain layout and way to work.
This is because all the seeders must be created in the AppSeeder file and then it can call the same function.

## Commands

composer seed.<br>
&nbsp;Seed the database.

# Migrations

The setup is made with an interface and abstract class to force a certain layout and way to work.
This is because all migrations must be created in the AppMigration file and then it can call the same function for
creating and dropping the tables.

## Commands

composer migrate.<br>
&nbsp;Migrate the tables.<br>
composer migrate:drop.<br>
&nbsp;Drop all the tables.<br>
composer migrate:fresh --seed.<br>
&nbsp;Drop and then create the tables and seed the db.<br>
