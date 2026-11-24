@props(['name', 'label', 'options' => [], 'value' => null, 'required' => false, 'placeholder' => null])

<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="kp-label">
        {{ $label }}@if ($required)<span class="text-red-500"> *</span>@endif
    </label>
    <select id="{{ $name }}" name="{{ $name }}" @required($required)
            {{ $attributes->except('class') }}
            class="kp-input @error($name) border-red-400 @enderror">
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $nilai => $teks)
            <option value="{{ $nilai }}" @selected((string) old($name, $value) === (string) $nilai)>{{ $teks }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
