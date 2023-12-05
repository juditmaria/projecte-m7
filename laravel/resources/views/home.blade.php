<style>
    @import 'tailwindcss/base';
    @import 'tailwindcss/components';
    @import 'tailwindcss/utilities';

    #user{
        width: 10%;
        position: absolute;
        top: 10px; 
        left: 150px;
        background-color: #1E212B;
    }
    img{
        width: 30px;
    }
    #enviar{
        width: 40px;
    }
</style>
<x-geomir-layout>
    @foreach($post as $postItem)
        <div class="flex">
            <div class="flex items-center justify-center relative">
                <img class="w-2/3 rounded-2xl " src="{{ asset('storage/'.$postItem->file->filepath) }}" title="Image preview">
                <div id="user" class="text-white flex items-center rounded-3xl">
                    <?php $usuario = asset('img/usuario.png'); ?>
                    <a href="#" class="flex items-center ">
                        <img src="{{ $usuario }}" alt="" class="m-2">
                        <p>{{ $postItem->user->name }}</p>
                    </a>
                </div>
                <div class=" h-full bg-gray-800">
                    <ul class="text-white">
                        <?php $like = asset('img/like.png'); ?>
                        <li class="ml-5  w-20 mb-5"><a><img src="{{ $like }}" alt=""></a></li>
                        <?php $comentario = asset('img/comentario.png'); ?>
                        <li class="ml-5 w-20 mb-3"><a><img src="{{ $comentario }}" alt=""></a></li>
                        <?php $enviar = asset('img/enviar.png'); ?>
                        <li class="ml-4  w-20 mb-5"><a><img id="enviar" src="{{ $enviar }}" alt=""></a></li>
                        
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="flex items-center justify-center relative">
            <div class=" w-2/3 m-10  text-white ">
                {{ $postItem->description }}
            </div>
        </div>
        <!-- Si solo quieres mostrar detalles del primer lugar, puedes romper el bucle aquí -->
    @endforeach
</x-geomir-layout>

