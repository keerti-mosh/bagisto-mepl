<div class="grid grid-cols-1 gap-6">
    @if ($bookingProduct['default_slot']['duration'])
        <div class="flex gap-3">
            <span class="icon-calendar text-2xl"></span>

            <div class="grid grid-cols-1 gap-1.5 text-sm font-medium">
                <p class="text-[#6E6E6E]">
                    @lang('cliqnshop::app.products.view.type.booking.default.slot-duration') :
                </p>

                <div>
                    @lang('cliqnshop::app.products.view.type.booking.default.slot-duration-in-minutes', ['minutes' => $bookingProduct['default_slot']['duration']])
                </div>
            </div>
        </div>
    @endif

    @include('cliqnshop::products.view.types.booking.slots', ['bookingProduct' => $bookingProduct])
</div>
