# Frontdesk — Ön Büro Yazılımı

Basit ölçekte otel ön büro yönetim uygulaması. Laravel, MySQL ve Bootstrap ile geliştirilmiştir.

## Özellikler

- **Panel (Dashboard):** Bugün giriş/çıkış yapacak misafirler, oda özeti, son rezervasyonlar
- **Odalar:** Oda ekleme, düzenleme, silme ve duruma göre filtreleme
- **Misafirler:** Misafir kayıtları, arama ve rezervasyon geçmişi
- **Rezervasyonlar:** Rezervasyon oluşturma, giriş/çıkış işlemleri, tarih çakışması kontrolü
- **Giriş:** Basit admin oturum yönetimi

## Gereksinimler

- PHP 8.2 veya üzeri
- Composer
- XAMPP (Apache + MySQL) veya ayrı MySQL kurulumu
- Git (isteğe bağlı)

---

## XAMPP Kurulum Rehberi

### 1. XAMPP İndirme ve Kurulum

1. [https://www.apachefriends.org](https://www.apachefriends.org) adresinden XAMPP'ı indirin
2. Kurulum sihirbazını takip edin (varsayılan ayarlar yeterlidir)
3. XAMPP Control Panel'i açın
4. **Apache** ve **MySQL** servislerini **Start** ile başlatın

### 2. PHP ve Composer Kurulumu

XAMPP ile birlikte PHP gelir. Composer'ı ayrıca kurmanız gerekir:

1. [https://getcomposer.org/download/](https://getcomposer.org/download/) adresinden Composer'ı indirin
2. Kurulum sırasında PHP yolunu XAMPP dizinine yönlendirin:
   ```
   C:\xampp\php\php.exe
   ```
3. Kurulumu doğrulayın:
   ```bash
   php -v
   composer -V
   ```

> **Not:** `php` komutu tanınmıyorsa, `C:\xampp\php` klasörünü Windows PATH ortam değişkenine ekleyin.

### 3. Veritabanı Oluşturma

1. Tarayıcıda [http://localhost/phpmyadmin](http://localhost/phpmyadmin) adresini açın
2. **Yeni** (New) sekmesine tıklayın
3. Veritabanı adı: `frontdesk`
4. Karakter seti: `utf8mb4_unicode_ci`
5. **Oluştur** butonuna tıklayın

### 4. Projeyi Kurma

Proje klasörüne gidin ve şu komutları sırayla çalıştırın:

```bash
# Bağımlılıkları yükle
composer install

# Ortam dosyasını oluştur
copy .env.example .env

# Uygulama anahtarını üret
php artisan key:generate
```

`.env` dosyasını açın ve veritabanı ayarlarını kontrol edin:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=frontdesk
DB_USERNAME=root
DB_PASSWORD=
```

> XAMPP'ta MySQL varsayılan şifresi boştur. Şifre belirlediyseniz `DB_PASSWORD` alanına yazın.

```bash
# Tabloları oluştur ve örnek verileri yükle
php artisan migrate --seed

# Geliştirme sunucusunu başlat
php artisan serve
```

Tarayıcıda [http://localhost:8000](http://localhost:8000) adresini açın.

### 5. Giriş Bilgileri

| Alan     | Değer                    |
|----------|--------------------------|
| E-posta  | `admin@frontdesk.local`  |
| Şifre    | `password`               |

---

## Proje Yapısı

```
app/
├── Http/Controllers/     # İstek işleyiciler (Auth, Dashboard, Room, Guest, Reservation)
├── Http/Requests/        # Form doğrulama kuralları
└── Models/               # Veritabanı modelleri (Room, Guest, Reservation)

database/
├── migrations/           # Tablo tanımları
└── seeders/              # Örnek veriler

resources/views/          # Blade şablonları (Türkçe arayüz)
routes/web.php            # URL tanımları
docs/STAJ_REHBERI.md      # Stajyer rehberi
```

## Veritabanı Tabloları

| Tablo          | Açıklama                                      |
|----------------|-----------------------------------------------|
| `users`        | Admin kullanıcıları                             |
| `rooms`        | Oda envanteri (numara, tip, durum, fiyat)     |
| `guests`       | Misafir bilgileri                             |
| `reservations` | Rezervasyonlar (misafir, oda, tarihler)       |

---

## Sunucuya Kurulum (cPanel / Paylaşımlı Hosting)

### Veritabanı ayarları

cPanel'de oluşturduğunuz bilgileri `.env` dosyasına yazın. **Önemli:** Site ile MySQL aynı sunucudaysa:

```env
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=xanaduhotels_fttest
DB_USERNAME=xanaduhotels_fdu
DB_PASSWORD="sifreniz"
```

> `DB_HOST` olarak sunucunun dış IP adresini (`213.159.6.182` gibi) **yazmayın**. Bu durumda MySQL bağlantıyı uzaktan görür ve `Access denied for user '@IP'` hatası verir.

Şifrede `{`, `}`, `)` gibi özel karakterler varsa değeri çift tırnak içine alın.

### cPanel kontrol listesi

1. **MySQL Databases** → veritabanı oluşturuldu mu?
2. **MySQL Users** → kullanıcı oluşturuldu mu?
3. Kullanıcı veritabanına **ALL PRIVILEGES** ile eklendi mi?
4. Dosyalar `public_html` altına yüklendi mi? (Laravel'de `public/` klasörü document root olmalı)
5. SSH veya Terminal varsa:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan config:clear
   ```

### Production `.env` ayarları

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://alanadiniz.com
```

---

## Sorun Giderme

### "Access denied for user" (MySQL 1045)

- `DB_HOST=localhost` kullanın (dış IP değil)
- cPanel'de kullanıcının veritabanına yetkisi olduğunu doğrulayın
- Şifreyi cPanel'deki ile birebir karşılaştırın; özel karakter varsa tırnak içine alın: `DB_PASSWORD="sifre"`
- Değişiklikten sonra: `php artisan config:clear`

### "rename(...): Erişim engellendi" veya view cache hatası (Windows)

Blade view cache dosyası yazılamıyorsa (genelde Windows'ta birden fazla PHP süreci veya antivirüs kilidi):

```bash
php artisan view:clear
```

Hâlâ devam ederse `storage/framework/views/` içindeki `.tmp` dosyalarını silin ve sunucuyu yeniden başlatın. Aynı anda yalnızca **bir** sunucu çalıştırın (`php artisan serve` **veya** XAMPP Apache — ikisi birden değil).

### "Hedef makine etkin olarak reddettiğinden bağlantı kurulamadı" (MySQL)

XAMPP Control Panel'den **MySQL** servisinin çalıştığından emin olun. Ardından:

```bash
php artisan migrate --seed
```

### MySQL başlamıyor
- Port 3306 başka bir uygulama tarafından kullanılıyor olabilir
- XAMPP Control Panel'de **Config → my.ini** ile portu değiştirebilirsiniz

### `php` komutu bulunamıyor
- XAMPP PHP yolunu (`C:\xampp\php`) PATH'e ekleyin
- Veya komutları tam yol ile çalıştırın: `C:\xampp\php\php.exe artisan serve`

### Port 8000 kullanımda
```bash
php artisan serve --port=8080
```

### Migration hatası
- phpMyAdmin'de `frontdesk` veritabanının oluşturulduğundan emin olun
- `.env` dosyasındaki DB ayarlarını kontrol edin

### Storage izin hatası
```bash
php artisan storage:link
```

---

## Stajyer Rehberi

Detaylı görev listesi ve öğrenme hedefleri için [`docs/STAJ_REHBERI.md`](docs/STAJ_REHBERI.md) dosyasına bakın.

## Lisans

Bu proje eğitim amaçlıdır.
