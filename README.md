# SЁCU

[![Gitter chat](https://badges.gitter.im/secusu/secusu.svg)](https://gitter.im/secusu/secusu?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
[![Build Status](https://travis-ci.org/secusu/secusu.svg)](https://travis-ci.org/secusu/secusu)
[![Latest Stable Version](https://poser.pugx.org/secu/secu/version)](https://packagist.org/packages/secu/secu)
[![License](https://poser.pugx.org/secu/secu/license)](https://packagist.org/packages/secu/secu)

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
