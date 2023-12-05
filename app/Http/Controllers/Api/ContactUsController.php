<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\ClientOpinionRequest;
use App\Models\ClientOpinion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientOpinionController extends Controller
{
    public function index()
    {
        $clientopinions = ClientOpinion::all()->map(function ($clientopinion) {
            $data = $clientopinion->toArray();

            $media = $clientopinion->getMedia('image')->map(function ($media) {
                return [
                    'name' => $media->name,
                    'original_url' => $media->getUrl(),
                ];
            });

            $data['media'] = $media;

            return $data;
        });

        return response()->json(['data' => $clientopinions], 200); // Status code OK
    }



    public function store(ClientOpinionRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'opinion' => 'required|string',
            'project_id' => 'required|integer|exists:projects,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $clientopinions  = ClientOpinion::create($request->all());
        $clientopinions
            ->addMediaFromRequest('image')
            ->toMediaCollection('image');
        return response()->json(['data' => $clientopinions], 201); // Status code created
    }

    public function show($id)
    {
        $clientopinion = ClientOpinion::findOrFail($id);

        $media = $clientopinion->getMedia('image')->map(function ($media) {
            return [
                'name' => $media->name,
                'original_url' => $media->getUrl(),
            ];
        });

        $data = $clientopinion->toArray();

        $data['media'] = $media;

        return response()->json(['data' => $data], 200); // Status code OK
    }

    public function update(ClientOpinionRequest $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'opinion' => 'required|string',
            'project_id' => 'required|integer|exists:projects,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $clientopinions = ClientOpinion::findorfail($id);
        if (!$clientopinions) {
            return response()->json(['message' => 'client opinion not found'], 404); // Status code not found
        }
        $clientopinions->update($request->all());

        $clientopinions
            ->addMediaFromRequest('image')
            ->toMediaCollection('image');

        return response()->json(['data' => $clientopinions], 200); // Status code OK
    }

    public function destroy($id)
    {
        $clientopinions = ClientOpinion::findorfail($id);
        if (!$clientopinions) {
            return response()->json(['message' => 'client opinion not found'], 404); // Status code not found
        }
        $clientopinions->delete();
        return response()->json(['message' => 'client opinion deleted sucessfully'], 200); // Status code OK
    }
}
