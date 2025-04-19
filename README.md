# Project Setup and Start Guide

This project uses Sail (https://laravel.com/docs/sail) to run PHP and MySQL in Docker containers .

To set up and start the project, follow these steps:

**Step 1: Clone the Project**

Clone the project repository to your local machine using Git:
```bash
git clone https://github.com/username/project.git
```
**Step 2: Install Dependencies**

Enter the project directory and install dependencies:
```bash
composer install
```

**Step 3: Setup Environment Variables**

Copy the `.env.example` file to `.env` and update needed values:
```bash
cp .env.example .env
```

Update the `docker-compose.yml` if necessary.

**Step 4: Generate Application Key**

Generate a new application key using the following command:
```bash
php artisan key:generate
```

**Step 5: Start the Development Server**

```bash
./vendor/bin/sail up
```

**Step 6: Run Migrations**

Run the migrations to set up the database schema:
```bash
./vendor/bin/sail artisan migrate
```

**Step 7: Seed the Database (Optional)**

If you want to populate the database with some initial data, run the following command:
```bash
./vendor/bin/sail artisan db:seed
```
If you have seeded, there is one predefined admin user account:

```
Email: admin@example.com
Password: password
```

**Step 8: Install npm dependencies**

```bash
npm install
```

**Step 9: Build front-end assets**

```bash
npm run build
```

Open your web browser and navigate to `http://0.0.0.0` to access the project.

The main Posts functionality is within the **Blog** section.

That's it!
