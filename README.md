# HimalayaVoyage - Nepal Tours & Travel Platform

A comprehensive tours and travels booking platform built with Laravel 11, featuring tour management, booking system, payment gateways, and more.

## Features

- ✅ Custom authentication system (Admin & User roles)
- ✅ Tour management with categories and destinations
- ✅ Advanced booking system
- ✅ Multiple payment gateways (eSewa, Khalti, PayPal, Stripe)
- ✅ Review and rating system
- ✅ Blog management
- ✅ Inquiry system
- ✅ User dashboard
- ✅ Admin panel with analytics
- ✅ Responsive design (mobile-first)
- ✅ SEO optimized
- ✅ Weather integration

## Tech Stack

- **Framework:** Laravel 11
- **Database:** MySQL 8
- **Frontend:** Blade Templates + Tailwind CSS + Alpine.js
- **Payment:** eSewa, Khalti, PayPal, Stripe

## Installation

### Requirements

- PHP 8.2+
- Composer
- MySQL 8+
- Node.js 18+
- XAMPP/LAMPP (for local development)

### Steps

1. **Clone the repository**
```bash
git clone https://github.com/yourusername/himalayavoyage.git
cd himalayavoyage
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Create environment file**
```bash
cp .env.example .env
```

5. **Configure database in .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tours
DB_USERNAME=root
DB_PASSWORD=
```

6. **Generate application key**
```bash
php artisan key:generate
```

7. **Run migrations**
```bash
php artisan migrate
```

8. **Seed database with sample data**
```bash
php artisan db:seed
```

9. **Create storage link**
```bash
php artisan storage:link
```

10. **Compile assets**
```bash
npm run dev
```

11. **Start the development server**
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## Default Login Credentials

### Admin
- Email: `admin@himalayavoyage.com`
- Password: `password123`

### User
- Email: `user@example.com`
- Password: `password123`

## Project Structure
```
tours/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/           # Authentication controllers
│   │   ├── Admin/          # Admin panel controllers
│   │   └── Frontend/       # Public website controllers
│   ├── Models/             # Eloquent models
│   ├── Services/           # Business logic services
│   └── Traits/             # Reusable traits
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── routes/
│   ├── web.php            # Public routes
│   ├── admin.php          # Admin routes
│   └── frontend.php       # User dashboard routes
└── public/                # Public assets
```

## Payment Gateway Configuration

### eSewa (Nepal)
```env
ESEWA_MERCHANT_CODE=your_merchant_code
ESEWA_SECRET_KEY=your_secret_key
ESEWA_URL=https://rc-epay.esewa.com.np/api/epay/main/v2/form
```

### Khalti (Nepal)
```env
KHALTI_PUBLIC_KEY=your_public_key
KHALTI_SECRET_KEY=your_secret_key
```

### Stripe (International)
```env
STRIPE_KEY=pk_test_your_key
STRIPE_SECRET=sk_test_your_secret
```

## Key Features Explained

### Tour Management
- Create/Edit/Delete tours
- Multi-image upload
- Itinerary builder
- Price management with sale prices
- Difficulty levels
- SEO meta tags

### Booking System
- Real-time availability
- Multiple travelers support
- Special requests
- Payment integration
- Booking confirmation emails
- Invoice generation (PDF)

### User Dashboard
- View bookings history
- Manage favorites
- Write reviews
- Edit profile
- Change password

### Admin Panel
- Dashboard with statistics
- Tour management
- Booking management
- User management
- Category management
- Destination management
- Blog management
- Review moderation
- Inquiry management
- Settings management

## API Endpoints (Future Enhancement)

Currently using web routes. API endpoints can be added in `routes/api.php` for:
- Mobile app integration
- Third-party integrations
- Webhooks

## Testing

Run tests:
```bash
php artisan test
```

## Deployment

### Production Checklist
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure proper database credentials
4. Set up SSL certificate (HTTPS)
5. Configure mail settings
6. Set up cron jobs for scheduled tasks
7. Optimize application:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Server Requirements
- PHP 8.2+
- MySQL 8+
- Composer
- Node.js & NPM
- Web server (Apache/Nginx)

## Common Issues & Solutions

### Issue: "Class not found" error
**Solution:** Run `composer dump-autoload`

### Issue: Storage link not working
**Solution:** Run `php artisan storage:link`

### Issue: Permission denied on storage
**Solution:** 
```bash
chmod -R 775 storage bootstrap/cache
```

### Issue: 404 on all routes except homepage
**Solution:** Enable `mod_rewrite` in Apache or configure Nginx properly

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is open-sourced under the MIT License.

## Support

For support, email info@himalayavoyage.com or create an issue in the repository.

## Credits

- **Developer:** Your Name
- **Design:** Inspired by modern travel websites
- **Icons:** Heroicons, Font Awesome
- **Images:** Unsplash (for demo purposes)

## Changelog

### Version 1.0.0 (Initial Release)
- User authentication system
- Tour management
- Booking system
- Payment gateway integration
- Admin panel
- User dashboard
- Blog system
- Review system
- Contact/Inquiry system

## Roadmap

- [ ] Mobile app (React Native)
- [ ] Advanced analytics
- [ ] Multi-language support
- [ ] Multi-currency support
- [ ] Live chat support
- [ ] WhatsApp integration
- [ ] Email marketing integration
- [ ] Loyalty program
- [ ] Referral system
- [ ] Social media login