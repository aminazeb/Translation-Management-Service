# Laravel Translation Management API

A high-performance, API-driven translation management service built with Laravel, supporting localization, tagging, search, and export for frontend frameworks like Vue.js.

## Features

- Manage translations for multiple locales (`en`, `fr`, `es`, etc.)
- Contextual tagging for translations (`mobile`, `web`, `desktop`)
- Search translations by key, tag, or content
- Export translations as JSON for frontend usage
- Add/update translations via API using Laravel's localization files
- Sanctum authentication for secured API access
- Factory/Seeder to populate 100k+ translations for performance testing
- Built using Laravel Orion for scalable and clean CRUD APIs
- Middleware-based locale switching
- PSR-12 compliant codebase: php-cs-fixer fix
- Feature test coverage

---

## Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/aminazeb/translation-api.git
cd translation-api

2. Install dependencies

composer install
cp .env.example .env
php artisan key:generate

3. Configure .env
Can be shared on request
 
4. Run migrations and seeders

php artisan migrate
php artisan db:seed

Or populate large dataset:

php artisan tinker
\App\Models\Translation::factory()->count(100000)->create();


⸻

### Authentication

Use Sanctum for API authentication.

Create a token

Send a POST request:

POST /api/tokens/create

{
  "email": "admin@example.com",
  "password": "password",
  "token_name": "postman"
}

Use the token from the response as a Bearer Token in future requests.

⸻

### Endpoints

Method	Endpoint	Description
GET	/orion/translations	List all translations
POST /orion/translations	Add a new translation
PUT	/orion/translations/{id}	Update a translation
POST /orion/translations/search	Search translations by key, tag, or content
GET	/api/export/{lang?}	Export JSON translations for frontend


⸻

### Folder Structure

BASIC
    Translation Api Specific Implementation is included in;
	•	app/Models/Translation.php: Translation model
	•	app/Http/Controllers/Orion/TranslationController.php: Business logic
	•	app/Http/Middleware/ApiLocalization.php: Handles locale switching in export Api
    •	app/Policies/TranslationPolicy.php: Policy Control
	•	routes/orion.php: Orion routes
	•	database/factories/TranslationFactory.php: Populates dummy data
    •	database/migrations/2025_08_07_184538_create_translations_table.php: Setup db tabel for storing translations
    •	tests/Feature/TranslationApiTest.php: Feature tests

    Custom App Configurations are included in;
	•	Service Providers: AppServiceProvider.php, RouteServiceProvider.php, AuthServiceProvider.php
	•	Configs: app.php, auth.php
    •	Models: User.php
    •	Controllers: AuthController.php implements authentication logic.
    •	Routes: routes/api.php, implements authentication routes. 

   
Translation by App Locale - implements logic required for future extension of web app
	•	app/Http/Controllers/TranslationController.php: Business logic
	•	app/Http/Middleware/ApiLocalization.php: Handles locale switching
	•	resources/lang/{locale}/messages.php: Stores translations
	•	routes/api.php: API routes
	•	Middlewares: WebAuthenticate.php, Authenticate.php, RedirectIfAuthenticate.php, .


⸻

### Testing

Run tests:

php artisan test

Includes:
	•	Feature tests
	•	Performance test for JSON export

⸻

### Swagger Documentation
TBA
