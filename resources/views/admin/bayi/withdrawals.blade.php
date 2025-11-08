@extends('admin.layouts.app')

@section('title', 'Müşteri Çekim Raporu')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Müşteri Çekim Raporu (Sadece Onaylananlar)</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Müşteri</th>
                                <th scope="col">Tutar</th>
                                <th scope="col">Yöntem</th>
                                <th scope="col">Onay Tarihi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($withdrawals as $withdrawal)
                                <tr>
                                    <td>{{ $withdrawal->user->name ?? 'Silinmiş Kullanıcı' }}</td>
                                    <td>{{ number_format($withdrawal->amount, 2, ',', '.') }}</td>
                                    <td>
                                        @if ($withdrawal->method)
                                            @if ($withdrawal->method_type == 'App\Models\UserBankAccount')
                                                <span class="badge bg-primary-subtle text-primary">Banka</span>
                                            @elseif ($withdrawal->method_type == 'App\Models\UserCryptoWallet')
                                                <span class="badge bg-secondary-subtle text-secondary">Kripto</span>
                                            @endif
                                        @else
                                            <span class="text-danger small">Yöntem Silinmiş</span>
                                        @endif
                                    </td>
                                    <td>{{ $withdrawal->reviewed_at ? $withdrawal->reviewed_at->format('d.m.Y H:i') : '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Müşterilerinize ait onaylanmış bir çekim talebi bulunmuyor.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="mt-3">
                    {{ $withdrawals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection