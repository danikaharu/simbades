<div class="d-flex">

    @can('view detail assistance')
        <a class="btn btn-info me-2" href="{{ route('admin.detailAssistance.show', $id) }}"><i class="bx bx-show me-1"></i>
            Detail</a>
    @endcan

    @can('edit detail assistance')
        <a class="btn btn-warning me-2" href="{{ route('admin.detailAssistance.edit', $id) }}"><i
                class="bx bx-edit-alt me-1"></i>
            Edit</a>
    @endcan

    @can('delete detail assistance')
        <form action="{{ route('admin.detailAssistance.destroy', $id) }}" method="POST" role="alert"
            alert-title="Hapus Data" alert-text="Yakin ingin menghapusnya?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger me-2"><i class="bx bx-trash">Hapus</i>
            </button>
        </form>
    @endcan
</div>
