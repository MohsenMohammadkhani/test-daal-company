<p dir="rtl">
ابتدا دو دیتابیس در mySql به نام های test_daal_company و test_daal_company_test   بسازید و متغییرهای mysql خود password , user , port , host را  بعد از ساختن فایل  env ,  وارد فایل  env  کنید.
دستورات زیر را بعد از clone کردن پروژه وارد کنید.
</p>
<pre>
composer install 

cp .env.example .env

php artisan key:generate

php artisan migrate
php artisan migrate --database="mysql_testing"

php artisan test

php artisan serve
</pre>
<p dir="rtl">
برای اجرا job روزانه خود دستور زیر را وارد کنید
</p>
<pre>
php artisan schedule:work
</pre>
<p dir="rtl">
با استفاده از دستورات زیر میتوانید کاربر تستی بسازید
</p>
<pre>
php artisan tinker
User::factory()->count(3)->create()
</pre>
<p dir="rtl">
آدرس ها در فایل api فولدر routes موجود است.
</p>
<pre>
get localhost:8000/api/v1/user/{userID}/get-balance
post localhost:8000/api/v1/user/add-money
</pre>
