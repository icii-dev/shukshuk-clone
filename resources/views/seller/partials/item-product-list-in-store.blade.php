<div class="body">
    @if (count($pagedProduct->items()) > 0)
        @foreach($pagedProduct->items() as $product)
            <div class="row">
                <div class="col-1 stt text-center">{{ $loop->iteration + ($pagedProduct->currentPage() - 1) * $pagedProduct->perPage() }}</div>
                <div class="col-3">{{ \Illuminate\Support\Str::words($product->name, 10) }}</div>
                <div class="col-4">{!! \Illuminate\Support\Str::words($product->description, 10, '...') !!}</div>
                <div class="col text-center">{{ moneyFormat($product->price) }}</div>
                <div class="col-1 text-center">{{ $product->quantity === -1 ? '-' : $product->quantity }}</div>
                <div class="col text-center">
                    <a href="{{ route('seller.product.edit', ['id' => $product->id]) }}">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
            </div>
            <hr>
        @endforeach
    @else
        <p class="body-seller-home-empty text-center">@lang('Start adding your products!') :)</p>
    @endif
</div>