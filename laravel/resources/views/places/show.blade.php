@extends('layouts.box-app')

@section('box-title')
    {{ __('Place') . " " . $place->id }}
@endsection

@section('box-content')
<x-columns columns=2>
    @section('column-1')
        <img class="w-full" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    @endsection

    @section('column-2')
        <div>
            <h2>{{ $place->name }}</h2>
            <p>{{ $place->description }}</p>
            <br>
            <p>Favoritos: {{$place->favorites_count}}</p>
            @if(auth()->check() && $userHasFavorited)
                <form action="{{ route('places.unfavorite', $place->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button>
                        <img style="width: 10%;" src="https://cdn-icons-png.flaticon.com/512/3747/3747736.png" alt="">             
                    </button>                
                </form>
            @else
                <form action="{{ route('places.favorite', $place->id) }}" method="post">
                    @csrf
                    @method('POST')
                    <button>
                        <img style="width: 10%; " src="https://cdn-icons-png.flaticon.com/512/3747/3747725.png" alt="">             
                    </button>                
                </form>
            @endif
        </div>
        <table class="table mt-8">
            <tbody>
                <tr>
                    <td><strong>ID<strong></td>
                    <td>{{ $place->id }}</td>
                </tr>
                <tr>
                    <td><strong>Name</strong></td>
                    <td>{{ $place->name }}</td>
                </tr>
                <tr>
                    <td><strong>Description</strong></td>
                    <td>{{ $place->description }}</td>
                </tr>
                <tr>
                    <td><strong>Lat</strong></td>
                    <td>{{ $place->latitude }}</td>
                </tr>
                <tr>
                    <td><strong>Lng</strong></td>
                    <td>{{ $place->longitude }}</td>
                </tr>
                <tr>
                    <td><strong>Author</strong></td>
                    <td>{{ $author->name }}</td>
                </tr>
                <tr>
                    <td><strong>Created</strong></td>
                    <td>{{ $place->created_at }}</td>
                </tr>
                <tr>
                    <td><strong>Updated</strong></td>
                    <td>{{ $place->updated_at }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-8">
            <x-primary-button href="{{ route('places.edit', $place) }}">
                {{ __('Edit') }}
            </x-danger-button>
            <x-danger-button href="{{ route('places.delete', $place) }}">
                {{ __('Delete') }}
            </x-danger-button>
            <x-secondary-button href="{{ route('places.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>
        </div>
    @endsection
</x-columns>
@endsection
