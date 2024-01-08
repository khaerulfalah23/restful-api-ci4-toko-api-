<?php

namespace App\Models;

use CodeIgniter\Model;

class MRegistrasi extends Model
{
  protected $table = 'member';
  protected $allowedFields = ['nama', 'email', 'password'];
}
