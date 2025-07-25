<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container" style="max-width: 500px; margin: 40px auto;">
        <h2 style="text-align: center;">Cambiar Foto de Perfil</h2>

        @if(session('success'))
            <div style="color: green; margin-top: 15px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
            @csrf

            @if (Auth::user()->profile_photo)
                <div style="text-align: center;">
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto actual"
                         style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                </div>
            @endif

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="profile_photo">Selecciona una imagen:</label>
                <input type="file" name="profile_photo" id="profile_photo" required>
                @error('profile_photo')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn" style="background-color: #6abf4b; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer;">
                Subir Foto
            </button>
        </form>
    </div>
</x-app-layout>
