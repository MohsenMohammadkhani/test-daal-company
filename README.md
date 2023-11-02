<p dir="rtl">
ابتدا دو دیتابیس در mySql به نام های test_daal_company و test_daal_company_test   بسازید و متغییرهای mysql خود password , user , port , host را  بعد از ساختن فایل  env ,  وارد فایل  env  کنید.
دستورات زیر را بعد از clone کردن پروژه وارد کنید.
</p>

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate
php artisan migrate --database="mysql_testing"

php artisan test

php artisan serve

<p dir="rtl">
برای اجرا job روزانه خود دستور زیر را وارد کنید
</p>
php artisan schedule:work
