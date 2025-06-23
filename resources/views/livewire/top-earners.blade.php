<main class="container mx-auto px-4 py-8">
    <div class="relative rounded-lg overflow-hidden mb-8">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80"
                alt="Team collaboration"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-primary/80 to-primary/60"></div>
        </div>
        <div class="relative px-6 py-12 md:py-16 md:px-12">
            <h1 class="text-3xl md:text-4xl font-bold text-white">Top Earners</h1>
            <p class="text-white/90 mt-2 max-w-2xl">Meet our most successful members who are crushing it on the platform</p>
        </div>
    </div>

    <!-- Filter and Sort Options -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ri-search-line text-gray-400"></i>
                    </div>
                    <input type="text" placeholder="Search earners..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-button w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                </div>

                <select class="border border-gray-300 rounded-button py-2 px-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary bg-white w-full md:w-auto">
                    <option value="">All Platforms</option>
                    <option value="design">Design</option>
                    <option value="writing">Writing</option>
                    <option value="programming">Programming</option>
                    <option value="data-entry">Data Entry</option>
                </select>
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <span class="text-gray-600 whitespace-nowrap">Sort by:</span>
                <select class="border border-gray-300 rounded-button py-2 px-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary bg-white w-full">
                    <option value="earnings">Total Earnings</option>
                    <option value="tasks">Tasks Completed</option>
                    <option value="ratings">Highest Rated</option>
                    <option value="newest">Recently Joined</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Top Earners List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Earner Card 1 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah Johnson" class="w-16 h-16 rounded-full object-cover">
                    <div class="flex-1">
                        <a href="#" class="text-xl font-semibold text-gray-800 hover:text-primary">Sarah Johnson</a>
                        <div class="flex items-center text-gray-500 mt-1">
                            <i class="ri-map-pin-line mr-1"></i>
                            <span>New York, USA</span>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex text-yellow-400">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-half-fill"></i>
                            </div>
                            <span class="ml-2 text-gray-600 text-sm">(127 reviews)</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 mt-4 pt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-gray-500 text-sm">Total Earnings</div>
                            <div class="font-semibold text-primary">$9,745.00</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Tasks Completed</div>
                            <div class="font-semibold">231</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Member Since</div>
                            <div class="font-semibold">Mar 2022</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Completion Rate</div>
                            <div class="font-semibold text-green-600">98%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earner Card 2 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="David Chen" class="w-16 h-16 rounded-full object-cover">
                    <div class="flex-1">
                        <a href="#" class="text-xl font-semibold text-gray-800 hover:text-primary">David Chen</a>
                        <div class="flex items-center text-gray-500 mt-1">
                            <i class="ri-map-pin-line mr-1"></i>
                            <span>Toronto, Canada</span>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex text-yellow-400">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                            </div>
                            <span class="ml-2 text-gray-600 text-sm">(203 reviews)</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 mt-4 pt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-gray-500 text-sm">Total Earnings</div>
                            <div class="font-semibold text-primary">$8,940.50</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Tasks Completed</div>
                            <div class="font-semibold">189</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Member Since</div>
                            <div class="font-semibold">Jan 2021</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Completion Rate</div>
                            <div class="font-semibold text-green-600">99%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earner Card 3 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Maria Garcia" class="w-16 h-16 rounded-full object-cover">
                    <div class="flex-1">
                        <a href="#" class="text-xl font-semibold text-gray-800 hover:text-primary">Maria Garcia</a>
                        <div class="flex items-center text-gray-500 mt-1">
                            <i class="ri-map-pin-line mr-1"></i>
                            <span>Barcelona, Spain</span>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex text-yellow-400">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-line"></i>
                            </div>
                            <span class="ml-2 text-gray-600 text-sm">(156 reviews)</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 mt-4 pt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-gray-500 text-sm">Total Earnings</div>
                            <div class="font-semibold text-primary">$7,880.25</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Tasks Completed</div>
                            <div class="font-semibold">172</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Member Since</div>
                            <div class="font-semibold">May 2022</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Completion Rate</div>
                            <div class="font-semibold text-green-600">96%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earner Card 4 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="James Wilson" class="w-16 h-16 rounded-full object-cover">
                    <div class="flex-1">
                        <a href="#" class="text-xl font-semibold text-gray-800 hover:text-primary">James Wilson</a>
                        <div class="flex items-center text-gray-500 mt-1">
                            <i class="ri-map-pin-line mr-1"></i>
                            <span>London, UK</span>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex text-yellow-400">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-half-fill"></i>
                            </div>
                            <span class="ml-2 text-gray-600 text-sm">(142 reviews)</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 mt-4 pt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-gray-500 text-sm">Total Earnings</div>
                            <div class="font-semibold text-primary">$7,120.75</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Tasks Completed</div>
                            <div class="font-semibold">165</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Member Since</div>
                            <div class="font-semibold">Feb 2022</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Completion Rate</div>
                            <div class="font-semibold text-green-600">97%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earner Card 5 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="Olivia Brown" class="w-16 h-16 rounded-full object-cover">
                    <div class="flex-1">
                        <a href="#" class="text-xl font-semibold text-gray-800 hover:text-primary">Olivia Brown</a>
                        <div class="flex items-center text-gray-500 mt-1">
                            <i class="ri-map-pin-line mr-1"></i>
                            <span>Sydney, Australia</span>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex text-yellow-400">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-line"></i>
                            </div>
                            <span class="ml-2 text-gray-600 text-sm">(112 reviews)</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 mt-4 pt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-gray-500 text-sm">Total Earnings</div>
                            <div class="font-semibold text-primary">$6,950.30</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Tasks Completed</div>
                            <div class="font-semibold">148</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Member Since</div>
                            <div class="font-semibold">Jul 2022</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Completion Rate</div>
                            <div class="font-semibold text-green-600">95%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earner Card 6 -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <img src="https://randomuser.me/api/portraits/men/74.jpg" alt="Ahmed Khan" class="w-16 h-16 rounded-full object-cover">
                    <div class="flex-1">
                        <a href="#" class="text-xl font-semibold text-gray-800 hover:text-primary">Ahmed Khan</a>
                        <div class="flex items-center text-gray-500 mt-1">
                            <i class="ri-map-pin-line mr-1"></i>
                            <span>Dubai, UAE</span>
                        </div>

                        <div class="flex items-center mt-3">
                            <div class="flex text-yellow-400">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-half-fill"></i>
                                <i class="ri-star-line"></i>
                            </div>
                            <span class="ml-2 text-gray-600 text-sm">(98 reviews)</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 mt-4 pt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-gray-500 text-sm">Total Earnings</div>
                            <div class="font-semibold text-primary">$6,485.90</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Tasks Completed</div>
                            <div class="font-semibold">136</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Member Since</div>
                            <div class="font-semibold">Apr 2022</div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">Completion Rate</div>
                            <div class="font-semibold text-green-600">94%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        <nav class="inline-flex rounded-md shadow">
            <a href="#" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                <i class="ri-arrow-left-s-line"></i>
            </a>
            <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-primary text-white">1</a>
            <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">2</a>
            <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">3</a>
            <span class="px-3 py-2 border-t border-b border-gray-300 bg-white text-gray-500">...</span>
            <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">8</a>
            <a href="#" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                <i class="ri-arrow-right-s-line"></i>
            </a>
        </nav>
    </div>
</main>