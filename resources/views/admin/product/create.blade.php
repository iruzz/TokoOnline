<x-admin-layout>
    <x-slot name="title">Add Product</x-slot>
    <x-slot name="header">Add New Product</x-slot>
    <x-slot name="subtitle">Create a new product for your store</x-slot>

    <div class="max-w-4xl">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.product.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                            Slug <span class="text-gray-400 text-xs">(Auto-generated if empty)</span>
                        </label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="description" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price & Discount Price -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Price <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-2.5 text-gray-500">$</span>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                       class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror">
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-2">
                                Discount Price <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-2.5 text-gray-500">$</span>
                                <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price') }}" step="0.01" min="0"
                                       class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_price') border-red-500 @enderror">
                            </div>
                            @error('discount_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock & SKU -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock') border-red-500 @enderror">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                                SKU <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sku') border-red-500 @enderror">
                            @error('sku')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Size & Color -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="size" class="block text-sm font-medium text-gray-700 mb-2">
                                Size <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <input type="text" name="size" id="size" value="{{ old('size') }}" placeholder="e.g., S, M, L, XL"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('size') border-red-500 @enderror">
                            @error('size')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                                Color <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <input type="text" name="color" id="color" value="{{ old('color') }}" placeholder="e.g., Black, White, Blue"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('color') border-red-500 @enderror">
                            @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Badge & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="badge" class="block text-sm font-medium text-gray-700 mb-2">
                                Badge <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <input type="text" name="badge" id="badge" value="{{ old('badge') }}" placeholder="e.g., New, Sale, Hot"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('badge') border-red-500 @enderror">
                            @error('badge')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Is Trending Checkbox -->
                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_trending" id="is_trending" value="1" {{ old('is_trending') ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_trending" class="ml-2 text-sm font-medium text-gray-700">
                                Mark as Trending Product
                            </label>
                        </div>
                    </div>

                    <!-- Multiple Images Upload with Drag & Drop Ordering -->
                    <div x-data="imageUploader()">
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Images <span class="text-gray-400 text-xs">(Multiple images - Drag to reorder)</span>
                        </label>
                        <input type="file" 
                               @change="handleFiles($event)" 
                               accept="image/*" 
                               multiple
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('images') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Max size: 2MB per image. First image will be the primary image. Drag images to reorder.</p>
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Image Preview Container with Drag & Drop -->
                        <div x-show="images.length > 0" 
                             class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"
                             x-ref="container">
                            <template x-for="(image, index) in images" :key="index">
                                <div class="relative group cursor-move"
                                     draggable="true"
                                     @dragstart="dragStart($event, index)"
                                     @dragover.prevent
                                     @drop="drop($event, index)"
                                     :class="{ 'opacity-50': dragging === index }">
                                    <img :src="image.preview" 
                                         class="w-full h-32 object-cover rounded-lg border-2 border-gray-200"
                                         :class="{ 'border-blue-500': index === 0 }">
                                    
                                    <!-- Primary Badge -->
                                    <span x-show="index === 0" 
                                          class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                        Primary
                                    </span>
                                    
                                    <!-- Order Badge -->
                                    <span class="absolute top-2 right-2 bg-gray-900 bg-opacity-75 text-white text-xs px-2 py-1 rounded">
                                        #<span x-text="index + 1"></span>
                                    </span>
                                    
                                    <!-- Remove Button -->
                                    <button type="button"
                                            @click="removeImage(index)"
                                            class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-50 transition-all rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <span class="bg-red-600 text-white p-2 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    
                                    <!-- Drag Handle Icon -->
                                    <div class="absolute bottom-2 left-2 bg-gray-900 bg-opacity-75 text-white p-1 rounded opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                        </svg>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Hidden file inputs for actual upload -->
                        <div x-ref="hiddenInputs"></div>
                    </div>

                    <script>
                        function imageUploader() {
                            return {
                                images: [],
                                dragging: null,
                                
                                handleFiles(event) {
                                    const files = Array.from(event.target.files);
                                    files.forEach(file => {
                                        if (file.type.startsWith('image/')) {
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                this.images.push({
                                                    file: file,
                                                    preview: e.target.result
                                                });
                                                this.updateHiddenInputs();
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    });
                                    event.target.value = ''; // Reset input
                                },
                                
                                removeImage(index) {
                                    this.images.splice(index, 1);
                                    this.updateHiddenInputs();
                                },
                                
                                dragStart(event, index) {
                                    this.dragging = index;
                                    event.dataTransfer.effectAllowed = 'move';
                                },
                                
                                drop(event, dropIndex) {
                                    event.preventDefault();
                                    if (this.dragging !== null && this.dragging !== dropIndex) {
                                        const draggedItem = this.images[this.dragging];
                                        this.images.splice(this.dragging, 1);
                                        this.images.splice(dropIndex, 0, draggedItem);
                                        this.updateHiddenInputs();
                                    }
                                    this.dragging = null;
                                },
                                
                                updateHiddenInputs() {
                                    const container = this.$refs.hiddenInputs;
                                    container.innerHTML = '';
                                    
                                    // Create DataTransfer to hold files in order
                                    const dataTransfer = new DataTransfer();
                                    this.images.forEach(image => {
                                        dataTransfer.items.add(image.file);
                                    });
                                    
                                    // Create hidden input with ordered files
                                    const input = document.createElement('input');
                                    input.type = 'file';
                                    input.name = 'images[]';
                                    input.multiple = true;
                                    input.files = dataTransfer.files;
                                    input.style.display = 'none';
                                    container.appendChild(input);
                                }
                            }
                        }
                    </script>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.product.index') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Create Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>