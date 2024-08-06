<?php

namespace App\Models;

class User extends BaseModel
{
    protected $connection = 'mysql'; // Specify the connection for this model

    protected $fillable = [
        'name', 'email', 'password',
    ];

    // Other model properties and methods...
}
Example for Order Model:
Create a new file app/Models/Order.php:

php
Copy code
<?php

namespace App\Models;

class Order extends BaseModel
{
    protected $connection = 'mysql2'; // Specify the connection for this model

    protected $fillable = [
        'order_number', 'user_id', 'amount',
    ];

    // Other model properties and methods...
}