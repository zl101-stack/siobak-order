<!DOCTYPE html>
<html>
<head>
    <title>Menu Sio Bak</title>
</head>
<body>

    <h1>Menu Meja {{ $table }}</h1>

    @foreach($menus as $menu)
        <div style="margin-bottom:20px;">
            <h3>{{ $menu->name }}</h3>
            <p>Harga: Rp {{ number_format($menu->price) }}</p>

            @if($menu->image)
                <img src="{{ $menu->image }}" width="100">
            @endif
        </div>
    @endforeach

</body>
</html>