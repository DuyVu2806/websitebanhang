@push('style')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush
<div>
    <div id="{{ $quillId }}" wire:ignore ></div>
</div>
@push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['link', 'image'],
            ['blockquote', 'code-block'],
            [{
                'header': 1
            }, {
                'header': 2
            }],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }],
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }],
            [{
                'direction': 'rtl'
            }],
            [{
                'size': ['small', false, 'large', 'huge']
            }],
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            [{
                'color': []
            }, {
                'background': []
            }],
            [{
                'font': []
            }],
            [{
                'align': []
            }],
            ['clean']
        ];
        var quill = new Quill('#{{ $quillId }}', {
            modules: {
                toolbar: toolbarOptions,
            },
            theme: 'snow',
        });
        for (var key in @json($quillStyles)) {
            if (Object.prototype.hasOwnProperty.call(@json($quillStyles), key)) {
                quill.root.style[key] = @json($quillStyles)[key];
            }
        };
        quill.clipboard.dangerouslyPasteHTML(`{!! $this->value !!}`);
        quill.on('text-change', function() {
            let value = document.getElementsByClassName('ql-editor')[0].innerHTML;
            @this.set('value', value)
        });
        
    </script>

@endpush
