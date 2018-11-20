<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserControllerAPI extends Controller
{
    public function getProfile($id)
    {
        return new ItemResource(Item::find($id));
    }
}
