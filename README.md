## About Package

Simple JWT Auth that provide two routes `/login` and `/me`

## Configuration

Add a guard named `api` with a driver `api` to `config/auth.php`.

Example:
```
'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        "api" => [
            'driver' => 'api'
        ]
        ...
    ],
```


## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
