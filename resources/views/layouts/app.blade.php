<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Peternakan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Smooth transitions */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Active menu item indicator */
        .menu-item-active {
            background: linear-gradient(90deg, rgba(34, 197, 94, 0.1) 0%, transparent 100%);
            border-left: 3px solid #22c55e;
        }

        /* Hover effects */
        .menu-item:hover {
            background: rgba(34, 197, 94, 0.05);
            transform: translateX(4px);
        }

        /* Backdrop blur for mobile menu */
        .backdrop-blur-custom {
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-40 border-b border-gray-200">
        <div class="px-4 lg:px-6 py-3">
            <div class="flex items-center justify-between">
                <!-- Left Section: Logo & Menu Toggle -->
                <div class="flex items-center space-x-4">
                    <!-- Mobile Menu Toggle -->
                    <button id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 rounded-lg p-2 transition-all">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-br from-green-600 to-green-700 p-2 rounded-xl shadow-lg">
                            <i class="fas fa-cow text-white text-xl"></i>
                        </div>
                        <div class="hidden md:block">
                            <h1 class="text-xl font-bold text-gray-800">Sistem Peternakan</h1>
                            <p class="text-xs text-gray-500">Manajemen Modern</p>
                        </div>
                    </div>
                </div>

                <!-- Right Section: Search, Notifications, Profile -->
                <div class="flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar (Desktop) -->
                    <div class="hidden md:flex items-center bg-gray-100 rounded-lg px-4 py-2 w-64 lg:w-80 transition-all focus-within:ring-2 focus-within:ring-green-500">
                        <i class="fas fa-search text-gray-400 mr-2"></i>
                        <input type="text" placeholder="Cari data..." class="bg-transparent outline-none w-full text-sm text-gray-700 placeholder-gray-400">
                    </div>

                    <!-- Notifications -->
                    <div class="relative">
                        <button class="relative p-2 text-gray-600 hover:text-green-600 hover:bg-gray-100 rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-green-500">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                        </button>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-all focus:outline-none focus:ring-2 focus:ring-green-500">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-semibold text-sm shadow">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-800">Admin</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400 hidden md:block"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="py-2">
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-user-circle mr-3 text-gray-400"></i>
                                    Profil Saya
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-cog mr-3 text-gray-400"></i>
                                    Pengaturan
                                </a>
                                <hr class="my-2">
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    Keluar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-white shadow-xl z-50 sidebar-transition transform -translate-x-full lg:translate-x-0 lg:top-[73px] lg:h-[calc(100vh-73px)] custom-scrollbar overflow-y-auto">
        <!-- Close Button (Mobile) -->
        <div class="lg:hidden flex items-center justify-between p-4 border-b border-gray-200">
            <span class="font-semibold text-gray-800">Menu</span>
            <button id="sidebarClose" class="text-gray-600 hover:text-red-600 focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <nav class="p-4 space-y-2">
            <!-- Dashboard -->
            <a href="#" class="menu-item menu-item-active flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-home text-green-600 w-5"></i>
                <span class="font-medium text-gray-800">Dashboard</span>
            </a>

            <!-- Manajemen Section -->
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen</p>
            </div>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-cow text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Data Ternak</span>
            </a>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-clipboard-list text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Kesehatan Ternak</span>
            </a>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-syringe text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Vaksinasi</span>
            </a>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-box text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Inventaris</span>
            </a>

            <!-- Keuangan Section -->
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Keuangan</p>
            </div>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-dollar-sign text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Pemasukan</span>
            </a>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-money-bill-wave text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Pengeluaran</span>
            </a>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-chart-line text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Laporan Keuangan</span>
            </a>

            <!-- Laporan Section -->
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Laporan</p>
            </div>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-file-alt text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Laporan Bulanan</span>
            </a>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-chart-bar text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Statistik</span>
            </a>

            <!-- Pengaturan Section -->
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sistem</p>
            </div>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-users text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Manajemen User</span>
            </a>

            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg sidebar-transition">
                <i class="fas fa-cog text-gray-600 w-5"></i>
                <span class="font-medium text-gray-700">Pengaturan</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-200 mt-4">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <div class="flex items-start space-x-3">
                    <div class="bg-green-600 rounded-lg p-2">
                        <i class="fas fa-lightbulb text-white"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Butuh Bantuan?</p>
                        <p class="text-xs text-gray-600 mt-1">Hubungi tim support kami</p>
                        <button class="mt-2 text-xs font-semibold text-green-600 hover:text-green-700">
                            Hubungi Sekarang →
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden backdrop-blur-custom"></div>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-[73px] min-h-screen flex flex-col flex-1">
        <div class="p-4 lg:p-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-r-lg shadow-sm flex items-center space-x-3 animate-fade-in">
                    <div class="bg-green-500 rounded-full p-2">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-green-500 hover:text-green-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-r-lg shadow-sm flex items-center space-x-3 animate-fade-in">
                    <div class="bg-red-500 rounded-full p-2">
                        <i class="fas fa-exclamation text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">Gagal!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="border-t border-gray-200 bg-white">
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <p class="text-sm text-gray-600">
                        © 2024 <span class="font-semibold text-gray-800">Sistem Peternakan</span>. All rights reserved.
                    </p>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <a href="#" class="hover:text-green-600 transition-colors">Tentang</a>
                        <a href="#" class="hover:text-green-600 transition-colors">Bantuan</a>
                        <a href="#" class="hover:text-green-600 transition-colors">Kontak</a>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <script>
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        sidebarToggle?.addEventListener('click', openSidebar);
        sidebarClose?.addEventListener('click', closeSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });

        // Active menu item highlight (you can customize this based on current route)
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.menu-item');
            
            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('menu-item-active');
                }
            });
        });
    </script>
</body>
</html>