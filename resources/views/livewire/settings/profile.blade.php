<div class="container mx-auto px-4 py-8">
    <div x-data="{ open: false, activeSection: 'basic' }" class="lg:flex lg:space-x-8">
        <!-- Sidebar -->
        <div class="lg:w-1/4">
            <!-- Mobile Sidebar Toggle -->
            <div class="lg:hidden mb-4">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-lg font-semibold text-left text-gray-800 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-white">
                    <span>Profile Menu</span>
                    <i :class="{'ri-arrow-down-s-line': !open, 'ri-arrow-up-s-line': open}" class="ml-2"></i>
                </button>
            </div>
            
            <!-- Sidebar Menu -->
            <nav :class="{'block': open, 'hidden': !open}" class="lg:block bg-white rounded-lg shadow p-4 dark:bg-gray-800">
                <ul class="space-y-2">
                    <li>
                        <a href="#" @click.prevent="activeSection = 'basic'" :class="{'bg-primary text-white': activeSection === 'basic', 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700': activeSection !== 'basic'}" class="flex items-center px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="ri-user-line mr-3"></i>
                            Basic Information
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="activeSection = 'bank'" :class="{'bg-primary text-white': activeSection === 'bank', 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700': activeSection !== 'bank'}" class="flex items-center px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="ri-bank-line mr-3"></i>
                            Bank Accounts
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="activeSection = 'verification'" :class="{'bg-primary text-white': activeSection === 'verification', 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700': activeSection !== 'verification'}" class="flex items-center px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="ri-shield-check-line mr-3"></i>
                            Verifications
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="activeSection = 'interests'" :class="{'bg-primary text-white': activeSection === 'interests', 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700': activeSection !== 'interests'}" class="flex items-center px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="ri-heart-line mr-3"></i>
                            Interests
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="activeSection = 'skills'" :class="{'bg-primary text-white': activeSection === 'skills', 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700': activeSection !== 'skills'}" class="flex items-center px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="ri-tools-line mr-3"></i>
                            Skills
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="activeSection = 'password'" :class="{'bg-primary text-white': activeSection === 'password', 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700': activeSection !== 'password'}" class="flex items-center px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="ri-lock-password-line mr-3"></i>
                            Update Password
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="activeSection = 'delete'" :class="{'bg-primary text-white': activeSection === 'delete', 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700': activeSection !== 'delete'}" class="flex items-center px-4 py-2 rounded-lg text-sm font-medium">
                            <i class="ri-delete-bin-line mr-3"></i>
                            Delete Account
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="lg:w-3/4 mt-8 lg:mt-0">
            <div x-show="activeSection === 'basic'">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Basic Information</h2>
                @livewire('settings.basic-information')
            </div>
            <div x-show="activeSection === 'bank'" style="display: none;">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Bank Accounts</h2>
                @livewire('settings.bank-accounts')
            </div>
            <div x-show="activeSection === 'verification'" style="display: none;">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Verifications</h2>
                @livewire('settings.verifications')
            </div>
            <div x-show="activeSection === 'interests'" style="display: none;">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Interests</h2>
                @livewire('settings.interests')
            </div>
            <div x-show="activeSection === 'skills'" style="display: none;">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Skills</h2>
                @livewire('settings.skills')
            </div>
            <div x-show="activeSection === 'password'" style="display: none;">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Update Password</h2>
                @livewire('settings.update-password')
            </div>
            <div x-show="activeSection === 'delete'" style="display: none;">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Delete Account</h2>
                @livewire('settings.delete-account')
            </div>
        </div>
    </div>
</div>