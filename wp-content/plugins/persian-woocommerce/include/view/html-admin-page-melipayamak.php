<?php
/**
 * Admin View: Gateways
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?>
<div class="main-box font-iran-sans my-10">

	<div class="py-6 sm:px-8 px-6">
		<div class="flex items-center gap-5 mb-6">
			<div class="sm:h-16 h-14">
				<svg class="h-full" viewBox="0 0 63 71" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
							d="M25.0715 0H37.9287C41.143 0.129091 44.4858 0.774545 47.443 2.06545C52.5858 4.26 56.9573 8.00364 59.7858 12.9091C61.5858 16.1364 62.6144 19.88 62.8715 23.6236V35.8873C62.6144 41.4382 61.2001 46.9891 58.3715 51.7654C56.3144 55.5091 53.4858 58.8655 50.143 61.5764C46.543 64.5455 42.4287 66.74 38.1858 68.2891C35.1001 69.4509 31.8858 70.3545 28.6715 71H28.543C28.2858 71 27.9001 70.8709 27.9001 70.4836C28.0287 70.0964 28.2858 69.7091 28.543 69.4509C29.3144 68.5473 30.2144 67.7727 30.9858 66.9982C33.1715 64.8036 35.1001 62.2218 36.1287 59.2527C33.8144 59.2527 26.1001 59.2527 24.6858 59.2527C21.2144 58.9945 17.8715 58.22 14.7858 56.6709C9.64298 54.2182 5.27155 50.0873 2.82869 44.9236C1.54298 42.0836 0.771547 39.1145 0.514404 36.0164C0.514404 35.7582 0.514404 22.5909 0.642976 21.8164C0.900119 19.88 1.28583 18.0727 2.05726 16.2655C3.34298 12.78 5.52869 9.68182 8.22869 7.1C10.8001 4.64727 13.8858 2.84 17.1001 1.67818C19.543 0.645454 22.243 0.129091 25.0715 0ZM12.6001 19.6218C12.6001 21.4291 12.6001 23.3655 12.6001 25.1727C25.843 25.1727 39.0858 25.1727 52.2001 25.1727C52.2001 23.2364 52.2001 21.4291 52.2001 19.4927C51.3001 19.4927 50.4001 19.4927 49.5001 19.4927C38.9573 19.4927 28.2858 19.4927 17.743 19.4927C16.0715 19.6218 14.4001 19.6218 12.6001 19.6218ZM12.6001 33.3055C12.6001 35.2418 12.6001 37.0491 12.6001 38.9855C21.0858 38.9855 29.5715 38.9855 38.0573 38.9855C38.0573 37.0491 38.0573 35.2418 38.0573 33.3055C29.5715 33.3055 21.0858 33.3055 12.6001 33.3055Z"
							fill="url(#paint0_linear_4_122)"
					/>
					<defs>
						<linearGradient id="paint0_linear_4_122" x1="3056.01" y1="3905" x2="-445.864" y2="452.803"
										gradientUnits="userSpaceOnUse">
							<stop stop-color="#42B75E"/>
							<stop offset="1" stop-color="#96CB45"/>
						</linearGradient>
					</defs>
				</svg>
			</div>
			<div>
				<h1 class="text-gary-dark rtl sm:text-2xl text-lg font-bold mb-1">
					اتصال به ملی پیامک
				</h1>
				<h2 class="text-gray-light rtl sm:text-lg text-sm">
					ارتباط سریع و بی دردسر
				</h2>
			</div>
		</div>

		<div class="bg-gray-light-2 rtl rounded-md text-sm1 p-4 mb-6">

			وب‌سرویس ملی پیامک به شما اجازه می‌دهد وب‌سایت ووکامرسی خود را با استفاده از افزونه‌های پیامکی به سامانه
			ملی‌پیامک متصل کرده و در زمان ورود و عضویت، ثبت یا تغییر وضعیت سفارش، تحویل کالا، تکمیل فرم و... مشتریان خود
			را آگاه سازید.
		</div>

		<div class="text-center mb-5">
			<div class="offer">
				<div class="text rtl">
					20% تخفیف ملی پیامک
				</div>

				<div class="holder-code">
                        <span class="code rtl">
                            PWSMS
                        </span>
					<button class="btn-copy rtl" onclick="copyToClipboard(this, 'PWSMS')">
						کپی کد
					</button>
				</div>
			</div>
		</div>

		<div class="d-flex justify-contet-between" style="display: flex;justify-content: center;flex-wrap: wrap;">
			<div class="text-center  ml-20 mb-2">
				<a href="https://www.melipayamak.com/?utm_source=wordpress-admin&utm_medium=landing&utm_campaign=persian-woocommerce/"
				   class="flex w-full items-center justify-center gap-2 bg-blue text-white rounded-[3px] py-3 sm:px-5 px-3  hover:shadow-xl hover:-translate-y-0.5 a2:hover"
				   target="_blank">
                    <span class="sm:h-7 h-6">
                        <svg class="h-full" viewBox="0 0 21 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
									d="M8.3571 0H12.6428C13.7142 0.0418182 14.8285 0.250909 15.8142 0.669091C17.5285 1.38 18.9857 2.59273 19.9285 4.18182C20.5285 5.22727 20.8714 6.44 20.9571 7.65273V11.6255C20.8714 13.4236 20.4 15.2218 19.4571 16.7691C18.7714 17.9818 17.8285 19.0691 16.7142 19.9473C15.5142 20.9091 14.1428 21.62 12.7285 22.1218C11.7 22.4982 10.6285 22.7909 9.5571 23H9.51424C9.42853 23 9.29996 22.9582 9.29996 22.8327C9.34282 22.7073 9.42853 22.5818 9.51424 22.4982C9.77139 22.2055 10.0714 21.9545 10.3285 21.7036C11.0571 20.9927 11.7 20.1564 12.0428 19.1945C11.2714 19.1945 8.69996 19.1945 8.22853 19.1945C7.07139 19.1109 5.9571 18.86 4.92853 18.3582C3.21424 17.5636 1.7571 16.2255 0.942815 14.5527C0.514244 13.6327 0.257101 12.6709 0.171387 11.6673C0.171387 11.5836 0.171387 7.31818 0.214244 7.06727C0.299958 6.44 0.42853 5.85455 0.685672 5.26909C1.11424 4.14 1.84282 3.13636 2.74282 2.3C3.59996 1.50545 4.62853 0.92 5.69996 0.543636C6.51424 0.209091 7.41424 0.0418182 8.3571 0ZM4.19996 6.35636C4.19996 6.94182 4.19996 7.56909 4.19996 8.15454C8.61424 8.15454 13.0285 8.15454 17.4 8.15454C17.4 7.52727 17.4 6.94182 17.4 6.31455C17.1 6.31455 16.8 6.31455 16.5 6.31455C12.9857 6.31455 9.42853 6.31455 5.91424 6.31455C5.3571 6.35636 4.79996 6.35636 4.19996 6.35636ZM4.19996 10.7891C4.19996 11.4164 4.19996 12.0018 4.19996 12.6291C7.02853 12.6291 9.8571 12.6291 12.6857 12.6291C12.6857 12.0018 12.6857 11.4164 12.6857 10.7891C9.8571 10.7891 7.02853 10.7891 4.19996 10.7891Z"
									fill="white"
							/>
                        </svg>
                    </span>
					<span class="rtl">
                        خرید پنل پیامکی
                    </span>
				</a>

			</div>

			<div class="text-center  mb-2">
				<a href="<?php echo admin_url( 'plugin-install.php?tab=plugin-information&plugin=persian-woocommerce-sms' ); ?>"
				   class="flex w-full items-center justify-center gap-2 bg-gray-button rounded-[3px] py-3 sm:px-5 px-3  hover:shadow-xl hover:-translate-y-0.5 a2:hover"
				   target="_blank">
                    <span class="rtl" style="font-size: 16px;">
                        نصب افزونه پیامک ووکامرس
                    </span>
				</a>
			</div>

		</div>


		<div class="flex gap-2 w-full items-center justify-content-md-center  justify-content-evenly text-sm container-sm">
                    <span class="rtl">
                        سوالی دارید؟
                    </span>
			<div>
				<a href="tel:+982163404" class="rtl">
					۰۲۱-۶۳۴۰۴
				</a>
				<span class="inline-block bg-gray-light-2 text-gray-light text-xs rounded-[4px] p-1 mr-1 rtl">
                            داخلی ۱
                        </span>
			</div>
		</div>


	</div>

	<div class="container">

		<div class="md:mb-14 mb-10">
			<div class="flex lg:flex-row flex-col items-center lg:pr-8 gap-x-12 gap-y-6">
				<div class="holder-sms start-right">
					<div class="sms top-7 rtl">
						رمز یکبار مصرف شما : ۴۱۱۳۰
					</div>
					<div class="sms top-20 rtl">
						محمد عزیز خوش آمدید!
					</div>
					<div class="sms bottom-7 rtl">
						مدیر عزیز سفارش جدید داریم.
					</div>
				</div>
				<div>
					<div class="mb-4 lg:text-right text-center">
						<h3 class="text-xl font-bold mb-3 rtl">
							عضویت و ورود با پیامک
						</h3>
						<h5 class="text-gray-light rtl">
							ورود و عضویت همانند دیجی کالا و اسنپ
						</h5>
					</div>
					<ul class="text-sm">
						<li class="mb-2 rtl">
							مدیریت کامل کاربران
						</li>
						<li class="mb-2 rtl">
							فراموشی رمز و پیامک یکبار مصرف
						</li>
						<li class="mb-2 rtl">
							خوش آمدگویی با اس ام اس
						</li>
						<li class="mb-2 rtl">
							اطلاع‌رسانی فروش جدید، کمبود موجودی و... به مدیر
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="lg:mb-10 mb-5">
			<div class="flex lg:flex-row flex-col items-center lg:pr-8 gap-x-12 gap-y-6">
				<div class="holder-sms start-left">
					<div class="sms top-7 rtl">
						کدرهگیری مرسوله پستی شما:
					</div>
					<div class="sms top-20 rtl">
						نظر شما برای ما مهم است!
					</div>
					<div class="sms bottom-7 rtl">
						مدیر عزیز، فرم *** تکمیل شد.
					</div>
				</div>
				<div>
					<div class="mb-4 lg:text-right text-center">
						<h3 class="text-xl font-bold mb-3 rtl">
							فروش بیشتر با تخفیف پیامکی
						</h3>
						<h5 class="text-gray-light rtl">
							اطلاع‌رسانی پیامکی در همه مراحل سفارش
						</h5>
					</div>
					<ul class="text-sm">
						<li class="mb-2 rtl">
							حمل‌ و نقل و رهگیری مرسوله با پیامک
						</li>
						<li class="mb-2 rtl">
							پیامک ثبت سفارش و نظرسنجی به مشتری
						</li>
						<li class="mb-2 rtl">
							اطلاع‌رسانی تخفیف‌ها و خبرنامه پیامکی
						</li>
						<li class="mb-2 rtl">
							سازگاری با گرویتی فرم و ۱۰ افزونه وردپرس دیگر
						</li>
					</ul>
				</div>
			</div>
		</div>

	</div>


	<div class="mb-6 text-lg"
		 style="color: #4d4d8f;font-weight: 800;/* font-size: 17px; */text-decoration: underline;text-align: center;">
		<a href="https://www.melipayamak.com/blog/posts/wordpress-woocommerce-plugins/" class="rtl" target="_blank">جزئیات
			بیشتر اتصال ووکامرس به پیامک</a>
	</div>

	<div class="border-t border-gray-light py-6 sm:px-8 px-6">
		<div class="text-center mb-6">
			<h4 class="text-lg font-bold mb-2 rtl">
				وب‌سایتت رو به پیامک مجهز کن!
			</h4>
			<p class="text-gray-light text-sm rtl">
				با ارسال پیامک از لحظه ثبت‌نام تا لحظه تحویل محصول در کنار مشتری خود باشید.
			</p>
		</div>
		<div class="bg-gray-light-2 rounded-md text-sm1 p-4 mb-6 rtl"
			 style="color: #004085; border-color: #b8daff; background-color: #cce5ff; font-weight:500; font-size:14px;">
			اگر قصد دارید فرآیند ورود و عضویت وب‌سایت خود را با احراز هویت پیامکی انجام دهید، پس از خرید پنل از سامانه
			ملی پیامک به ما از قسمت پشتیبانی یک تیکت ارسال کنید تا در اسرع وقت افزونه‌های ورود با شماره موبایل برای شما
			ارسال گردد.
		</div>
		<div class="text-center mb-5">
			<div class="offer">
				<div class="text rtl">
					20% تخفیف ملی پیامک
				</div>

				<div class="holder-code">
                        <span class="code rtl">
                            PWSMS
                        </span>
					<button class="btn-copy rtl" onclick="copyToClipboard(this, 'PWSMS')">
						کپی کد
					</button>
				</div>
			</div>
		</div>

		<div class="d-flex justify-contet-between" style="display: flex;justify-content: center;flex-wrap: wrap;">
			<div class="text-center  ml-20 mb-2">
				<a href="https://www.melipayamak.com/?utm_source=wordpress-admin&utm_medium=landing&utm_campaign=persian-woocommerce/"
				   class="flex w-full items-center justify-center gap-2 bg-blue text-white rounded-[3px] py-3 sm:px-5 px-3  hover:shadow-xl hover:-translate-y-0.5 a2:hover"
				   target="_blank">
                    <span class="sm:h-7 h-6">
                        <svg class="h-full" viewBox="0 0 21 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
									d="M8.3571 0H12.6428C13.7142 0.0418182 14.8285 0.250909 15.8142 0.669091C17.5285 1.38 18.9857 2.59273 19.9285 4.18182C20.5285 5.22727 20.8714 6.44 20.9571 7.65273V11.6255C20.8714 13.4236 20.4 15.2218 19.4571 16.7691C18.7714 17.9818 17.8285 19.0691 16.7142 19.9473C15.5142 20.9091 14.1428 21.62 12.7285 22.1218C11.7 22.4982 10.6285 22.7909 9.5571 23H9.51424C9.42853 23 9.29996 22.9582 9.29996 22.8327C9.34282 22.7073 9.42853 22.5818 9.51424 22.4982C9.77139 22.2055 10.0714 21.9545 10.3285 21.7036C11.0571 20.9927 11.7 20.1564 12.0428 19.1945C11.2714 19.1945 8.69996 19.1945 8.22853 19.1945C7.07139 19.1109 5.9571 18.86 4.92853 18.3582C3.21424 17.5636 1.7571 16.2255 0.942815 14.5527C0.514244 13.6327 0.257101 12.6709 0.171387 11.6673C0.171387 11.5836 0.171387 7.31818 0.214244 7.06727C0.299958 6.44 0.42853 5.85455 0.685672 5.26909C1.11424 4.14 1.84282 3.13636 2.74282 2.3C3.59996 1.50545 4.62853 0.92 5.69996 0.543636C6.51424 0.209091 7.41424 0.0418182 8.3571 0ZM4.19996 6.35636C4.19996 6.94182 4.19996 7.56909 4.19996 8.15454C8.61424 8.15454 13.0285 8.15454 17.4 8.15454C17.4 7.52727 17.4 6.94182 17.4 6.31455C17.1 6.31455 16.8 6.31455 16.5 6.31455C12.9857 6.31455 9.42853 6.31455 5.91424 6.31455C5.3571 6.35636 4.79996 6.35636 4.19996 6.35636ZM4.19996 10.7891C4.19996 11.4164 4.19996 12.0018 4.19996 12.6291C7.02853 12.6291 9.8571 12.6291 12.6857 12.6291C12.6857 12.0018 12.6857 11.4164 12.6857 10.7891C9.8571 10.7891 7.02853 10.7891 4.19996 10.7891Z"
									fill="white"
							/>
                        </svg>
                    </span>
					<span class="rtl">
                        خرید پنل پیامکی
                    </span>
				</a>

			</div>

			<div class="text-center  mb-2">
				<a href="<?php echo admin_url( 'plugin-install.php?tab=plugin-information&plugin=persian-woocommerce-sms' ); ?>"
				   class="flex w-full items-center justify-center gap-2 bg-gray-button rounded-[3px] py-3 sm:px-5 px-3  hover:shadow-xl hover:-translate-y-0.5 a2:hover"
				   target="_blank">
                    <span class="rtl" style="font-size: 16px;">
                        نصب افزونه پیامک ووکامرس
                    </span>
				</a>
			</div>

		</div>


		<div class="flex gap-2 w-full items-center justify-content-md-center  justify-content-evenly text-sm container-sm rtl">
                    <span>
                        سوالی دارید؟
                    </span>
			<div>
				<a href="tel:+982163404" class="rtl">
					۰۲۱-۶۳۴۰۴
				</a>
				<span class="inline-block bg-gray-light-2 text-gray-light text-xs rounded-[4px] p-1 mr-1 rtl">
                            داخلی ۱
                        </span>
			</div>
		</div>


	</div>


