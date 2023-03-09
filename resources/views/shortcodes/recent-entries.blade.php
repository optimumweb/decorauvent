<div class="columns is-multiline">
    @foreach ($entries as $entry)
        <div class="column is-4">
            @include('partials.post-preview')
        </div>
    @endforeach
</div>
