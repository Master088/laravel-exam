LaravelAssessment API - README

=========================================
1. Installation Steps
=========================================

1. Clone the repository:
   git clone <your-repo-url>
   cd laravel-assessment

2. Install PHP dependencies:
   composer install

3. Install Node dependencies and build assets:
   npm install
   npm run build

4. Copy .env.example to .env:
   cp .env.example .env

5. Generate the application key:
   php artisan key:generate

6. Run migrations:
   php artisan migrate

7. (Optional) Seed the database with an admin user:
   php artisan db:seed --class=AdminSeeder

8. Serve the application:
   php artisan serve
   Your app will run at http://localhost:8000

=========================================
2. Environment Setup
=========================================

.env.example

APP_NAME=LaravelAssessment
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_assessment
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<MAILTRAP_USERNAME>
MAIL_PASSWORD=<MAILTRAP_PASSWORD>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="${APP_NAME}"

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

> Replace <MAILTRAP_USERNAME> and <MAILTRAP_PASSWORD> with your Mailtrap credentials.

=========================================
3. Migrations
=========================================

- Users table includes a 'role' column:
  $table->string('role')->default('user'); // user or admin

- Run migrations:
  php artisan migrate

- Optional admin seeder:
  php artisan db:seed --class=AdminSeeder

=========================================
4. Mail Setup (Mailtrap)
=========================================

- Configure MAIL_* settings in .env as above.
- Mailtrap sandbox captures all outgoing emails.
- Useful for testing forgot password and reset password.

=========================================
5. API Endpoints
=========================================

Prefix: /api

Authentication:

POST /api/login
  Body: { "email":"...","password":"..." }
  Auth: ❌
  Returns: Sanctum token

POST /api/logout
  Body: none
  Auth: ✅ Bearer token

POST /api/password/email
  Body: { "email":"..." }
  Auth: ❌
  Description: Send reset password link (throttle: 5/min)

POST /api/password/reset
  Body: { "token":"...","email":"...","password":"...","password_confirmation":"..." }
  Auth: ❌
  Description: Reset user password

Dashboard:

GET /api/dashboard
  Body: none
  Auth: ✅ Bearer token
  Returns logged-in user info

User Management (Admin only):

GET /api/users
  Auth: ✅ Admin
  List all users

POST /api/users
  Body: { "name":"...","email":"...","password":"...","password_confirmation":"...","role":"user/admin" }
  Auth: ✅ Admin
  Create a new user

PUT /api/users/{id}
  Body: { "name":"...","role":"user/admin" }
  Auth: ✅ Admin
  Update user info

DELETE /api/users/{id}
  Auth: ✅ Admin
  Delete user

=========================================
6. Sample API Requests / Responses
=========================================

Login:
POST /api/login
{
  "email": "admin@example.com",
  "password": "password"
}
Response:
{
  "token": "SANCTUM_TOKEN",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com",
    "role": "admin"
  }
}

Create User:
POST /api/users
{
  "name": "New User",
  "email": "newuser@example.com",
  "password": "password",
  "password_confirmation": "password",
  "role": "user"
}
Response:
{
  "id": 2,
  "name": "New User",
  "email": "newuser@example.com",
  "role": "user",
  "created_at": "2026-02-15T08:30:00.000000Z",
  "updated_at": "2026-02-15T08:30:00.000000Z"
}

Forgot Password:
POST /api/password/email
{
  "email": "user@example.com"
}
Response:
{
  "message": "Password reset link sent to your email."
}

Reset Password:
POST /api/password/reset
{
  "token": "RESET_TOKEN",
  "email": "user@example.com",
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
Response:
{
  "message": "Password has been reset successfully."
}

=========================================
7. Seeders (Optional)
=========================================

AdminSeeder.php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}

=========================================
8. Notes
=========================================

- All API requests must include Bearer token in Authorization header for protected routes.
- Mailtrap captures emails for password reset testing.
- Admin middleware restricts routes to users with "role": "admin".
- Forgot password requests are rate-limited: 5 per minute per IP.

