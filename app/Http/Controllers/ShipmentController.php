<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewShipmentRequest;
use App\Http\Requests\UpdateShipmentRequest;
use App\Models\Shipment;
use App\Models\ShipmentDocuments;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class ShipmentController extends Controller
{

    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = Cache::remember('unassigned_shipments', 600,
            fn() => Shipment::where(['status' => Shipment::STATUS_UNASSIGNED])->get()
        );

        return view('shipments.index', [
            'shipments' => $shipments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * GET: /shipments/create
     */
    public function create()
    {
        Gate::authorize('canViewCreationPage', Shipment::class);
        return view('shipments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * POST: /shipments/create
     */
    public function store(NewShipmentRequest $request)
    {
        Gate::authorize('create', Shipment::class);

        $shipment = Shipment::create($request->validated());

        $fileTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        foreach ($request->file('documents') as $document) {

            if(str_starts_with($document->getMimeType(), 'image/')) {

                $name = $this->uploadImage($document, "documents/$shipment->id");

                $name = $shipment->id."/".$name;

                ShipmentDocuments::create([
                    'shipment_id' => $shipment->id,
                    'document_name' => $name
                ]);

            }
            elseif(in_array($document->getMimeType(), $fileTypes)) {

                $extension = $document->getClientOriginalExtension(); // .pdf, .doc, .docx

                $filename = uniqid().".".$extension;

                $path = $document->storeAs("documents/{$shipment->id}", $filename, 'public');

                $path = str_replace("documents/", "", $path);

                ShipmentDocuments::create([
                    'shipment_id' => $shipment->id,
                    'document_name' => $path
                ]);
            }
        }

        return redirect()->route('shipments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        return view('shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        return view('shipments.edit', compact('shipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentRequest $request, Shipment $shipment)
    {
        $shipment->update($request->validated());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipments)
    {
        //
    }
}
