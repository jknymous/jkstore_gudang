@props(['title', 'value', 'icon', 'color'])

<div class="bg-white shadow rounded-lg p-5">
    <div class="flex items-center">
        <div class="p-2 rounded-full {{ $color }} bg-opacity-20 mr-3">
            {!! $icon !!}
        </div>
        <div>
            <div class="text-sm text-gray-500 font-medium">{{ $title }}</div>
            <div class="mt-1 text-xl font-semibold text-gray-800">{{ $value }}</div>
        </div>
    </div>
</div>
