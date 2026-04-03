{{-- School Landing Page - CMS Ready --}}
<x-landing.layout>
    {{-- Navigation --}}
    <x-landing.nav />

    {{-- CMS-powered sections, rendered in database order --}}
    @php
        $sectionOrder = array_keys($cmsSections ?? []);
        if (empty($sectionOrder)) {
            $sectionOrder = ['hero', 'features', 'about', 'stats', 'programs', 'testimonials', 'faq', 'newsletter', 'contact', 'footer'];
        }
    @endphp

    @foreach($sectionOrder as $key)
        @switch($key)
            @case('hero')
                <x-landing.hero :stats="$stats" :cms="$cmsSections['hero'] ?? null" />
                @break
            @case('features')
                <x-landing.features :cms="$cmsSections['features'] ?? null" />
                @break
            @case('about')
                <x-landing.about :cms="$cmsSections['about'] ?? null" />
                @break
            @case('stats')
                <x-landing.stats :stats="$stats" :cms="$cmsSections['stats'] ?? null" />
                @break
            @case('programs')
                <x-landing.programs :grades="$grades" :cms="$cmsSections['programs'] ?? null" />
                @break
            @case('testimonials')
                <x-landing.testimonials :cms="$cmsSections['testimonials'] ?? null" />
                @break
            @case('faq')
                <x-landing.faq :cms="$cmsSections['faq'] ?? null" />
                @break
            @case('newsletter')
                <x-landing.newsletter :cms="$cmsSections['newsletter'] ?? null" />
                @break
            @case('contact')
                <x-landing.contact :cms="$cmsSections['contact'] ?? null" />
                @break
            @case('footer')
                <x-landing.footer :grades="$grades" :cms="$cmsSections['footer'] ?? null" />
                @break
        @endswitch
    @endforeach
</x-landing.layout>
