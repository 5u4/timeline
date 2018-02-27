# User

## Index

Note: Admin Only

**GET /api/v1/users**

Authorization: Bearer {api_token}

### Response

```
{
    "data": [
        {
            "username": "admin"
        },
        {
            "username": "admin2"
        }
    ]
}
```

## Index Trashed

Note: Admin Only

**GET /api/v1/users/trashed**

Authorization: Bearer {api_token}

### Response

```
{
    "data": [
        {
            "username": "admin2",
            "deleted_at": {
                "date": "2018-02-26 07:20:27.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    ]
}
```

## Register

**POST /api/v1/users/register**

Content-Type: application/json

### Request

```
{
	"username": "admin",
	"password": "password",
	"password_confirmation": "password"
}
```

### Response

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

## Login

**POST /api/v1/users/login**

Content-Type: application/json

### Request

```
{
	"username": "admin",
	"password": "password"
}
```

### Response

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

## Change Password

**PUT /api/v1/users/password**

Content-Type: application/json

### Request

```
{
	"username": "admin",
	"password": "password",
	"new_password": "newpassword",
	"new_password_confirmation": "newpassword"
}
```

### Response

```
{
    "data": {
        "username": "admin"
    },
    "api_token": "SvDAxnwYGMxIu7no"
}
```

## Self Soft Delete

**DELETE /api/v1/users**

Authorization: Bearer {api_token}

### Response

```
{
    "data": {
        "username": "admin",
        "deleted_at": {
            "date": "2018-02-26 06:08:19.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    },
    "api_token": "SvDAxnwYGMxIu7no"
}
```

## Soft Delete

Note: Admin Only

**DELETE /api/v1/users/{username}**

Authorization: Bearer {api_token}

### Response

```
{
    "data": {
        "username": "admin",
        "deleted_at": {
            "date": "2018-02-26 06:08:19.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    },
    "api_token": "SvDAxnwYGMxIu7no"
}
```

## Restore

Note: Admin Only

**PUT /api/v1/users/{username}/restore**

Authorization: Bearer {api_token}

### Response

```
{
    "data": {
        "username": "admin"
    },
    "api_token": "SvDAxnwYGMxIu7no"
}
```

# Event

## Index

**GET /api/v1/events**

Content-Type: application/json

Authorization: Bearer {api_token}

### Response

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

## IndexTrashed

**GET /api/v1/events/trashed**

Content-Type: application/json

Authorization: Bearer {api_token}

### Response

```
{
    "data": [
        {
            "id": 1,
            "name": "test",
            "description": "test event",
            "date": "2018-02-25",
            "done": 0,
            "deleted_at": {
                "date": "2018-02-26 07:26:07.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    ]
}
```

## Create

Note: `descripition`, `date`, `done` are optional.

**POST /api/v1/events**

Content-Type: application/json

Authorization: Bearer {api_token}

### Request

```
{
	"name": "test",
	"description": "test event",
	"date": "2018-02-25"
}
```

### Response

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

## Edit

Note: `name`, `descripition`, `date`, `done` are optional.

**PUT /api/v1/events/{event_id}**

Content-Type: application/json

Authorization: Bearer {api_token}

### Request

```
{
	"name": "alter name",
	"description": "test event",
	"date": "2018-02-25",
	"done": true
}
```

### Response

```
{
    "name": "alter name",
    "description": "test event",
    "date": "2018-02-25",
    "done": true
}
```

## Show Event Tags

**GET /api/v1/events/{event_id}/tags**

Content-Type: application/json

Authorization: Bearer {api_token}

### Response

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

## Tag Event

**POST /api/v1/events/{event_id}/tags**

Content-Type: application/json

Authorization: Bearer {api_token}

### Request

```
{
	"event_id": 1,
	"tag_ids": [1, 3, 4]
}
```

### Response

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

## Soft Delete

**DELETE /api/v1/events/{event_id}**

Authorization: Bearer {api_token}

### Response

```
{
    "data": {
        "id": 1,
        "name": "test",
        "description": "test event",
        "date": "2018-02-25",
        "done": 0,
        "deleted_at": {
            "date": "2018-02-26 06:30:02.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    }
}
```

## Restore

**PUT /api/v1/events/{event_id}/restore**

Authorization: Bearer {api_token}

### Response

```
{
    "data": {
        "id": 1,
        "name": "test",
        "description": "test event",
        "date": "2018-02-25",
        "done": 0
    }
}
```

# Tag

## Index

**GET /api/v1/tags**

Content-Type: application/json

Authorization: Bearer {api_token}

### Response

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

## Index Trashed

**GET /api/v1/tags/trashed**

Content-Type: application/json

Authorization: Bearer {api_token}

### Response

```
{
    "data": [
        {
            "id": 1,
            "name": "test",
            "color": "FFFFFF",
            "deleted_at": {
                "date": "2018-02-26 07:23:44.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    ]
}
```

## Create

**POST /api/v1/tags**

Content-Type: application/json

Authorization: Bearer {api_token}

### Request

```
{
	"name": "test",
	"color": "FFFFFF"
}
```

### Response

```
{
    "data": {
        "id": 1,
        "name": "test",
        "color": "FFFFFF"
    }
}
```

## Edit

Note: `name`, `color` are optional.

**PUT /api/v1/tags/{tag_id}**

Content-Type: application/json

Authorization: Bearer {api_token}

### Request

```
{
	"name": "rename",
	"color": "FFFFFF"
}
```

### Response

```
{
    "data": {
        "name": "rename",
        "color": "FFFFFF"
    }
}
```

## Show Tag Events

**GET /api/v1/tags/{tag_id}/events**

Content-Type: application/json

Authorization: Bearer {api_token}

### Response

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

## Soft Delete

**DELETE /api/v1/tags/{tag_id}**

Authorization: Bearer {api_token}

### Response

```
{
    "data": {
        "id": 1,
        "name": "test",
        "color": "FFFFFF",
        "deleted_at": {
            "date": "2018-02-26 06:25:39.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    }
}
```

## Restore

**PUT /api/v1/tags/{tag_id}/restore**

Authorization: Bearer {api_token}

### Response

```
{
    "data": {
        "id": 1,
        "name": "test",
        "color": "FFFFFF"
    }
}
```

# Log

**GET /api/v1/logs**

Content-Type: application/json

Authorization: Bearer {api_token}

### Response

```
{
    "data": [
        {
            "id": 2,
            "action": "login",
            "data": null,
            "timestamp": "2018-02-25 19:35:05"
        },
        {
            "id": 1,
            "action": "register",
            "data": null,
            "timestamp": "2018-02-25 19:34:43"
        }
    ]
}
```

### Action Code

```
/* User Actions */
public const REGISTER = 'register';
public const LOGIN = 'login';
public const CHANGE_PASSWORD = 'change_password';
public const DELETE_USER = 'delete_user';
public const RESTORE_USER = 'restore_user';

/* Event Actions */
public const CREATE_EVENT = 'create_event';
public const EDIT_EVENT = 'edit_event';
public const TAG_EVENT = 'tag_event';
public const DELETE_EVENT = 'delete_event';
public const RESTORE_EVENT = 'restore_event';

/* Tag Actions */
public const CREATE_TAG = 'create_tag';
public const EDIT_TAG = 'edit_tag';
public const DELETE_TAG = 'delete_tag';
public const RESTORE_TAG = 'restore_tag';
```

# Test with Postman

## How to use

1. Download [Postman](https://www.getpostman.com/apps)

2. Click `Import` in the left top corner

3. Select `Import From Link` and paste the link

4. `Import`

## Link

https://www.getpostman.com/collections/4009956d9567c5a86092
