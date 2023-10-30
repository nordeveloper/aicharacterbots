<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent {
   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

   protected $fillable = ['email', 'password', 'username'];

   /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */

   protected $hidden = ['password'];

 }