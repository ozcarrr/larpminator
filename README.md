# Larpminator

Larpminator is a Laravel web application that analyzes technical interview transcripts. It assesses whether candidate responses reflect real operational experience or superficial buzzwords.

## Core Features

- Ingestion: Submit candidate answers alongside the role, tech stack, and question context.
- Depth Evaluation: Generates an overall depth score (0 to 100) and verdict based on operational depth, friction handling, ownership, and logical consistency.
- Flag Detection: Highlights red and amber flags quoting specific segments from the candidate transcript with explanations.
- Tactical Drill-Downs: Produces targeted counter-questions with expected practitioner signals to probe deeper during live interviews.
- Role Reuse: Clone questions and role parameters to evaluate multiple candidates on the same benchmark.

## Tech Stack

- Backend: PHP 8.2+, Laravel 11
- Database: SQLite
- AI Integration: Groq API (llama-3.3-70b-versatile) via Laravel HTTP client
- Frontend: Blade, Tailwind CSS

## Requirements

- PHP 8.2 or higher with the SQLite extension enabled (`pdo_sqlite`)
- Composer

## Installation

1. Clone the repository:
```bash
git clone https://github.com/ozcarrr/larpminator.git
cd larpminator
```

2. Install Composer dependencies:
```bash
composer install
```

3. Set up the environment configuration:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your Groq API key in `.env`:
```env
GROQ_API_KEY=your_groq_api_key_here
```
Note: If no API key is supplied, the app uses a safe fallback response so evaluations do not crash during testing or demos.

5. Run migrations and database seeder:
```bash
php artisan migrate:fresh --seed
```

6. Start the local development server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## Testing

Run the test suite with:

```bash
php artisan test
```
