(function () {
    'use strict';

    function changeFormTabs() {
        if (document.querySelector('.calculator-app .calculator-toolbar .toolbar-data ul li label input[type=radio]:checked')) {
            let _form = document.querySelector('.calculator-app .calculator-toolbar .toolbar-data ul li label input[type=radio]:checked').dataset.form;

            document.querySelector('.calculator-app .calculator-data .intro-img').style.display = 'none';
            if (document.querySelector('.calculator-app .calculator-data .data-wrap.active') !== null) {
                document.querySelector('.calculator-app .calculator-data .data-wrap.active').classList.remove('active');
            }
            document.querySelector('.calculator-app .calculator-data .data-wrap[data-form="' + _form + '"]').classList.add('active');

            document.querySelector('.calculator-page .page-title .main-title').style.display = 'none';
            if (document.querySelector('.calculator-page .page-title .form-title.active') !== null) {
                document.querySelector('.calculator-page .page-title .form-title.active').classList.remove('active');
            }
            document.querySelector('.calculator-page .page-title .form-title[data-form="' + _form + '"]').classList.add('active');
        }
    }

    document.querySelector(".calculator-app .calculator-toolbar .toolbar-btn button").addEventListener("click", changeFormTabs);

    if (document.querySelector('.amount-credits-form')) {
        const TOTAL_ACF_PRICE = document.querySelector('.amount-credits-form .summary-range .results .total-price .amount p'),
            MONTHLY_ACF_PRICE = document.querySelector('.amount-credits-form .summary-range .results .monthly-price .amount p'),
            CREDITS_AMOUNT_ACF_SLIDER = document.querySelector('.amount-credits-form .credits-amount-range .item-handle'),
            CREDITS_AMOUNT_ACF_VALUE = document.querySelector('.amount-credits-form .credits-amount-range .current-value p'),
            RENTAL_MONTHS_ACF_SLIDER = document.querySelector('.amount-credits-form .rental-months-range .item-handle'),
            RENTAL_MONTHS_ACF_VALUE = document.querySelector('.amount-credits-form .rental-months-range .current-value p'),
            CREDIT_WORTH_ACF_SLIDER = document.querySelector('.amount-credits-form .credit-worth-range .item-handle'),
            CREDIT_WORTH_ACF_VALUE = document.querySelector('.amount-credits-form .credit-worth-range .current-value p');

        noUiSlider.create(CREDITS_AMOUNT_ACF_SLIDER, {
            start: parseFloat(CREDITS_AMOUNT_ACF_SLIDER.dataset.start.replace(/ /g, '')),
            tooltips: false,
            connect: [true, false],
            step: parseFloat(CREDITS_AMOUNT_ACF_SLIDER.dataset.step.replace(/ /g, '')),
            range: {
                min: parseFloat(CREDITS_AMOUNT_ACF_SLIDER.dataset.min.replace(/ /g, '')),
                max: parseFloat(CREDITS_AMOUNT_ACF_SLIDER.dataset.max.replace(/ /g, ''))
            },
        });

        noUiSlider.create(RENTAL_MONTHS_ACF_SLIDER, {
            start: parseFloat(RENTAL_MONTHS_ACF_SLIDER.dataset.start.replace(/ /g, '')),
            tooltips: false,
            connect: [true, false],
            step: parseFloat(RENTAL_MONTHS_ACF_SLIDER.dataset.step.replace(/ /g, '')),
            range: {
                min: parseFloat(RENTAL_MONTHS_ACF_SLIDER.dataset.min.replace(/ /g, '')),
                max: parseFloat(RENTAL_MONTHS_ACF_SLIDER.dataset.max.replace(/ /g, ''))
            },
        });

        noUiSlider.create(CREDIT_WORTH_ACF_SLIDER, {
            start: parseFloat(CREDIT_WORTH_ACF_SLIDER.dataset.start.replace(/ /g, '')),
            tooltips: false,
            connect: [true, false],
            step: parseFloat(CREDIT_WORTH_ACF_SLIDER.dataset.step.replace(/ /g, '')),
            range: {
                min: parseFloat(CREDIT_WORTH_ACF_SLIDER.dataset.min.replace(/ /g, '')),
                max: parseFloat(CREDIT_WORTH_ACF_SLIDER.dataset.max.replace(/ /g, ''))
            },
        });

        function get_acf_total() {
            let _total = parseFloat(CREDITS_AMOUNT_ACF_SLIDER.noUiSlider.get()) * parseFloat(CREDIT_WORTH_ACF_SLIDER.noUiSlider.get())
            TOTAL_ACF_PRICE.innerHTML = _total.toLocaleString('en-US', {maximumFractionDigits: 2});
        }

        function get_acf_monthly_price() {
            let _total = parseFloat(CREDITS_AMOUNT_ACF_SLIDER.noUiSlider.get()) / parseFloat(RENTAL_MONTHS_ACF_SLIDER.noUiSlider.get())
            MONTHLY_ACF_PRICE.innerHTML = _total.toLocaleString('en-US', {maximumFractionDigits: 2});
        }

        function get_acf_credit_worth() {
            // let _total = 8 - 4.5 * ((0.25 * (parseFloat(RENTAL_MONTHS_ACF_SLIDER.noUiSlider.get()) - 12)) / -11 + (0.75 * (parseFloat(CREDITS_AMOUNT_ACF_SLIDER.noUiSlider.get()) - 50)) / 4950)
            // CREDIT_WORTH_ACF_SLIDER.noUiSlider.set(Math.round(_total))

            let _z = 4.5 + (parseFloat(CREDITS_AMOUNT_ACF_SLIDER.noUiSlider.get()) - 500) * (-0.0002);
            let _y = parseFloat(CREDITS_AMOUNT_ACF_SLIDER.noUiSlider.get()) / 500;
            let _total = (1 + (parseFloat(RENTAL_MONTHS_ACF_SLIDER.noUiSlider.get()) - _y) * 0.05) * _z;
            CREDIT_WORTH_ACF_SLIDER.noUiSlider.set(Math.round(_total))
        }

        CREDITS_AMOUNT_ACF_SLIDER.noUiSlider.on('update', function (values, handle) {
            CREDITS_AMOUNT_ACF_VALUE.innerHTML = parseFloat(values[handle]).toLocaleString();
            get_acf_total();
            get_acf_monthly_price();
            get_acf_credit_worth();
        });

        RENTAL_MONTHS_ACF_SLIDER.noUiSlider.on('update', function (values, handle) {
            RENTAL_MONTHS_ACF_VALUE.innerHTML = parseFloat(values[handle]).toFixed(0);
            get_acf_monthly_price();
            get_acf_credit_worth();
        });

        CREDIT_WORTH_ACF_SLIDER.noUiSlider.on('update', function (values, handle) {
            CREDIT_WORTH_ACF_VALUE.innerHTML = parseFloat(values[handle]).toFixed(0);
            get_acf_total();
        });
    }


    if (document.querySelector('.monthly-budget-form')) {
        const TOTAL_MBF_PRICE = document.querySelector('.monthly-budget-form .summary-range .results .total-price .amount p'),
            MONTHLY_BUDGET_MBF_SLIDER = document.querySelector('.monthly-budget-form .monthly-budget-range .item-handle'),
            MONTHLY_BUDGET_MBF_VALUE = document.querySelector('.monthly-budget-form .monthly-budget-range .current-value p'),
            RENTAL_MONTHS_MBF_SLIDER = document.querySelector('.monthly-budget-form .rental-months-range .item-handle'),
            RENTAL_MONTHS_MBF_VALUE = document.querySelector('.monthly-budget-form .rental-months-range .current-value p');

        noUiSlider.create(MONTHLY_BUDGET_MBF_SLIDER, {
            start: parseFloat(MONTHLY_BUDGET_MBF_SLIDER.dataset.start.replace(/ /g, '')),
            tooltips: false,
            connect: [true, false],
            step: parseFloat(MONTHLY_BUDGET_MBF_SLIDER.dataset.step.replace(/ /g, '')),
            range: {
                min: parseFloat(MONTHLY_BUDGET_MBF_SLIDER.dataset.min.replace(/ /g, '')),
                max: parseFloat(MONTHLY_BUDGET_MBF_SLIDER.dataset.max.replace(/ /g, ''))
            },
        });

        noUiSlider.create(RENTAL_MONTHS_MBF_SLIDER, {
            start: parseFloat(RENTAL_MONTHS_MBF_SLIDER.dataset.start.replace(/ /g, '')),
            tooltips: false,
            connect: [true, false],
            step: parseFloat(RENTAL_MONTHS_MBF_SLIDER.dataset.step.replace(/ /g, '')),
            range: {
                min: parseFloat(RENTAL_MONTHS_MBF_SLIDER.dataset.min.replace(/ /g, '')),
                max: parseFloat(RENTAL_MONTHS_MBF_SLIDER.dataset.max.replace(/ /g, ''))
            },
        });

        function get_mbf_total() {
            let _total = (parseFloat(MONTHLY_BUDGET_MBF_SLIDER.noUiSlider.get()) * Math.pow(1.05, (parseFloat(RENTAL_MONTHS_MBF_SLIDER.noUiSlider.get()) - 1))) / 4.2
            TOTAL_MBF_PRICE.innerHTML = _total.toLocaleString('en-US', {maximumFractionDigits: 2});
        }

        MONTHLY_BUDGET_MBF_SLIDER.noUiSlider.on('update', function (values, handle) {
            MONTHLY_BUDGET_MBF_VALUE.innerHTML = parseFloat(values[handle]).toLocaleString();
            get_mbf_total()
        });

        RENTAL_MONTHS_MBF_SLIDER.noUiSlider.on('update', function (values, handle) {
            RENTAL_MONTHS_MBF_VALUE.innerHTML = parseFloat(values[handle]).toFixed(0);
            get_mbf_total()
        });
    }


    let infoBtns = document.querySelectorAll(".data-range .range-title h3 span.info-icon");

    for (let i = 0; i < infoBtns.length; i++) {
        infoBtns[i].addEventListener("mouseover", function () {
            let _current = document.querySelectorAll(".data-range .range-title h3 span.info-icon.active");

            // If there's no active class
            if (_current.length > 0) {
                _current[0].className = _current[0].className.replace(" active", "");
            }

            this.classList.add('active');
        });
        infoBtns[i].addEventListener("mouseout", function () {
            this.classList.remove('active');
        });
    }

})();

//# sourceMappingURL=maps/common.js.map
