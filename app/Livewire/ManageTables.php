<?php

namespace App\Livewire;

use App\Models\Table;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageTables extends Component
{
 use WithFileUploads;
    public $type, $capacity,$price,$image,$tableId,$search;
    private $oldimage;
    public $isEditMode = false;

    protected $rules = [
        'type' => 'required|string|max:255',
        'price' => 'required|numeric|min:1',
        'image' => 'required|max:255',
        'capacity' => 'required|numeric|min:1',
    ];

    public function render()
    {
        $tables = Table::where("type","like","%".$this->search."%")->get();
        return view('livewire.admin.manage-tables', compact('tables'));
    }

    public function saveTable()
    {
        $this->validate();

        Table::create([
            'type' => $this->type,
            'capacity' => $this->capacity,
            'price' => $this->price,
            'image' => $this->image->store("images","public"),
        ]);

        session()->flash('message', 'Table added successfully.');

        $this->resetForm();
        return $this->redirect(route('admin.tables'),navigate:true);
         
    }

    public function editTable($id)
    {
        $table = Table::findOrFail($id);
        $this->tableId = $table->id;
        $this->type = $table->type;
        $this->price = $table->price;
        $this->image = $table->image;
        $this->oldimage=$table->image;
        $this->capacity = $table->capacity;
        $this->isEditMode = true;
    }

    public function updateTable()
    {
        $this->validate();

        $table = Table::findOrFail($this->tableId);
        if ($this->image==$table->image) {
           $table->update([
            'type' => $this->type,
            'capacity' => $this->capacity,
            'price' => $this->price,
        ]);
        }
        else{
            $table->update([
            'type' => $this->type,
            'capacity' => $this->capacity,
            'price' => $this->price,
            'image' => $this->image->store("images","public")
        ]); 
        }
       

        session()->flash('message', "Table updated successfully.");

        $this->resetForm();
        return $this->redirect(route('admin.tables'),navigate:true);
        
    }

    public function deleteTable($id)
    {
        Table::findOrFail($id)->delete();
        session()->flash('message', 'Table deleted successfully.');
    }

    public function resetForm()
    {
        $this->type = '';
        $this->capacity = '';
        $this->isEditMode = false;
    }
}