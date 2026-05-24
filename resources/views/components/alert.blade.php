{{-- 
    Reusable Alert Component
    Usage: <x-alert type="error" message="Something went wrong" icon="exclamation-circle" />
--}}
@props([
    'type' => 'info',
    'message' => '',
    'icon' => 'info-circle',
])

<div class="form-alert {{ $type }}">
    <i class="fas fa-{{ $icon }}"></i>
    <span>{{ $message }}</span>
</div>
