<div class="container">
    <h1 class="mt-4">Manage Beverages</h1>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Beverages List
            <div class="float-right space-x-8">
                <input type="text" wire:model.live="search" placeholder="Search bevarage...">
                <button class="btn btn-primary" wire:click="resetForm()" data-bs-toggle="modal"
                    data-bs-target="#addBeverageModal">Add new
                    Beverage</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($beverages as $beverage)
                    <tr>
                        <td>
                            <center>
                                <img src="{{Storage::url($beverage->image)}}" alt="bevarage" width="100px"
                                    height="100px">
                            </center>
                        </td>
                        <td>{{ $beverage->name }}</td>
                        <td>{{ $beverage->price }}</td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addBeverageModal"
                                wire:click="editBeverage({{ $beverage->id }})">Edit</button>
                            <button class="btn btn-danger" wire:confirm="You want to delete {{$beverage->name}}"
                                wire:click="deleteBeverage({{ $beverage->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Beverage Modal -->
    <div class="modal fade" id="addBeverageModal" tabindex="-1" role="dialog" aria-labelledby="addBeverageModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBeverageModalLabel">
                        {{ $isEditMode ? 'Edit Beverage' : 'Add Beverage' }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $isEditMode ? 'updateBeverage' : 'saveBeverage' }}">
                        <div class="form-group">
                            <label for="name">Beverage Name</label>
                            <input type="text" class="form-control" id="name" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" wire:model="price">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="" class="label">image</label>
                            <br>
                            <input type="file" class="" id="" wire:model="image">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit"
                            class="btn btn-primary mt-3">{{ $isEditMode ? 'Update' : 'Save' }}</button>
                        <div wire:loading>
                            <img src="../loading-loader2.gif" alt="no" width="50px" height="50px">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <livewire:footer />
</div>