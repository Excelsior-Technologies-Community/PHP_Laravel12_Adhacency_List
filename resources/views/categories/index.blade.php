<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Category Tree</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white">

    <div class="max-w-6xl mx-auto px-6 py-12">

        <div class="bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl mb-8 backdrop-blur-xl">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                Category Hierarchy
            </h1>
            <p class="text-slate-300 mt-2">Manage categories with tree structure</p>
        </div>

        @if(session('success'))
            <div id="successMsg" class="mb-6 p-4 rounded-xl bg-green-500/20 border border-green-400/30 text-green-300 shadow-lg">
                <div class="flex items-center justify-between">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="document.getElementById('successMsg').remove()" class="text-green-200 hover:text-white">
                        ✖
                    </button>
                </div>
            </div>
        @endif

        <div class="flex flex-wrap gap-3 mb-6">
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" placeholder="Search category..." class="px-4 py-2 rounded-lg text-black focus:outline-none">
                <button class="bg-indigo-500 px-4 py-2 rounded-lg hover:bg-indigo-600">
                    Search
                </button>
            </form>

            <a href="/categories/create" class="bg-green-500 px-4 py-2 rounded-lg hover:bg-green-600">
                + Add
            </a>

            <a href="/categories/trash" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600">
                Trash
            </a>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl backdrop-blur-xl">
            <ul class="sortable-list space-y-4 min-h-[50px]" data-parent-id="">
                @forelse ($categories as $category)
                    <li data-id="{{ $category->id }}">

                        <div class="flex items-center justify-between bg-gradient-to-r from-indigo-500/20 to-purple-500/20 border border-indigo-400/20 px-5 py-3 rounded-2xl hover:scale-[1.02] transition duration-300">
                            
                            <div class="flex items-center gap-3">
                                <span class="drag-handle cursor-move text-slate-400 hover:text-white">☰</span>
                                <span class="text-lg font-semibold">
                                    {{ $category->name }}
                                </span>
                                <span class="text-xs text-indigo-300 ml-2">
                                    Root
                                </span>
                            </div>

                            <div class="flex gap-3 text-sm">
                                <a href="/categories/edit/{{ $category->id }}" class="bg-blue-500 px-3 py-1 rounded-lg hover:bg-blue-600 text-white">
                                    Edit
                                </a>

                                <a href="/categories/toggle/{{ $category->id }}" class="px-3 py-1 rounded-lg {{ $category->status ? 'bg-green-500' : 'bg-gray-500' }}">
                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                </a>

                                <a href="/categories/delete/{{ $category->id }}" class="bg-red-500 px-3 py-1 rounded-lg hover:bg-red-600">
                                    Delete
                                </a>
                            </div>
                        </div>

                        <ul class="sortable-list ml-8 mt-4 space-y-3 border-l border-indigo-400/20 pl-6 min-h-[30px]" data-parent-id="{{ $category->id }}">
                            @if ($category->children->count())
                                @include('categories.partials.children', [
                                    'children' => $category->children
                                ])
                            @endif
                        </ul>

                    </li>
                @empty
                    <p class="text-center text-slate-400">No categories found</p>
                @endforelse
            </ul>
        </div>

    </div>
    
    <script>
        setTimeout(() => {
            let msg = document.getElementById('successMsg');
            if(msg) msg.remove();
        }, 3000);

        document.querySelectorAll('.sortable-list').forEach(function(el) {
            new Sortable(el, {
                group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                handle: '.drag-handle',
                onEnd: function (evt) {
                    let itemEl = evt.item;
                    let toList = evt.to;
                    let itemId = itemEl.getAttribute('data-id');
                    let newParentId = toList.getAttribute('data-parent-id') || null;

                    fetch('/categories/move', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: itemId, parent_id: newParentId })
                    }).then(res => res.json()).then(data => {
                        if(!data.success) {
                            alert('⚠️ Invalid Move: ' + data.message);
                            location.reload();
                        }
                    }).catch(error => {
                        alert('⚠️ Something went wrong!');
                        location.reload();
                    });
                }
            });
        });
    </script>

</body>
</html>