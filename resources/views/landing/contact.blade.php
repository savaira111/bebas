@extends('layouts.landing')

@section('title', 'Contact')

@section('content')
    <!-- Header -->
    <div class="bg-gray-50 py-16 text-center">
        <h1 class="font-serif text-4xl md:text-5xl text-gray-900 mb-3" data-aos="fade-up">Get in Touch</h1>
        <p class="text-gray-500 uppercase tracking-widest text-sm" data-aos="fade-up" data-aos-delay="100">We'd love to hear from you</p>
    </div>

    <!-- Content -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Contact Info & Map -->
                <div data-aos="fade-right">
                    <h2 class="font-serif text-2xl text-gray-900 mb-6">Visit Our Boutique</h2>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Experience our collections in person at our flagship store. Our beauty consultants are ready to assist you in finding your perfect match.
                    </p>

                    <div class="space-y-6 mb-10">
                        <div class="flex items-start">
                            <div class="text-pink-luxury mt-1 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider mb-1">Address</h3>
                                <p class="text-gray-600">Jl. Jendral Sudirman No. 123<br>Jakarta Selatan, Indonesia</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                             <div class="text-pink-luxury mt-1 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider mb-1">Email</h3>
                                <p class="text-gray-600">hello@luxurybeauty.com</p>
                            </div>
                        </div>
                         <div class="flex items-start">
                            <div class="text-pink-luxury mt-1 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider mb-1">Phone</h3>
                                <p class="text-gray-600">+62 21 555 0199</p>
                            </div>
                        </div>
                    </div>

                    <!-- Embed Map -->
                    <div class="h-64 bg-gray-200 rounded-sm overflow-hidden shadow-sm">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.307584102663!2d106.804306314769!3d-6.222285995495863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f14d30079f01%3A0x2e74f2341f2643a1!2sSudirman%20Central%20Business%20District!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-gray-50 p-10 rounded-sm" data-aos="fade-left">
                    <h2 class="font-serif text-2xl text-gray-900 mb-6">Send a Message</h2>
                    <form>
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 uppercase tracking-wide mb-2">Name</label>
                                <input type="text" id="name" class="w-full border-gray-300 focus:border-pink-luxury focus:ring-pink-luxury rounded-sm shadow-sm" placeholder="Your Name">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 uppercase tracking-wide mb-2">Email</label>
                                <input type="email" id="email" class="w-full border-gray-300 focus:border-pink-luxury focus:ring-pink-luxury rounded-sm shadow-sm" placeholder="your@email.com">
                            </div>
                             <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 uppercase tracking-wide mb-2">Subject</label>
                                <input type="text" id="subject" class="w-full border-gray-300 focus:border-pink-luxury focus:ring-pink-luxury rounded-sm shadow-sm" placeholder="Inquiry about...">
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 uppercase tracking-wide mb-2">Message</label>
                                <textarea id="message" rows="5" class="w-full border-gray-300 focus:border-pink-luxury focus:ring-pink-luxury rounded-sm shadow-sm" placeholder="How can we help you?"></textarea>
                            </div>
                            <button type="button" class="w-full px-6 py-4 bg-gray-900 text-white font-medium uppercase tracking-widest hover:bg-pink-luxury transition duration-300 shadow-lg">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
