<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'activeProducts' => Product::query()->where('is_active', true)->count(),
            'totalMessages' => ContactMessage::query()->count(),
            'unreadMessages' => ContactMessage::query()->unread()->count(),
            'latestMessages' => ContactMessage::query()->latest()->latest('id')->limit(5)->get(),
        ]);
    }
}
