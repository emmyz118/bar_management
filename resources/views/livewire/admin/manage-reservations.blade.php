<div class="container-fluid">

    </h1>
    <h1 class="m-4 ">Manage Reservations </h1>


    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar-check mr-1"></i>
            Reservations List

        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Table type</th>
                        <th>Client Name</th>
                        <th>Client_phone</th>
                        <th>Reservation Date</th>
                        <th>Reservation Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->type }}</td>
                        <td>{{ $reservation->client_name }}</td>
                        <td>{{ $reservation->telephone }}</td>


                        <td>{{ $reservation->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $reservation->status}}</td>

                        <td>
                            @if ($reservation->status=="Pending")
                            <button class="btn btn-info"
                                wire:confirm="Are you sure you want to complete this reservation now?"
                                wire:click="completeReservation({{ $reservation->id }})">Complete</button>
                            <button class="btn btn-warning"
                                wire:confirm="Are you sure you want to reject this reservation ?"
                                wire:click="rejectReservation({{ $reservation->id }})">Reject</button>
                            @endif

                            <button class="btn btn-danger"
                                wire:confirm="Are you sure you want to delete this reservation ?"
                                wire:click="deleteOrder({{ $reservation->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <livewire:footer />
</div>