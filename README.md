# Shopping App - Setup & Testing Guide

## Prerequisites
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) installed
- No need for Sail or Composer/NPM installed locally

## Setup Steps

1. **Clone the project**
```sh
git clone <your-repo-url>
cd shopping-app
```

2. **Make the dev script executable**
```sh
chmod +x dev
```

3. **Build and set up the environment**
```sh
./dev build
```
- Installs backend dependencies
- Runs migrations and seeds
- Installs frontend dependencies

4. **Import products from Fake Store API**
- Access the container workspace:
```sh
./dev workspace
```
- Run the import command:
```sh
php artisan products:import
```

5. **Run the frontend app**
```sh
./dev up:frontend
```
- The frontend will be available at [http://localhost:5173](http://localhost:5173)

6. **Run feature tests**
- Access the container workspace:
```sh
./dev workspace
```
- Run Laravel feature tests:
```sh
php artisan test
```

## Test User Credentials
To test the frontend login, use:
- **Email:** test@email.com
- **Password:** test1234

## Notes
- Always use the `dev` script for setup, workspace access, and running frontend to avoid permission issues.
- All commands are run inside the container as the `sail` user for proper permissions.

---
For any issues, check logs with:
```
docker compose logs app
```
