@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh]">
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Verifikasi Email</h2>

        @if (session('resent'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                Link verifikasi baru telah dikirim ke email kamu.
            </div>
        @endif

        <p class="text-gray-700 mb-4">
            Sebelum melanjutkan, silakan periksa email kamu untuk tautan verifikasi.
        </p>
        <p class="text-gray-700 mb-6">
            Jika kamu belum menerima email tersebut,
        </p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                Klik di sini untuk meminta ulang
            </button>
        </form>
    </div>
</div>
@endsection
