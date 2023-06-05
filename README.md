# job-batch-laravel 

This simple example for how laravel deals with a huge data 

## Installation Steps

1. Clone the repository.
2. Create a MySQL database with your favorite name ex:"blogs".
3. Run the following commands:

```
composer install
```

```
cat .env.example > .env
```

```
php artisan key:generate
```

4. Customize the vars in the `.env` file with your database info.
5. Run migration and seed:

```
php artisan migrate
```

6. open queue works

```
php artisan queue:work

```

7. Start the application:

```
php artisan serve
```

## how it works

you can go to:

```
127.0.0.1/users
```

and this will add 500K users in 10 or less seonds, Please check the code in UserController of how it done to understand what happened
## Donation

If you find this helpful, consider buying me a coffee :)

<center>

[![QR Code for Donation](https://github.com/islamsamy214/admin-laravel-vue-bootstrap/blob/master/public/bmc_qr.png?raw=true)](https://www.buymeacoffee.com/islamsamy)

</center>