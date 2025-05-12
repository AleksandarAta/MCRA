<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Additional information') }}
        </h2>
    </x-slot>
    @if (session()->has('message'))
            <div class="text-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
             <span class="font-bold">   {{ session('message') }} </span>
            </div>
    @endif

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form  action="{{ route('add.information') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
                    @error('user_id')
                    <span class="text-red-500 text-sm">{{ __("You have already filled this form") }}</span>
                @enderror
                    <div class="flex flex-col">
                        <h2>{{__("Living address")}}</h2>
                       <label for="country" class=" ">{{__("Country")}}</label>
                            @error('country')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                       <x-input class=" w-1/3 " type="text" for="country" name="country" id="country"/> 
                       <label class="" for="city">{{__("city")}}</label> 
                        @error('city')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                       <x-input class="" type="text" for="city" name="city" id="city" /> 
                       <label class="" for="street">{{__("street")}}</label> 
                            @error('street')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                       <x-input class="" type="text" for="street" name="street" id="street" /> 
                       <label class="" for="postal_code">{{__("postal code")}}</label> 
                            @error('postal_code')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                       <x-input class="" type="number" for="postal_code" name="postal_code" id="postal_code" /> 
                    </div> 
                    <div>
                        <h2>{{__("Short Biography")}}</h2>
                        <label class="block" for="title">{{__("title")}}</label> 
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        <x-input class="block" type="text" for="title" name="title" id="title" /> 
                       
                        <label class="block" for="biography">{{__("biography")}}</label> 
                        @error('biography')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <textarea name="biography" id="biography" cols="30" rows="10"></textarea>
                    </div>
                        <x-button>{{__("Save")}}</x-button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ (asset("/tinymce/tinymce.min.js")) }}" referrerpolicy="origin"></script>
<script>
         const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

  tinymce.init({
            selector: 'textarea#biography',
            plugins: 'preview importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            editimage_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            toolbar_sticky_offset: isSmallScreen ? 102 : 108,
            image_advtab: true,
            height: 350,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            skin: useDarkMode ? 'oxide-dark' : 'oxide',
            content_css: useDarkMode ? 'dark' : 'default',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
            promotion: false,
            images_upload_url: '/upload',
            file_picker_types: 'image',
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            file_picker_callback: function (cb, value, meta){
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function(){
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function(){
                        var id = 'blobid'+(new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), {title:file.name});
                    };
                };
                input.click();
            },
         
        });
        
</script>
</x-app-layout>
