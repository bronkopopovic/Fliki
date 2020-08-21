# Fliki

A flat-file, headless, API-driven Wiki application.
The only exception the the flat-file paradigm is the SQLite database for storing users. (May be replaced with an Eloquent filesystem driver)

## Installation

- Install packages:
```
$ composer install
```

- Create an .env file (if you don't have one yet) and add at least a crypt key:
```
$ cp .env.example .env
```

- If you don't have an existint Fliki database, create a new one:
```
$ touch /database/database.sqlite
```

- If you don't have an existing auth secret in your .env create a new one:
```
$ php artisan jwt:secret
```

- Migrate the database:
```
$ php artisan migrate
```

- If this is a fresh database, run the seeder. This will create a new user named "admin" with the default password "admin":
```
$ php artisan db:seed
```
