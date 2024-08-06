<div class="container mt-5">
    <h6 class="p-5">Thi is Beverages deal we have for you to day. We Are here to make your day with different cocktails
        for
        affordable price and affordable quality + quantity
    </h6>
    <div class="row" wire:poll>
        @foreach($beverages as $beverage)
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body shadow">
                    <h5 class="card-title">{{ $beverage->name }}</h5>
                    <img src="{{Storage::url($beverage->image)}}" alt="" width="150px" height="150px">
                    <p class="card-text">{{ $beverage->description }}</p>
                    <p class="card-text"><strong>Price:</strong> {{ $beverage->price }} Frw</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal"
                        wire:click="$set('beverage_id', {{ $beverage->id }}),ass()">Order</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Order Modal -->
    <div wire:ignore.self class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Place Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                    @endif

                    <form wire:submit.prevent="submitOrder">
                        <div class="mb-3">
                            <label for="clientName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="clientName" wire:model="client_name">
                            @error('client_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="telephone" wire:model="telephone">
                            @error('telephone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" wire:model="location">
                            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <select class="form-control" id="beverage" wire:model="beverage_id" hidden>
                                <option value="">Select a beverage</option>
                                @foreach($beverages as $beverage)
                                <option value="{{ $beverage->id }}">{{ $beverage->name }}</option>
                                @endforeach
                            </select>
                            @error('beverage_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>