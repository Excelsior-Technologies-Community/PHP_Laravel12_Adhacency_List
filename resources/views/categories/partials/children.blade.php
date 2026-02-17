<ul class="ml-8 mt-4 space-y-3 border-l border-indigo-400/20 pl-6">
    @foreach ($children as $child)
        <li>

            <div class="flex items-center justify-between
                        bg-white/5 border border-white/10
                        px-4 py-2 rounded-xl
                        hover:bg-indigo-500/10 hover:border-indigo-400/30
                        transition duration-300 backdrop-blur-md">

                <span class="text-slate-200">
                    {{ $child->name }}
                </span>

                <span class="text-xs text-slate-400">
                    Child
                </span>
            </div>

            @if ($child->children->count())
                @include('categories.partials.children', [
                    'children' => $child->children
                ])
            @endif

        </li>
    @endforeach
</ul>
