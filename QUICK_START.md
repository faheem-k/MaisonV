# Quick Access Guide

## 🎯 Main URLs

### Frontend
- **Homepage**: http://localhost:8000
- **Products**: http://localhost:8000/products
- **Cart**: http://localhost:8000/cart
- **Checkout**: http://localhost:8000/checkout

### Admin Panel (Newly Created)
- **Dashboard**: http://localhost:8000/admin ⭐
- **Products List**: http://localhost:8000/admin/products
- **Create Product**: http://localhost:8000/admin/products/create
- **Edit Product**: http://localhost:8000/admin/products/{id}/edit
- **Orders List**: http://localhost:8000/admin/orders
- **View Order**: http://localhost:8000/admin/orders/{id}

### Database & Utilities
- **PhpMyAdmin**: http://localhost:8080
- **MySQL**: localhost:3306

---

## 📊 Admin Panel Features Summary

### Dashboard
- View overall statistics
- See recent products and orders
- Quick navigation to management areas

### Products Management
✅ **View all products** with search and category filters
✅ **Create new products** with full details (name, price, stock, category, image, etc.)
✅ **Edit existing products** 
✅ **Delete products**
✅ **Manage product status** (active, new, sale, featured)

### Orders Management
✅ **View all orders** with advanced search and filtering
✅ **Search orders** by order number, customer name, or email
✅ **Filter orders** by status and payment status
✅ **View order details** including customer info, items, and totals
✅ **Update order status** (pending → processing → shipped → delivered/cancelled)
✅ **Delete orders**

---

## 🔧 Docker Container Management

### Check if containers are running
```bash
docker ps
```

### Start containers (if stopped)
```bash
docker-compose -f docker/docker-compose.yml up -d
```

### Stop containers
```bash
docker-compose -f docker/docker-compose.yml down
```

### View logs
```bash
docker logs laravel_app  # PHP container
docker logs laravel_db   # MySQL container
docker logs laravel_web  # Nginx container
```

### Execute commands inside container
```bash
docker exec -it laravel_app php artisan [command]
```

---

## 🗄️ Database Operations

### Refresh database with seeding
```bash
docker exec -it laravel_app php artisan migrate:fresh --seed
```

### Access MySQL directly
```bash
docker exec -it laravel_db mysql -u root -p
# Password: laravel
```

### View PhpMyAdmin
Open http://localhost:8080 in browser
- Username: root
- Password: laravel
- Server: laravel_db

---

## 📝 Sample Test Data

**10 Pre-seeded Products Available:**
- 5 Fashion items (Dresses, Blazers, etc.)
- 3 Accessories (Handbags, Scarves, Sunglasses)
- 2 Shoe items (Boots, Sneakers)

All with realistic prices, stock levels, and descriptions.

---

## 🎨 Admin Panel Design

- **Color Scheme**: Dark theme (Dark gray background with white text)
- **Status Colors**:
  - 🟡 Yellow: Pending
  - 🔵 Blue: Processing
  - 🟣 Purple: Shipped
  - 🟢 Green: Delivered
  - 🔴 Red: Cancelled
- **Responsive**: Works on desktop, tablet, and mobile
- **User-Friendly**: Clear navigation and intuitive forms

---

## ⚡ Performance Tips

- Admin panel loads instantly with minimal database queries
- Search and filters are optimized
- Pagination limits results to 15 items per page
- Images are cached by browser

---

## 🔐 Security

- All forms protected with CSRF tokens
- Delete operations require confirmation
- Input validation on all forms
- Ready for authentication middleware (when implemented)

---

## 📞 Troubleshooting

### Admin panel not loading?
1. Check if Docker containers are running: `docker ps`
2. Check Laravel logs: `docker logs laravel_app`
3. Verify database is running: `docker logs laravel_db`

### Database connection error?
```bash
docker exec -it laravel_app php artisan migrate:fresh --seed
```

### Need to create a new product?
1. Go to http://localhost:8000/admin/products/create
2. Fill in the form with product details
3. Click "Create Product" button

### Need to update an order?
1. Go to http://localhost:8000/admin/orders
2. Click the eye icon to view order details
3. Select new status from dropdown
4. Click "Update Status" button

---

## 🎉 Your Admin Panel is Ready!

**Status**: ✅ Fully Functional
**Containers**: ✅ All Running
**Database**: ✅ Initialized with Sample Data
**Access**: ✅ http://localhost:8000/admin

Start managing your e-commerce store now! 🚀
