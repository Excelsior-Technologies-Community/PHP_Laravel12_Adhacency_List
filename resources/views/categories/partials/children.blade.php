<ul class="ml-8 mt-4 space-y-3 border-l border-indigo-400/20 pl-6">
    @foreach ($children as $child)
        <li>

            <div class="flex items-center justify-between
                            bg-white/5 border border-white/10
                            px-4 py-2 rounded-xl
                            hover:bg-indigo-500/10 transition">

                <!-- NAME -->
                <div>
                    <span class="text-slate-200">
                        {{ $child->name }}
                    </span>

                    <span class="text-xs text-slate-400 ml-2">
                        Child
                    </span>
                </div>

                <!-- ACTIONS -->
                <div class="flex gap-2 text-sm">

                    <!-- STATUS -->
                    <a href="/categories/toggle/{{ $child->id }}" class="px-2 py-1 rounded
                           {{ $child->status ? 'bg-green-500' : 'bg-gray-500' }}">
                        {{ $child->status ? 'Active' : 'Inactive' }}
                    </a>

                    <!-- DELETE -->
                    <a href="/categories/delete/{{ $child->id }}" class="bg-red-500 px-2 py-1 rounded hover:bg-red-600">
                        Delete
                    </a>

                </div>
            </div>

            <!-- RECURSION -->
            @if ($child->children->count())
                @include('categories.partials.children', [
                    'children' => $child->children
                ])
            @endif

            </li>
    @endforeach
</ul>