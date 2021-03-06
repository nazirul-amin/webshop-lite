<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <div class="sidebar-brand d-flex align-items-center mx-4">
                <div class="sidebar-brand-icon">
                    <img src="img/undraw_empty_cart_co35.svg" style="width: 70%">
                </div>
                <h1 class="sidebar-brand-text mx-1">WEBSHOP</h1>
            </div>
        </x-slot>

        <x-jet-validation-errors class="mb-3" />

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <x-jet-label value="{{ __('Name') }}" />

                    <x-jet-input class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                                 :value="old('name')" required autofocus autocomplete="name" />
                    <x-jet-input-error for="name"></x-jet-input-error>
                </div>

                <div class="form-group">
                    <x-jet-label value="{{ __('Identity Number') }}" />

                    <x-jet-input class="{{ $errors->has('identity_no') ? 'is-invalid' : '' }}" type="text" name="identity_no"
                                 :value="old('identity_no')" required autofocus autocomplete="identity_no" />
                    <x-jet-input-error for="identity_no"></x-jet-input-error>
                </div>

                <div class="form-group">
                    <x-jet-label value="{{ __('phone Number') }}" />

                    <x-jet-input class="{{ $errors->has('phone_no') ? 'is-invalid' : '' }}" type="text" name="phone_no"
                                 :value="old('phone_no')" required autofocus autocomplete="phone_no" />
                    <x-jet-input-error for="phone_no"></x-jet-input-error>
                </div>

                <div class="form-group">
                    <x-jet-label value="{{ __('Age') }}" />

                    <x-jet-input class="{{ $errors->has('age') ? 'is-invalid' : '' }}" type="text" name="age"
                                 :value="old('age')" required autofocus autocomplete="age" />
                    <x-jet-input-error for="age"></x-jet-input-error>
                </div>

                <div class="form-group">
                    <x-jet-label value="{{ __('Email') }}" />

                    <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
                                 :value="old('email')" required />
                    <x-jet-input-error for="email"></x-jet-input-error>
                </div>

                <div class="form-group">
                    <x-jet-label value="{{ __('Password') }}" />

                    <x-jet-input class="{{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                                 name="password" required autocomplete="new-password" />
                    <x-jet-input-error for="password"></x-jet-input-error>
                </div>

                <div class="form-group">
                    <x-jet-label value="{{ __('Confirm Password') }}" />

                    <x-jet-input class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <x-jet-checkbox id="terms" name="terms" />
                            <label class="custom-control-label" for="terms">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                            </label>
                        </div>
                    </div>
                @endif

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        <a class="text-muted mr-3 text-decoration-none" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-jet-button>
                            {{ __('Register') }}
                        </x-jet-button>
                    </div>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
