# Kurulum

Aşağıdaki kurulum için bilgisayarınızda kurulu olması gereken uygulamalar:

- [Docker](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/downloads)
- [Composer](https://getcomposer.org/download/)

---

```
git clone https://github.com/atess/ideasoft-app.git
```
```
cd ideasoft-app
```
```
composer install --ignore-platform-reqs
```

###### Kurulumdan sonra oluşturulan docker container içerisinde tüm sistem gereksinimleri karşılanmaktadır.

---

### Lütfen devam etmeden önce aşağıdaki portların kullanımda olmadığına emin olunuz.

#### Başlatılacak servisler
| App                |  Port |    Version    | Host                                                                    |
|--------------------|:-----:|:-------------:|-------------------------------------------------------------------------|
| php - Ideasoft API |   81  |      8.1      | http://localhost:81                                                     |
| phpMyAdmin         |  8081 |     5.1.2     | http://localhost:8181                                                   |
| Redis              |  6380 | redis:alphine | host.docker.internal:6380                                               |
| MySQL              |  3307 |      8.0      | host.docker.internal:3307                                               |



---
### macOS
```
./vendor/bin/sail up -d
```
```
./vendor/bin/sail shell
```
### Windows
```
bash ./vendor/bin/sail up -d
```
```
bash ./vendor/bin/sail shell
```

---

`bash ./vendor/bin/sail shell` komutunu çalıştırarak oluşturulan container'ın komut satırına giriş yaptıktan sonra aşağıdaki komut ile veritabanında olması gereken tablo ve verileri oluşturun.
```
php artisan migrate --seed
```

### Test
```
php artisan test
```

### Routes
```
php artisan route:list
```

### PHPStan check code quality
```
./vendor/bin/phpstan analyse src
```



# Durdurma / Çıkış
```
exit
```

### macOS
```
./vendor/bin/sail down
```

### Windows
```
bash ./vendor/bin/sail down
```

## Açıklama
- Domain Driven Design architecture kullanıldı.
- Service ve Repository katmanları arasına Cache katmanı eklendi. (Redis tagged).

Not: Yeni bir discount rule eklemek için inceleyiniz `src/Support/DiscountHelper.php` `database/seeders/DiscountSeeder.php`

Tüm endpointlere modelin durumuna göre created_by, updated_by, deleted_by ve timestamps alanları için filtreleme, sıralama ve relation yüklemesi otomatik olarak izin verilen parametrelere eklenmektedir. [spatie/laravel-query-builder](https://github.com/spatie/laravel-query-builder) temel alınmıştır.

##### Örnek Kullanım
sort = id (asc) OR sort = -id (desc)
```
/api/users?filter[created_by]=1&sort=-id&filter[trashed]=with&include=updatedBy,createdBy,deletedBy
```

