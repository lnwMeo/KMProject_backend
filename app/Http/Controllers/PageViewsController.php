<?php

namespace App\Http\Controllers;
use App\Models\PageViews;
use Illuminate\Http\Request;

class PageViewsController extends Controller
{
    public function storeIpAddress(Request $request)
    {
        $ipAddress = $request->ip();

        PageViews::create([
            'ip_address' => $ipAddress,
        ]);
    
        return response()->json(['message' => 'IP address recorded successfully']);
    }

    public function countViews()
    {
        // นับจำนวน users
        $ipAddress = PageViews::query()->count();
        return response()->json(['count' => $ipAddress]);
    }
}
