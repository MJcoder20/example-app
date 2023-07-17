<?php

namespace App\Classes;

use InvalidArgumentException;

class Users {

    private string $username;
    private string $firstName;
    private string $lastName;
    private int $isAdmin;
    private int $isActive;
    private string $email;

    public function __construct(string $username, string $firstName, string $lastName, int $isAdmin, int $isActive, string $email){
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->isAdmin = $isAdmin;
        $this->isActive = $isActive;
        $this->email = $email;
    }


    // getters and setters

    # username getter method
    public function getUsername(): string{
        return $this->username;
    }

    # firstName getter method
    public function getFirstName(): string{
        return $this->firstName;
    }

    # lastName getter method
    public function getLastName(): string{
        return $this->lastName;
    }

    # email getter method
    public function getEmail(): string{
        return $this->email;
    }
    # isActive getter method
    public function getIsActive(): int{
        return $this->isActive;
    }

    # isAdmin getter method
    public function getIsAdmin(): int{
        return $this->isAdmin;
    }



    
    # firstName setter method
    public function setFirstName(string $firstname): void {
        if (strlen($firstname) > 15 && strlen($firstname) < 3){
            throw new InvalidArgumentException("Invalid first name");
        }else
            $this->firstName=$firstname;
    } 

    # username setter method
    public function setUsername(string $username): void {
       
        if (!preg_match('/^[a-zA-Z]+$/', $username)) {
            throw new InvalidArgumentException('Invalid Username');}
            else
            $this->username = $username;
    }

    # lastName setter method
    public function setLastName(string $lastname): void {
        if (strlen($lastname) > 15 && strlen($lastname) < 3){
            throw new InvalidArgumentException("Invalid last name");
        }else
            $this->lastName=$lastname;
    }

    // #email setter method
    // public function setEmail(string $email){
    //     // check for valid email format using regular expression
    //     if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    //         throw new InvalidArgumentException("Invalid Email Address!");
    //         }
    //         elseif ($this->checkIfUserExistsByEmail())
    // }
   

        

            
}