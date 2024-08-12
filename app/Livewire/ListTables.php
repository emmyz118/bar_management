<?php

namespace App\Livewire;

use App\Models\Reservation;
use App\Models\Table;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListTables extends Component
{
    

    public $client_name;
    public $telephone;
    public $location;
    public $onetb;
    public $table_id;
    #[Layout("livewire.layout.client-layout")]
        public function render()
    {
        $tb = Table::all();
        return view('livewire.client.list-tables',["tables"=>$tb]);
    }
    protected $rules = [
        'client_name' => 'required|string|max:255',
        'telephone' => 'required|string|max:15',
        'location' => 'required|string|max:255',
        'table_id' => 'required|exists:tables,id',
    ];

    public function submitReservation()
    {
        $this->validate();

        Reservation::create([
            'client_name' => $this->client_name,
            'telephone' => $this->telephone,
            'location' => $this->location,
            'table_id' => $this->table_id,
        ]);

        $this->reset(['client_name', 'telephone', 'location', 'table_id']);

        session()->flash('message', 'Table reserved now successfully.');
        $this->redirect(route("client.tables"),navigate:true );
    }
    public function ass(){
    $this->onetb=$this->table_id;
    }

}