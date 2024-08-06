<div class="container-fluid">
    <h1 class="mt-4">Manage Reservations</h1>

    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar-check mr-1"></i>
            Reservations List
            <button class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#addReservationModal">Add
                Reservation</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Table</th>
                        <th>Reservation Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->client_name }}</td>
                        <td>{{ $reservation->table->number }}</td>
                        <td>{{ $reservation->reservation_date->format('Y-m-d H:i') }}</td>
                        <td>
                            <button class="btn btn-warning" wire:click="editReservation({{ $reservation->id }})"
                                data-toggle="modal" data-target="#addReservationModal">Edit</button>
                            <button class="btn btn-danger"
                                wire:click="deleteReservation({{ $reservation->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Reservation Modal -->
    <div class="modal fade" id="addReservationModal" tabindex="-1" role="dialog"
        aria-labelledby="addReservationModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReservationModalLabel">
                        {{ $isEditMode ? 'Edit Reservation' : 'Add Reservation' }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $isEditMode ? 'updateReservation' : 'saveReservation' }}">
                        <div class="form-group">
                            <label for="client_name">Client Name</label>
                            <input type="text" class="form-control" id="client_name" wire:model="client_name">
                            @error('client_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="table_id">Table</label>
                            <select class="form-control" id="table_id" wire:model="table_id">
                                <option value="">Select Table</option>
                                @foreach($tables as $table)
                                <option value="{{ $table->id }}">{{ $table->number }}</option>
                                @endforeach
                            </select>
                            @error('table_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="reservation_date">Reservation Date</label>
                            <input type="datetime-local" class="form-control" id="reservation_date"
                                wire:model="reservation_date">
                            @error('reservation_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">{{ $isEditMode ? 'Update' : 'Save' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <livewire:footer />
</div>