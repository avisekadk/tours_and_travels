#!/bin/bash

echo "🚀 Installing HimalayaVoyage..."

# Check if composer is installed
if ! command -v composer &> /dev/null
then
    echo "❌ Composer is not installed. Please install Composer first."
    exit
fi

# Check if npm is installed
if ! command -v npm &> /dev/null
then
    echo "❌ NPM is not installed. Please install Node.js and NPM first."
    exit
fi

echo "📦 Installing PHP dependencies..."
composer install

echo "📦 Installing Node dependencies..."
npm install

echo "🔧 Creating .env file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ .env file created"
else
    echo "⚠️  .env file already exists"
fi

echo "🔑 Generating application key..."
php artisan key:generate

echo "🗄️  Running migrations..."
read -p "Do you want to run migrations? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan migrate
fi

echo "🌱 Seeding database..."
read -p "Do you want to seed the database with sample data? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan db:seed
fi

echo "🔗 Creating storage link..."
php artisan storage:link

echo "🎨 Compiling assets..."
npm run build

echo "✅ Installation complete!"
echo ""
echo "🎉 You can now start the server with: php artisan serve"
echo "👉 Admin Login: admin@himalayavoyage.com / password123"
echo "👉 User Login: user@example.com / password123"