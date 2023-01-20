<?php
namespace App\Models;

use Core\Model\Model;
use Core\Traits\User\Extended;
use Core\Traits\User\Help;

class User extends Model
{
 use Help, Extended;

 /**
  * Get all wallet that belong to this user
  * include balances
  * @return array
  */
 public function wallets() : array
 {
    return $this->hasMany(Wallet::class,  null, 'balances');
 }

 /**
  * Get wallet that belong to this user by ID
  * @return Wallet
  */
 public function wallet($id)
 {
    return $this->hasOne(Wallet::class, null, 'balances');
 }

 /**
  * Get all users transactions
  * @return array
  */
 public function transactions() : array
 {
    return $this->hasMany(Transaction::class);
 }

}