@props([
    'count' => 0
])

@if($count > 0)
    <x-alert-banner 
        type="warning" 
        message="{{ $count }} tugas memiliki deadline dalam 24 jam ke depan!" 
    />
@endif
