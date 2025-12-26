<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="animate-fade-in-up">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/95 backdrop-blur-lg shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20 animate-fade-in-up" style="animation-delay: 0.2s; opacity: 0;">
        {{ $slot }}
    </div>
</div>
