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
        $reservations = Reservation::join('tables', 'reservations.table_id', '=', 'tables.id')
            ->select('tables.type', 'reservations.*')
            ->get();
        return view('livewire.admin.manage-reservations', compact('reservations'));
        
    }
  

    public function deleteReservation($id)
    {
        Reservation::findOrFail($id)->delete();
        session()->flash('message', 'Reservation deleted successfully.');
        return $this->redirect(route("admin.reservations"),navigate:true);
        
    }

    public function completeReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status='Completed';
        $reservation->save();


        session()->flash('message', 'Reservation marked as completed.'.$id);
        return $this->redirect(route("admin.reservations"),navigate:true);
    }

    public function rejectReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
         $reservation->status='Rejected';
        $reservation->save();

        session()->flash('message', 'Reservation rejected.');
        return $this->redirect(route("admin.reservations"),navigate:true);
    }


}