# SЁCU

<p align="center">
<img src="https://user-images.githubusercontent.com/1849174/72083735-5dd72f00-3313-11ea-9ea1-1a5b57548232.png">
</p>

[![Gitter chat](https://badges.gitter.im/secusu/secusu.svg)](https://gitter.im/secusu/secusu)
[![Build Status](https://travis-ci.org/secusu/secusu.svg)](https://travis-ci.org/secusu/secusu)
[![Latest Stable Version](https://poser.pugx.org/secu/secu/version)](https://packagist.org/packages/secu/secu)
[![License](https://poser.pugx.org/secu/secu/license)](https://github.com/secusu/secusu/blob/master/LICENSE)

## Introduction

[SЁCU](https://secu.su/) is a public API to store self-destructing data payloads.
This repository includes only backend part using Laravel framework.

Frontend could be found in [SЁCU web application repository](https://github.com/secusu/web-app).

## Contents

- [Features](#features)
- [Configuration](#configuration)
- [Installation](#installation)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Testing](#testing)
- [Security](#security)
- [Contributors](#contributors)
- [License](#license)
- [About CyberCog](#about-cybercog)

## Features

- Uses only free open source libraries
- Uses [Stanford Javascript Crypto Library](https://github.com/bitwiseshiftleft/sjcl)
- Send password protected self-destructing data packages
- Real-time encrypted chat server on node.js
- Telegram bot for generate SЁCU records right from the Telegram
- Following PHP Standard Recommendations:
  - [PSR-1 (Basic Coding Standard)](http://www.php-fig.org/psr/psr-1/)
  - [PSR-2 (Coding Style Guide)](http://www.php-fig.org/psr/psr-2/)
  - [PSR-4 (Autoloading Standard)](http://www.php-fig.org/psr/psr-4/)
- Covered with unit tests

## Configuration

Create environment configuration file from example

```sh
$ cp .env.example .env
```

Specify your environment parameters in `.env` file 

```
$ vi .env
```

## Installation

Install PHP dependencies

```sh
$ composer install
```

Generate application secret key

```sh
$ php artisan key:generate
```

Perform database migrations

```sh
$ php artisan migrate
```

If you need to run node.js chat server install JavaScript dependencies

```sh
$ npm install
```

### Add CRON entry to your OS

```
* * * * * php /path/to/secu/artisan schedule:run >> /dev/null 2>&1
```

This will run schedule commands every minute. Schedule will delete outdated records.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please refer to [CONTRIBUTING.md](https://github.com/secusu/secusu/blob/master/CONTRIBUTING.md) for information on how to contribute to SЁCU and its related projects.

## Testing

Run the tests with:

```sh
$ vendor/bin/phpunit
```

## Security

If you discover any security related issues, please email open@cybercog.su instead of using the issue tracker.

## Contributors

| <a href="https://github.com/antonkomarev">![@antonkomarev](https://avatars.githubusercontent.com/u/1849174?s=110)<br />Anton Komarev</a> |  
| :---: |

[SЁCU contributors list](../../contributors)

## License

The SЁCU application is an open-sourced software licensed under the [BSD 3-Clause License](https://opensource.org/licenses/BSD-3-Clause).

## About CyberCog

[CyberCog](https://cybercog.su) is a Social Unity of enthusiasts. Research best solutions in product & software development is our passion.

- [Follow us on Twitter](https://twitter.com/cybercog)
- [Read our articles on Medium](https://medium.com/cybercog)

<a href="https://cybercog.su"><img src="https://cloud.githubusercontent.com/assets/1849174/18418932/e9edb390-7860-11e6-8a43-aa3fad524664.png" alt="CyberCog"></a>
