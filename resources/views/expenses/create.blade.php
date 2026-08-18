<x-app-layout>
    <x-slot name="header"><h2 class="font-serif text-2xl text-ink leading-tight">Add expense</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-hairline overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <x-input-label value="Category" />
                        <div class="flex gap-2 overflow-x-auto pb-2 mt-1" id="category-pills">
                            @foreach($categories as $category)
                                <button type="button"
                                        class="category-pill px-4 py-2 min-h-[36px] rounded-full font-medium whitespace-nowrap text-sm border border-hairline text-ink hover:border-ledger transition"
                                        data-value="{{ $category->name }}">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                            <button type="button"
                                    class="category-pill px-4 py-2 min-h-[36px] rounded-full font-medium whitespace-nowrap text-sm border border-hairline text-ink hover:border-ledger transition"
                                    data-value="Other">
                                Other
                            </button>
                        </div>
                        <input type="hidden" name="category" id="category-input" value="{{ old('category') }}">
                        @error('category') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4" id="description-field" style="display: none;">
                        <x-input-label value="What's this expense for?" />
                        <x-text-input type="text" name="description" value="{{ old('description') }}" class="w-full mt-1" />
                        @error('description') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Amount" />
                        <x-text-input type="number" step="0.01" name="amount" min="0" value="{{ old('amount') }}" class="w-full mt-1 font-mono" />
                        @error('amount') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Date" />
                        <x-text-input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full mt-1" />
                        @error('date') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Receipt (optional)" />
                        <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf" class="w-full mt-1 text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-md file:border file:border-hairline file:bg-paper file:text-ink file:text-sm hover:file:bg-white">
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, or PDF. Max 5MB.</p>
                        @error('receipt') <p class="text-negative text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <x-primary-button>Save expense</x-primary-button>
                    <a href="{{ route('expenses.index') }}" class="ml-2 text-gray-500 hover:text-ink hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        const pills = document.querySelectorAll('.category-pill');
        const categoryInput = document.getElementById('category-input');
        const descriptionField = document.getElementById('description-field');

        function selectPill(value) {
            pills.forEach(function (p) {
                if (p.dataset.value === value) {
                    p.classList.remove('border-hairline', 'text-ink');
                    p.classList.add('bg-ledger', 'text-paper', 'border-ledger');
                } else {
                    p.classList.remove('bg-ledger', 'text-paper', 'border-ledger');
                    p.classList.add('border-hairline', 'text-ink');
                }
            });
            categoryInput.value = value;
            descriptionField.style.display = value === 'Other' ? 'block' : 'none';
        }

        pills.forEach(function (pill) {
            pill.addEventListener('click', function () {
                selectPill(this.dataset.value);
            });
        });

        if (categoryInput.value) {
            selectPill(categoryInput.value);
        }
    </script>
</x-app-layout>