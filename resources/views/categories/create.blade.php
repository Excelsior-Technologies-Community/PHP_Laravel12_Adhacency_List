<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white flex justify-center items-center">

    <div class="w-full max-w-lg mx-auto px-6 py-12">

        <div class="bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl mb-6 text-center">
            <h1 class="text-3xl font-bold">➕ Create Category</h1>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl backdrop-blur-xl">

            <form method="POST" action="/categories/store" class="space-y-6">
                @csrf

                <div>
                    <label class="block mb-2 text-slate-300">Category Name</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block mb-2 text-slate-300">Parent Category</label>
                    <select name="parent_id" class="w-full px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white focus:outline-none focus:border-indigo-500">
                        <option value="">-- No Parent (Make Root) --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-4 pt-2">
                    <button type="submit" class="w-full bg-green-500 py-2 rounded-lg hover:bg-green-600 font-bold transition">
                        Save Category
                    </button>

                    <a href="/categories" class="w-full text-center bg-gray-600 py-2 rounded-lg hover:bg-gray-700 font-bold transition">
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>

</body>

</html>