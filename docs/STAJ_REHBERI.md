# Frontdesk Staj Rehberi

Bu belge, 2. sınıf bilgisayar mühendisliği stajyeri için hazırlanmıştır. Proje boyunca öğrenmeniz beklenen kavramlar ve haftalık görev dağılımı aşağıdadır.

---

## Projenin Amacı

Basit bir otel ön büro yazılımı geliştirerek şu konularda pratik yapmanız hedeflenir:

- Web uygulaması mimarisi (MVC)
- Laravel framework kullanımı
- İlişkisel veritabanı tasarımı
- CRUD (Create, Read, Update, Delete) işlemleri
- Form doğrulama (validation)
- Bootstrap ile responsive arayüz

---

## Haftalık Görev Dağılımı

### 1. Hafta — Kurulum ve Odalar Modülü

| Gün | Görev |
|-----|-------|
| 1-2 | XAMPP, Composer kurulumu. Projeyi ayağa kaldırma. README'yi takip etme |
| 3-4 | Odalar modülünü inceleme: migration, model, controller, view |
| 5   | Odalar modülüne yeni alan ekleme (örn: kat numarası) — alıştırma |

**Öğrenilecek kavramlar:**
- Migration nedir, nasıl çalıştırılır?
- Eloquent Model nedir?
- Resource Controller yapısı
- Blade şablonları ve `@extends`, `@section`
- Form Request ile validation

**İncelemeniz gereken dosyalar:**
- `database/migrations/2026_07_10_000001_create_rooms_table.php`
- `app/Models/Room.php`
- `app/Http/Controllers/RoomController.php`
- `app/Http/Requests/StoreRoomRequest.php`
- `resources/views/rooms/`

---

### 2. Hafta — Misafirler Modülü

| Gün | Görev |
|-----|-------|
| 1-2 | Misafirler modülünü inceleme ve test etme |
| 3-4 | Arama özelliğini anlama (`where like` sorgusu) |
| 5   | Misafir detay sayfasındaki rezervasyon geçmişini inceleme |

**Öğrenilecek kavramlar:**
- Route Model Binding (`Guest $misafir`)
- Eloquent ilişkileri: `hasMany`, `belongsTo`
- Pagination (`paginate()`)
- Query string ile filtreleme

**İncelemeniz gereken dosyalar:**
- `app/Http/Controllers/GuestController.php`
- `app/Models/Guest.php`
- `resources/views/guests/show.blade.php`

---

### 3. Hafta — Rezervasyonlar Modülü

| Gün | Görev |
|-----|-------|
| 1-2 | Rezervasyon oluşturma akışını test etme |
| 3   | Tarih çakışması kontrolünü anlama (`Reservation::hasConflict`) |
| 4   | Check-in / Check-out işlemlerini test etme |
| 5   | Oda durumu senkronizasyonunu inceleme |

**Öğrenilecek kavramlar:**
- Foreign key (yabancı anahtar)
- `withValidator()` ile özel doğrulama
- İş kuralları (business logic) controller'da
- HTTP PATCH metodu ve `@method('PATCH')`

**İncelemeniz gereken dosyalar:**
- `database/migrations/2026_07_10_000003_create_reservations_table.php`
- `app/Models/Reservation.php`
- `app/Http/Requests/StoreReservationRequest.php`
- `app/Http/Controllers/ReservationController.php`

---

### 4. Hafta — Panel ve İyileştirmeler

| Gün | Görev |
|-----|-------|
| 1-2 | Dashboard sorgularını inceleme ve test etme |
| 3   | Auth (giriş/çıkış) akışını anlama |
| 4-5 | Ekstra görevlerden birini seçme (aşağıya bakın) |

**Öğrenilecek kavramlar:**
- Middleware (`auth`, `guest`)
- Session yönetimi
- Eloquent eager loading (`with()`)
- Tarih sorguları (`whereDate`, `today()`)

**İncelemeniz gereken dosyalar:**
- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/AuthController.php`
- `routes/web.php`
- `bootstrap/app.php`

---

## Kod İçi Yorum Standardı

Controller metodlarının üstüne ne yaptığını açıklayan Türkçe yorum yazın:

```php
/**
 * Misafir listesini gösterir. Ad, soyad veya telefona göre arama yapılabilir.
 */
public function index(Request $request)
{
    // ...
}
```

Karmaşık sorguların yanına kısa açıklama ekleyin:

```php
// Bugün giriş yapması beklenen, henüz check-in olmamış rezervasyonlar
$todayCheckIns = Reservation::whereDate('check_in', today())
    ->where('status', 'beklemede')
    ->get();
```

---

## Ekstra Görevler (İsteğe Bağlı)

Temel modülleri tamamladıktan sonra bir veya birkaçını seçebilirsiniz:

1. **Takvim görünümü:** Rezervasyonları aylık takvimde gösterme
2. **PDF fatura:** Check-out sonrası basit PDF oluşturma (DomPDF paketi)
3. **E-posta bildirimi:** Rezervasyon onay e-postası gönderme
4. **Oda doluluk grafiği:** Chart.js ile aylık doluluk oranı
5. **Misafir fotoğrafı:** Misafir profiline fotoğraf yükleme
6. **Kat filtresi:** Odaları kata göre filtreleme

---

## Teslim Kriterleri

Proje tamamlandığında şunların çalışır durumda olması gerekir:

- [ ] XAMPP ile kurulum yapılabiliyor (README adımları)
- [ ] Admin girişi çalışıyor
- [ ] Odalar CRUD işlemleri çalışıyor
- [ ] Misafirler CRUD + arama çalışıyor
- [ ] Rezervasyon oluşturma, düzenleme, iptal çalışıyor
- [ ] Tarih çakışması engelleniyor (aynı oda, aynı tarih)
- [ ] Check-in yapılınca oda "dolu" oluyor
- [ ] Check-out yapılınca oda "müsait" oluyor
- [ ] Dashboard bugünkü giriş/çıkışları doğru gösteriyor
- [ ] Validation hataları Türkçe görünüyor
- [ ] Aktif rezervasyonu olan oda/misafir silinemiyor

---

## Faydalı Kaynaklar

- [Laravel Türkçe Dokümantasyon](https://laravel.com/docs) — resmi docs (İngilizce)
- [Laravel Türkçe Eğitim](https://laravel.gen.tr/) — topluluk kaynağı
- [Bootstrap 5 Dokümantasyon](https://getbootstrap.com/docs/5.3/getting-started/introduction/)
- [PHP The Right Way](https://phptherightway.com/)

---

## Sık Sorulan Sorular

**S: Migration çalıştırınca hata alıyorum**
C: phpMyAdmin'de `frontdesk` veritabanının oluşturulduğundan ve `.env` ayarlarının doğru olduğundan emin olun.

**S: Giriş yapamıyorum**
C: `php artisan db:seed --class=UserSeeder` komutu ile admin kullanıcısını yeniden oluşturun.

**S: Rezervasyon kaydederken "oda çakışması" hatası alıyorum**
C: Seçtiğiniz oda, belirttiğiniz tarihlerde başka bir aktif rezervasyona ayrılmış demektir. Farklı tarih veya oda seçin.

**S: Check-in butonu görünmüyor**
C: Check-in yalnızca durumu "Beklemede" olan rezervasyonlarda görünür.

---

## İletişim

Sorularınız için staj danışmanınıza başvurun. Kod değişikliği yapmadan önce ilgili dosyaları okuyup anlamaya çalışın — bu projenin asıl amacı öğrenmektir.
