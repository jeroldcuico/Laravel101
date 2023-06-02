<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Option Groups') }}
        </h2>
        <a href="/optionsgroups">Back to List</a>
    </x-slot>

    @if(session('status') != '')
    <p
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 3000)"
        class="bg-emerald-200 py-[6px] px-[10px] rounded text-sm text-gray-600">{{ session('status') }}</p>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form id="record-data" method="post" action="{{ $optionGroup->id > 0 ? route('optionsgroups.update', $optionGroup->id) : route('optionsgroups.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @if($optionGroup->id > 0)
                            @method('patch')
                        @endif
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="name" :value="__('Name')"/>
                                <x-text-input id="name" name="name" type="text" value="{{ $optionGroup->name }}" class="mt-1 block w-full" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                            </div>
                            <div>
                            <x-input-label for="description" :value="__('Description')"/>
                            <x-textarea id="description" name="description" label="Description" value="{{ $optionGroup->description }}" rows="5" cols="40"/></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')"/>
                            </div>  
                        </div>                        
                
                    </form>

                    <div class="flex items-center gap-4 mt-[15px]">
                        <x-primary-button onclick="doCancel()">{{ __('Cancel') }}</x-primary-button>
                        <x-primary-button form="record-data">{{ __('Save') }}</x-primary-button>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const doCancel = () =>{
        window.location.href=`/optionsgroups`;
    }

    const validatePassword = () =>{

        const formData = new FormData(document.querySelector('#record-data'));
        const newData = {};

        for (let [key, value] of formData.entries()){
            newData[key] = value;
        }

        // (?=.*[A-Z]) at least one uppercase
        // (?=.*[a-z]) at least one lowercase
        // (?=.*[0-9]) at least one numeric
        // (?=.*[!@#\$%\^&\*]) at least one special char
        // (?=.{8}) at least 8 characters in length
        const regEx = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;

        if(newData.password != ''){
            if(regEx.test(newData.password)){
                if(newData.password ===  newData.confirm_password){
                    return true;
                }
            }
            return false;
        }

        return true;
    }

</script>
