<ul class="category-tree">
    @php
        function renderCategory($categories, $level = 0, $currentCategoryId = null)
        {
            foreach ($categories as $category) {
    @endphp
    <li class="category-item @if ($category->children->isNotEmpty()) has-children @endif">
        <a href="{{ route('products', array_filter([
            'category_id' => $category->id,
            'search' => request()->query('search'),
            'price_max' => request()->query('price_max'),
            'sort' => request()->query('sort')
        ])) }}"
            class="category-link @if ($currentCategoryId == $category->id) active @endif"
            data-level="{{ $level }}" style="padding-left: {{ 10 + $level * 20 }}px;">
            <span class="category-name">
                @if ($level > 0)
                    {{ str_repeat('-', $level) }} 
                @endif
                {{ $category->name }}
            </span>
        </a>
        @if ($category->children->isNotEmpty())
            <ul class="category-subtree">
                @php
                    echo renderCategory($category->children, $level + 1, $currentCategoryId);
                @endphp
            </ul>
        @endif
    </li>
    @php
            }
            return '';
        }
        echo renderCategory($categories, 0, $categoryId);
    @endphp
</ul>