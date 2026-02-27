@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

<div class="min-h-screen bg-gray-50 text-gray-800">
    <style>
        .price-num {
            font-weight: 800;
            font-size: clamp(2.2rem, 4vw, 3rem);
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .tab-pill {
            font-weight: 600;
            font-size: 13px;
            padding: 9px 22px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            background: transparent;
            color: rgba(0, 0, 0, 0.45);
            letter-spacing: 0.03em;
        }

        .tab-pill.active {
            background: #16714B;
            color: white;
        }

        .tab-pill:hover:not(.active) {
            color: rgba(0, 0, 0, 0.7);
            background: rgba(0, 0, 0, 0.05);
        }

        .card-featured::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #16714B, #22c55e);
            border-radius: 20px 20px 0 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #16714B, #15803d);
            color: white;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #15803d, #166534);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(22, 113, 75, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
        }

        .btn-outline:hover {
            border-color: rgba(0, 0, 0, 0.35);
            background: rgba(0, 0, 0, 0.03);
        }

        .check-icon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: rgba(22, 113, 75, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .x-icon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .fade-up {
            animation: fadeUp 0.55s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .delay-2 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .delay-3 {
            animation-delay: 0.3s;
            opacity: 0;
        }
    </style>

    {{-- ─── HERO ─────────────────────────────── --}}
    <div class="relative px-4 pt-14 pb-20 text-center overflow-hidden bg-white border-b border-gray-100">

        {{-- Current plan badge --}}
        @if ($user->subscription_type === 'premium')
            <div
                class="inline-flex items-center gap-2 mb-5 px-4 py-2 rounded-full border border-yellow-400/50 bg-yellow-50 fade-up">
                <img src="https://img.icons8.com/ios-filled/20/FAB005/crown.png" alt="crown" class="w-4 h-4">
                <span class="text-yellow-600 text-sm font-semibold">You're on Premium</span>
            </div>
        @else
            <div
                class="inline-flex items-center gap-2 mb-5 px-4 py-2 rounded-full border border-orange-200 bg-orange-50 fade-up">
                <span class="w-2 h-2 rounded-full bg-orange-400 animate-pulse"></span>
                <span class="text-orange-600 text-sm font-semibold">Limited deal — up to 40% off</span>
            </div>
        @endif

        <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight tracking-tight fade-up delay-1 text-gray-900">
            Simple, honest
            <span class="block text-[#16714B]">pricing</span>
        </h1>
        <p class="text-gray-400 text-lg max-w-md mx-auto mb-10 fade-up delay-2" style="font-weight:300;">
            One subscription. Unlimited plants.
        </p>

        {{-- Duration Tabs --}}
        <div class="flex justify-center mb-12 fade-up delay-2" x-data="subscriptionPricing()">
            <div class="flex flex-col items-center gap-8 w-full">

                <div class="flex p-1 rounded-full bg-gray-100 border border-gray-200">
                    <button class="tab-pill" :class="{ active: duration === 'monthly' }"
                        @click="duration = 'monthly'">Monthly</button>
                    <button class="tab-pill" :class="{ active: duration === 'yearly' }"
                        @click="duration = 'yearly'">Semi-Annually</button>
                    <button class="tab-pill" :class="{ active: duration === 'biennial' }"
                        @click="duration = 'biennial'">
                        Annually
                        <span class="ml-1 px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wide uppercase"
                            :style="duration === 'biennial'
                                ?
                                'background:rgba(255,255,255,0.2);border:1px solid white;color:white;' :
                                'background:rgba(22,113,75,0.12);border:1px solid rgba(22,113,75,0.25);color:#16714B;'">
                            Best
                        </span>
                    </button>
                </div>

                {{-- PLAN CARDS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl w-full fade-up delay-3">

                    {{-- General Plan --}}
                    <div class="relative rounded-2xl p-7 text-left flex flex-col transition-transform duration-300 hover:-translate-y-1 bg-white"
                        style="border:1px solid rgba(0,0,0,0.08);box-shadow:0 1px 12px rgba(0,0,0,0.06);">
                        <p class="text-[11px] uppercase tracking-widest text-gray-400 font-semibold mb-1">Starter</p>
                        <h2 class="text-xl font-bold mb-1 text-gray-900">General Plan</h2>
                        <p class="text-gray-400 text-sm mb-5">Essentials only</p>
                        <div class="mb-5">
                            <div class="flex items-end gap-1">
                                <span class="price-num text-gray-900" x-text="plans[duration].starter.price">Free</span>
                            </div>
                            <p class="text-gray-400 text-sm mt-1" x-text="plans[duration].starter.billed">No credit card
                                required</p>
                            <p class="text-lg mt-1 h-4" x-html="plans[duration].starter.save"></p>
                        </div>
                        <button
                            class="btn-outline w-full font-bold text-sm py-3 px-5 rounded-full text-gray-700 mb-6">Your
                            current plan</button>
                        <hr class="border-gray-100 mb-5">
                        <ul class="space-y-3 flex-1">
                            @foreach (['General Features', 'Simple Dashboard', 'Add up to 5 plants'] as $f)
                                <li class="flex items-center gap-3 text-sm text-gray-600">
                                    <span class="check-icon"><svg width="10" height="10" viewBox="0 0 12 12"
                                            fill="none" stroke="#16714B" stroke-width="2.5">
                                            <polyline points="2,6 5,9 10,3" />
                                        </svg></span>
                                    {{ $f }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Premium Plan --}}
                    <div class="relative rounded-2xl p-7 text-left flex flex-col card-featured transition-transform duration-300 hover:-translate-y-1 bg-white overflow-hidden"
                        style="border:1.5px solid rgba(22,113,75,0.4);box-shadow:0 4px 24px rgba(22,113,75,0.1);">
                        <div class="flex items-start justify-between mb-1">
                            <p class="text-[11px] uppercase tracking-widest text-gray-400 font-semibold">BloomChain One</p>
                            <span
                                class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full text-white"
                                style="background:linear-gradient(135deg,#16714B,#22c55e);">Popular</span>
                        </div>
                        <h2 class="text-xl font-bold mb-1 text-gray-900">Premium Plan</h2>
                        <p class="text-gray-400 text-sm mb-5">Complete package</p>
                        <div class="mb-5">
                            <div class="flex items-end gap-1">
                                <span class="price-num text-gray-900" x-text="plans[duration].one.price">$2.49</span>
                                <span class="text-gray-400 text-sm mb-1">/mo</span>
                            </div>
                            <p class="text-gray-400 text-sm mt-1" x-text="plans[duration].one.billed">Billed $29.88
                                every year</p>
                            <p class="text-lg mt-1" x-html="plans[duration].one.save"></p>
                        </div>
                        <button class="btn-primary w-full font-bold text-sm py-3 px-5 rounded-full mb-6">Get
                            Premium</button>
                        <hr class="border-gray-100 mb-5">
                        <ul class="space-y-3 flex-1">
                            @foreach (['Everything in General Plan', 'Dashboard Analytics', 'Unlimited Plant Addition'] as $f)
                                <li class="flex items-center gap-3 text-sm text-gray-600">
                                    <span class="check-icon"><svg width="10" height="10" viewBox="0 0 12 12"
                                            fill="none" stroke="#16714B" stroke-width="2.5">
                                            <polyline points="2,6 5,9 10,3" />
                                        </svg></span>
                                    {{ $f }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        {{-- Trust row --}}
        <div class="flex flex-wrap justify-center gap-6 mt-10 fade-up delay-3">
            @foreach ([['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z', '30-day money-back'], ['M12 5a3 3 0 1 1 3 3m-3-3a3 3 0 1 0-3 3m3-3v1|M9 8a3 3 0 1 0 3 3M9 8h1m5 0a3 3 0 1 1-3 3m3-3h-1m-2 3v-1|M12 10v12|M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z|M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z', 'Unlimited plants'], ['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z|M9 12l2 2 4-4', 'Secure & private']] as [$path, $label])
                <div class="flex items-center gap-2 text-gray-400 text-sm">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="#16714B" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        @foreach (explode('|', $path) as $p)
                            <path d="{{ $p }}" />
                        @endforeach
                    </svg>
                    {{ $label }}
                </div>
            @endforeach
        </div>
    </div>

    {{-- ─── WHY SECTION ──────────────────────── --}}
    <div class="px-4 py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-3 text-gray-900">Why choose us?</h2>
                <p class="text-gray-400 text-base">Beyond features — we offer peace of mind.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach ([['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z|M9 12l2 2 4-4', '30-day money-back', 'Not happy? Get a full refund within 30 days of signing up — no questions asked.'], ['M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z|M2 12h20|M12 2a15 15 0 0 1 4 10 15 15 0 0 1-4 10', 'Unlimited plants', 'Upgrade to premium and add as many plants as you need to your nursery.'], ['M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z|M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z', 'Full analytics', 'Get detailed insights and analytics on your nursery performance and plant data.']] as [$icon, $title, $desc])
                    <div class="rounded-2xl p-6 bg-white transition-transform duration-300 hover:-translate-y-1"
                        style="border:1px solid rgba(0,0,0,0.07);box-shadow:0 1px 8px rgba(0,0,0,0.05);">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4"
                            style="background:rgba(22,113,75,0.1);">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#16714B"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                @foreach (explode('|', $icon) as $p)
                                    <path d="{{ $p }}" />
                                @endforeach
                            </svg>
                        </div>
                        <h3 class="text-base font-bold mb-2 text-gray-900">{{ $title }}</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <a href="{{ route('checkout') }}"
        @click.prevent="navigate('{{ route('checkout') }}', 'payment.checkout')"
        class="btn-primary w-full font-bold text-sm py-3 px-5 rounded-full mb-6"
    >Checkout Button</a>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('subscriptionPricing', () => ({
            duration: 'biennial',
            plans: {
                monthly: {
                    starter: {
                        price: 'Free',
                        billed: 'No credit card required',
                        save: ''
                    },
                    one: {
                        price: 'Rs. 999',
                        billed: 'Billed Rs. 999 every month',
                        save: ''
                    },
                },
                yearly: {
                    starter: {
                        price: 'Free',
                        billed: 'No credit card required',
                        save: ''
                    },
                    one: {
                        price: 'Rs. 849',
                        billed: 'Billed Rs. 5,094 every 6 months',
                        save: '<s class="text-gray-300">Rs. 999/mo</s><span class="text-orange-500 font-semibold ml-1">15% off</span>'
                    },
                },
                biennial: {
                    starter: {
                        price: 'Free',
                        billed: 'No credit card required',
                        save: ''
                    },
                    one: {
                        price: 'Rs. 599',
                        billed: 'Billed Rs 7,188 every year',
                        save: '<s class="text-gray-300">Rs. 999/mo</s><span class="text-orange-500 font-semibold ml-1">40% off</span>'
                    },
                }
            }
        }))
    })

    function subSetPlan(duration, btn) {
        document.querySelectorAll('.tab-pill').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const badge = document.getElementById('best-badge');
        if (duration === 'biennial') {
            badge.style.background = 'rgba(255,255,255,0.2)';
            badge.style.border = '1px solid white';
            badge.style.color = 'white';
        } else {
            badge.style.background = 'rgba(22,113,75,0.12)';
            badge.style.border = '1px solid rgba(22,113,75,0.25)';
            badge.style.color = '#16714B';
        }

        const p = plans[duration];
        document.getElementById('starter-price').textContent = p.starter.price;
        document.getElementById('starter-billed').textContent = p.starter.billed;
        document.getElementById('starter-save').innerHTML = p.starter.save;
        document.getElementById('one-price').textContent = p.one.price;
        document.getElementById('one-billed').textContent = p.one.billed;
        document.getElementById('one-save').innerHTML = p.one.save;
    }
</script>
