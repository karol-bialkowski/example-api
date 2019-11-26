### Features

- create, update and remove products with prices
- support currencies ( now is only PLN and EUR )
- create cart and assign new products

### TODO
- JWT authorization
- RabbitMQ as queue
- Swagger as beautiful api docs



# Docs
This is simple, example REST API. Let`s get started!

All endpoints use `/api` as prefix. Api require only headers **Content-Type: application/json** and send content as json.

You shoud use specific end-points, details below:


### create product

`POST example.com/api/products`

```
{
    "name": "Example Product",
    "price": "1002"
}
```

**Example response**
```
{
    "status": true,
    "payload": {
        "product": {
            "name": "Example Product",
            "id": "14fd0b08-d4a0-47d1-83e3-59c653d49290",
            "updated_at": "2019-11-26 20:44:34",
            "created_at": "2019-11-26 20:44:34"
        },
        "price": [
            {
                "currency": {
                    "PLN": "10,02 zł",
                    "EUR": "2.33 €"
                },
                "raw": 1002
            }
        ]
    }
}
```


### update product

`PUT example.com/api/products/{product_uuid}`

```
{
    "name": "Name to change",
    "price": "500"
}
```

**Example of not found response**
```
{
    "status": false,
    "payload": [],
    "message": "Not found product with uuid: Ananasy"
}
```

**Example response**
```
{
    "status": true,
    "payload": {
        "product": {
            "id": "14fd0b08-d4a0-47d1-83e3-59c653d49290",
            "name": "Mario Forever1133",
            "created_at": "2019-11-26 20:44:34",
            "updated_at": "2019-11-26 21:00:00"
        },
        "price": [
            {
                "currency": {
                    "PLN": "100,03 zł",
                    "EUR": "23.28 €"
                },
                "raw": 10003
            }
        ]
    }
}
```



### last products, with paginate

`GET example.com/api/products/last`

```
without content :)
```

**Example response**
```
{
    "status": true,
    "payload": [
        {
            "current_page": 1,
            "data": [
                {
                    "id": "14fd0b08-d4a0-47d1-83e3-59c653d49290",
                    "name": "Mario Forever1133",
                    "created_at": "2019-11-26 20:44:34",
                    "updated_at": "2019-11-26 21:00:00",
                    "price": "100,03 zł"
                },
                {
                    "id": "2fded9e0-e43c-400e-8895-28f022bc88e5",
                    "name": "Mari22o22",
                    "created_at": "2019-11-24 15:20:42",
                    "updated_at": "2019-11-24 15:20:42",
                    "price": "10,02 zł"
                },
                {
                    "id": "cce47ece-fb4b-4688-936f-22aca7ab2fe7",
                    "name": "Mari22o2",
                    "created_at": "2019-11-24 15:20:28",
                    "updated_at": "2019-11-24 15:20:28",
                    "price": "10,02 zł"
                }
            ],
            "first_page_url": "http://bialkowski.test/api/products/last?page=1",
            "from": 1,
            "last_page": 3,
            "last_page_url": "http://bialkowski.test/api/products/last?page=3",
            "next_page_url": "http://bialkowski.test/api/products/last?page=2",
            "path": "http://bialkowski.test/api/products/last",
            "per_page": 3,
            "prev_page_url": null,
            "to": 3,
            "total": 8
        }
    ]
}
```



### create cart

`POST example.com/api/carts`

```
without content :)
```

**Example response**
```
{
    "status": true,
    "payload": {
        "cart": {
            "id": "b0b53ac0-5562-4b57-8492-06f362886ec0",
            "expire_at": {
                "date": "2019-11-26 23:05:15.179778",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": "2019-11-26 21:05:15",
            "created_at": "2019-11-26 21:05:15"
        }
    }
}
```



### assign product to cart

`POST example.com/api/carts`

```
{
	"cart_id": "0c3099b9-a2b5-4d39-86b4-cfde9be16e80",
	"products": [
		"c7649d42-fcff-47bd-8f52-72f97dfe3668"
	]
}
```

**Example error response**

```
{
    "status": false,
    "payload": [],
    "message": "You can`t assign product: c7649d42-fcff-47bd-8f52-72f97dfe3668 - this products is exist in this cart."
}
```

**Example response**
```
{
    "status": true,
    "payload": {
        "cart": {
            "id": "b0b53ac0-5562-4b57-8492-06f362886ec0",
            "expire_at": "2019-11-26 23:05:15",
            "created_at": "2019-11-26 21:05:15",
            "updated_at": "2019-11-26 21:05:15"
        },
        "cart_products": [
            {
                "id": 10,
                "product_id": "c7649d42-fcff-47bd-8f52-72f97dfe3668",
                "cart_id": "b0b53ac0-5562-4b57-8492-06f362886ec0",
                "created_at": "2019-11-26 21:08:20",
                "updated_at": "2019-11-26 21:08:20"
            }
        ]
    }
}
```



### delete product from cart

`DELETE example.com/api/carts`

```
{
	"cart_uuid": "0c3099b9-a2b5-4d39-86b4-cfde9be16e80",
	"product_uuid": "9df42478-0b82-4ef8-8e37-6c329c2267c8"
}
```

**Example of error**
```
{
    "status": false,
    "errors": {
        "product_uuid": [
            "The selected product uuid is invalid."
        ]
    }
}
```

**Example response**
```
{
    "status": true,
    "payload": {
        "cart": {
            "id": "b0b53ac0-5562-4b57-8492-06f362886ec0",
            "expire_at": "2019-11-26 23:05:15",
            "created_at": "2019-11-26 21:05:15",
            "updated_at": "2019-11-26 21:05:15"
        }
    }
}
```





### summary of cart

`GET example.com/api/carts/{cart_uuid}`

```
without content :-(
```

**Example response**
```
{
    "status": true,
    "payload": {
        "cart": {
            "id": "0c3099b9-a2b5-4d39-86b4-cfde9be16e80",
            "expire_at": "2019-11-24 20:08:08",
            "created_at": "2019-11-24 18:08:08",
            "updated_at": "2019-11-24 18:08:08"
        },
        "cart_products": {
            "0": {
                "product": {
                    "product": {
                        "id": "d0d86460-d95a-4abe-a72e-ac9de2389f04",
                        "name": "Karolowy-1235",
                        "created_at": "2019-11-24 13:04:20",
                        "updated_at": "2019-11-24 13:04:20"
                    },
                    "price": [
                        {
                            "currency": {
                                "PLN": "99,09 zł",
                                "EUR": "23.06 €"
                            },
                            "raw": 9909
                        }
                    ]
                }
            },
            "1": {
                "product": {
                    "product": {
                        "id": "c7649d42-fcff-47bd-8f52-72f97dfe3668",
                        "name": "Mario",
                        "created_at": "2019-11-24 15:09:27",
                        "updated_at": "2019-11-24 15:09:27"
                    },
                    "price": [
                        {
                            "currency": {
                                "PLN": "1,00 zł",
                                "EUR": "0.23 €"
                            },
                            "raw": 100
                        }
                    ]
                }
            },
            "summary": {
                "PLN": "100,09 zł",
                "EUR": "23.29 €"
            }
        }
    }
}
```


### Routes

```
Route::group(['prefix' => 'products'], function () {
    Route::get('/last', 'ProductController@lastProducts');

    Route::get('/', 'ProductController@index');
    Route::post('/', 'ProductController@create');
    Route::get('/{product_uuid}', 'ProductController@product');
    Route::delete('/{product_uuid}', 'ProductController@delete');
    Route::put('/{product_uuid}', 'ProductController@update');
});

Route::group(['prefix' => 'carts'], function () {
    Route::get('/{cart_uuid}', 'CartController@index');
    Route::post('/', 'CartController@create');
    Route::delete('/', 'CartController@delete');
    Route::post('/assign-products', 'CartController@assignProducts');
});
```
