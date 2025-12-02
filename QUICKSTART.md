# Quick Start Guide

## Prerequisites
- PHP 8.2+ installed
- Composer installed
- MySQL/MariaDB installed
- Node.js 18+ installed
- XAMPP/LAMPP running (if using)

## 5-Minute Setup

### Step 1: Clone and Install
```bash
git clone <repository-url> tours
cd tours
composer install
npm install
```

### Step 2: Configure Environment
```bash
cp .env.example .env
```

Edit `.env` and set your database:
```
DB_DATABASE=tours
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Setup Database
```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

### Step 4: Compile Assets
```bash
npm run build
```

### Step 5: Start Server
```bash
php artisan serve
```

Visit: http://localhost:8000

## Login Credentials

**Admin Panel:** http://localhost:8000/login
- Email: admin@himalayavoyage.com
- Password: password123

**User Account:**
- Email: user@example.com
- Password: password123

## Next Steps

1. **Add Tours:** Login as admin → Tours → Create New Tour
2. **Configure Settings:** Admin → Settings
3. **Setup Payment Gateways:** Update `.env` with your API keys
4. **Customize Design:** Edit files in `resources/views/`

## Need Help?

- Check `README.md` for detailed documentation
- Review code comments for explanations
- All controllers have clear, beginner-friendly code

## Common URLs

- Homepage: http://localhost:8000
- Admin Dashboard: http://localhost:8000/admin/dashboard
- User Dashboard: http://localhost:8000/profile/dashboard
- Tours: http://localhost:8000/tours
- Blog: http://localhost:8000/blog