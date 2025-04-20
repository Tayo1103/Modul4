@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    @if(session('error') || session('success'))
        @php
            $type = session('error') ? 'error' : 'success';
            $message = session($type);
            $bgColor = $type === 'error' ? 'bg-red-500' : 'bg-green-500';
            $id = $type . 'Message';
            $closeFunction = 'close' . ucfirst($type) . 'Message';
        @endphp

        <div id="{{ $id }}" class="{{ $bgColor }} text-white p-4 rounded-lg mb-6 relative">
            <span>{{ $message }}</span>
            <button class="absolute right-5 text-white font-bold" onclick="{{ $closeFunction }}()">X</button>
        </div>

        <script>
            function {{ $closeFunction }}() {
                document.getElementById('{{ $id }}').classList.add('hidden');
            }

            setTimeout(function() {
                var el = document.getElementById('{{ $id }}');
                if (el) el.classList.add('hidden');
            }, 5000);
        </script>
    @endif

    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Manajemen Artikel</h1>

    <div class="mb-6">
        <a href="{{ route('admin.create') }}" class="bg-blue-600 text-white py-2 px-6 rounded-full shadow hover:bg-blue-700 transition duration-200">
            Tambah Artikel
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($articles as $article)
        <div class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition duration-200">
            @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover rounded mb-4">
            @endif
            <div class="flex justify-between items-center mt-4">
                <h2 class="text-xl font-semibold text-gray-900">{{ $article->title }}</h2>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.edit', $article) }}" class="text-blue-600 hover:underline">Edit</a>
                    <p>|</p>
                    <form action="{{ route('admin.destroy', $article) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
            <p class="text-gray-700 mt-2">{{ Str::limit($article->content, 150) }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection
