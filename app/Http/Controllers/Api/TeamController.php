<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all()->map(function ($team) {
            $data = $team->toArray();

            $media = $team->getMedia('image')->map(function ($media) {
                return [
                    'name' => $media->name,
                    'original_url' => $media->getUrl(),
                ];
            });

            $data['media'] = $media;

            return $data;
        });

        return response()->json(['data' => $teams], 200); // Status code OK
    }


    public function store(TeamRequest $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $team  = Team::create($request->all());
        $team
            ->addMediaFromRequest('image')
            ->toMediaCollection('image');
        return response()->json(['data' => $team], 201); // Status code created
    }

    public function show($id)
    {
        $team = Team::findOrFail($id);

        $media = $team->getMedia('image')->map(function ($media) {
            return [
                'name' => $media->name,
                'original_url' => $media->getUrl(),
            ];
        });

        $data = $team->toArray();

        $data['media'] = $media;

        return response()->json(['data' => $data], 200); // Status code OK
    }

    public function update(TeamRequest $request, $id)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $team = Team::findorfail($id);
        if (!$team) {
            return response()->json(['message' => 'team member not found'], 404); // Status code not found
        }
        $team->update($request->all());

        $team
            ->addMediaFromRequest('image')
            ->toMediaCollection('image');
        return response()->json(['data' => $team], 200); // Status code OK
    }

    public function destroy($id)
    {
        $team = Team::findorfail($id);
        if (!$team) {
            return response()->json(['message' => 'team member not found'], 404); // Status code not found
        }
        $team->delete();
        return response()->json(['message' => 'team member deleted successfully'], 200); // Status code OK
    }
}
