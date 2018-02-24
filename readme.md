# Time Line

## Description

## Functions

## Installation

## API Request/Response

### User

#### Register

**POST /api/v1/users/register**

Content-Type: application/json

##### Request

```
{
	"username": "admin",
	"password": "password",
	"password_confirmation": "password"
}
```

##### Response

200 OK:

```
{
    "data": {
        "username": "admin"
    },
    "api_token": "sqj5U9Ezp03BewmZ"
}
```

409 CONFLICT:

```
{
    "data": {
        "username": [
            "The name has already been taken."
        ]
    }
}
```

#### Login

**POST /api/v1/users/login**

Content-Type: application/json

##### Request

```
{
	"username": "admin",
	"password": "password"
}
```

##### Response

200 OK:

```
{
    "data": {
        "username": "admin"
    },
    "api_token": "sqj5U9Ezp03BewmZ"
}
```

401 UNAUTHORIZED:

```
{
    "data": {
        "message": "Name/Password does not match"
    }
}
```

