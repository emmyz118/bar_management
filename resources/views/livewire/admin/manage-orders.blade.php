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
                        <td>{{ $order->beverage_id }}</td>
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

    <!-- Add/Edit Order Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOrderModalLabel">{{ $isEditMode ? 'Edit Order' : 'Add Order' }}
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $isEditMode ? 'updateOrder' : 'saveOrder' }}">
                        <div class="form-group">
                            <label for="client_name">Client Name</label>
                            <input type="text" class="form-control" id="client_name" wire:model="client_name">
                            @error('client_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="beverage_id">Beverage</label>
                            <select class="form-control" id="beverage_id" wire:model="beverage_id">
                                <option value="">Select Beverage</option>
                                @foreach($beverages as $beverage)
                                <option value="{{ $beverage->id }}">{{ $beverage->name }}</option>
                                @endforeach
                            </select>
                            @error('beverage_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                            <label for="status">Status</label>
                            <select class="form-control" id="status" wire:model="status">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">{{ $isEditMode ? 'Update' : 'Save' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <livewire:footer />
</div>