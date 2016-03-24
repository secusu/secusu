# SЁCU

[![Join the chat at https://gitter.im/secusu/secusu](https://badges.gitter.im/secusu/secusu.svg)](https://gitter.im/secusu/secusu?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Sёcu is a public API to store self-destructing data payloads.

## Configuration

```sh
cp .env.example .env
vi .env
```

## Installation

```sh
composer install
php artisan key:generate
php artisan migrate
```

### Add CRON entry to your cron jobs

```sh
* * * * * php /path/to/secu/artisan schedule:run >> /dev/null 2>&1
```

## Contributing

Please refer to [CONTRIBUTING.md](https://github.com/secusu/secusu/blob/master/CONTRIBUTING.md) for information on how to contribute to Sёcu and its related projects.

## License

The Sёcu application is open-sourced software licensed under the [BSD 3-Clause License](https://opensource.org/licenses/BSD-3-Clause).
