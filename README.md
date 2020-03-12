## ETF Parse Challenge

#### This guide is assuming that you have Laravel already setup. If you do not, please following the instructions on the [Laravel website](https://laravel.com/docs/7.x).

#### Once you have Laravel installed, please run the following commands:
- `php artisan migrate`.
- `php artisan passport:install`.
- `php artisan parse:etfs`.
- `php artisan queue:listen`.

#### Testing with Postman
A Postman collection has been included under `app\documentation`. To test the app after it's been setup and data populated, perform the steps below:
- Ensure the URL matches your environment.
- Go to the `Sign Up` request and hit send.
- Go to the `Login` request and hit send. An `access_token` will be returned to you if successful.
- Using the `access_token` that was given on the previous step, use it to then access the `List All ETFs` or `ETF By Symbol` api by updating the bearer token in Postman.
