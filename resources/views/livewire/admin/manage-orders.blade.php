<div class="container-fluid">
    <h1 class="m-4 ">Manage Orders</h1>

    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <div class="card mb-4">

        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Orders List
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Beverage</th>
                        <th>Client Name</th>
                        <th>Phone</th>
                        <th>Client_address</th>
                        <th>date_ordered</th>
                        <th>Order status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->client_name }}</td>
                        <td>{{ $order->telephone }}</td>
                        <td>{{ $order->location }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{$order->status}}</td>

                        <td>
                            @if ($order->status=="Pending")
                            <button class="btn btn-info"
                                wire:click="completeReservation({{ $order->id }})">Complete</button>
                            <button class="btn btn-warning"
                                wire:click="rejectReservation({{ $order->id }})">Reject</button>
                            @endif

                            <button class="btn btn-danger" wire:click="deleteOrder({{ $order->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <livewire:footer />
</div>