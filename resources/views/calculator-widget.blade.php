<!DOCTYPE html>
<html lang="he">
<head>
    <title>Template</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">

    <link rel="stylesheet" href="{{asset('css/bundle_calculator.css')}}" type="text/css"/>

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{asset('images/favicon/apple-touch-icon-57x57.png')}}" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('images/favicon/apple-touch-icon-114x114.png')}}" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('images/favicon/apple-touch-icon-72x72.png')}}" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('images/favicon/apple-touch-icon-144x144.png')}}" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{asset('images/favicon/apple-touch-icon-60x60.png')}}" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{asset('images/favicon/apple-touch-icon-120x120.png')}}" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{asset('images/favicon/apple-touch-icon-76x76.png')}}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{asset('images/favicon/apple-touch-icon-152x152.png')}}" />
    <link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-196x196.png')}}" sizes="196x196" />
    <link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-96x96.png')}}" sizes="96x96" />
    <link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-32x32.png')}}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-16x16.png')}}" sizes="16x16" />
    <link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-128.png')}}" sizes="128x128" />
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="mstile-310x310.png" />


    <!-- open graph -->
	<meta property="og:site_name" content="Template">
     <meta property="og:url" content="http://template/" />
     <meta property="og:type" content="website" />
     <meta property="og:title" content="template" />
     <meta property="og:description" content="template" />
     <meta property="og:image" content="http://template/" />
	 <meta property="og:locale" content="ru_RU">
     <!-- open graph -->
</head>
<body>


