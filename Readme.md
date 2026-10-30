# 📚 BookHub

BookHub, kullanıcıların kitaplarını ekleyip birbirleriyle takas edebildiği bir kitap paylaşım platformudur. PHP (OOP + PDO) ve MySQL ile geliştirilmiştir.

![Ana sayfa](docs/screenshots/home.png)

## Özellikler

- Kullanıcı kayıt ve giriş sistemi
- Kitap ekleme, düzenleme, silme ve görsel yükleme
- Kategoriler, arama, filtreleme ve sayfalama
- Favorilere ekleme / çıkarma
- Kullanıcı profili
- Kitap takas sistemi (teklif, kabul, red, iptal)
- Yönetici paneli: kitap onayı, kategori ve kullanıcı yönetimi

## Teknolojiler

PHP (OOP, PDO) · MySQL / MariaDB · HTML · CSS · Bootstrap 5.3.3 · Bootstrap Icons · XAMPP

## Kurulum

1. Projeyi `C:\xampp\htdocs\BookHub` klasörüne kopyalayın (klasör adı `BookHub` olmalı).
2. XAMPP'te Apache ve MySQL'i başlatın.
3. phpMyAdmin'de `bookhub` adlı bir veritabanı oluşturup `database/bookhub.sql` dosyasını içe aktarın.
4. `backend/Database.class.php` içindeki veritabanı bilgilerini kendinize göre düzenleyin.
5. Tarayıcıdan `http://localhost/BookHub/` adresini açın.

> Admin yapmak için kayıt olduktan sonra phpMyAdmin'de `users` tablosunda ilgili kullanıcının `user_type` değerini `admin` olarak değiştirin.

## Geliştirici

**Adınız Soyadınız** · [@kadiryarar](https://github.com/kadiryarar)