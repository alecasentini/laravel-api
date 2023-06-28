@extends('layouts.dashboard')

@section('title')
Portfolio | Project Show
@endsection

@section('content')
<h1>Singolo Projects: {{$project->name}}</h1>

<img class="img-fluid" src="{{ asset('storage/' . $project->cover_image) }}" alt="">

<p>
    Descrizione: {{$project->description}}
</p>
<p>
    Cliente: {{$project->client}}
</p>


{{-- questa dovrebbe essere la funzione corretta {{$project->type->name}} --}}

<p>
    Tipo: {{ $type->name }}
    
</p>

<p>
    Tecnologie:
    @if ($project->technologies)
        @foreach ($project->technologies as $elem)
            <span>{{ $elem->name }}</span>
        @endforeach
    @endif
</p>




@endsection