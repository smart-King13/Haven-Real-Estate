@extends('layouts.admin')

@section('title', 'Manage Categories - Admin')
@section('page-title', 'Category Management')

@section('content')
    <!-- Premium Header Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-8 py-16">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1 space-y-2">
                    <h1 class="text-3xl font-semibold text-white font-heading tracking-tight underline decoration-accent-500/30 decoration-8 underline-offset-4">
                        Category Architecture
                    </h1>
                    <p class="text-lg text-primary-100/80 font-normal">
                        Manage property classifications, tags, and organizational taxonomy.
                    </p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <button onclick="openCreateModal()" class="btn-primary inline-flex items-center px-6 py-4 rounded-2xl shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Category
                    </button>
                </div>
            </div>
        </div>
    </div>

<!-- Categories Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($categories as $category)
    <?php 
        // Convert to object if array
        $cat = is_array($category) ? (object)$category : $category;
    ?>
    <div class="bg-white shadow-xl shadow-gray-200/60 rounded-3xl p-8 border border-gray-50 hover:shadow-2xl hover:shadow-accent-600/10 transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $cat->name ?? 'Unnamed' }}</h3>
                @if(isset($cat->description) && $cat->description)
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $cat->description }}</p>
                @else
                    <p class="text-sm text-gray-500 italic">No description provided</p>
                @endif
            </div>
            <div class="flex items-center space-x-1 ml-4">
                <button onclick="editCategory('{{ $cat->id }}', '{{ addslashes($cat->name ?? '') }}', '{{ addslashes($cat->description ?? '') }}')" 
                        class="inline-flex items-center justify-center w-8 h-8 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-150"
                        title="Edit Category">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </button>
                <button onclick="deleteCategory('{{ $cat->id }}', '{{ addslashes($cat->name ?? 'category') }}')" 
                        class="inline-flex items-center justify-center w-8 h-8 rounded-md text-gray-600 hover:text-red-600 hover:bg-red-50 transition-colors duration-150"
                        title="Delete Category">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Linked Listings</span>
            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-accent-50 text-accent-700 border border-accent-100">
                {{ $cat->properties_count ?? 0 }} {{ Str::plural('property', $cat->properties_count ?? 0) }}
            </span>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center mx-auto mb-4">
                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No categories yet</h3>
            <p class="text-gray-600 mb-6 max-w-sm mx-auto">Get started by creating your first property category to organize your listings.</p>
            <button onclick="openCreateModal()" class="btn-primary inline-flex items-center">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Category
            </button>
        </div>
    </div>
    @endforelse
</div>

<!-- Create/Edit Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-primary-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border border-white/20 w-full max-w-md shadow-2xl rounded-3xl bg-white animate-fade-in-up">
        <div class="flex items-center justify-between mb-6">
            <h3 id="modalTitle" class="text-lg font-medium text-gray-900">Add New Category</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" id="categoryId" name="category_id">
            <input type="hidden" id="formMethod" name="_method" value="POST">
            
            <div class="input-group">
                <label for="categoryName" class="field-label required">Category Name</label>
                <input type="text" name="name" id="categoryName" required
                       class="input-field"
                       placeholder="Enter category name">
                <div id="nameError" class="field-error hidden"></div>
            </div>
            
            <div class="input-group">
                <label for="categoryDescription" class="field-label">Description</label>
                <textarea name="description" id="categoryDescription" rows="3"
                          class="textarea-field"
                          placeholder="Describe this category (optional)"></textarea>
                <div id="descriptionError" class="field-error hidden"></div>
            </div>
            
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-50">
                <button type="button" onclick="closeModal()" class="btn-secondary">
                    Cancel
                </button>
                <button type="submit" id="submitBtn" class="btn-primary">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let isEditing = false;
let editingId = null;

function openCreateModal() {
    isEditing = false;
    editingId = null;
    document.getElementById('modalTitle').textContent = 'Add New Category';
    document.getElementById('submitBtn').textContent = 'Create Category';
    document.getElementById('categoryForm').action = '{{ route("admin.categories.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryName').value = '';
    document.getElementById('categoryDescription').value = '';
    clearErrors();
    document.getElementById('categoryModal').classList.remove('hidden');
}

function editCategory(id, name, description) {
    isEditing = true;
    editingId = id;
    document.getElementById('modalTitle').textContent = 'Edit Category';
    document.getElementById('submitBtn').textContent = 'Update Category';
    document.getElementById('categoryForm').action = '{{ route("admin.categories.update", ":id") }}'.replace(':id', id);
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('categoryId').value = id;
    document.getElementById('categoryName').value = name;
    document.getElementById('categoryDescription').value = description || '';
    clearErrors();
    document.getElementById('categoryModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('categoryModal').classList.add('hidden');
    clearErrors();
}

function deleteCategory(id, name) {
    if (confirm(`Are you sure you want to delete the category "${name}"? This action cannot be undone.`)) {
        // Create a form to submit the delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.categories.update", ":id") }}'.replace(':id', id);
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function clearErrors() {
    document.getElementById('nameError').classList.add('hidden');
    document.getElementById('descriptionError').classList.add('hidden');
    document.getElementById('categoryName').classList.remove('error');
    document.getElementById('categoryDescription').classList.remove('error');
}

// Handle form submission
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    clearErrors();
    
    const formData = new FormData(this);
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.textContent;
    
    submitBtn.textContent = 'Processing...';
    submitBtn.disabled = true;
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            // Handle validation errors
            if (data.errors) {
                if (data.errors.name) {
                    document.getElementById('nameError').textContent = data.errors.name[0];
                    document.getElementById('nameError').classList.remove('hidden');
                    document.getElementById('categoryName').classList.add('error');
                }
                if (data.errors.description) {
                    document.getElementById('descriptionError').textContent = data.errors.description[0];
                    document.getElementById('descriptionError').classList.remove('hidden');
                    document.getElementById('categoryDescription').classList.add('error');
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    })
    .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
});

// Close modal when clicking outside
document.getElementById('categoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endpush
@endsection
