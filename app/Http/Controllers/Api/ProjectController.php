<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin\Project;
use App\Models\Admin\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        $types = Type::all();
        $projects = Project::with('type', 'technologies')->paginate(6);

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
