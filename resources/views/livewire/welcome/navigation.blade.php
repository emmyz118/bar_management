<div class="row">
    <div class="col-lg-2">
        <x-application-logo />
    </div>
    <div class="text-white-50 col-lg-5 justify-center">
        <p class="space-x-8 mt-3 text-lg justify-center">
            <b>B</b>ar <b>M</b>anagement <b>S</b>ystem
        </p>
    </div>
    <div class="col-lg-5">
        <nav class="flex flex-1 justify-end float-end">
            @auth
            <a href="{{ url('/dashboard') }}" wire:navigate
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}" wire:navigate
                class="rounded-md  text-white px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                Log in
            </a>

            @endauth

        </nav>
    </div>
</div>