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

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white">

    <div class="max-w-3xl mx-auto px-6 py-12">

        <!-- HEADER -->
        <div class="bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl mb-6">
            <h1 class="text-3xl font-bold">➕ Create Category</h1>
        </div>

        <!-- FORM -->
        <div class="bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">

            <form method="POST" action="/categories/store" class="space-y-5">
                @csrf

                <!-- NAME -->
                <div>
                    <label class="block mb-2 text-sm">Category Name</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-2 rounded-lg text-black focus:outline-none">
                </div>

                <!-- PARENT -->
                <div>
                    <label class="block mb-2 text-sm">Parent Category</label>
                    <select name="parent_id" class="w-full px-4 py-2 rounded-lg text-black">
                        <option value="">No Parent (Root)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- BUTTONS -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-green-500 px-5 py-2 rounded-lg hover:bg-green-600">
                        Save
                    </button>

                    <a href="/categories" class="bg-gray-500 px-5 py-2 rounded-lg hover:bg-gray-600">
                        Back
                    </a>
                </div>

            </form>

        </div>

    </div>

</body>

</html>