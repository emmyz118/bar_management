<div class="container-fluid">
    <h1 class="mt-4">Manage Orders</h1>

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
                        <th>Beverage</th>
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
                        <td>{{$order->status}}</td>
                        <td>
                            <button class="btn btn-info" wire:click="editOrder({{ $order->id }})">Complete</button>
                            <button class="btn btn-warning" wire:click="editOrder({{ $order->id }})">Reject</button>
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