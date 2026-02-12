<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PowerGym | Expérience Fitness d'Élite</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,600,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --orange-glow: rgba(249, 115, 22, 0.4);
                --orange-deep: #7c2d12;
                --orange-bright: #f97316;
            }
            body { 
                font-family: 'Outfit', sans-serif;
                background-color: #09090b;
                color: #ffffff;
                overflow-x: hidden;
            }
            .hero-bg {
                background-image: linear-gradient(to bottom, rgba(9,9,11,0.6) 0%, rgba(9,9,11,0.95) 100%), url('{{ asset('images/gym_hero_bg.png') }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
            .glass {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            .animate-reveal {
                animation: reveal 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                opacity: 0;
            }
            @keyframes reveal {
                from { opacity: 0; transform: translateY(40px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .delay-1 { animation-delay: 0.2s; }
            .delay-2 { animation-delay: 0.4s; }
            .delay-3 { animation-delay: 0.6s; }
            
            .btn-primary {
                background: linear-gradient(135deg, var(--orange-bright), #ea580c);
                box-shadow: 0 8px 25px -10px var(--orange-glow);
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }
            .btn-primary:hover {
                box-shadow: 0 15px 35px -8px var(--orange-glow);
                transform: translateY(-5px);
            }
            .feature-card {
                position: relative;
                overflow: hidden;
                transition: all 0.4s ease;
                display: flex;
                flex-direction: column;
                height: 100%;
            }
            .feature-card::before {
                content: '';
                position: absolute;
                top: 0; left: 0; width: 100%; height: 100%;
                background: radial-gradient(circle at top left, rgba(249, 115, 22, 0.1), transparent);
                opacity: 0;
                transition: opacity 0.4s ease;
            }
            .feature-card:hover::before { opacity: 1; }
            .feature-card:hover { border-color: rgba(249, 115, 22, 0.3); transform: translateY(-8px); }

            .nav-blur {
                background: rgba(9, 9, 11, 0.85);
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }
            
            .cta-glow {
                box-shadow: 0 0 100px -20px rgba(249, 115, 22, 0.15);
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 nav-blur">
            <div class="max-w-7xl mx-auto px-6 h-20 md:h-24 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-orange-900/30">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xl md:text-2xl font-black italic tracking-tighter uppercase text-white">POWER<span class="text-orange-500">GYM</span></span>
                </div>
                <div class="hidden md:flex items-center gap-10">
                    <a href="#features" class="text-xs font-bold uppercase tracking-widest text-zinc-400 hover:text-orange-500 transition">Fonctionnalités</a>
                    <a href="#" class="text-xs font-bold uppercase tracking-widest text-zinc-400 hover:text-orange-500 transition">Entraînements</a>
                    <a href="#" class="text-xs font-bold uppercase tracking-widest text-zinc-400 hover:text-orange-500 transition">Tarifs</a>
                </div>
                <div>
                    <a href="{{ route('login') }}" class="px-6 py-2.5 md:px-8 md:py-3 bg-white/5 hover:bg-white/10 rounded-2xl text-xs md:text-sm font-black border border-white/10 transition uppercase tracking-[0.2em]">
                        Connexion
                    </a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center hero-bg overflow-hidden py-32 md:py-0">
            <div class="relative z-10 text-center px-6 max-w-5xl mx-auto">
                <div class="inline-flex items-center space-x-2 px-5 py-2 rounded-full glass border border-orange-500/30 mb-8 md:mb-12 animate-reveal">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-orange-500"></span>
                    </span>
                    <span class="text-[10px] md:text-[11px] font-black uppercase tracking-[0.3em] text-orange-500">Définir le Futur du Fitness</span>
                </div>
                
                <h1 class="text-5xl sm:text-7xl md:text-8xl lg:text-9xl font-black mb-8 md:mb-10 tracking-tighter leading-[1] md:leading-[0.9] animate-reveal delay-1">
                    PLUS FORT<br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600">ENSEMBLE</span>
                </h1>
                
                <p class="text-base md:text-2xl text-zinc-400/90 mb-12 md:mb-16 max-w-3xl mx-auto font-light leading-relaxed animate-reveal delay-2 px-4">
                    Découvrez des installations d'élite, un coaching de classe mondiale et une communauté déterminée à vous pousser au-delà de vos limites.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-5 md:gap-8 animate-reveal delay-3">
                    <a href="{{ route('login') }}" 
                       class="btn-primary px-12 py-6 text-white font-black text-xl rounded-[2rem] w-full sm:w-auto uppercase tracking-[0.15em] shadow-2xl">
                        Rejoindre l'Élite
                    </a>
                    <a href="#features" class="px-12 py-6 glass hover:bg-white/10 text-white font-bold text-xl rounded-[2rem] w-full sm:w-auto border border-white/10 transition">
                        Explorer Pro
                    </a>
                </div>
            </div>

            <!-- Enhanced scroll indicator -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 opacity-30 hidden md:flex">
                <div class="w-6 h-10 border-2 border-white/20 rounded-full flex justify-center p-1">
                    <div class="w-1 h-2 bg-orange-500 rounded-full animate-bounce"></div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-24 md:py-40 px-6 bg-zinc-950 relative">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-10 md:gap-16 mb-24 md:mb-32">
                    <div class="max-w-2xl text-left">
                        <h2 class="text-orange-500 text-xs md:text-sm font-black uppercase tracking-[0.4em] mb-6">Principes Fondamentaux</h2>
                        <h3 class="text-4xl md:text-7xl font-black leading-[1.1] uppercase tracking-tighter">Au-delà de la Routine.<br/><span class="text-zinc-700">Au-delà de la Moyenne.</span></h3>
                    </div>
                    <p class="text-zinc-500 text-lg md:text-xl font-medium max-w-md text-left leading-relaxed">Nous ne fournissons pas seulement des équipements. Nous offrons un chemin vers la domination physique et mentale.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                    <!-- Feature 1 -->
                    <div class="feature-card glass p-8 md:p-14 rounded-[3rem] group">
                        <div class="w-20 h-20 bg-orange-500/10 rounded-3xl flex items-center justify-center mb-10 border border-orange-500/20 group-hover:bg-orange-500/20 transition-all duration-500">
                            <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h4 class="text-3xl font-black mb-6 uppercase tracking-tighter text-white">Équipement Hyper</h4>
                        <p class="text-zinc-500 text-lg leading-relaxed mb-auto">Stations de levage de qualité industrielle et machines biomécaniques avancées pour une hypertrophie maximale.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card glass p-8 md:p-14 rounded-[3rem] group">
                        <div class="w-20 h-20 bg-orange-500/10 rounded-3xl flex items-center justify-center mb-10 border border-orange-500/20 group-hover:bg-orange-500/20 transition-all duration-500">
                            <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-3xl font-black mb-6 uppercase tracking-tighter text-white">Pro Élite</h4>
                        <p class="text-zinc-500 text-lg leading-relaxed mb-auto">Des maîtres entraîneurs certifiés disponibles pour élaborer votre plan d'évolution personnalisé.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card glass p-8 md:p-14 rounded-[3rem] group">
                        <div class="w-20 h-20 bg-orange-500/10 rounded-3xl flex items-center justify-center mb-10 border border-orange-500/20 group-hover:bg-orange-500/20 transition-all duration-500">
                            <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9s2.015-9 4.5-9m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-.778.099-1.533.284-2.253"/>
                            </svg>
                        </div>
                        <h4 class="text-3xl font-black mb-6 uppercase tracking-tighter text-white">Accès 24/7</h4>
                        <p class="text-zinc-500 text-lg leading-relaxed mb-auto">Accès biométrique illimité car la grandeur ne suit pas d'horaire de bureau.</p>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>