@foreach ($categories as $category)
    <tr>
        <th scope="row">{{ $index++ }}</th>
        <td>{{ str_repeat('— ', $level) }}{{ $category->name }}</td>
        <td>{{ $category->description }}</td>
        <td><img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 100px"
                class="border"></td>
        <td>
            <a href="/admin/categories/{{ $category->id }}/edit" class="btn btn-warning btn-sm edit-btn"><i
                    class="bi bi-pencil-square"></i> Sửa</a>
            <form action="/admin/categories/{{ $category->id }}" method="POST" style="display: inline">
                @csrf
                @method('DELETE')
                <button type="button" data-id="{{ $category->id }}" class="btn btn-danger btn-sm delete-btn"><i
                        class="bi bi-trash"></i> Xóa</button>
            </form>
        </td>
    </tr>
    @if ($category->children->isNotEmpty())
        @include('admin.categories.partials.category-list', [
            'categories' => $category->children,
            'level' => $level + 1,
            'index' => $index,
        ])
        @php $index = $index + $category->children->count(); @endphp
    @endif
@endforeach
