<?php

namespace App\Livewire\Owner;

use App\Models\{Order, Product};
use App\Enums\{OrderStatus, PaymentStatus};
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    protected $layout = 'layouts.owner';

    public $owner;
    public $stats = [];
    public $recentOrders = [];
    public $lowStockProducts = [];

    public function mount()
    {
        $this->owner = Auth::guard('owner')->user();
        $this->loadStats();
        $this->loadRecentOrders();
        $this->loadLowStockProducts();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_products' => $this->owner->products()->count(),
            'active_products' => $this->owner->activeProducts()->count(),
            'total_orders' => $this->owner->orders()->count(),
            'pending_orders' => $this->owner->orders()->where('status', OrderStatus::PENDING->value)->count(),
            'completed_orders' => $this->owner->orders()->where('status', OrderStatus::COMPLETED->value)->count(),
            'total_sales' => $this->owner->orders()->where('status', OrderStatus::COMPLETED->value)->sum('total_amount'),
            'monthly_sales' => $this->owner->orders()
                ->where('status', OrderStatus::COMPLETED->value)
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'low_stock_products' => $this->owner->products()->where('stock_quantity', '<=', 10)->count(),
        ];
    }

    public function loadRecentOrders()
    {
        $this->recentOrders = $this->owner->orders()
            ->with(['user', 'orderItems.product'])
            ->latest()
            ->take(5)
            ->get();
    }

    public function loadLowStockProducts()
    {
        $this->lowStockProducts = $this->owner->products()
            ->where('stock_quantity', '<=', 10)
            ->where('is_active', true)
            ->with('coverImage')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.owner.dashboard');
    }
}