<div class="calculator-page">
    <div class="container">
        <div class="page-title">
            <div class="main-title">
                <h1>מחשבון קרדיטים - התאימו את השכירות המושלמת עבורכם</h1>
                <p> מחשבון זה יעזור לכם להתייעל ולהתאים את הצורך של העסק לשכירות המושלמת עבורו, כמה קרדיטים תצטרכו ומה
                    רמת הגמישות הנדרשת עבור העסק, מעכשיו, השליטה בידיים שלכם</p>
            </div>
            <div class="form-title" data-form="1">
                <h2>מחשבון קרדיטים - התאימו את השכירות המושלמת עבורכם</h2>
                <p> מחשבון זה יעזור לכם להתייעל ולהתאים את הצורך של העסק לשכירות המושלמת עבורו, כמה קרדיטים תצטרכו ומה
                    רמת הגמישות הנדרשת עבור העסק, מעכשיו, השליטה בידיים שלכם</p>
            </div>
            <div class="form-title" data-form="2">
                <h2>מחשבון</h2>
                <p>מחשבון שיעזור לכם לדעת כמה משכנתא תוכלו לקבל, מה ההחזר החודשי שמתאים לכם וכמה כסף עומד לרשותכם לקניית
                    דירה</p>
            </div>
        </div>
        <div class="calculator-app">
            <div class="calculator-data">
                <div class="wrap">
                    <div class="intro-img">
                        <span><img src="{{asset('images/calc-app.png')}}" alt=""></span>
                    </div>
                    <div class="data-wrap amount-credits-form" data-form="1">
                        <div class="data-range">
                            <ul>
                                <li class="credits-amount-range">
                                    <div class="range-title">
                                        <h3><span class="info-icon" data-info=".הזן את כמות הקרדיטים שתרצה לרכוש שים לב- ככל שרוכשים יותר, מחיר הקרדיט יורד."></span>כמות הקרדיטים שתרצה לרכוש</h3>
                                    </div>
                                    <div class="range-wrap">
                                        <div class="current-value"><p data-currency="₪"></p></div>
                                        <div class="range-item">
                                            <div class="item-wrap">
                                                <div class="min-range"><p>50</p></div>
                                                <div class="max-range"><p>6 000</p></div>
                                                <div class="item-handle" data-min="50" data-max="6 000" data-step="100"
                                                     data-start="6000"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="rental-months-range">
                                    <div class="range-title">
                                        <h3><span class="info-icon" data-info="!השליטה בידיים שלך במשך כמה חודשים תרצה לנצל את כמות השעות שבחרת?"></span>מדד גמישות</h3>
                                    </div>
                                    <div class="range-wrap">
                                        <div class="current-value"><p></p></div>
                                        <div class="range-item">
                                            <div class="item-wrap">
                                                <div class="min-range"><p>1</p></div>
                                                <div class="max-range"><p>12</p></div>
                                                <div class="item-handle" data-min="1" data-max="12" data-step="1"
                                                     data-start="4"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="credit-worth-range">
                                    <div class="range-title">
                                        <h3><span class="info-icon" data-info="המחיר לקרדיט קובע את העלות השעתית שלך במשרדים השונים ומושפע מכמות הקרדיטים שרכשת וממדד הגמישות"></span>מחיר לקרדיט</h3>
                                    </div>
                                    <div class="range-wrap">
                                        <div class="current-value"><p></p></div>
                                        <div class="range-item">
                                            <div class="item-wrap">
                                                <div class="min-range"><p>1</p></div>
                                                <div class="max-range"><p>10</p></div>
                                                <div class="item-handle" data-min="1" data-max="10" data-step="1"
                                                     data-start="6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="range-text">
                                <p>מוזמנים לשנות את הנתונים ולראות איך זה משפיע על המחיר החודשי</p>
                            </div>
                            <div class="range-recommendation">
                                <div class="text">
                                    <p>כדי להגדיל את כמות הקרדיטים, מומלץ להאריך את התקציב החודשי שרוכשים או להאריך את
                                        תקופת המנוי</p>
                                </div>
                                <div class="icon">
                                    <img src="{{asset('images/logo.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="summary-range">
                            <div class="results">
                                <ul>
                                    <li class="total-price">
                                        <div class="title">
                                            <h3>עלות כוללת</h3>
                                        </div>
                                        <div class="amount"><p data-currency="₪"></p></div>
                                    </li>
                                    <li class="monthly-price">
                                        <div class="title">
                                            <h3>מחיר חודשי</h3>
                                        </div>
                                        <div class="amount"><p data-currency="₪"></p></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="text">
                                <p>התאמתם את השכירות המושלמת בשבילכם?</p>
                            </div>
                            <div class="btn">
                                <button type="button">לטעינת הקרדיטים באפליקציית WeBiz</button>
                            </div>
                        </div>
                    </div>
                    <div class="data-wrap monthly-budget-form" data-form="2">
                        <div class="data-range">
                            <ul>
                                <li class="monthly-budget-range">
                                    <div class="range-title">
                                        <h3><span class="info-icon" data-info="הזן את התקציב החודשי שלך למשרד"></span>כמות הקרדיטים שתרצה לרכוש</h3>
                                    </div>
                                    <div class="range-wrap">
                                        <div class="current-value"><p data-currency="₪"></p></div>
                                        <div class="range-item">
                                            <div class="item-wrap">
                                                <div class="min-range"><p>500</p></div>
                                                <div class="max-range"><p>6 000</p></div>
                                                <div class="item-handle" data-min="500" data-max="6 000" data-step="100"
                                                     data-start="1700"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="rental-months-range">
                                    <div class="range-title">
                                        <h3><span class="info-icon" data-info="השליטה בידיים שלך! לכמה חודשים תרצה לשכור את המשרד?"></span>מדד גמישות</h3>
                                    </div>
                                    <div class="range-wrap">
                                        <div class="current-value"><p></p></div>
                                        <div class="range-item">
                                            <div class="item-wrap">
                                                <div class="min-range"><p>1</p></div>
                                                <div class="max-range"><p>12</p></div>
                                                <div class="item-handle" data-min="1" data-max="12" data-step="1"
                                                     data-start="4"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="range-text">
                                <p>מוזמנים לשנות את הנתונים ולראות איך זה משפיע על המחיר החודשי</p>
                            </div>
                            <div class="range-recommendation">
                                <div class="text">
                                    <p>כדי להגדיל את כמות הקרדיטים, מומלץ להאריך את התקציב החודשי שרוכשים או להאריך את
                                        תקופת המנוי</p>
                                </div>
                                <div class="icon">
                                    <img src="{{asset('images/logo.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="summary-range">
                            <div class="results">
                                <ul>
                                    <li class="total-price">
                                        <div class="title">
                                            <h3>עלות כוללת</h3>
                                        </div>
                                        <div class="amount"><p data-currency="₪"></p></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="text">
                                <p>התאמתם את השכירות המושלמת בשבילכם?</p>
                            </div>
                            <div class="btn">
                                <button type="button">לטעינת הקרדיטים באפליקציית WeBiz</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="calculator-toolbar">
                <div class="wrap">
                    <div class="toolbar-title">
                        <h2>לפי מה תרצה להרכיב את השכירות המותאמת שלך?</h2>
                    </div>
                    <div class="toolbar-data">
                        <h3>אנחנו רוצים לדעת מהו</h3>
                        <ul>
                            <li>
                                <label>
                                    <input type="radio" name="app" data-form="1">
                                    <span>לפי כמות קרדיטים</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="app" data-form="2">
                                    <span>לפי מחיר חודשי</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="toolbar-btn">
                        <button type="button">התחל לחשב</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="{{asset('js/calculator/libs.js')}}" defer></script>
<script src="{{asset('js/calculator/common.js')}}" defer></script>

</body>
</html>