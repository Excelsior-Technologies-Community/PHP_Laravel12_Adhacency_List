<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Categories</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white">

    <div class="max-w-5xl mx-auto px-6 py-12">

        <!-- HEADER -->
        <div class="bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl mb-6">
            <h1 class="text-3xl font-bold text-red-400">🗑 Trash Categories</h1>
            <p class="text-slate-300 mt-2">Restore deleted categories</p>
        </div>

        <!-- ✅ SUCCESS MESSAGE -->
        @if(session('success'))
            <div id="successMsg"
                class="mb-6 p-4 rounded-xl bg-green-500/20 border border-green-400/30 text-green-300 shadow-lg">
                <div class="flex items-center justify-between">
                    <span>♻️ {{ session('success') }}</span>

                    <button onclick="document.getElementById('successMsg').remove()"
                        class="text-green-200 hover:text-white">
                        ✖
                    </button>
                </div>
            </div>
        @endif

        <!-- LIST -->
        <div class="bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl">

            @forelse($categories as $cat)

                <div class="flex items-center justify-between border-b border-white/10 py-3">

                    <!-- NAME -->
                    <span class="text-lg">{{ $cat->name }}</span>

                    <!-- ACTION -->
                    <div class="flex gap-3">

                        <!-- RESTORE -->
                        <a href="/categories/restore/{{ $cat->id }}"
                            class="bg-green-500 px-4 py-1 rounded-lg hover:bg-green-600">
                            Restore
                        </a>

                    </div>

                </div>

            @empty
                <p class="text-center text-slate-400">Trash is empty</p>
            @endforelse

            <!-- BACK -->
            <div class="mt-6">
                <a href="/categories" class="bg-indigo-500 px-5 py-2 rounded-lg hover:bg-indigo-600">
                    Back to Categories
                </a>
            </div>

        </div>

    </div>

    <!-- ✅ AUTO HIDE SCRIPT -->
    <script>
        setTimeout(() => {
            let msg = document.getElementById('successMsg');
            if (msg) msg.remove();
        }, 3000);
    </script>

</body>

</html>