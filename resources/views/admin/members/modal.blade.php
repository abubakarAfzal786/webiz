<div class="modal-info" id="balance-modal">
    <div class="scroll-wrap">
        <div class="info-text">
            <p>{{ __('Add Credits') }}</p>
        </div>

        <div class="info-icon">
            <label>
                <input type="number" name="credits" step="0.01">
                <span>{{ __('Credits') }}</span>
            </label>
        </div>
        <div class="info-btn">
            <button type="button" class="main-btn yellow add-credits">{{ __('Add') }}</button>
            <button type="button" class="main-btn yellow-blank" data-fancybox-close>{{ __('Close') }}</button>
        </div>
    </div>
</div>
