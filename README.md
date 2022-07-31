## Proje Hakkında
iOS ya da Google mobile application’lar bu API’ı kullanarak 
satın alma ya da doğrulama yapabilmesi kurgulanmıştır.

Proje geliştirilirken Docker, Laravel, Horizon, Supervisor kullanılmıştır.

### Port bilgileri
`app`   => `http://localhost:8086`\
`mysql` => `3030`

## Kurulum

Öncelikle projemizi repomuzdan çekelim.

`git clone https://github.com/mehmetcanyildiz/teknasyon-c.git`

Daha sonra docker ımızın konfigürasyonlarını build edelim.

`docker-compose build`

Build işlemini sorunsuz hallettikten sonra dockerımızı ayaklandırmak için aşağıdaki komutu kullanalım.

`docker-compose up -d`

Docker php cli’ne girerek projemizin ayarlarını ve gerekli kütüphanelerin kurulumu için aşağıdaki komutları sırasıyla yapalım.
```
composer update
cp .env.example .env
php artisan key:generate
```
Veritabanını import etmek için ister aşağıdaki komutu kullanabilir, isterseniz paylaşılan sql’i mysqlimize import edebilirsiniz.

`php artisan migrate --seed`

[database.sql](https://github.com/mehmetcanyildiz/teknasyon-c/blob/main/database.sql)

Evet şimdi her şey hazır test aşamasına geçebiliriz.

## Test
Postman için ekte sunduğum json dosyasını import yapalım.

[postman_collection.json](https://github.com/mehmetcanyildiz/teknasyon-c/blob/main/postman_collection.json)

### Api
Endpointlerimiz 4 ana başlıkta toplanır.

* Apps
* Devices
* Purchases
* Reports

**Apps**

* App oluşturma, güncelleme, silme ve listeleme işlemlerini yapabilirsiniz.
* Toplu listeleme için sayfalama kullanılmıştır. Sayfa geçişi için `?page=2` parametresini kullanabilirsiniz.
* App device ve purchase relation barındırmaktadır. Herhangi bir app’in silinmesi durumunda altındaki tüm devicelar ve purchaselar temizlenir.

**Devices**

* Device oluşturma, güncelleme,silme ve listeleme işlemlerini yapabilirsiniz.
* Aynı uid ye sahip device 1 uygulamaya sadece 1 kez kayıt olabilir. Eğer kayıtlısa veritabanı kaydı kullanıcıya geri döndürülür.

**Purchases**

* Purchase satın alma işlemi, abonelik kontrolü ve listeleme işlemlerini yapabilirsiniz.
* Satın alma işlemi geliştirilen mock tarafından kontrol edilir. Eğer android ise son değerinin tekil, ios için çoğul olmasına bakılır. 
* Duruma göre eventlar tetiklenir. `Canceled,Renewed,Started`

Callback kısmında detaylı açıklanmıştır.

**Reports**
* Uygulamaların sahip olduğu device listesi ve bu cihazların platform ve abonelik durumlarının filtreleme yapılarak tekil yada çoğul olarak raporlandığı kısımdır.

### Callback

Mevcut aboneliğin kontrolü sırasında mock’un cevabına göre 3 adet eventdan ilgili olanı tetikler.

**Types**
* Canceled
* Renewed
* Started

Tetiklenen event ilgili appdeki callback url’ine (type,app_id,uid) datalarını ekleyerek basit bir post işlemi yapar.

### Worker

* Command Schedule da tanımlanmış olan job her dakika(test için) aktif alan tüm purchase datalarını expire_time larına göre tarayarak gerekli ödemelerin doğrulanmasını ve kontrol edilmesi için bir kuyruğa tanımlar.
* Horizon yardımıyla workerlarının çalışma konfigürasyonlarını değiştirebilir yük dağılımını canlı ya da local sisteminize göre ayarlayabilirsiniz.
* İsterseniz horizon dashboard da workerların çalışma durumlarını analiz edebilirsiniz.

#### Horizon Yapılandırma Bilgileri
Horizon’un dosyasını yapılandırmak için `config/horizon.php` dosyasını açmalısınız.

* `minProcesses` ve `maxProcesses` işçinin işleme aldığı iş adetini belirlenir.
* `balanceMaxShift` ve `balanceCooldown` iş parçacıklarını ölçeklendirme için kullanılır.
* `tries` iş parçacığında hata oluşması durumunda kaç defa tekrar denenmesi gerektiğini belirtir.
