@extends('layouts.dashboard')

@section('title')
Portfolio | Project Edit
@endsection

@section('content')
<h1>Modifica Projects: {{$project->name}}</h1>

<form action="{{route ('admin.projects.update', $project)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method ('PUT')
    <div class="form-group mb-3">
        <label for="name" class="form-label @error('name') is-invalid @enderror">Name</label>
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="text" name="name" id="name" class="form-control" value="{{old ('name') ?? $project->name }}">
    </div>
    <div class="form-group mb-3">
        <label for="description" class="form-label @error('description') is-invalid @enderror">Description</label>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <textarea name="description" id="description" class="form-control" rows="5">{{old ('description') ?? $project->description }}</textarea>
    </div>
    <div class="form-group mb-3">
        <label for="client" class="form-label @error('client') is-invalid @enderror">Client</label>

        <input type="text" name="client" id="client" class="form-control" value="{{old ('client') ?? $project->client }}">
    </div>

    <div class="form-group mb-3">
        <label for="project-cover-image" class="form-label @error('cover_image') is-invalid @enderror">Cover Image</label>
        @error('cover_image')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="file" name="cover_image" id="project-cover-image" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label for="project-type" class="form-label @error('category_id') is-invalid @enderror">Types</label>
        @error('category_id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <select class="form-select form-select-lg" name="category_id" id="project-type">
            <option value="">-- Scegli un tipo --</option>
            @foreach ($types as $elem)

            <option value="{{ $elem->id }}" {{ old( 'category_id', $project->category_id) == $elem->id ? 'selected' : ''}}>{{$elem->name}}</option>
            @endforeach


        </select>
    </div>

    <div class="form-group mb-3">
        @foreach ($technologies as $elem)
        <div class="form-check @error('technologies') is-invalid  @enderror">

            @if($errors->any())

            <input class="form-check-input" 
                type="checkbox" 
                name="technologies[]"
                value="{{$elem->id}}" 
                id="projects-checkbox-{{$elem->id}}"
                {{in_array($elem->id, old('technologies', [] ) ) ? 'checked' : '' }}>

                
            @else

            <input class="form-check-input" 
            type="checkbox" 
            name="technologies[]"
            value="{{$elem->id}}" 
            id="projects-checkbox-{{$elem->id}}"
            {{ ($project->technologies->contains($elem)) ? 'checked' : '' }}>
     
            @endif

            <label class="form-check-label" for="">{{$elem->name}}</label>
        </div>
        @endforeach
    </div>

    @error('technologies')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror

    <button class="btn btn-primary">Modifica Project</button>
</form>

@endsection