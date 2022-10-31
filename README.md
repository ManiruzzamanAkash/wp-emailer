# WP Emailer
A WordPress starter plugin using Vue JS framework (Vue 3) to work with Vuex, Vue router, i18n, PHP OOP, PHPUnit test, table, pagination, settings, graphs and so many.

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

# Start development mode server (if needs).
npm run dev

# Build scripts (if needs).
npm run build
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

## PHP Unit test + PHPCS Check

```sh
composer run test:all
```
![Composer run test:all command](https://i.ibb.co/C5HfHKB/Composer-run-test.png "Composer run test:all command").




## JavaScript Lint error

```sh
npm run lint
```


## How to build plugin zip

### Single release command

```sh
npm run release
```
After running these commands, a zip file named - `wpemailer.zip` will be generated at `dist/` folder.

### One by one commands Optional (if needs)
```sh
npm run build
npm run version
npm run makepot
npm run zip
```

## Demo previews
### Settings Page
![Settings Page](https://i.ibb.co/H78Nmv9/01-Settings-Page.png "Settings Page").

### List Page
![List Page](https://i.ibb.co/ykhKQd1/02-List-Page.png "List Page").

### Graph Page
![Graph Page](https://i.ibb.co/x3cTBDL/03-Graph-Page.png "Graph Page").

### Skeleton Loader for Settings
![Skeleton Loader for Settings](https://i.ibb.co/SvBX57x/04-Settings-loading.png "Skeleton Loader for Settings").

### Skeleton Loader for Table
![Skeleton Loader for Table](https://i.ibb.co/vkLHvmp/05-Table-loading.png "Skeleton Loader for Table").

## Contact with me
manirujjamanakash@gmail.com
