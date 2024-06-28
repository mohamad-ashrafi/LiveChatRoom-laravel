<div class="w-full h-svh grid relative p-4 dark:bg-neutral-950">
    <section class="flex flex-col items-center justify-center gap-8">
        <header class="flex flex-col items-center justify-start gap-2 relative">
            <h1 class="font-bold text-secondary-600 dark:text-secondary-300 text-lg z-10">
                به چت روم آنلاین تکومیکس خوش آمدید
            </h1>
            <p class="text-sm text-secondary-600 dark:text-secondary-400">
                اگر قبلا عضو شدید با نام کاربری وارد شوید در غیر اینصورت عضو شوید
            </p>

            @if ($customErrorMessage)
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    {{ $customErrorMessage }}
                </div>
            @endif
        </header>

        <main class="w-full max-w-xl flex gap-8">
            <section class="flex flex-col w-1/2 gap-6">
                <header class="flex flex-col items-center justify-start gap-2 relative">
                    <h3 class="font-bold text-secondary-600 dark:text-secondary-300 text-lg z-10 text-sm">
                        ورود
                    </h3>
                </header>
                <form wire:submit.prevent="submitLogin" class="flex flex-col gap-4 w-full">
                    <div class="flex flex-col gap-2 w-full">
                        <div class="w-full flex items-center justify-between">
                            <label for="login_user_name" class="w-full text-secondary-700 dark:text-secondary-300">
                                نام کاربری
                                <span class="text-rose-500">*</span>
                            </label>
                        </div>
                        <input
                            wire:model="login_user_name"
                            id="login_user_name"
                            type="text"
                            placeholder="نام کاربری شما جهت نمایش"
                            class="w-full rounded px-4 py-2 outline-none ring-1 ring-secondary-100 focus:ring-primary-500
                        transition-all duration-500 dark:bg-secondary-900 dark:ring-secondary-800
                        dark:placeholder:text-secondary-500 dark:text-secondary-300"
                        >
                        @error('login_user_name')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="w-full flex items-center justify-between">
                            <label for="login_password" class="w-full text-secondary-700 dark:text-secondary-300">
                                کلمه عبور
                                <span class="text-rose-500">*</span>
                            </label>
                        </div>
                        <input
                            wire:model="login_password"
                            id="login_password"
                            type="password"
                            placeholder="رمز عبور خود را وارد کنید"
                            class="w-full rounded px-4 py-2 outline-none ring-1 ring-secondary-100 focus:ring-primary-500
                        transition-all duration-500 dark:bg-secondary-900 dark:ring-secondary-800
                        dark:placeholder:text-secondary-500 dark:text-secondary-300"
                        >
                        @error('login_password')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="bg-primary-600 w-full px-4 py-2 rounded-md text-white
                            hover:bg-primary-500 transition-all duration-500 dark:bg-primary-700 dark:hover:bg-primary-600">
                            ورود
                        </button>
                    </div>
                </form>
            </section>
            <section class="flex flex-col w-1/2 gap-6">
                <header class="flex flex-col items-center justify-start gap-2 relative">
                    <h3 class="font-bold text-secondary-600 dark:text-secondary-300 text-lg z-10 text-sm">
                        عضویت
                    </h3>
                </header>

                <form wire:submit.prevent="submitRegister" class="flex flex-col gap-4 w-full">
                    <div class="flex flex-col gap-2 w-full">
                        <div class="w-full flex items-center justify-between">
                            <label for="register_user_name" class="w-full text-secondary-700 dark:text-secondary-300">
                                نام کاربری
                                <span class="text-rose-500">*</span>
                            </label>
                        </div>
                        <input
                            wire:model="register_user_name"
                            id="register_user_name"
                            type="text"
                            placeholder="نام کاربری شما جهت نمایش"
                            class="w-full rounded px-4 py-2 outline-none ring-1 ring-secondary-100 focus:ring-primary-500
                        transition-all duration-500 dark:bg-secondary-900 dark:ring-secondary-800
                        dark:placeholder:text-secondary-500 dark:text-secondary-300"
                        >
                        @error('register_user_name')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="w-full flex items-center justify-between">
                            <label for="email" class="w-full text-secondary-700 dark:text-secondary-300">
                                ایمیل
                                <span class="text-rose-500">*</span>
                            </label>
                        </div>
                        <input
                            wire:model="email"
                            id="email"
                            type="email"
                            placeholder="test@gmail.com"
                            class="w-full rounded px-4 py-2 outline-none ring-1 ring-secondary-100 focus:ring-primary-500
                        transition-all duration-500 dark:bg-secondary-900 dark:ring-secondary-800
                        dark:placeholder:text-secondary-500 dark:text-secondary-300"
                        >
                        @error('email')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2 w-full">
                        <div class="w-full flex items-center justify-between">
                            <label for="register_password" class="w-full text-secondary-700 dark:text-secondary-300">
                                کلمه عبور
                                <span class="text-rose-500">*</span>
                            </label>
                        </div>
                        <input
                            wire:model="register_password"
                            id="register_password"
                            type="password"
                            placeholder="رمز عبور خود را وارد کنید"
                            class="w-full rounded px-4 py-2 outline-none ring-1 ring-secondary-100 focus:ring-primary-500
                        transition-all duration-500 dark:bg-secondary-900 dark:ring-secondary-800
                        dark:placeholder:text-secondary-500 dark:text-secondary-300"
                        >
                        @error('register_password')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2 w-full">
                        <div class="w-full flex items-center justify-between">
                            <label for="avatar" class="w-full text-secondary-700 dark:text-secondary-300">
                                آواتار
                            </label>
                        </div>
                        <input
                            wire:model="avatar"
                            id="avatar"
                            type="file"
                            class="w-full rounded px-4 py-2 outline-none ring-1 ring-secondary-100 focus:ring-primary-500
                        transition-all duration-500 dark:bg-secondary-900 dark:ring-secondary-800
                        dark:placeholder:text-secondary-500 dark:text-secondary-300"
                        >
                        @error('avatar')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="bg-primary-600 w-full px-4 py-2 rounded-md text-white
                    hover:bg-primary-500 transition-all duration-500 dark:bg-primary-700 dark:hover:bg-primary-600">
                            عضویت
                        </button>
                    </div>
                </form>
            </section>
        </main>

        <footer class="mt-10">
            <p class="text-sm text-secondary-500 dark:text-secondary-400">
                Created By Ashrafi
            </p>
        </footer>
    </section>
</div>
