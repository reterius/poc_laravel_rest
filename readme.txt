
Kurulum öncesi adımlar:
1) Sunucunuza php çalıştırabilmek için gerekli ortamları kurmalısınız, pratik olması açısından xampp kurabilirsiniz.
2) composer kurulumu yapılmalı

Kurulum adımları:
Önce proje klasörü içine gelip, cd poc_laravel_rest/ ;
1) composer install (Eğer mount edilen bir disk üzerinde projeyi çalıştırıyorsanız:
 vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php dosyasını açın, 
 Bu satırı: return file_put_contents($path, $contents, $lock ? LOCK_EX : 0) bulun
 Bununla: return file_put_contents($path, $contents, $lock ? LOCK_SH : 0) değiştirin)
2) php artisan key:generate
3) php artisan migrate
4) php artisan db:seed
5) php artisan passport:install
6) php artisan serve

TEST:

Örnek olarak Authentication için yazdığım testler tests/Feature/AuthenticationTest.php dosyasındadır.
 - test_must_enter_email_and_password testi: Email ve password girilmeme durumunu durumunu test eden methoddur
 - test_unauthorised_user_login testi: email ya da password yanlış girilmesi durumundaki senaryonun testidir
 - test_activate_email_validation_error testi: email aktivasyon kodunun yanlış girilmesi durumundaki senaryonun testidir
 - test_activate_email_successfully testi: email aktivasyon kodunun doğru girilmesi durumundaki senaryonun testidir
 - test_activate_email_already_email_activated testi: daha önce başarılı bir şekilde aktive edilmiş bir emaili tekrar aktive etmeye çalışma senaryosunun testidir.


Testi çalıştırmak için:

1) Testler için test veritabanını kullanmalıyız. Bunun için config/database.php dosyasında 
Bu satırı  'database' => env('DB_DATABASE', database_path('rest-api.sqlite')) bulun, 
Bununla  'database' => env('DB_DATABASE', database_path('rest-api-test.sqlite')) değiştirin.
2) terminalden proje klasörü içinde vendor/bin/phpunit komutunu çalıştırın


EK BİLGİLER:
app/Helpers/Helper.php dosyası proje için genel kullanılan methodların helper dosyasıdır.

Twitter api erişim bilgileri:

.env dosyası içinde bulunan aşağıdaki bilgiler tweetter api erişim bilgileridir.
TWITTER_CONSUMER_KEY=TxY9XLWV2FzybUGHZxK8L6AIx
TWITTER_CONSUMER_SECRET=YbWe7bl5xfWwJTzXpQDUEVBlC1iwVRoxc33mgX4B43chqOf35Z
TWITTER_ACCESS_TOKEN=407230209-W8aQNtXyfjoVbZV6YaxwxLsHmXmNJyaJtCTqpEm0
TWITTER_ACCESS_TOKEN_SECRET=uI9YuclYcxHpn778VK7gRkky3OMbqNJ1JCzRWcqRe688H

Endpoint dökümantasyonu: https://documenter.getpostman.com/view/5458897/TVeiEWZe



