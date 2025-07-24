<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-{$theme}"]) }}
    @isset($nameID)name="{{ $nameID }}" id="{{ $nameID }}"@endisset>
    @isset($icon) <i class="{{ $icon }}"></i> @endisset
    @isset($label) {{ $label }} @endisset
</button>
