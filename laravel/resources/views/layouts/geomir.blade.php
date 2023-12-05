<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            color: white;
            height: 100%;
        }

        #main {
            height: 100vh;
        }

        button {
            background-color: #D81159;
            border-color: #D81159;
        }

        #menu {
            width: 50px;
        }
    </style>
</head>
<body>
    <div id="main" class=" flex h-screen bg-gray-100">
        <div class="flex items-center justify-center w-64 bg-gray-800">
            <ul class="text-white">
                <?php $home = asset('img/home.png'); ?>
                <li class="p-2 mb-5"><a href="{{ route('home') }}"><img id="menu" src="{{ $home }}" alt=""></a></li>
                <?php $places = asset('img/places.png'); ?>
                <li class="p-2 mb-5"><a href="#"><img id="menu" src="{{ $places }}" alt=""></a></li>
                <?php $new = asset('img/new.png'); ?>
                <li class="p-2 mb-5"><a href="#"><img id="menu" src="{{ $new }}" alt=""></a></li>
                <?php $chat = asset('img/chat.png'); ?>
                <li class="p-2 mb-5"><a href="#"><img id="menu" src="{{ $chat }}" alt=""></a></li>
                <?php $usuario = asset('img/usuario.png'); ?>
                <li class="p-2 mb-5"><a href="#"><img id="menu" src="{{ $usuario }}" alt=""></a></li>
            </ul>
        </div>
        <div class="  w-screen bg-gray-800 flex flex-col items-center justify-center">
			<div class="w-full bg-gray-800 ">
				<div class="flex items-center justify-center bg-gray-800 py-10 w-full ">
					<input type="text w-50" placeholder="Buscar..." class="rounded-l-lg py-2 px-4 border-t mr-0 border-b border-l text-gray-800 border-gray-200 bg-white md:w-2/5">
					<button class="px-2 rounded-r-lg text-white font-bold p-2 uppercase  border-t border-b border-r">Buscar</button>
				</div>
			</div>
			<div class=" overflow-y-auto bg-gray-800 ">
				<!-- Page Content -->
				<main class="max-w-screen-lg w-full p-4">
					@include('partials.flash')
					{{ $slot }}
				</main>
			</div>
		</div>
    </div>
</body>
</html>
