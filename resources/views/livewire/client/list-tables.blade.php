<div class="container mt-5">
    <h5 class="m-3 text-gray-50">Tables</h5>
    <hr>
    <h6 class="p-5">Thi is table deal we have for you to day. We Are here to make your day with different types of
        tables
        for
        affordable price and affordable design
    </h6>
    <div class="row" wire:poll>
        @foreach($tables as $tbs)
        <div class="col-md-4 ">
            <div class="card rounded-circle align-content-center shadow mb-4">
                <center>
                    <div class="card-body ">
                        <img src="{{Storage::url($tbs->image)}}" alt="" width="150px" height="150px">
                        <h5 class="card-title">{{ $tbs->type }}</h5>
                        <span class="badge badge-primary">{{$tbs->capacity}} people</span>
                        <p class="card-text"><strong>Price:</strong> {{ $tbs->price }} Frw</p>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal"
                            wire:click="$set('table_id', {{ $tbs->id }}),ass()">Reserve now</button>
                    </div>
                </center>
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

                    <form wire:submit.prevent="submitReservation">
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
                            <select class="form-control" id="table" wire:model="beverage_id" hidden>
                                <option value="">Select a beverage</option>
                                @foreach($tables as $tbs)
                                <option value="{{ $tbs->id }}">{{ $tbs->type }}</option>
                                @endforeach
                            </select>
                            @error('table') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>