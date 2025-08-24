
@extends('layout')


@section('content')

    <div>
        {{ $shipment->from_city }}
        {{ $shipment->to_city }}
    </div>

    <div>
        @foreach($shipment->documents as $document)
            <a target="_blank" href="/storage/documents/{{ $document->document_name }}">{{ $document->document_name }}</a>
        @endforeach
    </div>

@endsection
