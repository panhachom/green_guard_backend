@php
    $status = $entry->status;
@endphp

@if ($status == 1)
<span class="badge bg-success">Published</span>
@else
<span class="badge bg-warning">Unpublished</span>
@endif
