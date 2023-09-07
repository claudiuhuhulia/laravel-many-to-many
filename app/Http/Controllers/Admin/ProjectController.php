<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('updated_at', 'DESC')->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $project = new Project();
        $types = Type::all();

        return view('admin.projects.create', compact('project', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:projects'],
            'image' => 'nullable|image:jpg,jpeg,png',
            'content' => 'required|string',
            'type_id' => 'nullable|exists:types,id'

        ], [
            'name.required' => 'Il nome è obbligatorio',
            'name.max' => 'Il nome deve essere lungo massimo :max caratteri',
            'name.unique' => "Esiste già un progetto dal titolo $request->name",
            'content.required' => 'non può esistere un progetto senza contenuto',
            'image.image' => "Il file caricato non è valido",
            'type_id.exists' => 'La categoria indicata è inesistente'
        ]);
        $data = $request->all();


        $project = new Project();

        if (array_key_exists('image', $data)) {
            $img_url = Storage::putFile('projects_images', $data['image']);
            $data['image'] = $img_url;
        }

        $project->fill($data);

        $project->slug = Str::slug($project->name, '-');

        $project->save();
        return to_route('admin.projects.show', compact('project'))->with('alert-type', 'success')->with('alert-message', 'Progetto aggiunto con successo');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {



        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)

    {
        $types = Type::all();

        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('projects')->ignore($project)],
            'image' => 'nullable|image:jpg,jpeg,png',
            'content' => 'required|string'

        ], [
            'name.required' => 'Il nome è obbligatorio',
            'name.max' => 'Il nome deve essere lungo massimo :max caratteri',
            'name.unique' => "Esiste già un progetto dal titolo $request->name",
            'content.required' => 'non può esistere un progetto senza contenuto',
            'image.image' => "Il file caricato non è valido",
        ]);
        $data = $request->all();
        $data['slug'] = Str::slug($data['name'], '-');
        $project->update($data);
        return to_route('admin.projects.index', $project)->with('alert-type', 'success')->with('alert-message', 'Progetto modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('admin.projects.index')->with('alert-type', 'danger')->with('alert-message', 'Progetto eliminato con successo');
    }

    public function trash()
    {
        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trash', compact('projects'));
    }


    public function restore(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();
        return to_route('admin.projects.index')->with('alert-type', 'success')->with('alert-message', 'Progetto ripristinato con successo');
    }


    public function drop(String $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->forceDelete();

        return to_route('admin.projects.trash')->with('alert-message', "Progetto eliminato definitivamente")->with('alert-type', 'danger');
    }

    public function dropAll()
    {
        Project::onlyTrashed()->forceDelete();

        return to_route('admin.projects.trash')->with('alert-message', "Clear trash")->with('alert-type', 'danger');
    }
}
