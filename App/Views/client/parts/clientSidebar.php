<?php 
    $currentRoute = $_SERVER['REQUEST_URI']; 
?>

<div class="w-64 bg-white shadow-lg hidden md:block" id="sidebar">
    <div class="p-6">
        <h1 class="text-2xl font-bold text-blue-600">My Bank</h1>
    </div>
    <nav class="mt-6">
        <a href="/" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i class="fas fa-home w-5 h-5"></i>
            <span>Dashboard</span>
        </a>
        <a href="compte" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/compte' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i class="fas fa-credit-card w-5 h-5"></i>
            <span>My Accounts</span>
        </a>
        <a href="transfer" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/transfer' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i class="fas fa-exchange-alt w-5 h-5"></i>
            <span>Transfers</span>
        </a>
        <a href="benefit" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/benefit' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i class="fas fa-users w-5 h-5"></i>
            <span>Beneficiaries</span>
        </a>
        <a href="history" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/history' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i class="fas fa-history w-5 h-5"></i>
            <span>History</span>
        </a>
        <a href="profile" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/profile' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i class="fas fa-user w-5 h-5"></i>
            <span>Profile</span>
        </a>

        <a href="/logout" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
            <i class="fas fa-sign-out-alt w-5 h-5 text-gray-500"></i>
            <span class="ml-3 text-sm font-medium">Logout</span>
        </a>
    </nav>
</div>