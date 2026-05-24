{{-- 
    Reusable Checkbox Component
    Usage: <x-form-checkbox name="remember" label="Remember me" />
--}}
@props([
    'name' => '',
    'label' => '',
    'checked' => false,
])

<div class="remember-group">
    <input
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        class="checkbox"
        @if($checked) checked @endif
        {{ $attributes }}
    >
    @if($label)
        <label for="{{ $name }}" class="remember-label">{{ $label }}</label>
    @endif
</div>
