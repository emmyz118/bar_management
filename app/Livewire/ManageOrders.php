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

    public function saveOrder()
    {
        $this->validate();

        Order::create([
            'client_name' => $this->client_name,
            'beverage_id' => $this->beverage_id,
            'table_id' => $this->table_id,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Order added successfully.');

        $this->resetForm();
        $this->emit('closeModal'); // Close modal using JS event
    }

    public function editOrder($id)
    {
        $order = Order::findOrFail($id);
        $this->orderId = $order->id;
        $this->client_name = $order->client_name;
        $this->beverage_id = $order->beverage_id;
        $this->table_id = $order->table_id;
        $this->status = $order->status;
        $this->isEditMode = true;
    }

    public function updateOrder()
    {
        $this->validate();

        $order = Order::findOrFail($this->orderId);
        $order->update([
            'client_name' => $this->client_name,
            'beverage_id' => $this->beverage_id,
            'table_id' => $this->table_id,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Order updated successfully.');

        $this->resetForm();
        $this->emit('closeModal');
    }

    public function deleteOrder($id)
    {
        Order::findOrFail($id)->delete();
        session()->flash('message', 'Order deleted successfully.');
    }

    public function resetForm()
    {
        $this->client_name = '';
        $this->beverage_id = '';
        $this->table_id = '';
        $this->status = '';
        $this->isEditMode = false;
    }
}