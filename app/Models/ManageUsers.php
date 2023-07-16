<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ManageUsers extends Authenticatable
{ 
    // private $username;
    // private $firstName;
    // private $lastName;
    // private $isAdmin;
    // private $isActive;
    // private $email;

    // public function __construct($username, $firstName, $lastName, $isAdmin, $isActive, $email){
    //     $this->username = $username;
    //     $this->firstName = $firstName;
    //     $this->lastName = $lastName;
    //     $this->isAdmin = $isAdmin;
    //     $this->isActive = $isActive;
    //     $this->email = $email;
    // }


    protected $fillable = ['username','first_name','last_name','email','password','is_admin','is_active'];
    protected $attributes = [
        'is_admin' => 0,
        'is_active' => 1,
    ];

    protected $hidden = [
        'password',
        'confirm_password',
    ];


    
    
    
}
