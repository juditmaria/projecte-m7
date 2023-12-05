<style>
    @import 'tailwindcss/base';
    @import 'tailwindcss/components';
    @import 'tailwindcss/utilities';

    h1 {
        color: yellow;
    }
    #user{
        width: 10%;
        position: absolute;
        top: 0px; 
        left: 110px;
    }
    img{
        width: 40px;
    }
</style>
<x-geomir-layout>
    @foreach($places as $placeItem)
        <div class="flex items-center justify-center relative">
            <img class="w-2/3" src="{{ asset('storage/'.$placeItem->file->filepath) }}" title="Image preview">
            <div id="user" class="p-4 text-white flex items-center ">
                <?php $usuario = asset('img/usuario.png'); ?>
                <a href="#" class="flex items-center ">
                    <img src="{{ $usuario }}" alt="" class="mr-2">
                    <p>{{ $placeItem->user->name }}</p>
                </a>
            </div>
        </div>
        <div class="mb-10 p-4 text-white">
            {{ $placeItem->description }}
        </div>
        <!-- Si solo quieres mostrar detalles del primer lugar, puedes romper el bucle aquí -->
    @endforeach
</x-geomir-layout>

