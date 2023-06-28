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
}
