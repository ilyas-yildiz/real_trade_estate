@extends('admin.layouts.app')

@section('title', 'Komisyon Raporum')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Komisyon Raporum</h4>
            </div>

            <div class="card-body">
                <p class="text-muted">Onaylanan müşteri çekim taleplerinden kazandığınız komisyonların dökümü.</p>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Müşteri</th>
                                <th scope="col">Çekim Tutarı</th>
                                <th scope="col">Komisyon Oranı</th>
                                <th scope="col">Net Kazanç</th>
                                <th scope="col">İşlem Tarihi</th>
                                <th scope="col">İlişkili Çekim ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($commissions as $commission)
                                <tr>
                                    <td>{{ $commission->customer->name ?? 'Silinmiş Kullanıcı' }}</td>
                                    <td>{{ number_format($commission->withdrawal_amount, 2, ',', '.') }}</td>
                                    <td>% {{ number_format($commission->commission_rate, 2) }}</td>
                                    <td>
                                        <span class="text-success fw-semibold">
                                            + {{ number_format($commission->commission_amount, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>{{ $commission->created_at->format('d.m.Y H:i') }}</td>
                                    <td># {{ $commission->withdrawal_request_id }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">Henüz komisyon kazanmamışsınız.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Linkleri --}}
                 <div class="mt-3">
                    {{ $commissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection