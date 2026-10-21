# LaporDong — Road Infrastructure Reporting Platform

LaporDong is a web-based platform designed to help citizens report damaged roads and monitor the progress of infrastructure repairs. It connects citizens, administrators, and field officers through an organized reporting and management system.

The platform also integrates AI-powered image validation and road damage priority assessment to support report processing and help determine which issues require attention first.

## Features

- **User Authentication** — Register, log in, and manage user profiles.
- **Road Damage Reporting** — Submit reports with photos and location information.
- **GPS-Based Location** — Support location detection to help identify where road damage occurs.
- **AI-Powered Image Validation** — Use Google Gemini to assist in validating road damage photos.
- **AI Priority Assessment** — Categorize reports into high, medium, or low priority to support handling decisions.
- **Report Tracking** — View report details, status updates, and reporting history.
- **Public Report Exploration** — Browse public reports and interact through comments.
- **Public Statistics** — View report statistics by status and priority.
- **Administrative Dashboard** — Allow administrators and authorized officers to review, verify, assign, and update reports.
- **Report Reviews** — Allow users to provide feedback on completed reports.
- **Badge System** — Recognize user participation through achievement badges.

## Tech Stack

- **PHP 8.2+**
- **Laravel 11**
- **MySQL** — Relational database
- **Blade** — Server-rendered templates
- **JavaScript** — Front-end interactions
- **Tailwind CSS** — UI styling
- **Vite** — Front-end asset bundling
- **Google Gemini API** — AI-assisted image validation and priority assessment
- **Google Maps API** — Map-related integration configuration

## Getting Started

### Prerequisites

Make sure you have installed:

- PHP 8.2 or later
- Composer
- MySQL
- Node.js and npm
- A compatible web browser

### Installation

**1. Clone the repository**

```bash
git clone <repository-url>
cd lapordong
```

**2. Install PHP dependencies**

```bash
composer install
```

**3. Configure the environment**

```bash
cp .env.example .env
php artisan key:generate
```

Update the `.env` file with your local database configuration and API keys.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lapordong
DB_USERNAME=root
DB_PASSWORD=

GEMINI_API_KEY=your_gemini_api_key
MAPS_API_KEY=your_google_maps_api_key
```

Create the `lapordong` database in MySQL before running the migrations.

**4. Run database migrations and seeders**

```bash
php artisan migrate --seed
```

**5. Install front-end dependencies**

```bash
npm install
npm run build
```

**6. Start the development server**

```bash
php artisan serve
```

Open the local URL displayed in your terminal, usually `http://127.0.0.1:8000`.

## Project Structure

```text
lapordong/
├── app/
│   ├── Http/Controllers/
│   ├── Http/Middleware/
│   ├── Models/
│   ├── Services/
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       └── pages/
│           ├── admin/
│           ├── auth/
│           ├── dashboard/
│           ├── eksplorasi/
│           └── laporan/
├── routes/
│   └── web.php
├── public/
│   ├── css/
│   ├── js/
│   └── images/
├── .env.example
├── composer.json
└── package.json
```

## How It Works

1. Citizens register and log in to the platform.
2. Users submit road damage reports with photos and location information.
3. AI-assisted services help validate submitted images and assess report priority.
4. Administrators or authorized officers review reports, assign tasks, and update their status.
5. Citizens monitor report progress and provide feedback after completion.

## Project Purpose

LaporDong was developed to demonstrate how web technologies and AI-assisted features can support public infrastructure reporting. The project focuses on making reports easier to submit, organize, review, and monitor through a centralized platform.

