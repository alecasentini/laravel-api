<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin\Project;
use App\Models\Admin\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        $types = Type::all();

        if ($request->has('category_id')) {
            $projects = Project::with(['type', 'technologies'])->where('category_id', $request->category_id)->paginate(6);
        } else {
            $projects = Project::with(['type', 'technologies'])->paginate(6);
        }
        return response()->json([
            'success' => true,
            'types' => $types,
            'projects' => $projects
        ]);
    }
    public function show($slug)
    {
        $project = Project::with('type', 'technologies')->where('slug', $slug)->first();
        if ($project) {
            return response()->json([
                'success' => true,
                'project' => $project
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Project non trovato'
            ])->setStatusCode(404);
        }
    }
}
