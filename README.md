# Fliki

A flat-file, headless, API-driven Wiki application built with [Laravel Lumen](https://lumen.laravel.com).
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

## Endpoints


- ### Login
#### `POST /api/auth/login`
Query parameters:
```
email
password
```
Returns:
```
{
    "access_token": "xxxxx",
    "token_type": "bearer",
    "expires_in": 259200
}
```

- ### Logout
#### `POST /api/auth/logout`
```
Authorization: Bearer <access_token>
```

- ### Refresh
#### `POST /api/auth/refresh`
```
Authorization: Bearer <access_token>
```

- ### Me
#### `POST /api/auth/me`
```
Authorization: Bearer <access_token>
```
Returns:
```
{
    "id": 1,
    "name": "admin",
    "email": "admin@admin.com",
    "is_admin": "1",
    "created_at": "2020-08-29T19:15:37.000000Z",
    "updated_at": "2020-08-29T19:15:37.000000Z"
}
```

- ### Create User
#### `POST /api/user/create`
```
Authorization: Bearer <access_token>
```
Query parameters:
```
email
password
name
is_admin
```
Returns:
```
{
    "message": "User saved",
    "id": 2
}
```

- ### Edit User
#### `POST /api/user/edit`
```
Authorization: Bearer <access_token>
```
Query parameters:
```
id
email
password
name
is_admin
```
Returns:
```
{
    "message": "User saved",
    "id": 2
}
```

- ### Delete User
#### `POST /api/user/delete`
```
Authorization: Bearer <access_token>
```
Query parameters:
```
id
```

- ### Get User
#### `GET /api/user/:id`
```
Authorization: Bearer <access_token>
```
Returns:
```
{
    "id": 1,
    "name": "admin",
    "email": "admin@admin.com",
    "is_admin": "1",
    "created_at": "2020-08-29T19:15:37.000000Z",
    "updated_at": "2020-08-29T19:15:37.000000Z"
}
```

- ### Get all Users
#### `GET /api/users`
```
Authorization: Bearer <access_token>
```
Returns:
```
[{
    "id": 1,
    "name": "admin",
    "email": "admin@admin.com",
    "is_admin": "1",
    "created_at": "2020-08-29T19:15:37.000000Z",
    "updated_at": "2020-08-29T19:15:37.000000Z"
},{
    ...
},{
    ...
}]
```

- ### Get page
#### `GET /api/page`
```
Authorization: Bearer <access_token>
```
Query parameters:
```
path
```
Returns:
```
{
  "title": "test",
  "content": "# test"
}
```

- ### Create Page
#### `POST /api/page/create`
```
Authorization: Bearer <access_token>
```
Query parameters:
```
title
path
content 
```

- ### Get File Tree
#### `GET /api/page/tree`
```
Authorization: Bearer <access_token>
```
Returns:
```
{
    "pages": {
        "data": {
            "type": "file",
            "path": "pages\/test.md",
            "timestamp": 1598729783,
            "size": 6,
            "dirname": "pages",
            "basename": "test.md",
            "extension": "md",
            "filename": "test"
        },
        "children": {
            "test.md": {
                "data": {
                    "type": "file",
                    "path": "pages\/test.md",
                    "timestamp": 1598729783,
                    "size": 6,
                    "dirname": "pages",
                    "basename": "test.md",
                    "extension": "md",
                    "filename": "test"
                },
                "children": null
            }
        }
    }
}
```
