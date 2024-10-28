<div class="d-flex">

    @if ($status == 0)
        @can('barcode recipient')
            <a class="btn btn-info me-2" href="{{ route('admin.qr-code.barcode', $id) }}"><i class="bx bx-qr me-1"></i>
                Cetak QR Code</a>
        @endcan

        @can('verification recipient')
            <a class="btn btn-info me-2" href="{{ route('admin.qr-code.scan') }}"><i class="bx bx-scan me-1"></i>
                Verifikasi QR Code</a>
        @endcan
    @endif

    @can('delete recipient')
        <form action="{{ route('admin.recipient.destroy', $id) }}" method="POST" role="alert" alert-title="Hapus Data"
            alert-text="Yakin ingin menghapusnya?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger me-2"><i class="bx bx-trash">Hapus</i>
            </button>
        </form>
    @endcan
</div>
