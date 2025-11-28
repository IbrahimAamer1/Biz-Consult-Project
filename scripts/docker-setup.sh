#!/bin/bash

# BizConsult Docker Setup Script
# This script automates the initial setup of the BizConsult application

set -e

echo "🐳 BizConsult Docker Setup"
echo "=========================="
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚠️  .env file not found. Creating from .env.example...${NC}"
    if [ -f .env.example ]; then
        cp .env.example .env
        echo -e "${GREEN}✅ .env file created${NC}"
    else
        echo -e "${RED}❌ .env.example not found. Please create .env manually.${NC}"
        exit 1
    fi
else
    echo -e "${GREEN}✅ .env file exists${NC}"
fi

# Build Docker images
echo ""
echo -e "${YELLOW}📦 Building Docker images...${NC}"
docker-compose build

# Start containers
echo ""
echo -e "${YELLOW}🚀 Starting containers...${NC}"
docker-compose up -d

# Wait for database to be ready
echo ""
echo -e "${YELLOW}⏳ Waiting for database to be ready...${NC}"
sleep 10

# Check database connection
echo ""
echo -e "${YELLOW}🔍 Checking database connection...${NC}"
until docker-compose exec -T db mysqladmin ping -h localhost -u root -prootpassword --silent; do
    echo "Waiting for database..."
    sleep 2
done
echo -e "${GREEN}✅ Database is ready${NC}"

# Generate application key
echo ""
echo -e "${YELLOW}🔑 Generating application key...${NC}"
docker-compose exec app php artisan key:generate || echo -e "${YELLOW}⚠️  Key already exists${NC}"

# Run migrations
echo ""
echo -e "${YELLOW}📊 Running migrations...${NC}"
docker-compose exec app php artisan migrate

# Create storage link
echo ""
echo -e "${YELLOW}🔗 Creating storage link...${NC}"
docker-compose exec app php artisan storage:link || echo -e "${YELLOW}⚠️  Storage link already exists${NC}"

# Build frontend assets
echo ""
echo -e "${YELLOW}🎨 Building frontend assets...${NC}"
docker-compose exec app npm run build

echo ""
echo -e "${GREEN}✅ Setup completed successfully!${NC}"
echo ""
echo "🌐 Application is available at:"
echo "   Frontend: http://localhost:8080"
echo "   Admin: http://localhost:8080/en/admin"
echo ""
echo "📝 Database credentials:"
echo "   Host: localhost:3307"
echo "   Database: bizconsult"
echo "   Username: bizconsult"
echo "   Password: password"
echo ""

