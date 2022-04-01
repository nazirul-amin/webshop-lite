<div>
    <div style="display:flex;">
        <div class="fixed" style="list-style: none; padding: 10px; width: 250px;">
            <x-jet-dropdown>
                <x-slot name="trigger">
                    Select Year
                    <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </x-slot>

                <x-slot name="content">
                    <h6 class="dropdown-header">
                        {{ __('Years') }}
                    </h6>
                    @foreach ($years as $year)
                        <x-jet-dropdown-link href="">
                            {{ __($year) }}
                        </x-jet-dropdown-link>
                    @endforeach
                </x-slot>
            </x-jet-dropdown>
        </div>
        <div class="fixed" style="list-style: none; padding: 10px; width: 250px;">
            <x-jet-dropdown>
                <x-slot name="trigger">
                    Select Months
                    <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </x-slot>

                <x-slot name="content">
                    <h6 class="dropdown-header">
                        {{ __('Months') }}
                    </h6>
                    @foreach ($months as $month)
                        <x-jet-dropdown-link href="">
                            {{ __($month) }}
                        </x-jet-dropdown-link>
                    @endforeach
                </x-slot>
            </x-jet-dropdown>
        </div>
    </div>
    <hr>
</div>
