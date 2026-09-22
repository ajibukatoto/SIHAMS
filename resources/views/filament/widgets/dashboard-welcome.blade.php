<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900"
>
    <div class="relative px-6 py-7 sm:px-8">
        <div class="relative z-10">
            <p class="text-sm font-medium text-primary-600 dark:text-primary-400">
                Smart ICT Helpdesk and Management System
            </p>

            <h1 class="mt-2 text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                Welcome back, {{ auth()->user()?->name ?? 'User' }} 👋
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">
                Monitor ICT support services, help desk tickets, assets,
                users and system activity from one central dashboard.
            </p>

            <div class="mt-5 flex flex-wrap gap-3">
                <div
                    class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300"
                >
                    ICT Management
                </div>

                <div
                    class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300"
                >
                    Help Desk
                </div>

                <div
                    class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300"
                >
                    Asset Management
                </div>
            </div>
        </div>

        <div
            class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-primary-500/10"
        ></div>

        <div
            class="pointer-events-none absolute -bottom-20 right-24 h-40 w-40 rounded-full bg-primary-500/5"
        ></div>
    </div>
</div>
