<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white flex justify-center items-center">

    <div class="bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl backdrop-blur-xl w-full max-w-lg">
        <h2 class="text-3xl font-bold mb-2">✏️ Edit Category</h2>
        
        <p class="text-indigo-300 text-sm mb-6 bg-indigo-900/40 p-2 rounded-lg border border-indigo-500/30">
            📍 <strong>Path:</strong> {{ $breadcrumbs }}
        </p>

        @if(session('error'))
            <p class="text-red-400 mb-4 bg-red-900/30 p-2 rounded">{{ session('error') }}</p>
        @endif

        <form action="/categories/update/{{ $category->id }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-slate-300 mb-2">Category Name</label>
                <input type="text" name="name" value="{{ $category->name }}" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 focus:outline-none focus:border-indigo-500" required>
            </div>

            <div class="mb-6">
                <label class="block text-slate-300 mb-2">Change Parent (Move)</label>
                <select name="parent_id" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white">
                    <option value="">-- No Parent (Make Root) --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="w-full bg-indigo-500 py-2 rounded-lg hover:bg-indigo-600 font-bold">Update & Move</button>
                <a href="/categories" class="w-full text-center bg-gray-600 py-2 rounded-lg hover:bg-gray-700 font-bold">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>