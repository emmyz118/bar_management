<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\Beverage;
use Livewire\Attributes\Layout;

class ListBeverages extends Component
{
 

    public $client_name;
    public $telephone;
    public $location;
    public $onebev;
    public $beverage_id;
    #[Layout("livewire.layout.client-layout")]
       public function render()
    {
        $bev = Beverage::all();
        //$onebev=Beverage::findOrFail($this->beverage_id);
        return view('livewire.client.list-beverages',["beverages"=>$bev]);
    }

    protected $rules = [
        'client_name' => 'required|string|max:255',
        'telephone' => 'required|string|max:15',
        'location' => 'required|string|max:255',
        'beverage_id' => 'required|exists:beverages,id',
    ];

    public function submitOrder()
    {
        $this->validate();

        Order::create([
            'client_name' => $this->client_name,
            'telephone' => $this->telephone,
            'location' => $this->location,
            'beverage_id' => $this->beverage_id,
        ]);

        $this->reset(['client_name', 'telephone', 'location', 'beverage_id']);

        session()->flash('message', 'Order placed successfully.');
        $this->redirect(route("client.beverages"),navigate:true );
    }
    public function ass(){
    $this->onebev=$this->beverage_id;
    }
}