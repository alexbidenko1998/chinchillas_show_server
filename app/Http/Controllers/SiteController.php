<?php

namespace App\Http\Controllers;

use App\Chinchilla;
use App\Status;
use App\User;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function statistics()
    {
        return [
            'totalChinchillas' => Chinchilla::count(),
            'totalUsers' => User::count(),
            'activeSales' => Status::whereName('sale')->count(),
            'totalSold' => Status::whereName('sold')->count(),
        ];
    }
}
