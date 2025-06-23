<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review & Payment - Post a Job</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
    </style>
    <script>
        tailwind.config={
            theme:{
                extend:{
                    colors:{
                        primary:'#2563eb',
                        secondary:'#4b5563'
                    },
                    borderRadius:{
                        'none':'0px',
                        'sm':'4px',
                        DEFAULT:'8px',
                        'md':'12px',
                        'lg':'16px',
                        'xl':'20px',
                        '2xl':'24px',
                        '3xl':'32px',
                        'full':'9999px',
                        'button':'8px'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-blue-800 text-white py-2 px-4">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <a href="#" class="text-2xl font-['Pacifico'] text-white">logo</a>
                <nav class="hidden md:flex ml-10">
                    <a href="#" class="px-4 py-2 hover:bg-blue-700 rounded-button">Home</a>
                    <a href="#" class="px-4 py-2 hover:bg-blue-700 rounded-button">Jobs</a>
                    <a href="#" class="px-4 py-2 hover:bg-blue-700 rounded-button">Hire</a>
                    <a href="#" class="px-4 py-2 bg-blue-700 rounded-button whitespace-nowrap">Post Job</a>
                </nav>
            </div>
            <div class="flex items-center">
                <button class="w-10 h-10 flex items-center justify-center text-white">
                    <i class="ri-notification-3-line ri-lg"></i>
                </button>
                <div class="w-8 h-8 rounded-full bg-white text-blue-800 flex items-center justify-center ml-2">
                    <span class="font-semibold">JP</span>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6 max-w-4xl">
        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Review & Payment</h1>
            <div class="flex items-center mt-2">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-primary h-2.5 rounded-full" style="width: 100%"></div>
                </div>
                <span class="ml-3 text-sm text-gray-600">Step 2 of 2</span>
            </div>
        </div>

        <!-- Job Summary Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Job Summary</h2>
                <button class="text-primary hover:text-blue-700 text-sm flex items-center">
                    <i class="ri-edit-line ri-lg mr-1"></i> Edit
                </button>
            </div>
            
            <div class="space-y-5">
                <!-- Basic Information -->
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Basic Information</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Job Title</p>
                            <p class="font-medium">Full Stack Developer for SaaS</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Platform</p>
                            <p class="font-medium">Web Development</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Job Type</p>
                            <p class="font-medium">Full-time</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Expected Duration</p>
                            <p class="font-medium">3+ months</p>
                        </div>
                    </div>
                </div>
                
                <!-- Job Description -->
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Job Description</h3>
                    <p class="text-gray-700">We're looking for a talented Full Stack Developer to join our team. You'll be working on our SaaS platform, building new features and maintaining existing functionality...</p>
                </div>
                
                <!-- Requirements -->
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Requirements & Qualifications</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Required Skills</p>
                            <p class="font-medium">JavaScript, React, Node.js, MongoDB</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Experience Level</p>
                            <p class="font-medium">Mid-experienced</p>
                        </div>
                    </div>
                </div>
                
                <!-- Budget -->
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Budget & Capacity</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Salary Range</p>
                            <p class="font-medium">$80,000 - $120,000</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Number of Openings</p>
                            <p class="font-medium">1</p>
                        </div>
                    </div>
                </div>
                
                <!-- Location -->
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Job Location</h3>
                    <p class="font-medium">Remote - Anywhere</p>
                </div>
                
                <!-- Monitoring Preferences -->
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Monitoring Preferences</h3>
                    <p class="font-medium">Weekly check-ins</p>
                </div>
                
                <!-- Job Visibility -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Job Visibility</h3>
                    <p class="font-medium">Featured Job (14 DAYS)</p>
                    <p class="text-sm text-gray-500">Will be highlighted and shown at the top of search results</p>
                </div>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Details</h2>
            
            <!-- Order Summary Table -->
            <div class="border-b border-gray-100 pb-4 mb-4">
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Basic Job Posting (30 days)</span>
                    <span class="font-medium">$99.00</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Featured Job Upgrade</span>
                    <span class="font-medium">$49.00</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Promoted in Newsletter</span>
                    <span class="font-medium">$29.00</span>
                </div>
                <div class="flex justify-between py-2 border-t border-gray-100 mt-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">$177.00</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Tax (8%)</span>
                    <span class="font-medium">$14.16</span>
                </div>
            </div>
            
            <!-- Coupon Code -->
            <div class="mb-6">
                <label for="coupon" class="block text-sm font-medium text-gray-700 mb-1">Discount Code</label>
                <div class="flex">
                    <input type="text" id="coupon" placeholder="Enter coupon code" class="flex-1 border border-gray-300 rounded-l-button px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <button class="bg-primary text-white px-4 py-2 rounded-r-button hover:bg-blue-700 transition-colors !rounded-button whitespace-nowrap">Apply</button>
                </div>
            </div>
            
            <!-- Total -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-700">Total Amount</span>
                    <span class="text-xl font-bold text-gray-900">$191.16</span>
                </div>
            </div>
        </div>
        
        <!-- Payment Methods -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Method</h2>
            
            <div class="space-y-3">
                <!-- Credit Card Option -->
                <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-primary">
                    <input type="radio" name="payment-method" class="mt-1" checked>
                    <div class="ml-3 flex-1">
                        <div class="flex items-center">
                            <span class="font-medium">Credit Card</span>
                            <div class="flex ml-auto space-x-2">
                                <div class="w-8 h-6 flex items-center justify-center text-blue-700">
                                    <i class="ri-visa-fill ri-lg"></i>
                                </div>
                                <div class="w-8 h-6 flex items-center justify-center text-blue-700">
                                    <i class="ri-mastercard-fill ri-lg"></i>
                                </div>
                                <div class="w-8 h-6 flex items-center justify-center text-blue-700">
                                    <i class="ri-american-express-fill ri-lg"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Secure payment processing</p>
                    </div>
                </label>
                
                <!-- PayPal Option -->
                <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-primary">
                    <input type="radio" name="payment-method" class="mt-1">
                    <div class="ml-3 flex-1">
                        <div class="flex items-center">
                            <span class="font-medium">PayPal</span>
                            <div class="ml-auto">
                                <div class="w-8 h-6 flex items-center justify-center text-blue-700">
                                    <i class="ri-paypal-fill ri-lg"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Pay securely via PayPal</p>
                    </div>
                </label>
            </div>
            
            <!-- Security Notice -->
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <div class="w-5 h-5 flex items-center justify-center mr-2 text-green-600">
                    <i class="ri-lock-line"></i>
                </div>
                <span>Your payment information is processed securely. We do not store credit card details.</span>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="sticky bottom-0 bg-white border-t border-gray-200 p-4 flex justify-between items-center mt-6 -mx-4 md:mx-0 md:rounded-lg md:shadow-sm">
            <button class="px-5 py-2 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 transition-colors !rounded-button whitespace-nowrap">
                <i class="ri-arrow-left-line mr-1"></i> Back to Edit
            </button>
            <div class="flex space-x-3">
                <button class="px-5 py-2 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 transition-colors !rounded-button whitespace-nowrap">Save as Draft</button>
                <button class="px-5 py-2 bg-primary text-white rounded-button hover:bg-blue-700 transition-colors !rounded-button whitespace-nowrap">Pay Now</button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12 py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <a href="#" class="text-2xl font-['Pacifico'] text-blue-800">logo</a>
                    <p class="mt-2 text-sm text-gray-600">Connect with top talent and find the perfect fit for your business needs.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-primary hover:text-white transition-colors">
                            <i class="ri-facebook-fill"></i>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-primary hover:text-white transition-colors">
                            <i class="ri-twitter-fill"></i>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-primary hover:text-white transition-colors">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-primary">Find Talent</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Post a Job</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">How It Works</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Pricing</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-primary">Blog</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Help Center</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Community</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Tutorials</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Success Stories</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-4">Subscribe</h3>
                    <p class="text-sm text-gray-600 mb-3">Get the latest news and updates directly to your inbox.</p>
                    <div class="flex">
                        <input type="email" placeholder="Your email address" class="flex-1 border border-gray-300 rounded-l-button px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <button class="bg-primary text-white px-4 py-2 rounded-r-button text-sm hover:bg-blue-700 transition-colors !rounded-button whitespace-nowrap">Subscribe</button>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-600">© 2025 All rights reserved</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-sm text-gray-600 hover:text-primary">Terms of Service</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-primary">Privacy Policy</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-primary">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script id="couponCodeScript">
        document.addEventListener('DOMContentLoaded', function() {
            const couponInput = document.getElementById('coupon');
            const applyButton = couponInput.nextElementSibling;
            
            applyButton.addEventListener('click', function() {
                const couponCode = couponInput.value.trim();
                if (couponCode) {
                    // Simulate coupon application
                    // In a real app, this would be an API call
                    if (couponCode.toLowerCase() === 'welcome15') {
                        // Success case
                        const discountAmount = 28.67; // 15% of $191.16
                        const newTotal = 191.16 - discountAmount;
                        
                        // Add discount row to summary
                        const taxRow = document.querySelector('.border-t').nextElementSibling;
                        const discountRow = document.createElement('div');
                        discountRow.className = 'flex justify-between py-2 text-green-600';
                        discountRow.innerHTML = `
                            <span>Discount (15%)</span>
                            <span class="font-medium">-$${discountAmount.toFixed(2)}</span>
                        `;
                        taxRow.parentNode.insertBefore(discountRow, null);
                        
                        // Update total
                        document.querySelector('.text-xl.font-bold').textContent = `$${newTotal.toFixed(2)}`;
                        
                        // Show success message
                        const successMsg = document.createElement('p');
                        successMsg.className = 'text-green-600 text-sm mt-2';
                        successMsg.textContent = 'Coupon applied successfully!';
                        couponInput.parentNode.parentNode.appendChild(successMsg);
                        
                        // Disable input and button
                        couponInput.disabled = true;
                        applyButton.disabled = true;
                        applyButton.classList.add('bg-gray-400');
                        applyButton.classList.remove('hover:bg-blue-700');
                    } else {
                        // Error case
                        const errorMsg = document.createElement('p');
                        errorMsg.className = 'text-red-600 text-sm mt-2';
                        errorMsg.textContent = 'Invalid coupon code. Please try again.';
                        couponInput.parentNode.parentNode.appendChild(errorMsg);
                        
                        // Remove error message after 3 seconds
                        setTimeout(() => {
                            errorMsg.remove();
                        }, 3000);
                    }
                }
            });
        });
    </script>

    <script id="paymentMethodScript">
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('input[name="payment-method"]');
            const paymentLabels = document.querySelectorAll('label.flex.items-start');
            
            paymentOptions.forEach((option, index) => {
                option.addEventListener('change', function() {
                    // Reset all labels
                    paymentLabels.forEach(label => {
                        label.classList.remove('border-primary', 'bg-blue-50');
                        label.classList.add('border-gray-200');
                    });
                    
                    // Highlight selected label
                    if (this.checked) {
                        paymentLabels[index].classList.remove('border-gray-200');
                        paymentLabels[index].classList.add('border-primary', 'bg-blue-50');
                    }
                });
                
                // Initialize with first option selected
                if (index === 0 && option.checked) {
                    paymentLabels[index].classList.remove('border-gray-200');
                    paymentLabels[index].classList.add('border-primary', 'bg-blue-50');
                }
            });
        });
    </script>
</body>
</html>