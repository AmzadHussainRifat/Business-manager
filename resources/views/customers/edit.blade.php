<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Edit customer</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('customers.update', $customer) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <x-input-label value="Name" />
                        <x-text-input type="text" name="name" value="{{ old('name', $customer->name) }}" class="w-full mt-1" />
                        @error('name') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <x-input-label value="Phone" />
                        <x-text-input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full mt-1" />
                        @error('phone') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <x-input-label value="Email (optional)" />
                        <x-text-input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full mt-1" />
                        @error('email') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <x-primary-button>Update customer</x-primary-button>
                    <a href="{{ route('customers.index') }}" class="ml-2 text-gray-500 hover:text-ink hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>