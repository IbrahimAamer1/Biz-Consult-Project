# 🐳 Docker Setup Guide for BizConsult

## 📋 About

This guide provides complete instructions for setting up and running BizConsult using Docker.

## 🚀 Quick Start with Docker

### Prerequisites

- [Docker](https://www.docker.com/get-started) (version 20.10 or higher)
- [Docker Compose](https://docs.docker.com/compose/install/) (version 2.0 or higher)

### First Time Setup

#### Option 1: Using Setup Script (Recommended)

```bash
# Make the script executable
chmod +x scripts/docker-setup.sh

# Run the setup script
bash scripts/docker-setup.sh
```

#### Option 2: Manual Setup

```bash
# 1. Copy environment file
cp .env.example .env

# 2. Build Docker images
docker-compose build

# 3. Start containers
docker-compose up -d

# 4. Generate application key
docker-compose exec app php artisan key:generate

# 5. Run migrations
docker-compose exec app php artisan migrate

# 6. Create storage link
docker-compose exec app php artisan storage:link

# 7. Build frontend assets
docker-compose exec app npm run build
```

### Access the Application

- **Frontend**: http://localhost:8080
- **Admin Panel**: http://localhost:8080/en/admin
- **Database**: localhost:3306
  - Username: `bizconsult`
  - Password: `password`
  - Database: `bizconsult`

## 🐳 Docker Services

The project includes the following Docker services:

- **app**: Laravel application with PHP-FPM 8.2
- **nginx**: Web server
- **db**: MySQL 8.0 database
- **redis**: Redis for caching and sessions
- **queue**: Laravel queue worker
- **scheduler**: Laravel task scheduler

## 📝 Common Docker Commands

### Using Makefile (Recommended)

```bash
# View all available commands
make help

# Start containers
make up

# Stop containers
make down

# Restart containers
make restart

# View logs
make logs

# Access app container shell
make shell

# Run migrations
make migrate

# Run seeders
make seed

# Clear all caches
make cache-clear

# Build frontend assets
make build-assets
```

### Using Docker Compose Directly

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Execute commands in app container
docker-compose exec app php artisan [command]

# Access MySQL shell
docker-compose exec db mysql -u bizconsult -ppassword bizconsult
```

## 🔧 Development Workflow

### Making Changes

1. Edit your code locally
2. Changes are automatically reflected in the container (thanks to volumes)
3. For PHP changes, no restart needed
4. For frontend changes, rebuild assets:
   ```bash
   make build-assets
   ```

### Database Operations

```bash
# Run migrations
make migrate

# Run seeders
make seed

# Fresh migration with seed
make fresh

# Access database shell
make db-shell

# Create database backup
make db-backup
```

### Cache Management

```bash
# Clear all caches
make cache-clear

# Cache configurations
make cache
```

## 📁 Docker Files Structure

```
BizConsult/
├── Dockerfile              # Docker image definition
├── docker-compose.yml     # Docker Compose configuration
├── .dockerignore          # Files to exclude from Docker build
├── Makefile               # Make commands
├── scripts/
│   └── docker-setup.sh    # Setup script
└── docker/
    ├── nginx/
    │   └── default.conf   # Nginx configuration
    ├── php/
    │   └── local.ini      # PHP configuration
    ├── mysql/
    │   └── my.cnf         # MySQL configuration
    └── supervisord.conf   # Supervisor configuration
```

## 🛠️ Configuration

### Environment Variables

Key environment variables in `.env`:

```env
APP_NAME="BizConsult"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_HOST=db
DB_DATABASE=bizconsult
DB_USERNAME=bizconsult
DB_PASSWORD=password

REDIS_HOST=redis
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Ports

- **Application**: 8080
- **MySQL**: 3307
- **Redis**: 6379

You can change these ports in `.env`:

```env
APP_PORT=8080
DB_PORT=3306
REDIS_PORT=6379
```

## 🧪 Testing

```bash
# Run tests
make test

# Or directly
docker-compose exec app php artisan test
```

## 🐛 Troubleshooting

### Containers won't start

```bash
# Check logs
docker-compose logs

# Rebuild images
docker-compose build --no-cache
```

### Database connection issues

```bash
# Check if database is running
docker-compose ps

# Check database logs
docker-compose logs db

# Wait for database to be ready
docker-compose exec db mysqladmin ping -h localhost -u root -prootpassword
```

### Permission issues

```bash
# Fix storage permissions
docker-compose exec app chmod -R 755 storage bootstrap/cache
```

### Clear everything and start fresh

```bash
# Stop and remove containers and volumes
docker-compose down -v

# Rebuild and start
make setup
```

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)

