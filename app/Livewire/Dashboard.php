<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Table;
use Livewire\Component;
use App\Models\Beverage;
use App\Models\Reservation;

class Dashboard extends Component
{
      public $beveragesCount;
    public $tablesCount;
    public $ordersCount;
    public $reservationsCount;
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
  

    public function mount()
    {
        $this->beveragesCount = Beverage::count();
        $this->tablesCount = Table::count();
        $this->ordersCount = Order::count();
        $this->reservationsCount = Reservation::count();
    }

}