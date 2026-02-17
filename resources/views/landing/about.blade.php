@extends('layouts.landing')

@section('title', 'About Us')

@section('content')
    <!-- Header -->
    <div class="bg-gray-50 py-20 text-center">
        <h1 class="font-serif text-4xl md:text-5xl text-gray-900 mb-4" data-aos="fade-up">Our Story</h1>
        <div class="w-24 h-1 bg-pink-luxury mx-auto" data-aos="fade-up" data-aos-delay="100"></div>
    </div>

    <!-- Story Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="w-full md:w-1/2" data-aos="fade-right">
                     <div class="relative aspect-[3/4] bg-gray-100 rounded-sm overflow-hidden">
                        <!-- Placeholder Image -->
                        <img src="https://images.unsplash.com/photo-1596462502278-27bfdd403cc2?q=80&w=2576&auto=format&fit=crop" alt="Luxury Beauty Story" class="object-cover w-full h-full">
                    </div>
                </div>
                <div class="w-full md:w-1/2 text-center md:text-left" data-aos="fade-left">
                     <h2 class="font-serif text-3xl text-gray-900 mb-6">Redefining Beauty</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Established with a vision to bring timeless elegance to the modern world, Luxury Beauty is more than just a brand; it is a celebration of individuality and grace. We believe that true beauty lies in confidence and authenticity.
                    </p>
                     <p class="text-gray-600 mb-6 leading-relaxed">
                        Our collections are strictly curated using the finest ingredients, ensuring that every product not only enhances your natural allure but also cares for your skin. From our signature gold-infused serums to our soft-matte lipsticks, every item is a testament to our commitment to quality and luxury.
                    </p>
                    <div class="mt-8">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/Signature_sample.svg/1200px-Signature_sample.svg.png" alt="Signature" class="h-12 opacity-50 mx-auto md:mx-0">
                        <p class="text-xs text-gray-400 mt-2 uppercase tracking-widest">Founder, Luxury Beauty</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-pink-soft/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-8 bg-white shadow-sm rounded-sm" data-aos="fade-up">
                    <div class="text-pink-luxury mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                     <h3 class="font-serif text-xl text-gray-900 mb-2">Premium Quality</h3>
                    <p class="text-gray-500 text-sm">Sourced from the rarest ingredients to deliver unmatched results.</p>
                </div>
                <div class="p-8 bg-white shadow-sm rounded-sm" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-pink-luxury mb-4">
                         <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                     <h3 class="font-serif text-xl text-gray-900 mb-2">Timeless Style</h3>
                    <p class="text-gray-500 text-sm">Classic aesthetics that never fade, designed for the modern muse.</p>
                </div>
                <div class="p-8 bg-white shadow-sm rounded-sm" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-pink-luxury mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                     <h3 class="font-serif text-xl text-gray-900 mb-2">Cruelty Free</h3>
                    <p class="text-gray-500 text-sm">Beauty with a conscience. We never test on animals.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
