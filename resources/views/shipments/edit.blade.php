@php use App\Models\Shipment; @endphp
@extends('layout')

@section('content')
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 24px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f9f9f9;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 16px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 0.9rem;
        }
    </style>

    <div class="form-container">
        <h2>Create New Shipment</h2>

        <form action="{{ route('shipments.update', ['shipment' => $shipment->id]) }}"
              enctype="multipart/form-data"
              method="POST"
        >

            @csrf
            @method('PUT')


            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" value="{{ $shipment->title ?? '' }}" required>
            </div>

            <div class="form-group">
                <label for="from_city">From City</label>
                <input type="text" name="from_city" value="{{ $shipment->from_city ?? '' }}" required>
            </div>

            <div class="form-group">
                <label for="from_country">From Country</label>
                <input type="text" name="from_country" value="{{ $shipment->from_country ?? '' }}" required>
            </div>

            <div class="form-group">
                <label for="to_city">To City</label>
                <input type="text" name="to_city" value="{{ $shipment->to_city ?? '' }}" required>
            </div>

            <div class="form-group">
                <label for="to_country">To Country</label>
                <input type="text" name="to_country" value="{{ $shipment->to_country ?? '' }}" required>
            </div>

            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" name="price" value="{{ $shipment->price ?? '' }}" min="0" required>
            </div>

            <div class="form-group">

                @if($errors->has('user_id'))
                    <p>{{ $errors->first('user_id') }}</p>
                @endif

                <label for="user_id">Trucker ID</label>
                <input type="number" name="user_id" value="{{ $shipment->user_id ?? '' }}" min="0" required>
            </div>

            <div class="form-group">

                @if($errors->has('client_id'))
                    <p>{{ $errors->first('client_id') }}</p>
                @endif

                <label for="client_id">Client ID</label>
                <input type="number" name="client_id" value="{{ $shipment->client_id ?? '' }}" min="0" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" required>
                    @foreach(Shipment::ALLOWED_STATUSES as $status)
                        <option value="{{ $status }}" {{ $shipment->status === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="documents">Documents</label>
                <input type="file" name="documents[]" multiple>
            </div>

            <div class="form-group">
                <label for="details">Details</label>
                <textarea name="details" rows="4" required>{{ $shipment->details ?? '' }}</textarea>
            </div>

            <button type="submit">Update Shipment</button>
        </form>

    </div>
@endsection
