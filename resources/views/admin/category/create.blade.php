<x-admin-layout>
    <x-slot name="title">Add Category</x-slot>
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Add New Category</h1>
                <p class="text-sm text-gray-500">Create a new product category</p>
            </div>
            <a href="{{ route('admin.category.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Category Information</h2>
            </div>

            <form action="{{ route('admin.category.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        placeholder="e.g., T-Shirts, Pants, Jackets"
                        required
                        autofocus
                        onkeyup="generateSlug()"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="slug" 
                        id="slug" 
                        value="{{ old('slug') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                        placeholder="e.g., t-shirts, pants, jackets"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500">URL-friendly version of the name. Auto-generated from name.</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                        placeholder="Brief description about this category"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icon (Emoji)
                    </label>
                    <div class="flex items-center space-x-3">
                        <input 
                            type="text" 
                            name="icon" 
                            id="icon" 
                            value="{{ old('icon') }}"
                            class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl @error('icon') border-red-500 @enderror"
                            placeholder="👕"
                            maxlength="10"
                        >
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Choose an emoji to represent this category</p>
                            <div class="mt-2 flex gap-2">
                                <button type="button" onclick="document.getElementById('icon').value='👕'" class="px-3 py-1 text-2xl hover:bg-gray-100 rounded">👕</button>
                                <button type="button" onclick="document.getElementById('icon').value='👖'" class="px-3 py-1 text-2xl hover:bg-gray-100 rounded">👖</button>
                                <button type="button" onclick="document.getElementById('icon').value='🧥'" class="px-3 py-1 text-2xl hover:bg-gray-100 rounded">🧥</button>
                                <button type="button" onclick="document.getElementById('icon').value='👟'" class="px-3 py-1 text-2xl hover:bg-gray-100 rounded">👟</button>
                                <button type="button" onclick="document.getElementById('icon').value='🎒'" class="px-3 py-1 text-2xl hover:bg-gray-100 rounded">🎒</button>
                                <button type="button" onclick="document.getElementById('icon').value='👒'" class="px-3 py-1 text-2xl hover:bg-gray-100 rounded">👒</button>
                                <button type="button" onclick="document.getElementById('icon').value='🕶️'" class="px-3 py-1 text-2xl hover:bg-gray-100 rounded">🕶️</button>
                            </div>
                        </div>
                    </div>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div>
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <span class="ml-2 text-sm font-medium text-gray-700">Active</span>
                    </label>
                    <p class="mt-1 ml-6 text-xs text-gray-500">Inactive categories won't be displayed on the website</p>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.category.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-generate slug from name
        function generateSlug() {
            const name = document.getElementById('name').value;
            const slug = name
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slug;
        }
    </script>
    @endpush

</x-admin-layout>