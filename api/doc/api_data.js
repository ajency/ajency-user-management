define({ api: [
  {
    "type": "get",
    "url": "/roles",
    "title": "Request system roles",
    "name": "GetRoles",
    "group": "Roles",
    "version": "0.1.0",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "field": "roles",
            "optional": false,
            "description": "<p>All system roles</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "field": "message",
            "optional": false,
            "description": "<p>(optional) Error message</p>"
          }
        ]
      }
    },
    "filename": "./aj-system-roles.php"
  },
  {
    "type": "post",
    "url": "/role/:role-slug",
    "title": "Return role",
    "name": "Get_Role",
    "group": "Roles",
    "version": "0.1.0",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "field": "role",
            "optional": false,
            "description": "<p>Role object</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "field": "message",
            "optional": false,
            "description": "<p>(optional) Error message</p>"
          }
        ]
      }
    },
    "filename": "./aj-system-roles.php"
  },
  {
    "type": "post",
    "url": "/roles",
    "title": "Create new role",
    "name": "New_Role",
    "group": "Roles",
    "version": "0.1.0",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "field": "role",
            "optional": false,
            "description": "<p>New Role</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "field": "message",
            "optional": false,
            "description": "<p>(optional) Error message</p>"
          }
        ]
      }
    },
    "filename": "./aj-system-roles.php"
  },
  {
    "type": "delete",
    "url": "/role/:role-slug",
    "title": "Delete role",
    "name": "Remove_Role",
    "group": "Roles",
    "version": "0.1.0",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "field": "message",
            "optional": false,
            "description": "<p>(optional) Error message</p>"
          }
        ]
      }
    },
    "filename": "./aj-system-roles.php"
  },
  {
    "type": "put",
    "url": "/role/:role-slug",
    "title": "update role",
    "name": "Update_Role",
    "group": "Roles",
    "version": "0.1.0",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "field": "role",
            "optional": false,
            "description": "<p>Updated Role object</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Int",
            "field": "code",
            "optional": false,
            "description": "<p>Response code</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "field": "message",
            "optional": false,
            "description": "<p>(optional) Error message</p>"
          }
        ]
      }
    },
    "filename": "./aj-system-roles.php"
  }
] });