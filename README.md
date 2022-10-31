# WP Emailer
A WordPress plugin using Vue JS framework to work with email settings.

---

## Installation

```sh
git clone https://github.com/ManiruzzamanAkash/wp-emailer.git

# Go to that plugin folder
cd wp-emailer

# Install composer dependencies.
composer install

# Install npm dependencies.
npm install
```

## PHP Coding Standard check and fix

```sh
# Check if any PHPCS issues found.
composer run phpcs

# Fix any possible PHPCS issues.
composer run phpcs:fix
```

## PHP Unit test

Create a test database called - `wp_phpunit_wpvue` (Only for `phpunit-test`. Not for development or production.)
Or, configure this from `/tests/phpunit/wp-config.php` file.

```sh
composer run test
```

## PHP Unit test + PHPCS CHeck

```sh
composer run test:all
```

## JavaScript Lint error

```sh
npm run lint
```


## How to build plugin zip -

```sh
npm run build
npm run version_replace
npm run makepot
npm run zip
```