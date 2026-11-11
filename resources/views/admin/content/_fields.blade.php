@props(['fields', 'values' => [], 'prefix' => ''])

@php
    $values = is_array($values) ? $values : [];
@endphp

<div class="space-y-5">
    @foreach($fields as $key => $field)
        @php
            $name = $prefix !== '' ? $prefix.'_'.$key : $key;
            $value = old($name, array_key_exists($key, $values) ? $values[$key] : ($field['default'] ?? null));
        @endphp

        @include('admin.content._field', [
            'name' => $name,
            'field' => $field,
            'value' => $value,
        ])
    @endforeach
</div>
