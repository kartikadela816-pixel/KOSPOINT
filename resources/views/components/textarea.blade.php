@props(['name', 'label', 'value' => null, 'required' => false, 'rows' => 3, 'hint' => null])

<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="kp-label">
        {{ $label }}@if ($required)<span class="text-red-500"> *</span>@endif
    </label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" @required($required)
              class="kp-input @error($name) border-red-400 @enderror">{{ old($name, $value) }}</textarea>
    @if ($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
