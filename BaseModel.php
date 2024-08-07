<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    protected $connection = 'default_connection'; // Default connection, can be overridden

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // You can dynamically set the connection based on certain conditions
        // $this->setConnection('mysql'); // Uncomment and modify as needed
    }
}

namespace App\Models;

class User extends BaseModel
{
    protected $connection = 'mysql'; // Specify the connection for this model if required otherwise base class connection would apply

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
    protected $connection = 'mysql2'; // Specify the connection for this model if required otherwise base class connection would apply

    protected $fillable = [
        'order_number', 'user_id', 'amount',
    ];

    // Other model properties and methods...
}