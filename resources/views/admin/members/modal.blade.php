<div class="modal-info" id="balance-modal">
    <div class="scroll-wrap">
        <div class="info-text">
            <p>{{ __('Update Credits') }}</p>
        </div>
        <div class="info-icon">
            <div class="add-new">
                <div class="item col-12">
                    <label class="text-option">
                        <span class="label-wrap">
                            <input type="number" name="credits" step="0.01" required
                                   class="placeholder-effect has-content">
                            <span class="placeholder">Credits</span>
                        </span>
                    </label>
                </div>
                <div class="item col-12">
                    <label class="text-option">
                        <span class="label-wrap">
                            <textarea type="text" name="transectionDescription"  required
                                   class="placeholder-effect has-content"></textarea>
                            <span class="placeholder">Description</span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="info-btn">
            <button type="button" class="main-btn yellow add-credits">{{ __('Update') }}</button>
            <button type="button" class="main-btn yellow-blank" data-fancybox-close>{{ __('Close') }}</button>
        </div>
    </div>
</div>
