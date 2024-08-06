<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Beverage;
use Livewire\WithFileUploads;

class ManageBeverages extends Component
{
    use WithFileUploads;
  public $name, $price, $beverageId,$image,$search;
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ];

    public function render()
    {
        $beverages = Beverage::where('name','like',"%".$this->search."%")->get();
        return view('livewire.admin.manage-beverages', compact('beverages'));
    }

    public function saveBeverage()
    {
        
        $this->validate();

        Beverage::create([
            'name' => $this->name,
            'price' => $this->price,
            'image'=>$this->image->store("images","public"),
        ]);

        session()->flash('message', 'Beverage added successfully.');

        $this->redirect("beverages",navigate:true);
        
    }

    public function editBeverage($id)
    {
        $beverage = Beverage::findOrFail($id);
        $this->beverageId = $beverage->id;
        $this->name = $beverage->name;
        $this->price = $beverage->price;
        $this->isEditMode = true;
    }

    public function updateBeverage()
    {
        $this->validate();

        $beverage = Beverage::findOrFail($this->beverageId);
        if (empty($this->image)) {
            $beverage->update([
            'name' => $this->name,
            'price' => $this->price,
            
        ]);
        }
        else{
           $beverage->update([
            'name' => $this->name,
            'price' => $this->price,
            'image' => $this->image->store("images","public")
            
        ]);  
        }
       
        session()->flash('message', 'Beverage updated successfully.');
        $this->redirect("beverages",navigate:true);
        
    }

    public function deleteBeverage($id)
    {
        Beverage::findOrFail($id)->delete();
        session()->flash('message', 'Beverage deleted successfully.');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->price = '';
        $this->isEditMode = false;
    }
}