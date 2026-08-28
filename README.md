# ThreadPixel

ThreadPixel is a PHP embroidery digitizing platform for businesses, apparel brands, embroidery shops, and creators. Users can explore services, submit artwork for quotes, track orders, receive files, and contact the support team.

## Features

- Embroidery digitizing service catalogue
- Portfolio and before/after artwork presentation
- Quote submission with artwork uploads
- Customer accounts, dashboards, orders, and messages
- Admin management for services, quotes, orders, portfolio items, and FAQs
- SQLite database setup for local development
- ThreadPixel chatbot for service, pricing, file-format, and workflow questions
- Responsive light interface with ThreadPixel branding

## Requirements

- PHP 8.0 or newer
- PDO SQLite extension enabled
- Git, optional

## Local Setup

1. Clone the repository and enter the project directory:

   ```powershell
   git clone https://github.com/MaryamJami1/ThreadPixel.git
   cd ThreadPixel
   ```

2. Create your local environment file:

   ```powershell
   Copy-Item .env.example .env
   ```

3. Update `.env` for your local environment. For the PHP built-in server, use:

   ```dotenv
   APP_ENV=local
   APP_URL=http://localhost:8000
   ```

4. Create the SQLite database and seed the initial data:

   ```powershell
   php database/setup_sqlite.php
   ```

5. Start the local server:

   ```powershell
   php -S localhost:8000 -t public public/router.php
   ```

6. Open [http://localhost:8000](http://localhost:8000) in your browser.

Stop the server with `Ctrl+C`.

## Default Admin Account

The local database seed creates this development account:

- Email: `admin@threadpixel.com`
- Password: `admin123`

Change or remove this account before deploying to a shared or production environment.

## Project Structure

```text
app/       Controllers, models, services, helpers, and views
config/    Application configuration
database/  SQLite setup script and schema
public/    Web root, router, CSS, JavaScript, images, and uploads
routes/    Application routes
storage/   Runtime logs
```

## Configuration and Security

- Never commit `.env` or production credentials.
- Use a strong `CSRF_TOKEN_SECRET` outside local development.
- Keep `public/assets/uploads/`, runtime logs, and the SQLite database out of version control.
- Serve the `public/` directory as the web root in production.
- Configure mail settings in `.env` before enabling production email delivery.

## License

No license has been specified yet. Contact the repository owner before redistributing this project.
