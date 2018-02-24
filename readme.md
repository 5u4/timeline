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
	"name": "admin",
	"password": "password",
	"password_confirmation": "password"
}
```

##### Response

200 OK:

```
{
    "data": {
        "id": 1,
        "name": "admin"
    },
    "api_token": "QdSMiv2KOoWkVt6j"
}
```

409 CONFLICT:

```
{
    "data": {
        "name": [
            "The name has already been taken."
        ]
    }
}
```

