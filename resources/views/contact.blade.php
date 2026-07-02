<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300;1,600&family=Epilogue:wght@700;900&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @import url('https://api.fontshare.com/v2/css?f[]=cabinet-grotesk@800,900&f[]=satoshi@400,700&display=swap');
        :root {
            --bg-color: #0d0d0d;
            --accent-color: #f5f2ed;
        }
        body {
            background-color: var(--bg-color);
            color: var(--accent-color);
            font-family: 'Satoshi', sans-serif;
            overflow-x: hidden;
        }
        .font-display {
            font-family: 'Cabinet Grotesk', sans-serif;
        }
        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }
        .asymmetric-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
        .diagonal-line {
            position: absolute;
            width: 150%;
            height: 1px;
            background: rgba(245, 242, 237, 0.1);
            transform: rotate(-15deg);
            top: 50%;
            left: -25%;
            z-index: 0;
            pointer-events: none;
        }
        .marquee-text {
            white-space: nowrap;
            animation: marquee 20s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .mask-image {
            mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 80%, transparent 100%);
        }
        input::placeholder, textarea::placeholder {
            color: rgba(245, 242, 237, 0.3);
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
    <title>Noir/Studio - Contact & Information</title>
</head>
<body>
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line"></div>

        <x-layout.header />

        <main class="relative pt-40 px-12 z-10">
            <!-- Hero Section -->
            <section id="hero" class="asymmetric-grid mb-32">
                <div class="col-span-12 lg:col-span-8 pr-12">
                    <div class="mb-20 relative">
                        <span class="absolute -top-12 left-0 text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase">Contact & Information</span>
                        <h1 class="text-8xl lg:text-[11rem] font-display font-black leading-[0.8] tracking-tighter uppercase mb-8">Studio<br/>Noir</h1>
                        <p class="font-serif italic text-4xl lg:text-5xl text-zinc-400 leading-tight ml-24 max-w-2xl">A space for artistic collaboration, dedicated to <span class="text-[#f5f2ed] border-b border-zinc-700">immortalizing</span> the human essence through the medium of light.</p>
                    </div>
                </div>
            </section>

            <!-- Methods Section -->
            <section id="methods" class="mb-40">
                <div class="asymmetric-grid">
                    <div class="col-span-12 lg:col-span-4 space-y-16">
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-6">Department Contacts</h4>
                                <div class="space-y-8">
                                    <div class="group border-b border-zinc-900 pb-4">
                                        <p class="text-[10px] text-zinc-600 uppercase mb-2">Bookings & Inquiries</p>
                                        <a id="email-bookings" href="mailto:bookings@noir.com" class="text-2xl font-medium hover:text-zinc-400 transition-colors">bookings@noir.com</a>
                                    </div>
                                    <div class="group border-b border-zinc-900 pb-4">
                                        <p class="text-[10px] text-zinc-600 uppercase mb-2">Press & Media</p>
                                        <a id="email-press" href="mailto:press@noir.com" class="text-2xl font-medium hover:text-zinc-400 transition-colors">press@noir.com</a>
                                    </div>
                                    <div class="group border-b border-zinc-900 pb-4">
                                        <p class="text-[10px] text-zinc-600 uppercase mb-2">Collaborations</p>
                                        <a id="email-collab" href="mailto:collab@noir.com" class="text-2xl font-medium hover:text-zinc-400 transition-colors">collab@noir.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-4">Telecommunications</h4>
                                <a id="phone-direct" href="tel:+6281234567890" class="text-3xl font-medium hover:text-zinc-400 transition-colors">+62 812 3456 7890</a>
                                <p class="text-[10px] text-zinc-600 mt-2 uppercase">Available for WhatsApp & Signal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-7 lg:col-start-6">
                        <div class="bg-zinc-900/50 p-12 lg:p-16 border border-zinc-800 rounded-sm">
                            <h4 class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-8">The Studio Experience</h4>
                            <div class="grid md:grid-cols-2 gap-16">
                                <div class="space-y-8">
                                    <div>
                                        <h5 class="text-xs font-bold uppercase mb-4">Address</h5>
                                        <p class="text-xl leading-relaxed text-zinc-300">Jalan Senopati No. 42<br/>Kebayoran Baru, Jakarta Selatan<br/>12190, Indonesia</p>
                                        <a id="directions-link" href="#" class="inline-flex items-center space-x-2 text-[10px] font-bold uppercase tracking-widest border-b border-zinc-700 pb-1 mt-4 hover:border-white transition-colors">
                                            <span>View on Google Maps</span>
                                            <iconify-icon icon="lucide:external-link"></iconify-icon>
                                        </a>
                                    </div>
                                    <div>
                                        <h5 class="text-xs font-bold uppercase mb-4">Studio Details</h5>
                                        <p class="text-sm text-zinc-400 leading-relaxed">Our 250sqm daylight studio is located in the heart of Senopati. Features include high ceilings, private dressing rooms, and a minimalist lounge area. Secured basement parking is available for all clients.</p>
                                    </div>
                                </div>
                                <div class="space-y-8">
                                    <div>
                                        <h5 class="text-xs font-bold uppercase mb-4">Business Hours</h5>
                                        <div class="space-y-2">
                                            <div class="flex justify-between text-sm"><span>Monday - Friday</span><span class="text-zinc-500">09:00 - 18:00</span></div>
                                            <div class="flex justify-between text-sm"><span>Saturday</span><span class="text-zinc-500">10:00 - 16:00</span></div>
                                            <div class="flex justify-between text-sm"><span>Sunday</span><span class="text-zinc-500">By Request</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="text-xs font-bold uppercase mb-4">Public Transport</h5>
                                        <p class="text-sm text-zinc-400 leading-relaxed">Accessible via MRT Jakarta (Asean Station) followed by a 5-minute walk. Bluebird and Grab services are readily available at the studio entrance.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Guarantees -->
            <section id="guarantees" class="mb-40 py-24 border-y border-zinc-900">
                <div class="max-w-4xl mx-auto text-center px-6">
                    <h4 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-12">Our Commitment</h4>
                    <div class="grid md:grid-cols-3 gap-12">
                        <div class="space-y-4">
                            <iconify-icon icon="lucide:clock-3" class="text-3xl text-zinc-700"></iconify-icon>
                            <h5 class="text-xs font-bold uppercase">24h Response</h5>
                            <p class="text-xs text-zinc-500 leading-relaxed">We guarantee a response to all initial inquiries within one business day.</p>
                        </div>
                        <div class="space-y-4">
                            <iconify-icon icon="lucide:shield-check" class="text-3xl text-zinc-700"></iconify-icon>
                            <h5 class="text-xs font-bold uppercase">Secure Delivery</h5>
                            <p class="text-xs text-zinc-500 leading-relaxed">High-resolution assets delivered via encrypted private gallery portals.</p>
                        </div>
                        <div class="space-y-4">
                            <iconify-icon icon="lucide:camera" class="text-3xl text-zinc-700"></iconify-icon>
                            <h5 class="text-xs font-bold uppercase">Professional SLA</h5>
                            <p class="text-xs text-zinc-500 leading-relaxed">Full production support including gear backups and on-site assistance.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Photographer -->
            <section id="photographer" class="mb-40">
                <div class="asymmetric-grid">
                    <div class="col-span-12 lg:col-span-5 mb-16 lg:mb-0">
                        <div class="aspect-[3/4] overflow-hidden grayscale border border-zinc-900">
                            <img src="https://images.unsplash.com/photo-1552058544-f2b08422138a?auto=format&fit=crop&q=80&w=1200" alt="Lead Photographer" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 lg:col-start-7 flex flex-col justify-center">
                        <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-8">Lead Photographer</span>
                        <h2 class="text-6xl font-display font-black tracking-tighter uppercase mb-8">Erik<br/>Vanguard</h2>
                        <div class="space-y-8 text-zinc-400 font-light leading-relaxed">
                            <p>With over 10 years of experience in fine art and editorial photography, Erik Vanguard has established a signature style characterized by its dramatic use of shadow and high-contrast monochromatic palettes.</p>
                            <p>His work has been featured in international publications including Vogue Italia, Harper's Bazaar, and Hypebeast. Erik is a graduate of the Royal College of Art, London, and is a certified Leica Ambassador.</p>
                        </div>
                        <div class="grid grid-cols-2 gap-12 mt-16">
                            <div class="space-y-4">
                                <h5 class="text-[10px] font-bold uppercase text-zinc-600 tracking-widest">Awards</h5>
                                <ul class="text-xs space-y-2">
                                    <li>Sony World Photo Awards (Portrait)</li>
                                    <li>IPA Professional Photographer of the Year</li>
                                    <li>Leica Oskar Barnack Finalist</li>
                                </ul>
                            </div>
                            <div class="space-y-4">
                                <h5 class="text-[10px] font-bold uppercase text-zinc-600 tracking-widest">Features</h5>
                                <ul class="text-xs space-y-2">
                                    <li>Vogue Italia Editorial Feature</li>
                                    <li>Adobe Creative Jam Winner</li>
                                    <li>Hasselblad Masters Selection</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Team -->
            <section id="team" class="mb-40 py-24 bg-zinc-950 px-12">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col mb-16">
                        <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase mb-4">The Collective</span>
                        <h2 class="text-4xl font-display font-black uppercase tracking-tight">Production Team</h2>
                    </div>
                    <div class="grid md:grid-cols-3 gap-12">
                        <div class="group space-y-6">
                            <div class="aspect-square bg-zinc-900 overflow-hidden grayscale group-hover:grayscale-0 transition-all duration-700">
                                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=600" alt="Stylist" class="w-full h-full object-cover">
                            </div>
                            <div class="space-y-2">
                                <h5 class="text-xl font-bold uppercase tracking-tighter">Maya Chen</h5>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Lead Stylist / 8 Years Exp.</p>
                                <p class="text-xs text-zinc-400">Specializing in avant-garde and high-fashion editorial concepts.</p>
                            </div>
                        </div>
                        <div class="group space-y-6">
                            <div class="aspect-square bg-zinc-900 overflow-hidden grayscale group-hover:grayscale-0 transition-all duration-700">
                                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600" alt="MUA" class="text-white w-full h-full object-cover">
                            </div>
                            <div class="space-y-2">
                                <h5 class="text-xl font-bold uppercase tracking-tighter">Lina Suzuki</h5>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Makeup & Hair Artist</p>
                                <p class="text-xs text-zinc-400">Expert in natural skin textures and dramatic editorial beauty looks.</p>
                            </div>
                        </div>
                        <div class="group space-y-6">
                            <div class="aspect-square bg-zinc-900 overflow-hidden grayscale group-hover:grayscale-0 transition-all duration-700">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=600" alt="Assistant" class="w-full h-full object-cover">
                            </div>
                            <div class="space-y-2">
                                <h5 class="text-xl font-bold uppercase tracking-tighter">David Aris</h5>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Lighting Tech & Digital Op</p>
                                <p class="text-xs text-zinc-400">Master of complex lighting setups and real-time digital post-processing.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Services -->
            <section id="services" class="mb-40">
                <div class="asymmetric-grid">
                    <div class="col-span-12 lg:col-span-10 lg:col-start-2">
                        <div class="grid md:grid-cols-2 gap-24">
                            <div class="space-y-16">
                                <div class="space-y-4">
                                    <h3 class="text-3xl font-display font-black uppercase tracking-tighter border-b border-zinc-900 pb-4">Fine Art Portraiture</h3>
                                    <p class="text-sm text-zinc-400 leading-relaxed">Deeply personal, high-concept portraits that focus on the emotional depth of the subject. Shot primarily on medium format digital or film.</p>
                                </div>
                                <div class="space-y-4">
                                    <h3 class="text-3xl font-display font-black uppercase tracking-tighter border-b border-zinc-900 pb-4">Editorial Fashion</h3>
                                    <p class="text-sm text-zinc-400 leading-relaxed">Collaborative story-driven fashion campaigns for brands and publications. Full creative direction and styling support provided.</p>
                                </div>
                            </div>
                            <div class="space-y-16">
                                <div class="space-y-4">
                                    <h3 class="text-3xl font-display font-black uppercase tracking-tighter border-b border-zinc-900 pb-4">Commercial Work</h3>
                                    <p class="text-sm text-zinc-400 leading-relaxed">Professional imagery for premium brands, focusing on product integrity and brand narrative through a sophisticated lens.</p>
                                </div>
                                <div class="space-y-4">
                                    <h3 class="text-3xl font-display font-black uppercase tracking-tighter border-b border-zinc-900 pb-4">Lifestyle & Branding</h3>
                                    <p class="text-sm text-zinc-400 leading-relaxed">Authentic, elevated personal branding photography for creative professionals, artists, and modern leaders.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials -->
            <section id="testimonials" class="mb-40 py-24 bg-white text-black">
                <div class="px-12 max-w-7xl mx-auto">
                    <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-400 uppercase block mb-8">Client Voices</span>
                    <div class="grid md:grid-cols-2 gap-x-24 gap-y-16">
                        <div class="space-y-4">
                            <iconify-icon icon="material-symbols:format-quote-rounded" class="text-4xl text-zinc-200"></iconify-icon>
                            <p class="text-xl font-serif italic leading-tight">"Erik has an incredible ability to see beyond the surface. The portraits he took for my latest exhibition captured a vulnerability I didn't know I could show on camera."</p>
                            <div class="pt-4">
                                <p class="text-xs font-bold uppercase">Julianne Moore</p>
                                <p class="text-[10px] uppercase text-zinc-400">Fine Art Session</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <iconify-icon icon="material-symbols:format-quote-rounded" class="text-4xl text-zinc-200"></iconify-icon>
                            <p class="text-xl font-serif italic leading-tight">"The most professional studio team in Jakarta. From styling to final retouching, Noir Studio exceeded every expectation for our brand campaign."</p>
                            <div class="pt-4">
                                <p class="text-xs font-bold uppercase">Marcus Aurelius</p>
                                <p class="text-[10px] uppercase text-zinc-400">Brand Creative Director</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <iconify-icon icon="material-symbols:format-quote-rounded" class="text-4xl text-zinc-200"></iconify-icon>
                            <p class="text-xl font-serif italic leading-tight">"Minimalist, daring, and absolutely stunning. The photography captured the exact essence of our collection."</p>
                            <div class="pt-4">
                                <p class="text-xs font-bold uppercase">Sarah Jenkins</p>
                                <p class="text-[10px] uppercase text-zinc-400">Fashion Designer</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <iconify-icon icon="material-symbols:format-quote-rounded" class="text-4xl text-zinc-200"></iconify-icon>
                            <p class="text-xl font-serif italic leading-tight">"A truly collaborative experience. The studio atmosphere is calming yet incredibly focused on the art of the shot."</p>
                            <div class="pt-4">
                                <p class="text-xs font-bold uppercase">David P. Lueth</p>
                                <p class="text-[10px] uppercase text-zinc-400">Architectural Designer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section id="faq" class="mb-40 px-12 max-w-4xl mx-auto">
                <div class="text-center mb-20">
                    <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase mb-4">Q&A</span>
                    <h2 class="text-5xl font-display font-black uppercase">Booking FAQ</h2>
                </div>
                <div class="space-y-12">
                    <div class="border-b border-zinc-900 pb-8">
                        <h5 class="text-lg font-bold uppercase mb-4">What is the typical turnaround time?</h5>
                        <p class="text-zinc-500 text-sm leading-relaxed">For portrait sessions, initial proofs are delivered within 48 hours. Final retouched high-resolution images are delivered within 10-14 business days via a secure digital gallery.</p>
                    </div>
                    <div class="border-b border-zinc-900 pb-8">
                        <h5 class="text-lg font-bold uppercase mb-4">Do you offer hair and makeup services?</h5>
                        <p class="text-zinc-500 text-sm leading-relaxed">Yes, our collective includes professional makeup artists and hair stylists. You can opt to include these services in your booking package for a seamless professional experience.</p>
                    </div>
                    <div class="border-b border-zinc-900 pb-8">
                        <h5 class="text-lg font-bold uppercase mb-4">Can I book a studio tour before a session?</h5>
                        <p class="text-zinc-500 text-sm leading-relaxed">Absolutely. We encourage clients to visit the space to discuss concepts and logistics. Tours are by appointment only during weekdays.</p>
                    </div>
                    <div class="border-b border-zinc-900 pb-8">
                        <h5 class="text-lg font-bold uppercase mb-4">What is your cancellation policy?</h5>
                        <p class="text-zinc-500 text-sm leading-relaxed">A 50% non-refundable deposit is required to secure your date. Rescheduling is permitted up to 72 hours before the session without additional fees.</p>
                    </div>
                    <div class="border-b border-zinc-900 pb-8">
                        <h5 class="text-lg font-bold uppercase mb-4">Do you provide wardrobe styling?</h5>
                        <p class="text-zinc-500 text-sm leading-relaxed">Our lead stylist, Maya, provides creative direction and can source specific wardrobe pieces for editorial and commercial commissions.</p>
                    </div>
                    <div class="border-b border-zinc-900 pb-8">
                        <h5 class="text-lg font-bold uppercase mb-4">Do you offer physical prints?</h5>
                        <p class="text-zinc-500 text-sm leading-relaxed">Yes, we partner with premium archival print labs to offer museum-quality giclée prints. Custom framing and art books are also available as additions to your session.</p>
                    </div>
                </div>
            </section>

            <!-- Press Kit -->
            <section id="press-kit" class="mb-40 bg-zinc-900/30 py-24 border-t border-zinc-900 px-12">
                <div class="max-w-7xl mx-auto flex flex-col lg:flex-row justify-between items-center gap-12">
                    <div class="max-w-xl">
                        <h4 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-6">Media Assets</h4>
                        <h2 class="text-4xl font-display font-black uppercase mb-6">Press & Media Kit</h2>
                        <p class="text-zinc-400 text-sm leading-relaxed mb-8">Download high-resolution headshots, studio biography, and our curated portfolio highlights for editorial use.</p>
                        <a id="download-press-kit" href="#" class="inline-flex items-center space-x-4 bg-[#f5f2ed] text-[#0d0d0d] px-8 py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-white transition-colors">
                            <span>Download Kit (240MB)</span>
                            <iconify-icon icon="lucide:download"></iconify-icon>
                        </a>
                    </div>
                    <div class="flex space-x-12">
                        <div class="text-center">
                            <p class="text-4xl font-display font-black">45K</p>
                            <p class="text-[10px] uppercase text-zinc-500 tracking-widest mt-2">Followers / IG</p>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-display font-black">120</p>
                            <p class="text-[10px] uppercase text-zinc-500 tracking-widest mt-2">Awards Won</p>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-display font-black">500+</p>
                            <p class="text-[10px] uppercase text-zinc-500 tracking-widest mt-2">Client Sagas</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Marquee -->
            <div class="py-24 border-t border-zinc-900 overflow-hidden">
                <div class="marquee-text flex space-x-24 items-center">
                    <span class="text-7xl font-display font-black text-transparent stroke-zinc-800 uppercase" style="-webkit-text-stroke: 1px #27272a;">Portrait</span>
                    <span class="text-7xl font-display font-black uppercase">Editorial</span>
                    <span class="text-7xl font-display font-black text-transparent stroke-zinc-800 uppercase" style="-webkit-text-stroke: 1px #27272a;">Fashion</span>
                    <span class="text-7xl font-display font-black uppercase">Art</span>
                    <span class="text-7xl font-display font-black text-transparent stroke-zinc-800 uppercase" style="-webkit-text-stroke: 1px #27272a;">Portrait</span>
                    <span class="text-7xl font-display font-black uppercase">Editorial</span>
                    <span class="text-7xl font-display font-black text-transparent stroke-zinc-800 uppercase" style="-webkit-text-stroke: 1px #27272a;">Fashion</span>
                    <span class="text-7xl font-display font-black uppercase">Art</span>
                </div>
            </div>
        </main>

        <x-layout.footer />
    </div>
</body>
</html>