</div>


<script>
    //copyToClipboard
    function copyToClipboard(el, codeValue) {
        if (navigator) {
            navigator.clipboard.writeText(codeValue);
            el.textContent = "کپی شد";
            el.classList.add("active");
        }
    }
</script>

<style>
    /*
	! tailwindcss v3.0.18 | MIT License | https://tailwindcss.com
	*/

    /*
	1. Prevent padding and border from affecting element width. (https://github.com/mozdevs/cssremedy/issues/4)
	2. Allow adding a border to an element by just adding a border-width. (https://github.com/tailwindcss/tailwindcss/pull/116)
	*/

    *,
    ::before,
    ::after {
        box-sizing: border-box;
        /* 1 */
        border-width: 0;
        /* 2 */
        border-style: solid;
        /* 2 */
        border-color: #e5e7eb;
        /* 2 */
    }

    ::before,
    ::after {
        --tw-content: '';
    }

    /*
	1. Use a consistent sensible line-height in all browsers.
	2. Prevent adjustments of font size after orientation changes in iOS.
	3. Use a more readable tab size.
	4. Use the user's configured `sans` font-family by default.
	*/

    html {
        line-height: 1.5;
        /* 1 */
        -webkit-text-size-adjust: 100%;
        /* 2 */
        -moz-tab-size: 4;
        /* 3 */
        -o-tab-size: 4;
        tab-size: 4;
        /* 3 */
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !important;
        /* 4 */
    }

    /*
	1. Remove the margin in all browsers.
	2. Inherit line-height from `html` so users can set them as a class directly on the `html` element.
	*/

    body {
        margin: 0;
        /* 1 */
        line-height: inherit;
        /* 2 */
    }

    /*
	1. Add the correct height in Firefox.
	2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
	3. Ensure horizontal rules are visible by default.
	*/

    hr {
        height: 0;
        /* 1 */
        color: inherit;
        /* 2 */
        border-top-width: 1px;
        /* 3 */
    }

    /*
	Add the correct text decoration in Chrome, Edge, and Safari.
	*/

    abbr:where([title]) {
        -webkit-text-decoration: underline dotted;
        text-decoration: underline dotted;
    }

    /*
	Remove the default font size and weight for headings.
	*/

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-size: inherit;
        font-weight: inherit;
    }

    /*
	Reset links to optimize for opt-in styling instead of opt-out.
	*/

    a {
        color: inherit;
        text-decoration: inherit;
    }

    /*
	Add the correct font weight in Edge and Safari.
	*/

    b,
    strong {
        font-weight: bolder;
    }

    /*
	1. Use the user's configured `mono` font family by default.
	2. Correct the odd `em` font sizing in all browsers.
	*/

    code,
    kbd,
    samp,
    pre {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        /* 1 */
        font-size: 1em;
        /* 2 */
    }

    /*
	Add the correct font size in all browsers.
	*/

    small {
        font-size: 80%;
    }

    /*
	Prevent `sub` and `sup` elements from affecting the line height in all browsers.
	*/

    sub,
    sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline;
    }

    sub {
        bottom: -0.25em;
    }

    sup {
        top: -0.5em;
    }

    /*
	1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
	2. Correct table border color inheritance in all Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
	3. Remove gaps between table borders by default.
	*/

    table {
        text-indent: 0;
        /* 1 */
        border-color: inherit;
        /* 2 */
        border-collapse: collapse;
        /* 3 */
    }

    /*
	1. Change the font styles in all browsers.
	2. Remove the margin in Firefox and Safari.
	3. Remove default padding in all browsers.
	*/

    button,
    input,
    optgroup,
    select,
    textarea {
        font-family: inherit;
        /* 1 */
        font-size: 100%;
        /* 1 */
        line-height: inherit;
        /* 1 */
        color: inherit;
        /* 1 */
        margin: 0;
        /* 2 */
        padding: 0;
        /* 3 */
    }

    /*
	Remove the inheritance of text transform in Edge and Firefox.
	*/

    button,
    select {
        text-transform: none;
    }

    /*
	1. Correct the inability to style clickable types in iOS and Safari.
	2. Remove default button styles.
	*/

    button,
    [type='button'],
    [type='reset'],
    [type='submit'] {
        -webkit-appearance: button;
        /* 1 */
        background-color: transparent;
        /* 2 */
        background-image: none;
        /* 2 */
    }

    /*
	Use the modern Firefox focus style for all focusable elements.
	*/

    :-moz-focusring {
        outline: auto;
    }

    /*
	Remove the additional `:invalid` styles in Firefox. (https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737)
	*/

    :-moz-ui-invalid {
        box-shadow: none;
    }

    /*
	Add the correct vertical alignment in Chrome and Firefox.
	*/

    progress {
        vertical-align: baseline;
    }

    /*
	Correct the cursor style of increment and decrement buttons in Safari.
	*/

    ::-webkit-inner-spin-button,
    ::-webkit-outer-spin-button {
        height: auto;
    }

    /*
	1. Correct the odd appearance in Chrome and Safari.
	2. Correct the outline style in Safari.
	*/

    [type='search'] {
        -webkit-appearance: textfield;
        /* 1 */
        outline-offset: -2px;
        /* 2 */
    }

    /*
	Remove the inner padding in Chrome and Safari on macOS.
	*/

    ::-webkit-search-decoration {
        -webkit-appearance: none;
    }

    /*
	1. Correct the inability to style clickable types in iOS and Safari.
	2. Change font properties to `inherit` in Safari.
	*/

    ::-webkit-file-upload-button {
        -webkit-appearance: button;
        /* 1 */
        font: inherit;
        /* 2 */
    }

    /*
	Add the correct display in Chrome and Safari.
	*/

    summary {
        display: list-item;
    }

    /*
	Removes the default spacing and border for appropriate elements.
	*/

    blockquote,
    dl,
    dd,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    hr,
    figure,
    p,
    pre {
        margin: 0;
    }

    fieldset {
        margin: 0;
        padding: 0;
    }

    legend {
        padding: 0;
    }

    ol,
    ul,
    menu {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    /*
	Prevent resizing textareas horizontally by default.
	*/

    textarea {
        resize: vertical;
    }

    /*
	1. Reset the default placeholder opacity in Firefox. (https://github.com/tailwindlabs/tailwindcss/issues/3300)
	2. Set the default placeholder color to the user's configured gray 400 color.
	*/

    input::-moz-placeholder, textarea::-moz-placeholder {
        opacity: 1;
        /* 1 */
        color: #9ca3af;
        /* 2 */
    }

    input:-ms-input-placeholder, textarea:-ms-input-placeholder {
        opacity: 1;
        /* 1 */
        color: #9ca3af;
        /* 2 */
    }

    input::placeholder,
    textarea::placeholder {
        opacity: 1;
        /* 1 */
        color: #9ca3af;
        /* 2 */
    }

    /*
	Set the default cursor for buttons.
	*/

    button,
    [role="button"] {
        cursor: pointer;
    }

    /*
	Make sure disabled buttons don't get the pointer cursor.
	*/

    :disabled {
        cursor: default;
    }

    /*
	1. Make replaced elements `display: block` by default. (https://github.com/mozdevs/cssremedy/issues/14)
	2. Add `vertical-align: middle` to align replaced elements more sensibly by default. (https://github.com/jensimmons/cssremedy/issues/14#issuecomment-634934210)
	   This can trigger a poorly considered lint error in some tools but is included by design.
	*/

    img,
    svg,
    video,
    canvas,
    audio,
    iframe,
    embed,
    object {
        display: block;
        /* 1 */
        vertical-align: middle;
        /* 2 */
    }

    /*
	Constrain images and videos to the parent width and preserve their intrinsic aspect ratio. (https://github.com/mozdevs/cssremedy/issues/14)
	*/

    img,
    video {
        max-width: 100%;
        height: auto;
    }

    /*
	Ensure the default browser behavior of the `hidden` attribute.
	*/

    [hidden] {
        display: none;
    }

    @font-face {
        font-family: "IRANSans";

        font-weight: 500;

        src: url("./fonts/ttf/IRANSansWeb(FaNum).ttf");

        /* IE9 Compat Modes */
        src: url("./fonts/eot/IRANSansWeb(FaNum).eot") format("embedded-opentype"), url("./fonts/woff2/IRANSansWeb(FaNum).woff2") format("woff2"), url("./fonts/woff/IRANSansWeb(FaNum).woff") format("woff");

        /* Safari, Android, iOS */
    }

    @font-face {
        font-family: "IRANSans";

        font-weight: bold;

        src: url("./fonts/ttf/IRANSansWeb(FaNum)_Bold.ttf");

        /* IE9 Compat Modes */
        src: url("./fonts/eot/IRANSansWeb(FaNum)_Bold.eot") format("embedded-opentype"), url("./fonts/woff2/IRANSansWeb(FaNum)_Bold.woff2") format("woff2"), url("./fonts/woff/IRANSansWeb(FaNum)_Bold.woff") format("woff");

        /* Safari, Android, iOS */
    }

    *, ::before, ::after {
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgb(59 130 246 / 0.5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia: ;
    }

    .top-7 {
        top: 1.75rem;
    }

    .top-20 {
        top: 5rem;
    }

    .bottom-7 {
        bottom: 1.75rem;
    }

    .my-10 {
        margin-top: 2.5rem;
        margin-bottom: 2.5rem;
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .mb-6 {
        margin-bottom: 1.5rem;
    }

    .mb-1 {
        margin-bottom: 0.25rem;
    }

    .mb-5 {
        margin-bottom: 1.25rem;
    }

    .mb-14 {
        margin-bottom: 3.5rem;
    }

    .mb-4 {
        margin-bottom: 1rem;
    }

    .mr-1 {
        margin-right: 0.25rem;
    }

    .mb-3 {
        margin-bottom: 0.75rem;
    }

    .mb-2 {
        margin-bottom: 0.5rem;
    }

    .mb-12 {
        margin-bottom: 3rem;
    }

    .mb-10 {
        margin-bottom: 2.5rem;
    }

    .inline-block {
        display: inline-block;
    }

    .flex {
        display: flex;
    }

    .h-14 {
        height: 3.5rem;
    }

    .h-full {
        height: 100%;
    }

    .h-8 {
        height: 2rem;
    }

    .h-5 {
        height: 1.25rem;
    }

    .h-7 {
        height: 1.75rem;
    }

    .h-6 {
        height: 1.5rem;
    }

    .w-56 {
        width: 14rem;
    }

    .w-full {
        width: 100%;
    }

    .w-6 {
        width: 1.5rem;
    }

    .w-60 {
        width: 15rem;
    }

    .w-64 {
        width: 16rem;
    }

    .flex-col {
        flex-direction: column;
    }

    .items-center {
        align-items: center;
    }

    .justify-center {
        justify-content: center;
    }

    .justify-between {
        justify-content: space-between;
    }

    .gap-5 {
        gap: 1.25rem;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .gap-x-12 {
        -moz-column-gap: 3rem;
        column-gap: 3rem;
    }

    .gap-y-6 {
        row-gap: 1.5rem;
    }

    .rounded-md {
        border-radius: 0.375rem;
    }

    .rounded-\[3px\] {
        border-radius: 3px;
    }

    .rounded-\[4px\] {
        border-radius: 4px;
    }

    .border-t {
        border-top-width: 1px;
    }

    .border-gray-light {
        --tw-border-opacity: 1;
        border-color: rgb(150 153 162 / var(--tw-border-opacity));
    }

    .bg-gray-200 {
        --tw-bg-opacity: 1;
        background-color: rgb(229 231 235 / var(--tw-bg-opacity));
    }

    .bg-gray-light-2 {
        --tw-bg-opacity: 1;
        background-color: rgb(240 240 241 / var(--tw-bg-opacity));
    }

    .bg-blue {
        --tw-bg-opacity: 1;
        background-color: rgb(34 113 177 / var(--tw-bg-opacity));
        border: 1px solid #2271b1;
    }

    .bg-gray-button {
        background: #F6F7F5;
        border: 1px solid #2271b1;
        color: #2271b1;
    }

    .p-4 {
        padding: 1rem;
    }

    .p-1 {
        padding: 0.25rem;
    }

    .py-6 {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .px-5 {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }

    .px-3 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .text-center {
        text-align: center;
    }

    .rtl h1, .rtl h2, .rtl h3, .rtl h4, .rtl h5, .rtl h6 {
        font-family: IRANSans !important;
    }

    .font-iran-sans {
        font-family: IRANSans;
    }

    .text-lg {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .text-sm {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .text-sm1 {
        line-height: 1.55rem;
        text-align: justify;
        font-size: 0.8rem;
    }

    .text-xs {
        font-size: 0.75rem;
        line-height: 1rem;
    }

    .text-xl {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .font-bold {
        font-weight: 700;
    }

    .text-gray-light {
        --tw-text-opacity: 1;
        color: rgb(150 153 162 / var(--tw-text-opacity));
    }

    .text-white {
        --tw-text-opacity: 1;
        color: rgb(255 255 255 / var(--tw-text-opacity));
    }

    a, button {
        cursor: pointer;
        transition-duration: 300ms;
    }

    .main-box {
        margin-left: auto;
        margin-right: auto;
        max-width: 100%;
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        text-align: right;
        --tw-text-opacity: 1;
        color: rgb(80 87 94 / var(--tw-text-opacity));
    }

    @media (min-width: 640px) {
        .main-box {
            width: 575px;
        }
    }

    @media (min-width: 1024px) {
        .main-box {
            width: 700px;
        }
    }

    @media (min-width: 1280px) {
        .main-box {
            width: 800px;
        }
    }

    .main-box {
        direction: rtl;
        border: 1px solid #C3C4C7;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.05);
        border-radius: 5px;
    }

    @media (max-width: 782px) {
        .main-box {
            width: calc(100% - 30px);
        }
    }

    .main-box ul {
        padding-right: 0.75rem;
        list-style-image: url("<?php echo PW()->plugin_url( 'assets/images/check.png' ); ?>");
    }

    .main-box ul li {
        padding-right: 0.25rem;
    }

    .offer {
        position: relative;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        border-radius: 0.25rem;
        --tw-bg-opacity: 1;
        background-color: rgb(255 109 109 / var(--tw-bg-opacity));
        --tw-text-opacity: 1;
        color: rgb(255 255 255 / var(--tw-text-opacity));
    }

    @media (min-width: 782px) {
        .offer {
            flex-direction: row;
        }
    }

    .offer:after {
        position: absolute;
        display: none;
        height: 0.75rem;
        width: 0.75rem;
        border-radius: 9999px;
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    }

    @media (min-width: 782px) {
        .offer:after {
            display: block;
        }
    }

    .offer:after {
        content: " ";
        right: -6px;
        top: calc(50% - 6px);
    }

    .offer::before {
        position: absolute;
        display: none;
        height: 0.75rem;
        width: 0.75rem;
        border-radius: 9999px;
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    }

    @media (min-width: 782px) {
        .offer::before {
            display: block;
        }
    }

    .offer::before {
        content: " ";
        left: -6px;
        top: calc(50% - 6px);
    }

    .offer .text {
        width: 50%;
        min-width: -moz-fit-content;
        min-width: fit-content;
        padding-top: 1rem;
        padding-bottom: 1rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        font-size: 0.96rem;
        line-height: 1.25rem;
    }

    .offer .holder-code {
        position: relative;
        width: 50%;
        min-width: -moz-fit-content;
        min-width: fit-content;
        border-top-width: 1px;
        border-style: dashed;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    @media (min-width: 782px) {
        .offer .holder-code {
            border-right-width: 1px;
        }

        .offer .holder-code {
            border-top-width: 0px;
        }
    }

    .offer .holder-code:after {
        position: absolute;
        height: 0.75rem;
        width: 0.75rem;
        border-radius: 9999px;
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    }

    @media (min-width: 782px) {
        .offer .holder-code:after {
            display: none;
        }
    }

    .offer .holder-code:after {
        content: " ";
        right: -6px;
        top: -6px;
    }

    .offer .holder-code::before {
        position: absolute;
        height: 0.75rem;
        width: 0.75rem;
        border-radius: 9999px;
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    }

    @media (min-width: 782px) {
        .offer .holder-code::before {
            display: none;
        }
    }

    .offer .holder-code::before {
        content: " ";
        left: -6px;
        top: -6px;
    }

    .offer .code {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .offer .btn-copy {
        margin-right: 0.5rem;
        border-radius: 0.25rem;
        --tw-bg-opacity: 1;
        background-color: rgb(214 54 56 / var(--tw-bg-opacity));
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .offer .btn-copy:hover {
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        --tw-text-opacity: 1;
        color: rgb(22 163 74 / var(--tw-text-opacity));
        --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .offer .btn-copy.active {
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        --tw-text-opacity: 1;
        color: rgb(22 163 74 / var(--tw-text-opacity));
    }

    .holder-sms {
        position: relative;
        display: none;
        height: 13rem;
        width: 11rem;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        border-left-width: 8px;
        border-right-width: 8px;
        border-top-width: 8px;
        --tw-border-opacity: 1;
        border-color: rgb(240 240 241 / var(--tw-border-opacity));
    }

    @media (min-width: 782px) {
        .holder-sms {
            display: block;
        }

        .text-sm1 {
            line-height: 1.875rem;
            text-align: justify;
            font-size: 0.875rem;
        }
    }

    .holder-sms .sms {
        position: absolute;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-radius: 0.375rem;
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        padding: 0.75rem;
        text-align: center;
        font-size: 11px;
        box-shadow: 0px 7px 15px rgba(0, 0, 0, 0.14);
    }

    .holder-sms::after {
        position: absolute;
        bottom: 0px;
        --tw-bg-opacity: 1;
        background-color: rgb(240 240 241 / var(--tw-bg-opacity));
        content: "";
        height: 2px;
        width: calc(100% + 50px);
        right: -25px;
    }

    .start-right .sms:nth-child(odd) {
        left: -1.25rem;
    }

    .start-right .sms:nth-child(even) {
        right: -2rem;
    }

    .start-left .sms:nth-child(even) {
        left: -1.25rem;
    }

    .start-left .sms:nth-child(odd) {
        right: -2rem;
    }

    .hover\:-translate-y-0\.5:hover {
        --tw-translate-y: -0.125rem;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }

    .hover\:-translate-y-0:hover {
        --tw-translate-y: -0px;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }

    .hover\:shadow-xl:hover {
        --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    /*
	a2:active,a2:focus,a2:hover {
		color: #ffffff !important;
	}
	*/
    a.flex.w-full.items-center.justify-center.gap-2.bg-blue.text-white.rounded-\[3px\].py-3.sm\:px-5.px-3.hover\:shadow-xl.hover\:-translate-y-0\.5.a2\:hover {
        color: #fff;
    }

    @media (min-width: 640px) {
        .sm\:h-16 {
            height: 4rem;
        }

        .sm\:h-20 {
            height: 5rem;
        }

        .sm\:h-7 {
            height: 24px;
        }

        .sm\:w-64 {
            width: 16rem;
        }

        .sm\:px-8 {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .sm\:px-5 {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        .sm\:text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .sm\:text-base {
            font-size: 1rem;
            line-height: 1.5rem;
        }

        .sm\:text-2xl {
            font-size: 1.375rem;
            line-height: 2rem;
        }

        .sm\:text-lg {
            font-size: 1.025rem;
            line-height: 1.75rem;
        }

    }

    @media (min-width: 782px) {
        .md\:mb-14 {
            margin-bottom: 3.5rem;
        }


    }

    @media (min-width: 1024px) {
        .lg\:mb-10 {
            margin-bottom: 2.5rem;
        }

        .lg\:flex-row {
            flex-direction: row;
        }

        .lg\:pr-8 {
            padding-right: 2rem;
        }

        .lg\:text-right {
            text-align: right;
        }

        .ml-20 {
            margin-left: 20px;
        }
    }

    /*# sourceMappingURL=styles.css.map */
    @media (max-width: 991px) {
        .justify-content-evenly {
            justify-content: space-evenly;
        }
    }

    @media (min-width: 991px) {
        .justify-content-md-center {
            justify-content: center;
        }
    }

    .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto
    }

    @media (min-width: 576px) {
        .container, .container-xs, .container-sm {
            max-width: 540px
        }
    }

    @media (min-width: 768px) {
        .container, .container-xs, .container-sm, .container-md {
            max-width: 720px
        }
    }

    @media (min-width: 992px) {
        .container, .container-xs, .container-sm, .container-md, .container-lg {
            max-width: 960px
        }
    }

    @media (min-width: 1200px) {
        .container-sm {
            max-width: 450px
        }
    }

    @media (min-width: 1400px) {
        .container-sm {
            max-width: 450px
        }
    }

    @media (min-width: 1200px) {
        .container, .container-xs, .container-md, .container-lg, .container-xl {
            max-width: 620px
        }
    }

    @media (min-width: 1400px) {
        .container, .container-xs, .container-md, .container-lg, .container-xl, .container-xxl {
            max-width: 620px
        }
    }
</style>