<?php 
$title = "Napsan Pharmacy || Home";
include 'partials/__header.php';


require 'components/navbar.php';
?>

<!-- home -->
<div id="home" class="w-full min-h-screen bg bg-center bg-cover flex items-center justify-center">

    <!-- Overlay -->
    <div class="w-full min-h-screen bg-black/60 flex flex-col items-center justify-center text-center text-white px-6 gap-6">

        <!-- Title -->
        <h1 class="text-5xl md:text-7xl font-bold leading-tight">
            Welcome to <br>
            <span>
                <span class="text-green-500">N<span class="text-red-600">APSAN</span></span>
                <span class="text-white"> Pharmacy</span>
            </span>
        </h1>

        <!-- Tagline -->
        <p class="text-lg md:text-xl font-medium text-gray-200 max-w-xl">
            Sa NAPSAN Pharmacy, ang gamot mo ay siguradong
            <span class="text-green-400 font-semibold">Quality</span> at
            <span class="text-green-400 font-semibold">Maaasahan</span>.
        </p>

        <!-- Buttons -->
        <div class="flex gap-4 mt-4">

            <a href="login.php">
                <button class="px-8 py-3 bg-green-600 rounded-lg font-semibold hover:bg-green-700 transition">
                    Login
                </button>
            </a>

            <a href="#products">
                <button class="px-8 py-3 border border-white rounded-lg font-semibold hover:bg-white hover:text-black transition">
                    View Products
                </button>
            </a>

        </div>

    </div>

</div>

<!-- 
about -->
<div id="about" class="w-full py-24 px-8 md:px-20 flex flex-col lg:flex-row items-center gap-16">

    <!-- Image -->
    <div class="w-full lg:w-1/2 flex justify-center">
        <img 
            src="imgs/pic_nap.jpg" 
            alt="Napsan Pharmacy" 
            class="w-full max-w-md rounded-xl shadow-xl object-cover"
        >
    </div>

    <!-- Text Content -->
    <div class="w-full lg:w-1/2 flex flex-col gap-6">

        <h1 class="text-4xl md:text-5xl font-bold text-gray-800">
            About Napsan Pharmacy
        </h1>

        <p class="text-gray-600 leading-relaxed text-justify">
            Napsan Pharmacy is committed to providing quality medicines,
            healthcare products, and trusted pharmaceutical services to the
            community of San Ildefonso, Bulacan. Our goal is to ensure that
            every customer receives reliable products and professional
            assistance for their health needs.
        </p>

        <p class="text-gray-600 leading-relaxed text-justify">
            We offer a wide range of prescription medicines, over-the-counter
            drugs, vitamins, supplements, and personal care products. Our
            pharmacy prioritizes accessibility, affordability, and excellent
            customer service to help promote healthier lives within our
            community.
        </p>

        <!-- Highlight Features -->
        <div class="grid grid-cols-2 gap-4 mt-4">

            <div class="flex items-center gap-2">
                <span class="text-green-600 text-xl">✔</span>
                <p class="text-sm text-gray-700">Trusted Medicines</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-green-600 text-xl">✔</span>
                <p class="text-sm text-gray-700">Affordable Prices</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-green-600 text-xl">✔</span>
                <p class="text-sm text-gray-700">Licensed Pharmacists</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-green-600 text-xl">✔</span>
                <p class="text-sm text-gray-700">Quality Healthcare Products</p>
            </div>

        </div>

    </div>

</div>

<!-- products -->
<div id="products" class="w-full bg-green-600 flex flex-col items-center px-10 md:px-24 py-20 gap-12">

    <!-- Title -->
    <div class="text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold">Our Products</h1>
        <p class="mt-3 text-green-100">Quality medicines and healthcare products you can trust.</p>
    </div>

    <!-- Product Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 w-full max-w-7xl">

        <!-- Card 1 -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition duration-300 cursor-pointer">

            <img src="imgs/pharma.jpg" class="w-full h-56 object-cover">

            <div class="p-6 flex flex-col gap-3">
                <h2 class="text-xl font-semibold text-gray-800">
                    Prescription Medicines
                </h2>

                <p class="text-gray-600 text-sm leading-relaxed text-justify">
                    These are drugs that require a doctor's prescription such as
                    antibiotics, antihypertensives, and insulin. They are regulated
                    and dispensed only under medical supervision.
                </p>
            </div>

        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition duration-300 cursor-pointer">

            <img src="imgs/pharma2.jpg" class="w-full h-56 object-cover">

            <div class="p-6 flex flex-col gap-3">
                <h2 class="text-xl font-semibold text-gray-800">
                    Non-Prescription Medicines
                </h2>

                <p class="text-gray-600 text-sm leading-relaxed text-justify">
                    These include medications that can be purchased without a
                    prescription such as pain relievers, cough syrups, antacids,
                    and vitamins for common mild conditions.
                </p>
            </div>

        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition duration-300 cursor-pointer">

            <img src="imgs/pharma3.jpg" class="w-full h-56 object-cover">

            <div class="p-6 flex flex-col gap-3">
                <h2 class="text-xl font-semibold text-gray-800">
                    Health & Personal Care
                </h2>

                <p class="text-gray-600 text-sm leading-relaxed text-justify">
                    Includes skincare, hygiene products, medical supplies
                    like thermometers and face masks, baby care items,
                    supplements, and other wellness products.
                </p>
            </div>

        </div>

    </div>

</div>


<footer id="contact" class="w-full bg-gray-100 text-gray-800 py-14 px-10">
    
    <!-- Title -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold">Contact or Find Us</h1>
        <p class="text-gray-600 mt-2">We are always ready to assist you.</p>
    </div>

    <!-- Main Footer Content -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 max-w-7xl mx-auto">

        <!-- About -->
        <div>
            <h2 class="font-semibold text-xl mb-3">Napsan Pharmacy</h2>
            <p class="text-sm text-gray-600 leading-relaxed">
                Providing trusted medicines and healthcare products for the
                community of San Ildefonso, Bulacan. Your health is our priority.
            </p>
        </div>

        <!-- Quick Links -->
        <div>
            <h2 class="font-semibold text-xl mb-3">Quick Links</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-blue-600">Home</a></li>
                <li><a href="#products" class="hover:text-blue-600">Products</a></li>
                <li><a href="#contact" class="hover:text-blue-600">Contact</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div>
            <h2 class="font-semibold text-xl mb-3">Contact Info</h2>
            <ul class="space-y-2 text-sm">
                <li>📞 <a href="tel:+639277977990" class="hover:text-blue-600">+63 927 797 7990</a></li>
                <li>📍 Poblacion, San Ildefonso, Bulacan</li>
                <li>📧 napsanpharmacy@gmail.com</li>
            </ul>
        </div>

        <!-- Social -->
        <div>
            <h2 class="font-semibold text-xl mb-3">Connect With Us</h2>
            <p class="text-sm text-gray-600 mb-3">Follow us on Facebook</p>
            <a href="#" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Visit Facebook Page
            </a>

            <div class="mt-4 text-sm text-gray-600">
                <p><span class="font-semibold">Business Hours:</span></p>
                <p>Mon - Sun: 6:30 AM - 6:30 PM</p>
                <!-- <p>Sunday: Closed</p> -->
            </div>
        </div>

    </div>

    <!-- Divider -->
    <div class="border-t border-gray-300 mt-12 pt-6 text-center text-sm text-gray-600">
        © 2025 Napsan Pharmacy. All Rights Reserved.
    </div>

</footer>

<?php include 'partials/__footer.php';?>