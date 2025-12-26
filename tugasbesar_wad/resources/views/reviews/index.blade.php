<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - Manajemen Review</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-white border-r border-gray-200 fixed h-full z-10">
            <div class="p-6 flex items-center space-x-2">
                <div class="w-8 h-8 bg-teal-400 rounded-lg"></div> 
                <span class="text-2xl font-bold text-gray-800">Vettix</span>
            </div>
            
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-lg">
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('reviews.index') }}" class="flex items-center px-4 py-3 bg-teal-50 text-teal-600 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    <span class="font-medium">Review</span>
                </a>
            </nav>
        </aside>

        <main class="ml-64 flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Event Feedback & Reviews</h1>
                    <p class="text-sm text-gray-500">Kelola ulasan dan rating peserta</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Rata-rata Rating</p>
                    <div class="flex items-center justify-end">
                        <span class="text-yellow-400 text-xl mr-1">★</span>
                        <span class="text-lg font-bold">{{ number_format($avgRating, 1) }}</span>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Info:</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="space-y-6">
                @forelse($reviews as $review)
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition hover:shadow-md">
                    <div class="flex justify-between items-start">
                        <div class="flex space-x-4">
                            <img src="{{ $review->avatar_url }}" alt="Avatar" class="w-12 h-12 rounded-full">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $review->participant_name }}</h3>
                                <div class="flex text-yellow-400 text-sm my-1">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= $review->rating) ★ @else <span class="text-gray-300">★</span> @endif
                                    @endfor
                                </div>
                                <p class="text-gray-600 mt-2">{{ $review->komentar }}</p>
                                <span class="inline-block mt-2 text-xs px-2 py-1 rounded {{ $review->is_published ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-500' }}">
                                    Status: {{ $review->is_published ? 'Published' : 'Hidden' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <span class="text-xs text-gray-400 text-right">{{ $review->created_at->diffForHumans() }}</span>
                            <div class="flex space-x-2 mt-2">
                                <form action="{{ route('reviews.toggle', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs px-3 py-1 rounded border {{ $review->is_published ? 'border-yellow-300 text-yellow-600 hover:bg-yellow-50' : 'border-green-300 text-green-600 hover:bg-green-50' }}">
                                        {{ $review->is_published ? 'Sembunyikan' : 'Tampilkan' }}
                                    </button>
                                </form>

                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus review ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs px-3 py-1 bg-red-50 text-red-600 rounded border border-red-200 hover:bg-red-100">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada ulasan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
               @if ($reviews->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                        {{-- Previous Page Link --}}
                        @if ($reviews->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                &laquo; Previous
                            </span>
                        @else
                            <a href="{{ $reviews->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                &laquo; Previous
                            </a>
                        @endif
            
                        {{-- Next Page Link --}}
                        @if ($reviews->hasMorePages())
                            <a href="{{ $reviews->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                Next &raquo;
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                Next &raquo;
                            </span>
                        @endif
                    </nav>
                @endif
            </div>
        </main>
    </div>
</body>
</html>