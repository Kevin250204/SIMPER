@props([
    'data',
    'anchor' => null
])

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

    @if($anchor)

        {{ $data->fragment($anchor)->links() }}

    @else

        {{ $data->links() }}

    @endif

</div>