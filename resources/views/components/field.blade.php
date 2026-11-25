@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'hint' => null, 'bag' => 'default'])

<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="kp-label">
        {{ $label }}@if ($required)<span class="text-red-500"> *</span>@endif
    </label>
    <input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}"
           @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
           @required($required)
           {{ $attributes->except('class') }}
           class="kp-input @error($name, $bag) border-red-400 @enderror">
    @if ($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif
    @error($name, $bag)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
