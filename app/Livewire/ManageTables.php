<?php

namespace App\Livewire;

use App\Models\Table;
use Livewire\Component;

class ManageTables extends Component
{
 
    public $number, $capacity, $tableId;
    public $isEditMode = false;

    protected $rules = [
        'number' => 'required|string|max:255',
        'capacity' => 'required|numeric|min:1',
    ];

    public function render()
    {
        $tables = Table::all();
        return view('livewire.admin.manage-tables', compact('tables'));
    }

    public function saveTable()
    {
        $this->validate();

        Table::create([
            'number' => $this->number,
            'capacity' => $this->capacity,
        ]);

        session()->flash('message', 'Table added successfully.');

        $this->resetForm();
         // Close modal using JS event
    }

    public function editTable($id)
    {
        $table = Table::findOrFail($id);
        $this->tableId = $table->id;
        $this->number = $table->number;
        $this->capacity = $table->capacity;
        $this->isEditMode = true;
    }

    public function updateTable()
    {
        $this->validate();

        $table = Table::findOrFail($this->tableId);
        $table->update([
            'number' => $this->number,
            'capacity' => $this->capacity,
        ]);

        session()->flash('message', 'Table updated successfully.');

        $this->resetForm();
        
    }

    public function deleteTable($id)
    {
        Table::findOrFail($id)->delete();
        session()->flash('message', 'Table deleted successfully.');
    }

    public function resetForm()
    {
        $this->number = '';
        $this->capacity = '';
        $this->isEditMode = false;
    }
}