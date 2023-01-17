## Installation

1. Clone the repo and `cd` into it
2. Rename or copy `.env.example` file to `.env`
3. Set your database credentials in your `.env` file
4. `composer install`

[//]: # (6. Set your Stripe credentials in your `.env` file. Specifically `STRIPE_KEY` and `STRIPE_SECRET`)
[//]: # (7. Set your Algolia credentials in your `.env` file. Specifically `ALGOLIA_APP_ID` and `ALGOLIA_SECRET`. See [this episode]&#40;https://www.youtube.com/watch?v=Sa0R_2aHICw&index=22&list=PLEhEHUEU3x5oPTli631ZX9cxl6cU_sDaR&#41;.)
[//]: # (8. Set your Braintree credentials in your `.env` file if you want to use PayPal. Specifically `BT_MERCHANT_ID`, `BT_PUBLIC_KEY`, `BT_PRIVATE_KEY`. See [this episode]&#40;https://www.youtube.com/watch?v=pv8pxwBxfA4&#41;. If you don't, it should still work but won't show the paypal payment at checkout.)

[//]: # (10. Set `ADMIN_PASSWORD` in your `.env` file if you want to specify an admin password. If not, the default password is 'password')
[//]: # (11. `php artisan ecommerce:install`. This will migrate the database and run any seeders necessary. See [this episode]&#40;https://www.youtube.com/watch?v=L3EbWJmmyjo&index=18&list=PLEhEHUEU3x5oPTli631ZX9cxl6cU_sDaR&#41;.)
6. `npm install`
7. `npm run dev`
8. `php artisan storage:link`
9. If use docker, exec workspace `chown -R laradock:laradock /var/www`
10. `php artisan key:generate`

[//]: # (10. chmod && chown upload file: `chmod 755 -R public/img` `chown -R www-data:www-data public/img` )
[//]: # (9. `php artisan app:migrate-product-variant` to update database)

## Config .env
1. APP_ENV (https request)
2. APP_URL
3. APP_LOCATE
4. APP_CURRENCY
5. MIX_APP_CURRENCY
6. DC_SECRET_ACCESS_KEY
7. DC_ACCESS_KEY_ID
8. DC_BASE_URL

#### Message by Sendbird
MIX_BASE_API_URL= your url
SENDBIRD_APPLICATION_ID=DBF8BFAF-A834-4045-AB56-D270B894C68C
SENDBIRD_API_TOKEN=17d34c5680e675f119e6ac1977264cd6872d884c
MIX_SENDBIRD_APPLICATION_ID=DBF8BFAF-A834-4045-AB56-D270B894C68C

#### Xendit
XENDIT_DOMAIN=
XENDIT_API_KEY=

#### Login with social
FACEBOOK_APP_ID =
FACEBOOK_APP_SECRET =
FACEBOOK_APP_CALLBACK_URL =

GOOGLE_APP_ID =
GOOGLE_APP_SECRET =
GOOGLE_APP_CALLBACK_URL =

## Multiple Language
to update language in Vuejs

`php artisan vue-i18n:generate`

## Windows Users - money_format() issue

The `money_format` function does not work in Windows. Take a look at [this thread](https://stackoverflow.com/questions/6369887/alternative-to-money-format-function-in-php-on-windows-platform/18990145). As an alternative, just use the `number_format` function instead.

1. In `app/helpers.php` replace `money_format` line with `return '$'.number_format($price / 100, 2);`
1. In `app/Product.php` replace `money_format` line with `return '$'.number_format($this->price / 100, 2);`
1. In `config/cart.php` set the `thousand_seperator` to an empty string or you might get a 'non well formed numeric value encountered' error. It conflicts with `number_format`.

