<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Table;
use Livewire\Component;
use App\Models\Beverage;

class ManageOrders extends Component
{

    public $client_name, $beverage_id, $table_id, $status, $orderId;
    public $isEditMode = false;

    protected $rules = [
        'client_name' => 'required|string|max:255',
        'beverage_id' => 'required|exists:beverages,id',
        'table_id' => 'required|exists:tables,id',
        'status' => 'required|string|in:pending,completed,canceled',
    ];

    public function render()
    {
        
      $orders = Order::join('beverages', 'orders.beverage_id', '=', 'beverages.id')
    ->select('beverages.name', 'orders.*')
    ->get();
        return view('livewire.admin.manage-orders', compact('orders'));
    }

    
    public function deleteOrder($id)
    {
        Order::findOrFail($id)->delete();
        session()->flash('message', 'Order deleted successfully.');
    }

 public function completeReservation($id)
    {
        $reservation = Order::findOrFail($id);
        $reservation->status='Completed';
        $reservation->save();


        session()->flash('message', "$reservation->client_name's Order marked as completed.".$id);
        return $this->redirect(route("admin.orders"),navigate:true);
    }

    public function rejectReservation($id)
    {
        $reservation = Order::findOrFail($id);
         $reservation->status='Rejected';
        $reservation->save();

        session()->flash('message', 'Order rejected.');
        return $this->redirect(route("admin.orders"),navigate:true);
    }

}