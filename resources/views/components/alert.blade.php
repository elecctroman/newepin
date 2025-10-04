<div {{ $attributes->merge(['class' => 'rounded-md p-4 mb-4 bg-'.$type.'-100 text-'.$type.'-800']) }}>
    {{ $slot }}
    @if($message)
        <p>{{ $message }}</p>
    @endif
</div>
