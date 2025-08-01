# Laravel Multi-Tenancy Platform

[![Laravel](https://img.shields.io/badge/Laravel-9.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.0+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

## 📋 Mô tả

Dự án Laravel Multi-Tenancy Platform là một ứng dụng web được xây dựng trên Laravel 9 với tính năng multi-tenancy (đa người thuê) sử dụng package [Spatie Laravel Multitenancy](https://github.com/spatie/laravel-multitenancy). 

**Đặc điểm nổi bật:**
- **Database Isolation**: Mỗi tenant có database riêng biệt, đảm bảo dữ liệu hoàn toàn tách biệt
- **Subdomain Management**: Tự động tạo subdomain riêng cho từng tenant (ví dụ: `tenant1.yourdomain.com`)
- **Automatic Setup**: Khi tạo tenant mới, hệ thống tự động tạo database, chạy migration và khởi tạo dữ liệu cơ bản
- **Centralized Management**: Quản lý tất cả tenant từ một admin panel duy nhất

Hệ thống cho phép quản lý nhiều tenant (khách hàng) trên cùng một nền tảng với database riêng biệt cho từng tenant.

## ✨ Tính năng chính

### 🏢 Multi-Tenancy
- **Database Isolation**: Mỗi tenant có database riêng biệt
- **Domain-based Routing**: Định tuyến dựa trên domain
- **Automatic Database Creation**: Tự động tạo database khi tạo tenant mới
- **Tenant Migration**: Tự động chạy migration cho tenant mới
- **Subdomain Management**: Mỗi tenant được cấp phát subdomain riêng biệt

### 🎛️ Admin Panel (Orchid Platform)
- **Tenant Management**: Quản lý tenant thông qua giao diện admin
- **User Management**: Quản lý người dùng cho từng tenant
- **Role & Permission**: Hệ thống phân quyền chi tiết
- **Dashboard**: Bảng điều khiển với biểu đồ và thống kê

### 🔐 Authentication & Authorization
- **Laravel Breeze**: Hệ thống xác thực đầy đủ
- **Email Verification**: Xác thực email
- **Password Reset**: Đặt lại mật khẩu
- **Multi-tenant Session**: Quản lý phiên đăng nhập theo tenant

## 🛠️ Công nghệ sử dụng

- **Framework**: Laravel 9.x
- **PHP**: 8.0+
- **Database**: MySQL/PostgreSQL
- **Admin Panel**: Orchid Platform 12.x
- **Multi-tenancy**: Spatie Laravel Multitenancy 2.x
- **Frontend**: Tailwind CSS, Alpine.js
- **Authentication**: Laravel Breeze

## 📦 Cài đặt

### Yêu cầu hệ thống
- PHP >= 8.0.2
- Composer
- MySQL/PostgreSQL
- Node.js & NPM

### Bước 1: Clone dự án
```bash
git clone <repository-url>
cd multi-tenancy
```

### Bước 2: Cài đặt dependencies
```bash
composer install
npm install
```

### Bước 3: Cấu hình môi trường
```bash
cp .env.example .env
php artisan key:generate
```

### Bước 4: Cấu hình database
Chỉnh sửa file `.env`:
```env
DB_CONNECTION=landlord
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=landlord_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

TENANT_DB_CONNECTION=tenant
TENANT_DB_HOST=127.0.0.1
TENANT_DB_PORT=3306
TENANT_DB_DATABASE=tenant_db
TENANT_DB_USERNAME=your_username
TENANT_DB_PASSWORD=your_password
```

### Bước 5: Chạy migration
```bash
php artisan migrate --path=database/migrations/landlord
```

**Lưu ý quan trọng:**
- Khi tạo tenant, hệ thống sẽ tự động tạo database `demo_localhost`
- Subdomain `demo.localhost` sẽ được cấp phát cho tenant này
- Tất cả migration sẽ được chạy tự động cho database mới
- Tenant có thể truy cập qua URL: `http://demo.localhost`

## 🚀 Sử dụng

### Tạo tenant mới
```bash
php artisan tenants:make --name="Tên Tenant" --domain="domain.com"
```

**Quá trình tạo tenant sẽ tự động:**
1. **Tạo database riêng**: Hệ thống tự động tạo một database mới với tên dựa trên domain (ví dụ: `domain_com`)
2. **Cấp phát subdomain**: Tenant được cấp phát subdomain riêng biệt (ví dụ: `tenant1.yourdomain.com`)
3. **Chạy migration**: Tự động chạy tất cả migration cần thiết cho database mới
4. **Khởi tạo dữ liệu**: Tạo các bảng và dữ liệu cơ bản cho tenant

### Truy cập admin panel
- URL: `http://your-domain/admin`
- Tài khoản mặc định: `admin@admin.com` / `password`

## 📁 Cấu trúc dự án

```
multi-tenancy/
├── app/
│   ├── Console/Commands/          # Lệnh Artisan
│   ├── Http/Middleware/           # Middleware
│   ├── Models/Landlord/           # Models cho landlord
│   ├── Orchid/                    # Admin panel (Orchid)
│   └── Providers/                 # Service providers
├── config/
│   └── multitenancy.php          # Cấu hình multi-tenancy
├── database/
│   ├── migrations/landlord/       # Migration cho landlord
│   └── seeders/                  # Database seeders
└── routes/
    ├── web.php                   # Routes chính
    └── platform.php              # Routes admin panel
```

## 🔧 Cấu hình

### Multi-tenancy Configuration
File `config/multitenancy.php` chứa các cấu hình:
- **Tenant Finder**: Tìm tenant dựa trên domain
- **Switch Tasks**: Các tác vụ khi chuyển tenant
- **Database Connections**: Kết nối database cho landlord và tenant

### Middleware
- `EnsureValidTenantSession`: Đảm bảo session tenant hợp lệ
- `NeedsTenant`: Yêu cầu tenant để truy cập
- `LandlordAsFallback`: Fallback về landlord nếu không có tenant

## 🤝 Đóng góp

1. Fork dự án
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Mở Pull Request

## 📄 License

Dự án này được cấp phép theo [MIT License](https://opensource.org/licenses/MIT).

## 🆘 Hỗ trợ

Nếu bạn gặp vấn đề hoặc có câu hỏi, vui lòng:
- Tạo issue trên GitHub
- Liên hệ qua email: [uocnv.soict.hust@gmail.com]
- Tham khảo documentation: [https://spatie.be/docs/laravel-multitenancy/v4/introduction]

## 🙏 Cảm ơn

- [Laravel Team](https://laravel.com) - Framework tuyệt vời
- [Spatie](https://spatie.be) - Package multi-tenancy
- [Orchid Platform](https://orchid.software) - Admin panel

---

**Lưu ý**: Đây là dự án demo, vui lòng cấu hình bảo mật phù hợp trước khi sử dụng trong production.
