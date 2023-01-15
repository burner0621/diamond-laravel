<div class="row">
    @foreach ($files as $file)
    <div class="col-md-3">
        <div class="card p-4 file-manager-item" id="item{{ $file->id }}" data-id="{{ $file->id }}"
            data-file-path="{{ $file->getImageOptimizedFullName(400) }}">
            <div class="check-option d-none">✔</div>
            {{-- <span class="file-created-at">{{ date('F d, Y, h:i:s A', strtotime($file->created_at)) }}</span> --}}
            <span class="file-created-at">{{ $file->created_at->format('M d, Y, h:i:s A') }}</span>
            @if ($file->type != 'image')
              <img src="{{ asset('assets/img/file.svg') }}" alt="">
            @else
              <img src="{{ $file->getImageOptimizedFullName() }}" class="card-img-top img-thumbnail" alt="{{ $file->file_name }}">
            @endif
            <div class="card-body">
                <h5 class="card-title text-center">{{ $file->getOriginalFileFullName() }}</h5>
                <span class="file-size">{{ number_format($file->file_size/1024/1024, 2, ".", ",") }} MB</span>
            </div>
        </div>

    </div>
    @endforeach
    <div id="pagination">
        {{ $files->links() }}
    </div>
</div>

<script>
    $(function() {
        $('ul.pagination').find('li').each(function() {
            var link = $(this).find('a');

            if (link.length) {
                $(this).html(
                    `<span class="page-link" data-href="${$(link).attr('href')}">${$(link).text()}</span>`
                )
            }
        });
    })
</script>
