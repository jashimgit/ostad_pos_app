##  OSTAD POS Application 


`This application is built with Laravel 10`



Task completed: Phase 1

1. Register an user
2. Login user
3. Reset password using OTP verification
4. Using JWT token user verified



Task Phase 2:

1. Planning Product category table by profile
2. category managing back-end development
3. category managing front-end development

-- category list page done
-- category delete done


Tash Phase 3:

1. Planning Customer Table
2. Customer Managing back-end development
3. Customer managing front-end development




`Important Note for Developers`

Here I have done CustomerFactory for the first time. 

command: `php artisan make:factory CustomerFactory`
now check database > factories folder, do change you need.

how to run a specific factory file?
php artisan tinker

\APP\Models\Customer::factory()->count(20)->create()

you are done, let's check database. Enjoy using factory.
