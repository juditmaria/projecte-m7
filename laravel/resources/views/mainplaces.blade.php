<style>
    @import 'tailwindcss/base';
    @import 'tailwindcss/components';
    @import 'tailwindcss/utilities';

    #user{
        width: 20%;
        position: absolute;
        top: 10px; 
        left: 20px;
        background-color: #1E212B;
    }
    img.main-image {
        width: 600px; /* Hacer que todas las imágenes principales ocupen el 100% del ancho del contenedor */
        height: 400px; /* Para mantener la proporción de aspecto */
        max-width: 80%; /* Para asegurarse de que las imágenes no se estiren más allá de su tamaño natural */
    }
    img{
        width: 30px;
    }
    #enviar{
        width: 40px;
    }
</style>
<x-geomir-layout>
<body class="">
@foreach($places as $postItem)
        <div class="flex">
            <div class="flex items-center justify-center relative">
                <img class="rounded-2xl main-image" src="{{ asset('storage/'.$postItem->file->filepath) }}" title="Image preview">
                <div id="user" class="text-white flex items-center rounded-3xl">
                    <?php $usuario = asset('img/usuario.png'); ?>
                    <a href="#" class="flex items-center ">
                        <img src="{{ $usuario }}" alt="" class="m-2">
                        <p>{{ $postItem->user->name }}</p>
                    </a>
                </div>
                <div class=" h-full bg-gray-800">
                    <ul class="text-white">
                        <li class="ml-5  w-20 mb-5"><a>{{ $postItem->name}}</a></li>
                        <li class="ml-5  w-20 mb-5"><a>{{ $postItem->description}}</a></li>
                        <li class="ml-5  w-20 mb-5"><a>{{ $postItem->upload}}</a></li>
                    </ul>
                    <ul class="flex flex-row ml-4">
                        <?php $star = asset('img/star.png'); ?>
                        <li><a href="#"><img src="{{ $star }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ $star }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ $star }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ $star }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ $star }}" alt=""></a></li>
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="flex items-center justify-start relative">
            <div class=" w-2/3 m-10  text-white ">
                {{ $postItem->body }}
            </div>
        </div>
        <!-- Si solo quieres mostrar detalles del primer lugar, puedes romper el bucle aquí -->
    @endforeach
</body>
</x-geomir-layout>

