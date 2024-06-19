<?php
require_once 'ORM.php';

class User extends ORM {
    // static pemeter lattribute de publier  dans leur  table 
    protected static $table = 'users';
    protected static $columns = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string'
    ];
// declaration att
    protected $name;
    protected $email;
    protected $password;
// permeter de crée l'instance de user
    public function __construct($attributes = []) {
        parent::__construct($attributes);
        $this->name = $attributes['name'] ?? null;
        $this->email = $attributes['email'] ?? null;
        $this->password = $attributes['password'] ?? null;
    }
}
?>
