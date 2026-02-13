<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight luxury-gold-text" style="font-family: 'Playfair Display', serif;">
            {{ __('SuperAdmin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Section -->
            <div class="relative bg-white overflow-hidden shadow-xl rounded-3xl p-8 border border-gray-50 flex items-center justify-between">
                <div class="relative z-10">
                    <h3 class="text-3xl font-bold text-gray-800 mb-2 font-serif">Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#d4a5a5] to-[#c29595]">{{ Auth::user()->name }}</span></h3>
                    <p class="text-gray-500 max-w-xl">Here's what's happening in your luxury beauty store today. Check out the latest stats and manage your store efficiently.</p>
                </div>
                 <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-pink-50 to-transparent opacity-50"></div>
                 <div class="hidden md:block relative z-10 p-3 bg-white rounded-2xl shadow-sm border border-pink-50">
                    <span class="text-sm text-gray-400 font-serif">{{ date('l, d F Y') }}</span>
                 </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users -->
                <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-50 transform hover:-translate-y-1 transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center text-[#d4a5a5]">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-1 rounded-full">+12%</span>
                    </div>
                    <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Users</h4>
                    <div class="text-3xl font-bold text-gray-800 font-serif mt-1">{{ number_format($totalUsers) }}</div>
                </div>

                <!-- Total Admins -->
                <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-50 transform hover:-translate-y-1 transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-400">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-400 bg-gray-50 px-2 py-1 rounded-full">Active</span>
                    </div>
                    <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Admins</h4>
                    <div class="text-3xl font-bold text-gray-800 font-serif mt-1">{{ number_format($totalAdmins) }}</div>
                </div>

                <!-- Articles -->
                <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-50 transform hover:-translate-y-1 transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                         <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                         <span class="text-xs font-semibold text-blue-500 bg-blue-50 px-2 py-1 rounded-full">+5 New</span>
                    </div>
                    <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Articles</h4>
                    <div class="text-3xl font-bold text-gray-800 font-serif mt-1">24</div> <!-- Dummy Data if not passed -->
                </div>

                 <!-- Products (Dummy) -->
                <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-50 transform hover:-translate-y-1 transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                         <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                         <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-1 rounded-full">+28%</span>
                    </div>
                    <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Products</h4>
                    <div class="text-3xl font-bold text-gray-800 font-serif mt-1">156</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Chart Section -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl border border-gray-50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-xl font-bold text-gray-800 font-serif">Monthly User Growth</h4>
                         <select class="text-sm border-gray-200 rounded-lg text-gray-500 focus:ring-pink-200 focus:border-pink-200">
                            <option>Last 6 Months</option>
                            <option>Last Year</option>
                        </select>
                    </div>
                    <!-- Dummy Chart Container -->
                    <div class="relative h-64 w-full bg-gray-50 rounded-2xl flex items-end justify-between px-4 pb-4 overflow-hidden">
                        <!-- Bars -->
                         @for ($i = 0; $i < 12; $i++)
                            <div class="w-full mx-1 bg-gradient-to-t from-[#d4a5a5] to-[#f4eaea] rounded-t-sm hover:from-[#c29595] hover:to-[#eebbbb] transition-all duration-300 relative group"
                                 style="height: {{ rand(30, 90) }}%;">
                                 <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition">
                                     {{ rand(100, 500) }}
                                 </div>
                            </div>
                        @endfor
                    </div>
                     <div class="flex justify-between mt-4 text-xs text-gray-400 font-medium px-2">
                        <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
                        <span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
                    </div>
                </div>

                <!-- Recent Activity & Featured -->
                <div class="space-y-8">
                    
                    <!-- Featured Articles -->
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-50 p-6">
                        <h4 class="text-xl font-bold text-gray-800 font-serif mb-4">Top Articles</h4>
                        <div class="space-y-4">
                            @forelse($featuredArticles as $article)
                                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-pink-50 transition cursor-pointer group">
                                    <div class="w-12 h-12 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                                         @if($article->image)
                                            <img src="{{ Storage::url($article->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">Img</div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="text-sm font-semibold text-gray-700 truncate group-hover:text-[#c29595] transition">{{ $article->title }}</h5>
                                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-2">
                                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ $article->views }}</span>
                                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> {{ $article->likes }}</span>
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 text-center py-4">No top articles yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Compact User List -->
                    <div class="bg-gradient-to-br from-[#212844] to-[#1a1f3b] rounded-3xl shadow-xl p-6 text-white text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-white opacity-5 blur-xl"></div>
                        <h4 class="text-xl font-bold font-serif mb-2 relative z-10">Premium Members</h4>
                        <p class="text-white/60 text-sm mb-4 relative z-10">Latest VIP registrations</p>
                        
                         <div class="flex items-center justify-center -space-x-2 mb-6 relative z-10">
                            @for($i=0; $i<4; $i++)
                                <div class="w-10 h-10 rounded-full border-2 border-[#212844] bg-gray-300 overflow-hidden">
                                     <img src="https://ui-avatars.com/api/?name=User+{{ $i }}&background=random" class="w-full h-full">
                                </div>
                            @endfor
                            <div class="w-10 h-10 rounded-full border-2 border-[#212844] bg-gray-700 text-white text-xs flex items-center justify-center font-bold">
                                +{{ $totalUsers > 4 ? $totalUsers - 4 : 0 }}
                            </div>
                        </div>

                         <a href="{{ route('superadmin.users.index') }}" class="inline-block w-full py-2 bg-white/10 hover:bg-white/20 rounded-xl text-sm font-medium transition backdrop-blur-sm">
                            Manage Users
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
