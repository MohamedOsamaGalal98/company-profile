<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('media')->get()->map(function ($project) {
            $data = $project->toArray();

            $firstMedia = $project->getMedia('images')->first();

            $data['preview_image'] = $firstMedia ? [
                'name' => $firstMedia->name,
                'original_url' => $firstMedia->getUrl(),
            ] : null;

            $data['media'] = $project->getMedia('images')->map(function ($media) {
                return [
                    'name' => $media->name,
                    'original_url' => $media->getUrl(),
                ];
            });

            return $data;
        });

        return response()->json(['data' => $projects], 200);
    }



    public function store(ProjectRequest $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'client_name' => 'required|string|max:255',
            'demo_email' => 'nullable|string|max:255',
            'demo_password' => 'nullable|string|max:255',
            'demo_link' => 'nullable|url|max:255',
            'dashboard_email' => 'nullable|string|max:255',
            'dashboard_password' => 'nullable|string|max:255',
            'dashboard_link' => 'nullable|url|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $project  = Project::create($request->all());
        $project
            ->addMediaFromRequest('image')
            ->toMediaCollection('image');
        return response()->json(['data' => $project], 201); // Status code created
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);

        $firstMedia = $project->getMedia('images')->first();

        $data = $project->toArray();

        $data['preview_image'] = $firstMedia ? [
            'name' => $firstMedia->name,
            'original_url' => $firstMedia->getUrl(),
        ] : null;

        $data['media'] = $project->getMedia('images')->map(function ($media) {
            return [
                'name' => $media->name,
                'original_url' => $media->getUrl(),
            ];
        });

        return response()->json(['data' => $data], 200); // Status code OK
    }


    public function update(ProjectRequest $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'client_name' => 'required|string|max:255',
            'demo_email' => 'nullable|string|max:255',
            'demo_password' => 'nullable|string|max:255',
            'demo_link' => 'nullable|url|max:255',
            'dashboard_email' => 'nullable|string|max:255',
            'dashboard_password' => 'nullable|string|max:255',
            'dashboard_link' => 'nullable|url|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $project = Project::findorfail($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404); // Status code not found
        }
        $project->update($request->all());

        $project
            ->addMediaFromRequest('image')
            ->toMediaCollection('image');

        return response()->json(['data' => $project], 200); // Status code OK
    }

    public function destroy($id)
    {
        $project = Project::findorfail($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404); // Status code not found
        }
        $project->delete();
        return response()->json(['message' => 'Project deleted sucessfully'], 200); // Status code OK
    }
}
