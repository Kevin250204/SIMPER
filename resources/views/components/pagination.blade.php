<div class="pagination-wrapper">

    <div class="pagination-info">
        Menampilkan
        {{ $data->firstItem() }}
        -
        {{ $data->lastItem() }}
        dari
        {{ $data->total() }}
        data
    </div>

    {{ $data->links() }}

</div>