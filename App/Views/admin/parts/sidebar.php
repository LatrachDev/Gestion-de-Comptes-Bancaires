<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0">
    <div class="flex flex-col h-full px-4 py-8 bg-white border-r border-gray-200">
        <div class="flex items-center mb-8">
            <img src="/assets/images/logo.png" alt="Logo" class="w-full mr-3">
        </div>

        <nav class="flex-1 space-y-2">
            <a href="/admin" class="flex items-center px-4 py-3 text-gray-700 bg-gray-100 rounded-lg">
                <i class="fas fa-home w-5 h-5 text-gray-500"></i>
                <span class="ml-3 text-sm font-medium">Dashboard</span>
            </a>

            <div class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Clients</p>
                <a href="/admin/clients" class="flex items-center px-4 py-3 mt-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-users w-5 h-5 text-gray-500"></i>
                    <span class="ml-3 text-sm font-medium">All Clients</span>
                </a>
                <a href="/admin/clients/create" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-user-plus w-5 h-5 text-gray-500"></i>
                    <span class="ml-3 text-sm font-medium">Add New Client</span>
                </a>
            </div>

            <div class="pt-4">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Reports</p>
                <a href="/admin/reports" class="flex items-center px-4 py-3 mt-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-chart-bar w-5 h-5 text-gray-500"></i>
                    <span class="ml-3 text-sm font-medium">Financial Reports</span>
                </a>
            </div>
        </nav>

        <div class="pt-4 border-t border-gray-200">
            <a href="/logout" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fas fa-sign-out-alt w-5 h-5 text-gray-500"></i>
                <span class="ml-3 text-sm font-medium">Logout</span>
            </a>
        </div>
    </div>
</aside>
