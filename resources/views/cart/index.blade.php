@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')

<h2 class="section-title text-center mb-4">
    <i class="bi bi-cart3 me-2"></i> Giỏ hàng của bạn
</h2>

@if(empty($cart))

<div class="text-center py-5">
    <i class="bi bi-cart-x fs-1 text-gold"></i>
    <p class="fs-5 text-gold mt-2">Giỏ hàng của bạn đang trống!</p>
    <a href="{{ route('products.index') }}" 
       class="btn btn-outline-gold fw-bold rounded-pill mt-3 d-inline-flex align-items-center justify-content-center">
        <i class="bi bi-shop me-1"></i> Mua sắm ngay
    </a>
</div>

@else

<div class="table-responsive">
    <table class="table align-middle text-center bg-light rounded-3 overflow-hidden shadow">
        <thead class="bg-dark text-gold">
            <tr>
                <th width="90">Ảnh</th>
                <th>Sản phẩm</th>
                <th width="120">Giá</th>
                <th width="140">Số lượng</th>
                <th width="120">Tổng</th>
                <th width="140">Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($cart as $id => $item)
            @php $lineTotal = $item['price'] * $item['quantity']; @endphp

            <tr>
                <td>
                    <img src="{{ asset('storage/'.$item['thumbnail']) }}" width="70" height="70"
                         class="rounded shadow-sm">
                </td>

                <td class="fw-bold text-gold">{{ $item['name'] }}</td>

                <td class="fw-bold text-gold">
                    {{ number_format($item['price'],0,',','.') }}₫
                </td>

                <td>
                    <span class="qty-display">{{ $item['quantity'] }}</span>

                    <form action="{{ route('cart.update', $id) }}" method="POST" 
                          class="qty-form d-none d-inline-block">
                        @csrf
                        <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}"
                               class="form-control form-control-sm text-center"
                               style="width:70px;">
                    </form>
                </td>

                <td class="fw-bold text-gold">
                    {{ number_format($lineTotal,0,',','.') }}₫
                </td>

                <td>
                    <div class="d-flex justify-content-center gap-2">

                        {{-- Edit --}}
                        <button type="button" class="btn btn-icon btn-edit">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        {{-- Save --}}
                        <button type="button" class="btn btn-icon btn-save d-none">
                            <i class="bi bi-check-lg"></i>
                        </button>

                        {{-- Remove --}}
                        <a href="{{ route('cart.remove', $id) }}" class="btn btn-icon"
                           onclick="return confirm('Xóa sản phẩm này?')">
                            <i class="bi bi-trash"></i>
                        </a>

                    </div>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

<div class="text-end mt-4">
    <h3 class="section-title">
        Tổng tiền: <span class="text-gold">{{ number_format($total,0,',','.') }}₫</span>
    </h3>

    <a href="{{ route('checkout.show') }}" 
       class="btn btn-gold btn-lg fw-bold rounded-pill px-5 mt-3 d-inline-flex align-items-center">
        <i class="bi bi-credit-card me-2 text-white"></i>
        Thanh toán
    </a>
</div>

@endif
@endsection


@push('scripts')
<script>
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function () {
        const tr = this.closest('tr');
        tr.querySelector('.qty-display').classList.add('d-none');
        tr.querySelector('.qty-form').classList.remove('d-none');
        tr.querySelector('.btn-save').classList.remove('d-none');
        this.classList.add('d-none');
    });
});

document.querySelectorAll('.btn-save').forEach(btn => {
    btn.addEventListener('click', function () {
        this.closest('tr').querySelector('.qty-form').submit();
    });
});
</script>
@endpush
