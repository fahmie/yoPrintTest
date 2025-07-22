# Project yoPrintTest

A Laravel-based web application running in Docker with Horizon support.

## Features

- Laravel + Docker + Horizon
- Vite asset build
- Queue management
- Easy local setup

## Requirements

- Docker & Docker Compose installed

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/fahmie/yoPrintTest.git
cd yoPrintTest

# 2. Copy the environment file
cp .env.example .env

# 3. Start Docker containers
docker compose up -d

# 4. Access the Laravel container
docker exec -it laravel_app bash

# 5. Install PHP dependencies
composer install

# 6. Install and build frontend assets
npm install
npm run build

# 7. Run Laravel Horizon
php artisan horizon
