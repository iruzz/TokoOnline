<x-admin-layout>
    <x-slot name="title">Edit Product</x-slot>
    <x-slot name="header">Edit Product</x-slot>
    <x-slot name="subtitle">Update product information</x-slot>

    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
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
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}"
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
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
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
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
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
                                <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}" step="0.01" min="0"
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
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock') border-red-500 @enderror">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                                SKU <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
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
                            <input type="text" name="size" id="size" value="{{ old('size', $product->size) }}" placeholder="e.g., S, M, L, XL"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('size') border-red-500 @enderror">
                            @error('size')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                                Color <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <input type="text" name="color" id="color" value="{{ old('color', $product->color) }}" placeholder="e.g., Black, White, Blue"
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
                            <input type="text" name="badge" id="badge" value="{{ old('badge', $product->badge) }}" placeholder="e.g., New, Sale, Hot"
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
                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Is Trending Checkbox -->
                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_trending" id="is_trending" value="1" {{ old('is_trending', $product->is_trending) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_trending" class="ml-2 text-sm font-medium text-gray-700">
                                Mark as Trending Product
                            </label>
                        </div>
                    </div>

                    <!-- Current Images Gallery with Instant Delete -->
                    @if($product->productImages->count() > 0)
                        <div x-data="existingImagesManager({{ $product->productImages->toJson() }})">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Current Images <span class="text-gray-400 text-xs">(Drag to reorder, Click X to delete)</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                <template x-for="(image, index) in existingImages" :key="image.id">
                                    <div class="relative group cursor-move"
                                         draggable="true"
                                         @dragstart="dragStart($event, index)"
                                         @dragover.prevent
                                         @drop="drop($event, index)"
                                         :class="{ 'opacity-50': dragging === index }">
                                        <img :src="'/storage/' + image.image_path" 
                                             :alt="image.id"
                                             class="w-full h-32 rounded-lg object-cover border-2"
                                             :class="image.is_primary ? 'border-blue-500' : 'border-gray-200'">
                                        
                                        <!-- Primary Badge -->
                                        <span x-show="image.is_primary" 
                                              class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                            Primary
                                        </span>
                                        
                                        <!-- Order Badge -->
                                        <span class="absolute bottom-2 right-2 bg-gray-900 bg-opacity-75 text-white text-xs px-2 py-1 rounded">
                                            #<span x-text="index + 1"></span>
                                        </span>
                                        
                                        <!-- Delete Button -->
                                        <button type="button"
                                                @click="deleteImage(image.id, index)"
                                                class="absolute top-2 right-2 bg-red-600 text-white p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700 z-10">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        
                                        <!-- Drag Handle -->
                                        <div class="absolute bottom-2 left-2 bg-gray-900 bg-opacity-75 text-white p-1 rounded opacity-0 group-hover:opacity-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            
                            <!-- Hidden inputs for reordering only -->
                            <template x-for="(image, index) in existingImages" :key="'order-' + image.id">
                                <input type="hidden" 
                                       :name="'image_order[' + image.id + ']'" 
                                       :value="index + 1">
                            </template>
                            
                            <p class="text-sm text-gray-500">
                                Drag images to change order. Click X to delete image immediately.
                            </p>
                        </div>
                        
                        <script>
                            function existingImagesManager(images) {
                                return {
                                    existingImages: images.sort((a, b) => a.order - b.order),
                                    dragging: null,
                                    
                                    async deleteImage(imageId, index) {
                                        if (!confirm('Are you sure you want to delete this image? This action cannot be undone.')) {
                                            return;
                                        }
                                        
                                        // Check if this is the last image
                                        if (this.existingImages.length <= 1) {
                                            alert('Cannot delete the last image. Product must have at least one image.');
                                            return;
                                        }
                                        
                                        try {
                                            const response = await fetch(`/admin/product/image/${imageId}`, {
                                                method: 'DELETE',
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                    'Accept': 'application/json',
                                                }
                                            });
                                            
                                            const data = await response.json();
                                            
                                            if (data.success) {
                                                // Remove from array
                                                this.existingImages.splice(index, 1);
                                                
                                                // Update first image to primary if needed
                                                if (this.existingImages.length > 0) {
                                                    this.existingImages[0].is_primary = 1;
                                                }
                                            } else {
                                                alert(data.message || 'Failed to delete image');
                                            }
                                        } catch (error) {
                                            console.error('Error:', error);
                                            alert('An error occurred while deleting the image');
                                        }
                                    },
                                    
                                    dragStart(event, index) {
                                        this.dragging = index;
                                        event.dataTransfer.effectAllowed = 'move';
                                    },
                                    
                                    drop(event, dropIndex) {
                                        event.preventDefault();
                                        if (this.dragging !== null && this.dragging !== dropIndex) {
                                            const draggedItem = this.existingImages[this.dragging];
                                            this.existingImages.splice(this.dragging, 1);
                                            this.existingImages.splice(dropIndex, 0, draggedItem);
                                            
                                            // Update primary status (first image is always primary)
                                            this.existingImages.forEach((img, idx) => {
                                                img.is_primary = idx === 0 ? 1 : 0;
                                            });
                                        }
                                        this.dragging = null;
                                    }
                                }
                            }
                        </script>
                    @endif

                    <!-- Upload New Images with Drag & Drop -->
                    <div x-data="newImageUploader()">
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                            Add More Images <span class="text-gray-400 text-xs">(Drag to reorder)</span>
                        </label>
                        <input type="file" 
                               @change="handleFiles($event)" 
                               accept="image/*" 
                               multiple
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('images') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Max size: 2MB per image. Drag to reorder before uploading.</p>
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- New Images Preview -->
                        <div x-show="images.length > 0" 
                             class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <template x-for="(image, index) in images" :key="index">
                                <div class="relative group cursor-move"
                                     draggable="true"
                                     @dragstart="dragStart($event, index)"
                                     @dragover.prevent
                                     @drop="drop($event, index)"
                                     :class="{ 'opacity-50': dragging === index }">
                                    <img :src="image.preview" 
                                         class="w-full h-32 object-cover rounded-lg border-2 border-green-500">
                                    
                                    <span class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
                                        New
                                    </span>
                                    
                                    <span class="absolute top-2 right-2 bg-gray-900 bg-opacity-75 text-white text-xs px-2 py-1 rounded">
                                        #<span x-text="index + 1"></span>
                                    </span>
                                    
                                    <button type="button"
                                            @click="removeImage(index)"
                                            class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-50 transition-all rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <span class="bg-red-600 text-white p-2 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    
                                    <div class="absolute bottom-2 left-2 bg-gray-900 bg-opacity-75 text-white p-1 rounded opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                        </svg>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <div x-ref="hiddenInputs"></div>
                    </div>

                    <script>
                        function newImageUploader() {
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
                                    event.target.value = '';
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
                                    
                                    const dataTransfer = new DataTransfer();
                                    this.images.forEach(image => {
                                        dataTransfer.items.add(image.file);
                                    });
                                    
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
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <!-- Delete Button - OUTSIDE MAIN FORM -->
                        <button type="button"
                                @click="if(confirm('Are you sure you want to delete this product? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }" 
                                class="px-6 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                            Delete Product
                        </button>

                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.product.index') }}" 
                               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Update Product
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Separate Delete Form - OUTSIDE MAIN FORM -->
            <form id="delete-form" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

</x-admin-layout>