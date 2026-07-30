<div class="max-w-7xl w-full mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Your Settings</h1>
    </div>

    <div class="grid grid-cols-1 w-full sm:grid-cols-2 gap-4 sm:gap-6">
        <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-4">
            <!-- acc info -->
            <div class="flex items-center gap-2 mb-2">
                <svg class="size-6 text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                </svg>

                <h2 class="text-lg font-medium text-gray-900">Account Information</h2>
            </div>

            <ul class=" space-y-2 ">
                <li class="flex items-center justify-between rounded-md">
                    <div>
                        <div class="font-medium text-gray-900">Email</div>
                        <div class="text-sm text-gray-500"><?= htmlspecialchars($user['email'] ?? 'N/A') ?></div>
                    </div>
                </li>
                <hr class="border-gray-100">
                <li class="flex items-center justify-between rounded-md">
                    <div>
                        <div class="font-medium text-gray-900">Name</div>
                        <div class="text-sm text-gray-500"><?= htmlspecialchars($user['name'] ?? 'N/A') ?></div>
                    </div>
                </li>

            </ul>
        </div>
        <div class="bg-white h-full rounded-lg flex flex-col justify-between border border-gray-100 shadow-sm p-4">
            <!-- security -->
            <div class="flex items-center gap-2 mb-4">
                <svg class="size-6 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <h2 class="text-lg font-medium text-gray-900">Security Settings</h2>
            </div>
            <div class="flex justify-end flex-col gap-2">
                <div class="w-full" x-data="{modalOpen:false}">
                    <button @click="modalOpen = true" class=" px-4 py-2 w-full text-sm box-border font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700  transition">
                        Change Password
                    </button>
                    <div x-show="modalOpen" class="fixed top-0 left-0 z-[40] flex items-center justify-center w-screen text-gray-900 h-screen" x-cloak>
                        <div x-show="modalOpen" x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 w-full h-full backdrop-blur-sm bg-white/70"></div>
                        <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95" class="relative mx-4 px-7 z-10 py-6 w-full bg-white border shadow-lg border-gray-100 sm:max-w-lg rounded-lg">
                            <div class="flex justify-between items-center pb-3">
                                <h3 class="text-lg mr-6 font-semibold">Change your password</h3>
                                <button @click="modalOpen=false" class="flex items-center justify-center w-8 h-8 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative text-gray-700 font-normal pb-8 w-auto">
                                <p>Enter your current password and your new password. </p>
                            </div>
                            <div>
                                <form x-data="{
                                    currentPassword: '',
                                    newPassword: '',
                                    confirmPassword: '',
                    
                                    newBlurred: false,
                                    confirmBlurred: false,
                                    get passwordsDontMatch() {
                                        return this.confirmBlurred &&
                                            this.confirmPassword.length > 0 &&
                                            this.newPassword !== this.confirmPassword;
                                    },
                                    get anyEmpty() {
                                        return this.currentPassword.length === 0 ||
                                            this.newPassword.length === 0 ||
                                            this.confirmPassword.length === 0;
                                    }
                                }" id="changePasswordForm" hx-post="<?= url('/staff/settings/change-password/') ?>" hx-swap="none" hx-vals="js:{ _csrf : '<?= csrf_token() ?>'}" @htmx:after-request="
                                    if ($event.detail.xhr.status === 200) {
                                        modalOpen = false;
                                        currentPassword = '';
                                        newPassword = '';
                                        confirmPassword = '';
                                        newBlurred = false;
                                        confirmBlurred = false;
                                    }
                                ">
                                    <div class="mb-4">
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">
                                            Current Password
                                        </label>
                                        <input x-model="currentPassword" type="password" name="current_password" id="current_password" required class="mt-1 block w-full rounded border border-gray-300 bg-gray-50 px-2 py-2 outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    <div class="mb-4">
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">
                                            New Password
                                        </label>
                                        <input x-model="newPassword" @blur="newBlurred = true" minlength="8" maxlength="100" type="password" name="new_password" id="new_password" maxlength="100" required class="mt-1 block w-full rounded border bg-gray-50 px-2 py-2 outline-none focus:ring-1 sm:text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="mb-4">
                                        <label for="confirm_new_password" class="block text-sm font-medium text-gray-700">
                                            Confirm New Password
                                        </label>
                                        <input x-model="confirmPassword" @blur="confirmBlurred = true" type="password" name="confirm_new_password" id="confirm_new_password" required :class="passwordsDontMatch
                    ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                    : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'" class="mt-1 block w-full rounded border bg-gray-50 px-2 py-2 outline-none focus:ring-1 sm:text-sm">
                                        <p x-show="passwordsDontMatch" x-cloak class="mt-1 text-sm text-red-600">
                                            Passwords do not match.
                                        </p>
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" @click="modalOpen = false" class="inline-flex h-10 items-center justify-center rounded-md border px-4 py-2 text-sm font-medium transition-colors focus:outline-none">
                                            Cancel
                                        </button>
                                        <button type="submit" :disabled="passwordsDontMatch || anyEmpty" :class="(passwordsDontMatch || anyEmpty)
                    ? 'cursor-not-allowed opacity-50'
                    : ''" class="inline-flex h-10 items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-700 focus:outline-none">
                                            Change Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full" x-data="{modalOpen:false}">
                    <button @click="modalOpen = true" class=" px-4 py-2 text-sm w-full font-medium text-white bg-red-600 box-border rounded-md hover:bg-red-700 transition">
                        Delete Account
                    </button>

                    <div x-show="modalOpen" class="fixed top-0 left-0 z-[40] flex items-center justify-center w-screen text-gray-900 h-screen" x-cloak>
                        <div x-show="modalOpen" x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 w-full h-full backdrop-blur-sm bg-white/70"></div>
                        <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95" class="relative mx-4 px-7 z-10 py-6 w-full bg-white border shadow-lg border-gray-100 sm:max-w-lg rounded-lg">
                            <div class="flex justify-between items-center pb-3">
                                <h3 class="text-lg mr-6 font-semibold">Are you sure?</h3>
                                <button @click="modalOpen=false" class="flex items-center justify-center w-8 h-8 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative text-gray-700 font-normal pb-8 w-auto">
                                <p>Are you sure you want to delete your account? <b>This action cannot be undone.</b> <br> <br>Enter your password to confirm.</p>
                            </div>
                            <div>
                                <form x-data="{
                                    currentPassword: '',

                                    get isEmpty() {
                                        return this.currentPassword.length === 0;
                                    },
                                }" id="changePasswordForm" hx-post="<?= url('/staff/settings/delete-account/') ?>" hx-swap="none" hx-vals="js:{ _csrf : '<?= csrf_token() ?>'}" @htmx:after-request="
                                    if ($event.detail.xhr.status === 204) {
                                        modalOpen = false;
                                        currentPassword = '';
                                    }
                                ">
                                    <div class="mb-4">
                                        <label for="password" class="block text-sm font-medium text-gray-700">
                                            Current Password
                                        </label>
                                        <input x-model="currentPassword" type="password" name="password" id="password" required class="mt-1 block w-full rounded border border-gray-300 bg-gray-50 px-2 py-2 outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                    </div>


                                    <div class="flex justify-end space-x-2">
                                        <button type="button" @click="modalOpen = false" class="inline-flex h-10 items-center justify-center rounded-md border px-4 py-2 text-sm font-medium transition-colors focus:outline-none">
                                            Cancel
                                        </button>
                                        <button type="submit" :disabled="isEmpty" :class="isEmpty
                    ? 'cursor-not-allowed opacity-50'
                    : ''" class="inline-flex h-10 items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700 focus:outline-none">
                                            Delete Account
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>