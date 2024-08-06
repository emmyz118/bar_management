<?php

namespace App\Livewire;

use App\Models\Table;
use Livewire\Component;
use App\Models\Reservation;

class ManageReservations extends Component
{
  public $client_name, $table_id, $reservation_date, $reservationId;
    public $isEditMode = false;

    protected $rules = [
        'client_name' => 'required|string|max:255',
        'table_id' => 'required|exists:tables,id',
        'reservation_date' => 'required|date|after_or_equal:today',
    ];

    public function render()
    {
        $reservations = Reservation::all();
        $tables = Table::all();
        return view('livewire.admin.manage-reservations', compact('reservations', 'tables'));
    }

    public function saveReservation()
    {
        $this->validate();

        Reservation::create([
            'client_name' => $this->client_name,
            'table_id' => $this->table_id,
            'reservation_date' => $this->reservation_date,
        ]);

        session()->flash('message', 'Reservation added successfully.');

        $this->resetForm();
        $this->emit('closeModal');
    }

    public function editReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->reservationId = $reservation->id;
        $this->client_name = $reservation->client_name;
        $this->table_id = $reservation->table_id;
        $this->reservation_date = $reservation->reservation_date;
        $this->isEditMode = true;
    }

    public function updateReservation()
    {
        $this->validate();

        $reservation = Reservation::findOrFail($this->reservationId);
        $reservation->update([
            'client_name' => $this->client_name,
            'table_id' => $this->table_id,
            'reservation_date' => $this->reservation_date,
        ]);

        session()->flash('message', 'Reservation updated successfully.');

        $this->resetForm();
        $this->emit('closeModal');
    }

    public function deleteReservation($id)
    {
        Reservation::findOrFail($id)->delete();
        session()->flash('message', 'Reservation deleted successfully.');
    }

    public function resetForm()
    {
        $this->client_name = '';
        $this->table_id = '';
        $this->reservation_date = '';
        $this->isEditMode = false;
    }
}