@foreach ($children as $child)
    <li data-id="{{ $child->id }}">

        <div class="flex items-center justify-between bg-white/5 border border-white/10 px-4 py-2 rounded-xl hover:bg-indigo-500/10 transition">
            
            <div class="flex items-center gap-2">
                <span class="drag-handle cursor-move text-slate-400 hover:text-white">☰</span>
                <span class="text-slate-200">
                    {{ $child->name }}
                </span>
                <span class="text-xs text-slate-400 ml-2">
                    Child
                </span>
            </div>

            <div class="flex gap-2 text-sm">
                <a href="/categories/edit/{{ $child->id }}" class="bg-blue-500 px-2 py-1 rounded hover:bg-blue-600 text-white">
                    Edit
                </a>
                
                <a href="/categories/toggle/{{ $child->id }}" class="px-2 py-1 rounded {{ $child->status ? 'bg-green-500' : 'bg-gray-500' }}">
                    {{ $child->status ? 'Active' : 'Inactive' }}
                </a>
                
                <a href="/categories/delete/{{ $child->id }}" class="bg-red-500 px-2 py-1 rounded hover:bg-red-600 text-white">
                    Delete
                </a>
            </div>
        </div>

        <ul class="sortable-list ml-8 mt-4 space-y-3 border-l border-indigo-400/20 pl-6 min-h-[30px]" data-parent-id="{{ $child->id }}">
            @if ($child->children->count())
                @include('categories.partials.children', [
                    'children' => $child->children
                ])
            @endif
        </ul>

    </li>
@endforeach