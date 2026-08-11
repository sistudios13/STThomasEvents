<div class="space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">Your Settings</h1>
        <p class="max-w-2xl text-sm text-gray-500">Manage your profile details and security preferences in one place.</p>
    </div>

    <div class="grid w-full grid-cols-1 gap-6 lg:grid-cols-2">
        <section class="rounded-lg border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Account Information</h2>
                    <p class="text-sm text-gray-500">Your profile details.</p>
                </div>
            </div>

            <div class="mt-5 space-y-3">
                <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="mt-1 text-base font-medium text-gray-900"><?= htmlspecialchars($user['email'] ?? 'N/A') ?></p>
                </div>
                <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                    <p class="text-sm font-medium text-gray-500">Name</p>
                    <p class="mt-1 text-base font-medium text-gray-900"><?= htmlspecialchars($user['name'] ?? 'N/A') ?></p>
                </div>
            </div>
        </section>

        <section class="flex h-full flex-col rounded-lg border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Security Settings</h2>
                    <p class="text-sm text-gray-500">Update your password or remove your account when needed.</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end flex-1 flex-col gap-3">
                <div class="w-full" x-data="{modalOpen:false}">
                    <button @click="modalOpen = true" class="w-full rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                        Change Password
                    </button>
                    <div x-show="modalOpen" class="fixed inset-0 z-[40] flex h-screen w-screen items-center justify-center text-gray-900" x-cloak>
                        <div x-show="modalOpen" x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 h-full w-full bg-white/70 backdrop-blur-sm"></div>
                        <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95" class="relative z-10 mx-4 w-full rounded-lg border border-gray-100 bg-white px-7 py-6 shadow-lg sm:max-w-lg">
                            <div class="flex items-center justify-between pb-3">
                                <h3 class="mr-6 text-lg font-semibold">Change your password</h3>
                                <button @click="modalOpen=false" class="flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="w-auto pb-8 font-normal text-gray-700">
                                <p>Enter your current password and your new password.</p>
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
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                        <input x-model="currentPassword" type="password" name="current_password" id="current_password" required class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                    </div>
                                    <div class="mb-4">
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                        <input x-model="newPassword" @blur="newBlurred = true" minlength="8" maxlength="100" type="password" name="new_password" id="new_password" required class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                    </div>
                                    <div class="mb-4">
                                        <label for="confirm_new_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                        <input x-model="confirmPassword" @blur="confirmBlurred = true" type="password" name="confirm_new_password" id="confirm_new_password" required :class="passwordsDontMatch ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'" class="mt-1 block w-full rounded-md border bg-gray-50 px-3 py-2 text-sm outline-none focus:ring-1">
                                        <p x-show="passwordsDontMatch" x-cloak class="mt-1 text-sm text-red-600">Passwords do not match.</p>
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" @click="modalOpen = false" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none">
                                            Cancel
                                        </button>
                                        <button type="submit" :disabled="passwordsDontMatch || anyEmpty" :class="(passwordsDontMatch || anyEmpty) ? 'cursor-not-allowed opacity-50' : ''" class="inline-flex h-10 items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none">
                                            Change Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full" x-data="{modalOpen:false}">
                    <button @click="modalOpen = true" class="w-full rounded-md bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                        Delete Account
                    </button>

                    <div x-show="modalOpen" class="fixed inset-0 z-[40] flex h-screen w-screen items-center justify-center text-gray-900" x-cloak>
                        <div x-show="modalOpen" x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 h-full w-full bg-white/70 backdrop-blur-sm"></div>
                        <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95" class="relative z-10 mx-4 w-full rounded-lg border border-gray-100 bg-white px-7 py-6 shadow-lg sm:max-w-lg">
                            <div class="flex items-center justify-between pb-3">
                                <h3 class="mr-6 text-lg font-semibold">Are you sure?</h3>
                                <button @click="modalOpen=false" class="flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="w-auto pb-8 font-normal text-gray-700">
                                <p>Are you sure you want to delete your account? <b>This action cannot be undone.</b><br><br>Enter your password to confirm.</p>
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
                                        <label for="password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                        <input x-model="currentPassword" type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <button type="button" @click="modalOpen = false" class="inline-flex h-10 items-center justify-center rounded-md border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none">
                                            Cancel
                                        </button>
                                        <button type="submit" :disabled="isEmpty" :class="isEmpty ? 'cursor-not-allowed opacity-50' : ''" class="inline-flex h-10 items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700 focus:outline-none">
                                            Delete Account
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>