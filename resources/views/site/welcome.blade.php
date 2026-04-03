{{-- School Landing Page - CMS Ready --}}
<x-landing.layout>
    {{-- Navigation --}}
    <x-landing.nav />

    {{-- Hero Section --}}
    <x-landing.hero :stats="$stats" />

    {{-- Features Section --}}
    <x-landing.features />

    {{-- About Section --}}
    <x-landing.about />

    {{-- Statistics Section --}}
    <x-landing.stats :stats="$stats" />

    {{-- Programs/Gallery Section --}}
    <x-landing.programs :grades="$grades" />

    {{-- Testimonials Section --}}
    <x-landing.testimonials />

    {{-- FAQ Section --}}
    <x-landing.faq />

    {{-- Newsletter Section --}}
    <x-landing.newsletter />

    {{-- Contact Section --}}
    <x-landing.contact />

    {{-- Footer --}}
    <x-landing.footer :grades="$grades" />
</x-landing.layout>
