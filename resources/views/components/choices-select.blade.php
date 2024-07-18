<!-- resources/views/components/choices-select.blade.php -->

@props(['id', 'name'])

<select id="{{ $id }}" name="{{ $name }}" {{ $attributes }}>
    {{ $slot }}
</select>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectElement = new Choices('#{{ $id }}', {
                searchEnabled: true,
                searchFields: ['label'],
                position: 'bottom',
                shouldSort: false,
                itemSelectText: '',
                maxItems: 1,
                placeholder: 'Seleccione una opción'

                // Opcional: personaliza la plantilla de la opción
                callbackOnCreateTemplates: function(template) {
                    return {
                        choice: function(item) {
                            return template(`
                                <div class="choice">
                                    <span>${item.label}</span>
                                </div>
                            `);
                        },
                    };
                },
            });
        });
    </script>
@endpush
