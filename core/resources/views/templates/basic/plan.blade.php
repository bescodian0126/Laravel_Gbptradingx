@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $planContent = getContent('plan.content', true);
    @endphp
    <section class="blog-section padding-top padding-bottom">
        <div class="container">
            <div class="row mb-30-none">
                @foreach ($plans as $plan)
                    <div class="col-lg-4 col-md-6 col-sm-10 mb-30">
                        <div class="plan-card bg_img text-center"
                            data-background="{{ asset(getImage('assets/images/frontend/plan/' . @$planContent->data_values->background_image, '700x480')) }}">
                            <h4 class="plan-card__title text--base mb-2">{{ __(@$plan->name) }}</h4>
                            <div class="price-range mt-5 text-white"> {{ showAmount($plan->price) }}
                                {{ __($general->cur_text) }} </div>
                            <ul class="plan-card__features mt-4">
                                <li> @lang('Maxiumn Income on Plan') : <span
                                        class="amount">{{ $general->cur_sym }}{{ $plan->max_income }}</span>
                                    <span class="icon float-right" data-bs-toggle="modal"
                                        data-bs-target="#profitInfoModal"><i class="fas fa-question-circle"></i></span>
                                </li>
                                <li>
                                    @lang('Daily Income') : <span class="amount"> {{ number_format($plan->start_income * $plan->price / 100, $plan->start_income * $plan->price / 100 - floor($plan->start_income * $plan->price / 100) == 0 ? 0 : 1, '.', '') }} 
                                        {{ __($general->cur_text) }}</span>
                                    <span class="icon float-right" data-bs-toggle="modal"
                                        data-bs-target="#inviteCountModal"><i class="fas fa-question-circle"></i></span>
                                </li>

                                <li>
                                    @lang('Brokerage Fee') : <span class="amount">{{ showAmount($plan->weekly_fee) }} (%)</span>
                                    <span class="icon float-right" data-bs-toggle="modal"
                                        data-bs-target="#bonusAmoutModal"><i class="fas fa-question-circle"></i></span>
                                </li>
                                <li>
                                    @lang('Duration') : <span class="amount">{{ intval($plan->duration) }}
                                        {{ $plan->repeat_unit }}</span>
                                    <span class="icon float-right" data-bs-toggle="modal"
                                        data-bs-target="#durationInfoModal"><i class="fas fa-question-circle"></i></span>
                                </li>

                            </ul>

                            @auth
                                @if (@auth()->user()->plan->price > $plan->price)
                                    <button class="custom-button theme disabled mt-3 w-auto text-white" type="button">
                                        @lang('Unavailable')
                                    </button>
                                @elseif (auth()->user()->plan_id != $plan->id)
                                    <button class="subscribeBtn custom-button theme mt-3 w-auto text-white"
                                        data-amount="{{ getAmount($plan->price) }}" data-id="{{ $plan->id }}"
                                        type="button">
                                        @lang('Subscribe Now')
                                    </button>
                                @else
                                    <button class="custom-button btn--success disabled mt-3 w-auto" type="button">
                                        @lang('Cureent Plan')
                                    </button>
                                @endif
                            @else
                                <button class="custom-button theme mt-3 w-auto text-white" data-bs-toggle="modal"
                                    data-bs-target="#loginModal">
                                    @lang('Subscribe now')
                                </button>
                            @endauth

                        </div>
                    </div>
                @endforeach
            </div>

            @if ($plans->hasPages())
                {{ paginateLinks($plans) }}
            @endif
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
    @include($activeTemplate . 'partials.plan_modals')
@endsection
