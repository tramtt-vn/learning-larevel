
    @extends('layouts.app')
<style>
.list-product {
    display: flex;
    justify-content: flex-start;
    max-width: 1080px;
    flex-wrap: wrap;
    gap: 16px;
}
.list-product li {
    width: calc(25% - 12px);
    list-style: none;
}
.list-product li img {
    width: 100%;
    max-height: 200px;
}
</style>
@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Danh sách người dùng</h2>
    <ul class="list-product">
        @foreach ($products as $product)
            <li>
                <img src="{{ asset("storage/".$product->image) }}">
                <span>{{ $product->name }}</span>
                <label>{{ $product->price }}</label>
            </li>
        @endforeach
    </ul>
</div>
@endsection
