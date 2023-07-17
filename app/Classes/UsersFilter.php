<?php 

namespace App\Classes;

use App\Classes\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class UsersFilter extends Users{
 

    public function scopeUsername(Builder $query, string $username)
    {
        return $query->where('username', $username);
    }

    public function scopeName(Builder $query, string $name)
    {
        $splitname = explode(" ", $name);
        $firstname = $splitname[0];
        $lastname = $splitname[1];
          
        return $query->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%".$firstname." ".$lastname."%");
    }

    /**
     * Scope a query to only include users of either type admin or user.
     */
    public function scopeIsAdmin(Builder $query, int $is_admin)
    {
        return $query->where('is_admin', $is_admin);
    }

    
    public function scopeIsActive(Builder $query, int $is_active)
    {
        return $query->where('is_active', $is_active);
    }

 
    public function scopeEmail(Builder $query, string $email)
    {
        return $query->where('email', $email);
    }

    public function scopeFilter(Builder $query,  string $username, string $name, int $is_admin, int $is_active, string $email)
    {

        return $this->scopeUsername($query, $username)->scopeName($query,$name)
        ->scopeIsAdmin($query,$is_admin)->scopeIsActive($query,$is_active)
        ->scopeEmail($query,$email);


        // $collection = collect(['username'=>$this->scopeUsername($query, $username), 
        // 'name'=>$this->scopeName($query, $name), 
        // 'is_admin'=>$this->scopeIsAdmin($query,$is_admin),
        // 'is_active' => $this->scopeIsActive($query,$is_active),
        // 'email'=> $this->scopeEmail($query,$email)]);

        // return $collection->all();
   
    }
}