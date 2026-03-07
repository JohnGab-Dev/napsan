<?php 
$title = "Napsan Pharmacy || Home";
include 'partials/__header.php';


require 'components/navbar.php';
?>

<div id="home" class="bg w-full h-screen flex items-center justify-center flex-col">
    <div class="bg1 w-full h-screen flex items-center justify-center flex-col text-white gap-2">
        <h1 class="text-7xl font-semibold text-center">Welcome to <br> <span class="font-bold"><span class="text-green-500">N<span class="text-red-600">APSAN</span> <span class="text-white">Pharmacy</span> </h1>
        <p class="font-semibold">Sa NAPSAN PHARMACY Gamot mo ...Quality !!!</p>
        <a href="login.php"><button class="px-10 py-2 bg-green-600 rounded-lg text-white font-semibold hover:bg-green-700 active:opacity-80">Login</button></a>
        
    </div>
    
</div>


<div id="about" class="w-full h-screen px-20 pt-20 pb-10 flex items-center justify-between">
    <div class="w-1/2 h-full ">
        <img src="imgs/pic_nap.jpg" alt="" class="w-[85%] h-[100%]">
    </div>

    <div class="w-1/2 h-full flex flex-col gap-4 items-center pt-10">
        <h1 class="text-4xl font-semibold">ABOUT NAPSAN</h1>
        <p class="text-justify">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quia accusantium, optio sequi eius eaque id nihil, ut quasi distinctio reprehenderit autem recusandae, molestias obcaecati non quam amet sit voluptates. Veritatis a voluptatem harum modi iste facilis odio, nobis beatae, ullam vel debitis! Praesentium, accusantium ad? Necessitatibus cupiditate, eveniet unde doloribus culpa quibusdam nihil expedita! Iusto unde, at inventore suscipit hic similique illum praesentium cumque, dicta blanditiis minima ut sed laboriosam perferendis repudiandae non porro recusandae impedit atque asperiores alias, omnis voluptatum reprehenderit? Sapiente, repellat perferendis? Aperiam tempora rem inventore, cupiditate expedita architecto, similique deserunt error magnam rerum minus? Dolorem, accusamus!
        </p>
    </div>
</div>

<div id="products" class="w-full h-screen bg-green-600 flex flex-col items-center px-24 pt-20 pb-10 gap-6">
    <h1 class="text-5xl font-semibold text-white">Our Products</h1>
    <div class="w-full h-4/5 rounded-sm flex gap-10">
        <div class="w-1/3 h-full rounded-sm bg-white shadow-lg cursor-pointer hover:border-b-8 border-green-300 duration-200">
            <img src="imgs/pharma.jpg" alt="" class="w-full h-3/6 rounded-t-sm">
            <div class="w-full h-3/6 flex flex-col items-center py-2 px-4 gap-2">
                <h1 class="font-semibold text-xl">Prescription Medicines</h1>
                <p class="indent-5 text-justify">These are drugs that require a doctor's prescription, such as antibiotics, antihypertensives, and insulin. They are regulated and dispensed only under medical supervision.</p>
            </div>
        </div>
        <div class="w-1/3 h-full rounded-sm bg-white shadow-lg cursor-pointer hover:border-b-8 border-green-300 duration-200">
            <img src="imgs/pharma2.jpg" alt="" class="w-full h-3/6 rounded-t-sm">
            <div class="w-full h-3/6 flex flex-col items-center py-2 px-4 gap-2">
                <h1 class="font-semibold text-xl">Non-prescription Medicines</h1>
                <p class="indent-5 text-justify">These include medications that can be bought without a prescription, like pain relievers, cough syrups, antacids, and vitamins. They are used for common, mild conditions.</p>
            </div>
        </div>

        <div class="w-1/3 h-full rounded-sm bg-white shadow-lg cursor-pointer hover:border-b-8 border-green-300 duration-200">
            <img src="imgs/pharma3.jpg" alt="" class="w-full h-3/6 rounded-t-sm">
            <div class="w-full h-3/6 flex flex-col items-center py-2 px-4 gap-2">
                <h1 class="font-semibold">Health and Personal Care Products</h1>
                <p class="indent-5 text-justify">These cover non-medicinal items such as skincare, hygiene products, medical supplies (like thermometers or face masks), baby care, and supplements.</p>
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
                <li><a href="#services" class="hover:text-blue-600">Services</a></li>
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
                <p>Mon - Sat: 8:00 AM - 8:00 PM</p>
                <p>Sunday: Closed</p>
            </div>
        </div>

    </div>

    <!-- Divider -->
    <div class="border-t border-gray-300 mt-12 pt-6 text-center text-sm text-gray-600">
        © 2025 Napsan Pharmacy. All Rights Reserved.
    </div>

</footer>

<?php include 'partials/__footer.php';?>