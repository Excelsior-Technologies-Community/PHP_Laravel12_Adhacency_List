<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Tree</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 2026 Design Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white">

    <!-- Page Wrapper -->
    <div class="max-w-6xl mx-auto px-6 py-12">

        <!-- Header -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10
                    rounded-3xl p-8 shadow-2xl mb-8">

            <h1 class="text-4xl font-bold tracking-tight bg-gradient-to-r
                       from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                Category Hierarchy
            </h1>

            <p class="text-slate-300 mt-3">
                Recursive tree structure powered by Laravel Adjacency List
            </p>
        </div>

        <!-- Tree Container -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10
                    rounded-3xl p-8 shadow-2xl">

            <ul class="space-y-4">
                @foreach ($categories as $category)
                    <li>

                        <!-- Parent Node -->
                        <div class="group flex items-center justify-between
                                    bg-gradient-to-r from-indigo-500/20 to-purple-500/20
                                    border border-indigo-400/20
                                    px-5 py-3 rounded-2xl
                                    hover:scale-[1.02] hover:border-indigo-300/40
                                    transition duration-300 shadow-lg">

                            <span class="font-semibold text-lg">
                                {{ $category->name }}
                            </span>

                            <span class="text-xs text-indigo-300 opacity-70">
                                Root
                            </span>
                        </div>

                        <!-- Children -->
                        @if ($category->children->count())
                            @include('categories.partials.children', [
                                'children' => $category->children
                            ])
                        @endif

                    </li>
                @endforeach
            </ul>

        </div>

    </div>

</body>
</html>
