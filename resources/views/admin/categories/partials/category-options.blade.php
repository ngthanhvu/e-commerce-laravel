@foreach ($categories as $category)
    @if (!isset($currentCategoryId) || $category->id !== $currentCategoryId)
        <option value="{{ $category->id }}"
            {{ isset($selectedCategoryId) && $selectedCategoryId == $category->id ? 'selected' : '' }}>
            {{ str_repeat('— ', $level) }}{{ $category->name }}
        </option>
        @if ($category->children->isNotEmpty())
            @include('admin.categories.partials.category-options', [
                'categories' => $category->children,
                'level' => $level + 1,
                'currentCategoryId' => isset($currentCategoryId) ? $currentCategoryId : null,
                'selectedCategoryId' => isset($selectedCategoryId) ? $selectedCategoryId : null,
            ])
        @endif
    @endif
@endforeach
