<div wire:ignore x-data x-init="document.addEventListener('DOMContentLoaded', function() {

    const pond = FilePond.create($refs.input, {
        allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
        server: {
            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
            },
            revert: (filename, load) => {
                @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
            },
        },
    });
    this.addEventListener('pondReset', e => {
        pond.removeFiles();
    });

});">
    <input type="file" x-ref="input" {!! isset($attributes['accept']) ? 'accept="' . $attributes['accept'] . '"' : '' !!}>
</div>
