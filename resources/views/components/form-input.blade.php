{{-- 
    Reusable Form Input Component
    Usage: <x-form-input name="email" type="email" placeholder="Email" icon="envelope" />
--}}
@props([
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'icon' => '',
    'label' => '',
    'error' => '',
    'value' => '',
])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label">
            @if($icon)
                <i class="fas fa-{{ $icon }}" style="margin-right: 6px; opacity: 0.7;"></i>
            @endif
            {{ $label }}
        </label>
    @endif

    <div class="input-wrapper">
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-input @if($error) error @endif {{ $attributes->get('class', '') }}"
            placeholder="{{ $placeholder }}"
            value="{{ old($name, $value) }}"
            {{ $attributes->except('class') }}
        >
        @if($icon)
            <i class="fas fa-{{ $icon }} input-icon"></i>
        @endif
    </div>

    @if($error)
        <div class="error-message">
            <i class="fas fa-times-circle"></i>
            <span>{{ $error }}</span>
        </div>
    @endif
</div>
