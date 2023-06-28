<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Admin\Technology;
use App\Models\Admin\Type;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $technologies = Technology::all();
        $types = Type::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        // $request->validate(
        //     [
        //         'name' => 'required|unique:projects',
        //         'description' => 'required',
        //     ],
        //     [
        //         'name.required' => 'Il campo Name deve essere compilato',
        //         'name.unique' => 'Esiste già un project con quel nome',
        //         'description.required' => 'Il campo Description deve essere compilato',
        //     ]
        // );
        // $form_data = $request->all();

        $form_data = $request->validated();

        $slug = Project::generateSlug($request->name);

        $form_data['slug'] = $slug;




        if ($request->hasFile('cover_image')) {
            $path = Storage::disk('public')->put('project_images', $request->cover_image);
            $form_data['cover_image'] = $path;
        }

        $new_project = Project::create($form_data);

        if ($request->has('technologies')) {
            $new_project->technologies()->attach($request->technologies);
        }
        // $new_project = new Project();
        // $new_project->fill($form_data);
        // $new_project->save();

        return redirect()->route('admin.projects.index')->with('success', "Project $new_project->name creato");;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $type = DB::table('types')
            ->where('id', $project->category_id)
            ->first();

        return view('admin.projects.show', compact('project', 'type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        // $request->validate(
        //     [
        //         'name' => 'required|unique:projects,name,' . $project->id,
        //         'description' => 'required',
        //     ],
        //     [
        //         'name.required' => 'Il campo Name deve essere compilato',
        //         'name.unique' => 'Esiste già un project con quel nome',
        //         'description.required' => 'Il campo Description deve essere compilato',
        //     ]
        // );

        // $form_data = $request->all();
        $form_data = $request->validated();

        $slug = Project::generateSlug($request->name);

        $form_data['slug'] = $slug;

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            $path = Storage::disk('public')->put('project_images', $request->cover_image);
            $form_data['cover_image'] = $path;
        }

        $project->update($form_data);

        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies);
        }

        return redirect()->route('admin.projects.index')->with('success', "Project $project->name modificato");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', "Project $project->name cancellato");
    }
}
