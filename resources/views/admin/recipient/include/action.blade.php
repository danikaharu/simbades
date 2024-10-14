<div class="d-flex">

    @if ($status == 0)
        <a class="btn btn-info me-2" href="{{ route('admin.qr-code', $id) }}"><i class="bx bx-qr me-1"></i>
            QR Code</a>
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
