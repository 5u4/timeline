# Time Line

## Description

## Functions

## Installation

## API Request/Response

### User

---

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

---

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

---


### Event

---

#### Index

**GET /api/v1/tags**

Content-Type: application/json

Authorization: Bearer {api_token}

##### Response

```
{
    "data": [
        {
            "id": 1,
            "name": "test",
            "description": null,
            "date": null,
            "done": 0
        }
    ]
}
```

---

#### Create

Note: `descripition`, `date`, `done` are optional.

**POST /api/v1/events**

Content-Type: application/json

Authorization: Bearer {api_token}

##### Request

```
{
	"name": "test",
	"description": "test event",
	"date": "2018-02-25"
}
```

##### Response

```
{
    "data": {
        "id": 1,
        "name": "test",
        "description": "test event",
        "date": "2018-02-25",
        "done": null
    }
}
```

---

#### Edit

Note: `name`, `descripition`, `date`, `done` are optional.

**PUT /api/v1/events/{event_id}**

Content-Type: application/json

Authorization: Bearer {api_token}

##### Request

```
{
	"name": "alter name",
	"description": "test event",
	"date": "2018-02-25",
	"done": true
}
```

##### Response

```
{
    "name": "alter name",
    "description": "test event",
    "date": "2018-02-25",
    "done": true
}
```

---

#### Show Event Tags

**GET /api/v1/events/{event_id}/tags**

Content-Type: application/json

Authorization: Bearer {api_token}

##### Response

```
{
    "data": [
        {
            "id": 1,
            "name": "test",
            "color": "FFFFFF"
        }
    ]
}
```

---

#### Tag Event

**POST /api/v1/events/{event_id}/tags**

Content-Type: application/json

Authorization: Bearer {api_token}

##### Request

```
{
	"event_id": 1,
	"tag_ids": [1, 3, 4]
}
```

##### Response

```
{
    "event_id": 1,
    "tag_id": [
        1,
        3,
        4
    ]
}
```

---

### Tag

---

#### Index

**GET /api/v1/tags**

Content-Type: application/json

Authorization: Bearer {api_token}

##### Response

```
{
    "data": [
        {
            "id": 1,
            "name": "test",
            "color": "000000"
        }
    ]
}
```

---

#### Create

**POST /api/v1/tags**

Content-Type: application/json

Authorization: Bearer {api_token}

##### Request

```
{
	"username": "admin",
	"name": "test",
	"color": "FFFFFF"
}
```

##### Response

```
{
    "data": {
        "id": 1,
        "name": "test",
        "color": "FFFFFF"
    }
}
```

---

#### Edit

Note: `name`, `color` are optional.

**PUT /api/v1/tags/{tag_id}**

Content-Type: application/json

Authorization: Bearer {api_token}

##### Request

```
{
	"name": "rename",
	"color": "FFFFFF"
}
```

##### Response

```
{
    "data": {
        "name": "rename",
        "color": "FFFFFF"
    }
}
```

---

#### Show Tag Events

**GET /api/v1/tags/{tag_id}/events**

Content-Type: application/json

Authorization: Bearer {api_token}

##### Response

```
{
    "data": [
        {
            "id": 1,
            "name": "alter name",
            "description": "test event",
            "date": "2018-02-25",
            "done": 1
        }
    ]
}
```

---
