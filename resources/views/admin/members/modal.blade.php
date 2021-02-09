<div class="modal-info" id="balance-modal">
    <div class="scroll-wrap">
        <div class="info-text">
            <p>{{ __('Add Credits') }}</p>
        </div>

        <div class="info-icon">
            <div class="add-new">
                <div class="item col-12">
                    <label class="text-option">
                        <span class="label-wrap">
                            <input type="number" name="credits" step="0.01" required
                                   class="placeholder-effect has-content" min="0" pattern="[0-9]+">
                            <span class="placeholder">Credits</span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="info-btn">
            <button type="button" class="main-btn yellow add-credits">{{ __('Add') }}</button>
            <button type="button" class="main-btn yellow-blank" data-fancybox-close>{{ __('Close') }}</button>
        </div>
    </div>
</div>
