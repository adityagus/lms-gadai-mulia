<template>
          <nav id="nav-guest" class="flex w-full bg-white border-b border-obito-grey">
            <div class="flex w-[1280px] px-[75px] py-5 items-center justify-between mx-auto">
                <div class="flex items-center gap-[50px]">
                    <a href="index.html" class="flex shrink-0">
                        <img src="assets/images/logos/logo.svg" class="flex shrink-0" alt="logo">
                    </a>
                    <ul class="flex items-center gap-10">
                        <li class="hover:font-semibold transition-all duration-300 font-semibold">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="hover:font-semibold transition-all duration-300">
                            <a href="pricing.html">Pricing</a>
                        </li>
                        <li class="hover:font-semibold transition-all duration-300">
                            <a href="#">Features</a>
                        </li>
                        <li class="hover:font-semibold transition-all duration-300">
                            <a href="#">Testimonials</a>
                        </li>
                    </ul>
                </div>
                <div class="flex items-center gap-5 justify-end">
                    <a href="#" class="flex shrink-0">
                        <img src="assets/images/icons/device-message.svg" class="flex shrink-0" alt="icon">
                    </a>
                    <div class="h-[50px] flex shrink-0 bg-obito-grey w-px"></div>
                    <div class="flex items-center gap-3">
                        <a href="signup.html" class="rounded-full border border-obito-grey py-3 px-5 gap-[10px] bg-white hover:border-obito-green transition-all duration-300">
                            <span class="font-semibold">Sign Up</span>
                        </a>
                        <a href="signin.html" class="rounded-full py-3 px-5 gap-[10px] bg-obito-green hover:drop-shadow-effect transition-all duration-300">
                            <span class="font-semibold text-white">My Account</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
</template>

<script setup>
</script>