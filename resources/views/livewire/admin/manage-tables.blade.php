<div class="container-fluid">
    <h1 class="m-4 text-bold">Manage Tables</h1>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header p-4">
            <i class="fas fa-table mr-1"></i>
            Tables List
            <div class="float-end space-x-8">

                <input type="text" wire:model.live="search" placeholder="Search table...">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTableModal">Add
                    Table</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Table image</th>
                        <th>Type</th>
                        <th>Capacity</ th>
                        <th>price</ th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tables as $table)
                    <tr>
                        <td><img src="{{Storage::url($table->image )}}" alt="no image" width="150px" height="200px">
                        </td>
                        <td>{{ $table->type }}</td>
                        <td>{{ $table->capacity }}</td>
                        <td>{{ $table->price }}</td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addTableModal"
                                wire:click="editTable({{ $table->id }})">Edit</button>
                            <button class="btn btn-danger"
                                wire:confirm="Are you sure you want to delete {{$table->type}}"
                                wire:click="deleteTable({{ $table->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Table Modal -->
    <div class="modal fade" id="addTableModal" tabindex="-1" role="dialog" aria-labelledby="addTableModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTableModalLabel">{{ $isEditMode ? 'Edit Table' : 'Add Table' }}
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body space-y-8">
                    <form wire:submit.prevent="{{ $isEditMode ? 'updateTable' : 'saveTable' }}">
                        <div class="form-group">
                            <label for="number">Table type</label>
                            <input type="text" class="form-control" id="number" wire:model="type">
                            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="capacity">Capacity</label>
                            <input type="number" class="form-control" id="capacity" wire:model="capacity">
                            @error('capacity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="price">price</label>
                            <input type="number" class="form-control" id="price" wire:model="price">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" wire:model="image">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit"
                            class="btn btn-primary mt-3">{{ $isEditMode ? 'Update' : 'Save' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <livewire:footer />
</div>