@extends('layout')

@section('content')
    <style>
        .shipments-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .shipment-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            width: 300px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: #f9f9f9;
        }

        .shipment-card h2 {
            margin-top: 0;
            font-size: 1.4rem;
            color: #333;
        }

        .shipment-info {
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .shipment-label {
            font-weight: bold;
            color: #555;
        }

        .shipment-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            color: white;
            background-color: #4CAF50;
        }

        .shipment-status.inactive {
            background-color: #f44336;
        }
    </style>

    <div class="shipments-container">
        @foreach($shipments as $shipment)
            <div class="shipment-card">
                <h2>{{ $shipment->title }}</h2>

                <div class="shipment-info">
                    <span class="shipment-label">From:</span>
                    {{ $shipment->from_city }}, {{ $shipment->from_country }}
                </div>

                <div class="shipment-info">
                    <span class="shipment-label">To:</span>
                    {{ $shipment->to_city }}, {{ $shipment->to_country }}
                </div>

                <div class="shipment-info">
                    <span class="shipment-label">Price:</span> ${{ number_format($shipment->price, 2) }}
                </div>

                <div class="shipment-info">
                    <span class="shipment-label">Status:</span>
                    <span class="shipment-status {{ $shipment->status === 'inactive' ? 'inactive' : '' }}">
                        {{ ucfirst($shipment->status) }}
                    </span>
                </div>

                <div class="shipment-info">
                    <span class="shipment-label">Details:</span>
                    {{ $shipment->details }}
                </div>

                <div class="shipment-info">
                    <span class="shipment-label">Posted by User ID:</span> {{ $shipment->user_id }}
                </div>
            </div>
        @endforeach
    </div>
@endsection
