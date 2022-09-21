@if ($errors->any())
    <div class="mt-2 mb-2">
        <ul class="list-group">
            @foreach ($errors->all() as $error)
                {{-- <li class="list-group-item list-group-item-danger">{{ $error }}</li> --}}
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        </ul>
    </div>
@endif