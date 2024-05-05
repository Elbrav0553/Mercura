To work with the project
Do a git pull of the project.
Inside the Mercura folder
We will run 
./vendor/bin/sail up

**Once here we can run the tests to see the correct flow.**
./vendor/bin/sail artisan test 

**Or if we want to test from Postman, we will have to run the corresponding migrations and seeder.**

This will create the DB structure
./vendor/bin/sail artisan migrate:fresh

Now we will proceed to create the fake data in order to be able to test 

**QUOTES**
./vendor/bin/sail artisan db:seed --class=QuoteSeeder

**PRODUCT**
./vendor/bin/sail artisan db:seed --class=ProductSeeder
./vendor/bin/sail artisan db:seed --class=ProductTranslationsSeeder

**OPTION**
./vendor/bin/sail artisan db:seed --class=OptionSeeder
./vendor/bin/sail artisan db:seed --class=OptionTranslationsSeeder

I hope everything works well and look forward to any feedback, both positive and negative, in order to improve in all aspects.
