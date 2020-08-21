# Fliki

A flat-file, headless, API-driven Wiki application.
The only exception to the flat-file paradigm is the SQLite database for storing users. (May be replaced with an Eloquent filesystem driver)

## Installation

- Install packages:
```
$ composer install
```

- Create an .env file (if you don't have one yet) and add at least a crypt key:
```
$ cp .env.example .env
```

- If you don't have an existing Fliki database, create a new one:
```
$ touch /database/database.sqlite
```

- If you don't have an existing auth secret in your .env ("JWT_SECRET") create a new one:
```
$ php artisan jwt:secret
```

- Migrate the database:
```
$ php artisan migrate
```

- If this is a fresh database, run the seeder. This will create a new user (name: admin, email: admin@admin.com, password: admin):
```
$ php artisan db:seed
```
