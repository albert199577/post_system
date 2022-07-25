<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class test extends Model
{
    use HasFactory;
    function isPalindrome($x) {
        $param_1 = '';
        $param_2 = '';
        for($i = 0; $i < strlen($x); $i++) {
        $param_1 .= substr($x, $i, 1);
        }
        for($y = strlen($x); $y > 0; $y--) {
        $param_2 .= substr($x, $y, 1);
        }
        return ($param_1 == $param_2);
    }
    
}

