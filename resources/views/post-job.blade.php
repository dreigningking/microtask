<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - Find Talent</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#2a4396',secondary:'#f0f4ff'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-primary text-white py-3 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-['Pacifico'] text-white">logo</a>
            <nav class="hidden md:flex space-x-6">
                <a href="#" class="text-white hover:text-gray-200">Home</a>
                <a href="#" class="text-white hover:text-gray-200">Jobs</a>
                <a href="#" class="text-white hover:text-gray-200">Tasks</a>
                <a href="#" class="text-white font-medium border-b-2 border-white">Post Job</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-white hover:text-gray-200">
                    <div class="w-8 h-8 flex items-center justify-center">
                        <i class="ri-notification-3-line ri-lg"></i>
                    </div>
                </a>
                <a href="#" class="flex items-center">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-primary font-bold">JS</div>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Post a Job</h1>
            <p class="text-gray-600 mt-2">Create a job posting to find skilled professionals for your tasks. Fill in the details below.</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-10">
            <div class="flex items-center justify-between">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold">1</div>
                    <span class="mt-2 text-sm font-medium text-primary">Job Details</span>
                </div>
                <div class="flex-1 h-1 mx-4 bg-gray-200">
                    <div class="h-full bg-primary" style="width: 0%"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-bold">2</div>
                    <span class="mt-2 text-sm font-medium text-gray-500">Payment</span>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form id="jobPostForm">
                <!-- Step 1: Job Details -->
                <div id="step1" class="space-y-8">
                    <!-- Basic Information Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="jobTitle" class="block text-sm font-medium text-gray-700 mb-1">Job Title <span class="text-red-500">*</span></label>
                                <input type="text" id="jobTitle" name="jobTitle" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="e.g. Social Media Content Writer" required>
                            </div>
                            <div>
                                <label for="platform" class="block text-sm font-medium text-gray-700 mb-1">Platform <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select id="platform" name="platform" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                                        <option value="" disabled selected>Select a platform</option>
                                        <option value="writing">Writing & Editing</option>
                                        <option value="design">Graphic Design</option>
                                        <option value="development">Web Development</option>
                                        <option value="marketing">Digital Marketing</option>
                                        <option value="data">Data Entry</option>
                                        <option value="customer">Customer Support</option>
                                        <option value="virtual">Virtual Assistant</option>
                                        <option value="translation">Translation</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="taskTemplate" class="block text-sm font-medium text-gray-700 mb-1">Task Template</label>
                                <div class="relative">
                                    <select id="taskTemplate" name="taskTemplate" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                        <option value="" selected>Select a template (optional)</option>
                                        <option value="template1">Content Creation</option>
                                        <option value="template2">Website Testing</option>
                                        <option value="template3">Data Processing</option>
                                        <option value="template4">Customer Outreach</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="completionTime" class="block text-sm font-medium text-gray-700 mb-1">Expected Completion Time <span class="text-red-500">*</span></label>
                                <div class="flex items-center space-x-4">
                                    <input type="number" id="completionTime" name="completionTime" min="1" class="w-1/3 px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="e.g. 3" required>
                                    <div class="relative w-2/3">
                                        <select id="timeUnit" name="timeUnit" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                            <option value="hours">Hours</option>
                                            <option value="days" selected>Days</option>
                                            <option value="weeks">Weeks</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-arrow-down-s-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Job Description</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Detailed Description <span class="text-red-500">*</span></label>
                                <div class="border border-gray-300 rounded-button overflow-hidden">
                                    <div class="bg-gray-50 border-b border-gray-300 px-3 py-2 flex items-center space-x-2">
                                        <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-bold"></i>
                                            </div>
                                        </button>
                                        <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-italic"></i>
                                            </div>
                                        </button>
                                        <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-underline"></i>
                                            </div>
                                        </button>
                                        <span class="h-4 w-px bg-gray-300 mx-1"></span>
                                        <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-list-unordered"></i>
                                            </div>
                                        </button>
                                        <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-list-ordered"></i>
                                            </div>
                                        </button>
                                        <span class="h-4 w-px bg-gray-300 mx-1"></span>
                                        <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-link"></i>
                                            </div>
                                        </button>
                                        <button type="button" class="p-1 rounded hover:bg-gray-200 !rounded-button">
                                            <div class="w-5 h-5 flex items-center justify-center">
                                                <i class="ri-image-add-line"></i>
                                            </div>
                                        </button>
                                    </div>
                                    <textarea id="description" name="description" rows="6" class="w-full px-4 py-2 border-none focus:ring-0 outline-none" placeholder="Provide a detailed description of the job. Include specific tasks, goals, and any special instructions." required></textarea>
                                </div>
                                <div class="mt-2 text-xs text-gray-500 flex items-center">
                                    <div class="w-4 h-4 flex items-center justify-center mr-1">
                                        <i class="ri-information-line"></i>
                                    </div>
                                    <span>Tip: Use bullet points for better readability and include examples where possible.</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Attachments</label>
                                <div class="border border-dashed border-gray-300 rounded-button p-4 text-center">
                                    <div class="w-10 h-10 mx-auto mb-2 bg-gray-100 rounded-full flex items-center justify-center">
                                        <div class="w-6 h-6 flex items-center justify-center text-gray-500">
                                            <i class="ri-upload-2-line"></i>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-1">Drag and drop files here, or <span class="text-primary font-medium">browse</span></p>
                                    <p class="text-xs text-gray-500">Maximum file size: 10MB (PDF, DOC, JPG, PNG)</p>
                                    <input type="file" id="attachments" name="attachments" class="hidden" multiple>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Requirements & Qualifications Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Requirements & Qualifications</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="skills" class="block text-sm font-medium text-gray-700 mb-1">Required Skills <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="flex flex-wrap gap-2 p-2 border border-gray-300 rounded-button min-h-[42px]" id="skillsContainer">
                                        <input type="text" id="skillInput" class="flex-grow min-w-[100px] border-none focus:ring-0 outline-none text-sm" placeholder="Type a skill and press Enter">
                                    </div>
                                    <div id="skillSuggestions" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-button shadow-lg hidden">
                                        <div class="p-2 hover:bg-gray-100 cursor-pointer text-sm">Content Writing</div>
                                        <div class="p-2 hover:bg-gray-100 cursor-pointer text-sm">SEO Knowledge</div>
                                        <div class="p-2 hover:bg-gray-100 cursor-pointer text-sm">Social Media Marketing</div>
                                        <div class="p-2 hover:bg-gray-100 cursor-pointer text-sm">Graphic Design</div>
                                        <div class="p-2 hover:bg-gray-100 cursor-pointer text-sm">Data Analysis</div>
                                    </div>
                                </div>
                                <input type="hidden" id="skills" name="skills">
                            </div>
                            <div>
                                <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">Experience Level <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select id="experience" name="experience" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                                        <option value="" disabled selected>Select experience level</option>
                                        <option value="entry">Entry Level (0-1 years)</option>
                                        <option value="intermediate">Intermediate (1-3 years)</option>
                                        <option value="experienced">Experienced (3-5 years)</option>
                                        <option value="expert">Expert (5+ years)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="certifications" class="block text-sm font-medium text-gray-700 mb-1">Required Certifications</label>
                                <input type="text" id="certifications" name="certifications" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="e.g. Google Analytics, HubSpot, etc. (comma separated)">
                            </div>
                            <div>
                                <label for="education" class="block text-sm font-medium text-gray-700 mb-1">Education Requirements</label>
                                <input type="text" id="education" name="education" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="e.g. Bachelor's in Marketing (optional)">
                            </div>
                        </div>
                    </div>

                    <!-- Budget & Capacity Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Budget & Capacity</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Salary Range <span class="text-red-500">*</span></label>
                                <div class="space-y-6">
                                    <div>
                                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                                            <span>$0</span>
                                            <span>$1,000+</span>
                                        </div>
                                        <div class="relative">
                                            <div class="h-2 bg-gray-200 rounded-full">
                                                <div class="absolute h-2 bg-primary rounded-full" id="salaryRangeTrack" style="width: 30%; left: 10%"></div>
                                            </div>
                                            <div class="absolute w-4 h-4 bg-white border-2 border-primary rounded-full -mt-1 -ml-2 cursor-pointer" id="minSalaryHandle" style="left: 10%"></div>
                                            <div class="absolute w-4 h-4 bg-white border-2 border-primary rounded-full -mt-1 -ml-2 cursor-pointer" id="maxSalaryHandle" style="left: 40%"></div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <label for="minSalary" class="block text-xs text-gray-500 mb-1">Min ($)</label>
                                            <input type="number" id="minSalary" name="minSalary" min="0" max="1000" value="100" class="w-full px-3 py-1 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm" required>
                                        </div>
                                        <div class="text-gray-400">to</div>
                                        <div>
                                            <label for="maxSalary" class="block text-xs text-gray-500 mb-1">Max ($)</label>
                                            <input type="number" id="maxSalary" name="maxSalary" min="0" max="1000" value="400" class="w-full px-3 py-1 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm" required>
                                        </div>
                                        <div class="relative">
                                            <select id="paymentType" name="paymentType" class="appearance-none px-3 py-1 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm">
                                                <option value="fixed">Fixed</option>
                                                <option value="hourly">Hourly</option>
                                                <option value="daily">Daily</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                                <div class="w-4 h-4 flex items-center justify-center">
                                                    <i class="ri-arrow-down-s-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="peopleNeeded" class="block text-sm font-medium text-gray-700 mb-1">Number of People Needed <span class="text-red-500">*</span></label>
                                <div class="flex items-center">
                                    <button type="button" id="decreasePeople" class="px-3 py-2 border border-gray-300 rounded-l-button bg-gray-50 hover:bg-gray-100 !rounded-button">
                                        <div class="w-4 h-4 flex items-center justify-center">
                                            <i class="ri-subtract-line"></i>
                                        </div>
                                    </button>
                                    <input type="number" id="peopleNeeded" name="peopleNeeded" min="1" value="1" class="w-16 px-3 py-2 border-y border-gray-300 text-center focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                                    <button type="button" id="increasePeople" class="px-3 py-2 border border-gray-300 rounded-r-button bg-gray-50 hover:bg-gray-100 !rounded-button">
                                        <div class="w-4 h-4 flex items-center justify-center">
                                            <i class="ri-add-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label for="companyUrl" class="block text-sm font-medium text-gray-700 mb-1">Company Website URL</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 rounded-l-button text-gray-500 text-sm">https://</span>
                                    <input type="text" id="companyUrl" name="companyUrl" class="flex-1 px-4 py-2 border border-gray-300 rounded-r-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="www.yourcompany.com">
                                </div>
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Job Location</label>
                                <div class="relative">
                                    <select id="location" name="location" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                        <option value="remote" selected>Remote - Anywhere</option>
                                        <option value="hybrid">Hybrid - Partial Remote</option>
                                        <option value="onsite">Onsite - Specific Location</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monitoring Preferences Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Monitoring Preferences</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Monitoring Type <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="relative">
                                        <input type="radio" id="selfMonitored" name="monitoringType" value="self" class="peer absolute opacity-0 w-0 h-0" checked>
                                        <label for="selfMonitored" class="flex flex-col items-center p-4 border border-gray-300 rounded-button cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mb-2">
                                                <div class="w-5 h-5 flex items-center justify-center text-primary">
                                                    <i class="ri-user-settings-line"></i>
                                                </div>
                                            </div>
                                            <span class="font-medium text-gray-800">Self-Monitored</span>
                                            <span class="text-xs text-gray-500 text-center mt-1">You'll review and approve all work</span>
                                        </label>
                                    </div>
                                    <div class="relative">
                                        <input type="radio" id="adminMonitored" name="monitoringType" value="admin" class="peer absolute opacity-0 w-0 h-0">
                                        <label for="adminMonitored" class="flex flex-col items-center p-4 border border-gray-300 rounded-button cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mb-2">
                                                <div class="w-5 h-5 flex items-center justify-center text-primary">
                                                    <i class="ri-admin-line"></i>
                                                </div>
                                            </div>
                                            <span class="font-medium text-gray-800">Admin-Monitored</span>
                                            <span class="text-xs text-gray-500 text-center mt-1">Our team will review work quality</span>
                                        </label>
                                    </div>
                                    <div class="relative">
                                        <input type="radio" id="systemMonitored" name="monitoringType" value="system" class="peer absolute opacity-0 w-0 h-0">
                                        <label for="systemMonitored" class="flex flex-col items-center p-4 border border-gray-300 rounded-button cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mb-2">
                                                <div class="w-5 h-5 flex items-center justify-center text-primary">
                                                    <i class="ri-robot-line"></i>
                                                </div>
                                            </div>
                                            <span class="font-medium text-gray-800">System-Automated</span>
                                            <span class="text-xs text-gray-500 text-center mt-1">Automated verification system</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="monitoringFrequencyContainer" class="bg-gray-50 p-4 rounded-button border border-gray-200">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Monitoring Frequency</label>
                                <div class="flex space-x-4">
                                    <div class="relative flex items-center">
                                        <input type="radio" id="daily" name="monitoringFrequency" value="daily" class="w-4 h-4 text-primary focus:ring-primary border-gray-300" checked>
                                        <label for="daily" class="ml-2 text-sm text-gray-700">Daily</label>
                                    </div>
                                    <div class="relative flex items-center">
                                        <input type="radio" id="weekly" name="monitoringFrequency" value="weekly" class="w-4 h-4 text-primary focus:ring-primary border-gray-300">
                                        <label for="weekly" class="ml-2 text-sm text-gray-700">Weekly</label>
                                    </div>
                                    <div class="relative flex items-center">
                                        <input type="radio" id="completion" name="monitoringFrequency" value="completion" class="w-4 h-4 text-primary focus:ring-primary border-gray-300">
                                        <label for="completion" class="ml-2 text-sm text-gray-700">Upon Completion</label>
                                    </div>
                                    <div class="relative flex items-center">
                                        <input type="radio" id="custom" name="monitoringFrequency" value="custom" class="w-4 h-4 text-primary focus:ring-primary border-gray-300">
                                        <label for="custom" class="ml-2 text-sm text-gray-700">Custom</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Visibility Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Job Visibility</h2>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="featured" name="featured" type="checkbox" class="w-4 h-4 text-primary focus:ring-primary border-gray-300 rounded">
                                </div>
                                <div class="ml-3">
                                    <label for="featured" class="font-medium text-gray-700">Featured Job (+$29.99)</label>
                                    <p class="text-gray-500 text-sm">Your job will be highlighted and shown at the top of search results</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="urgent" name="urgent" type="checkbox" class="w-4 h-4 text-primary focus:ring-primary border-gray-300 rounded">
                                </div>
                                <div class="ml-3">
                                    <label for="urgent" class="font-medium text-gray-700">Urgent Job (+$19.99)</label>
                                    <p class="text-gray-500 text-sm">Add an "Urgent" badge to attract immediate attention</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="private" name="private" type="checkbox" class="w-4 h-4 text-primary focus:ring-primary border-gray-300 rounded">
                                </div>
                                <div class="ml-3">
                                    <label for="private" class="font-medium text-gray-700">Private Job</label>
                                    <p class="text-gray-500 text-sm">Only invited freelancers can see and apply to this job</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Payment Details (Hidden Initially) -->
                <div id="step2" class="hidden space-y-8">
                    <!-- Payment Summary Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Summary</h2>
                        <div class="bg-gray-50 border border-gray-200 rounded-button p-6">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Base Posting Fee</span>
                                    <span class="font-medium">$49.99</span>
                                </div>
                                <div class="flex justify-between" id="featuredFeeRow">
                                    <span class="text-gray-600">Featured Job</span>
                                    <span class="font-medium">$29.99</span>
                                </div>
                                <div class="flex justify-between" id="urgentFeeRow">
                                    <span class="text-gray-600">Urgent Badge</span>
                                    <span class="font-medium">$19.99</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Platform Service Fee</span>
                                    <span class="font-medium">$9.99</span>
                                </div>
                                <div class="border-t border-gray-300 pt-3 flex justify-between">
                                    <span class="font-semibold">Total</span>
                                    <span class="font-semibold text-lg" id="totalAmount">$109.96</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Section -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Method</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" id="creditCard" name="paymentMethod" value="creditCard" class="peer absolute opacity-0 w-0 h-0" checked>
                                    <label for="creditCard" class="flex items-center p-4 border border-gray-300 rounded-button cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <div class="w-10 h-10 flex items-center justify-center mr-3">
                                            <i class="ri-bank-card-fill ri-lg text-primary"></i>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">Credit/Debit Card</span>
                                            <div class="flex items-center mt-1 space-x-2">
                                                <div class="w-8 h-5 flex items-center justify-center">
                                                    <i class="ri-visa-fill text-blue-700"></i>
                                                </div>
                                                <div class="w-8 h-5 flex items-center justify-center">
                                                    <i class="ri-mastercard-fill text-orange-500"></i>
                                                </div>
                                                <div class="w-8 h-5 flex items-center justify-center">
                                                    <i class="ri-american-express-fill text-blue-500"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="paypal" name="paymentMethod" value="paypal" class="peer absolute opacity-0 w-0 h-0">
                                    <label for="paypal" class="flex items-center p-4 border border-gray-300 rounded-button cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <div class="w-10 h-10 flex items-center justify-center mr-3">
                                            <i class="ri-paypal-fill ri-lg text-blue-600"></i>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">PayPal</span>
                                            <p class="text-xs text-gray-500 mt-1">Fast and secure payment</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Credit Card Form (Shown by Default) -->
                            <div id="creditCardForm" class="bg-white border border-gray-200 rounded-button p-4">
                                <div class="space-y-4">
                                    <div>
                                        <label for="cardNumber" class="block text-sm font-medium text-gray-700 mb-1">Card Number <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" id="cardNumber" name="cardNumber" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="1234 5678 9012 3456" maxlength="19">
                                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                                <div class="w-5 h-5 flex items-center justify-center">
                                                    <i class="ri-bank-card-line text-gray-400"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="expiryDate" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date <span class="text-red-500">*</span></label>
                                            <input type="text" id="expiryDate" name="expiryDate" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="MM/YY" maxlength="5">
                                        </div>
                                        <div>
                                            <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <input type="text" id="cvv" name="cvv" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="123" maxlength="3">
                                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                                    <div class="w-5 h-5 flex items-center justify-center">
                                                        <i class="ri-question-line text-gray-400"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="nameOnCard" class="block text-sm font-medium text-gray-700 mb-1">Name on Card <span class="text-red-500">*</span></label>
                                        <input type="text" id="nameOnCard" name="nameOnCard" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="John Smith">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- PayPal Form (Hidden Initially) -->
                            <div id="paypalForm" class="hidden bg-white border border-gray-200 rounded-button p-4 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                    <i class="ri-paypal-fill ri-3x text-blue-600"></i>
                                </div>
                                <p class="text-gray-700 mb-4">You will be redirected to PayPal to complete your payment securely.</p>
                                <button type="button" class="bg-blue-600 text-white px-6 py-2 rounded-button font-medium hover:bg-blue-700 !rounded-button whitespace-nowrap">Continue to PayPal</button>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Information Section -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">Billing Information</h2>
                            <div class="flex items-center">
                                <input type="checkbox" id="sameAsCompany" name="sameAsCompany" class="w-4 h-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label for="sameAsCompany" class="ml-2 text-sm text-gray-700">Same as company information</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="billingName" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" id="billingName" name="billingName" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="John Smith">
                            </div>
                            <div>
                                <label for="billingEmail" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" id="billingEmail" name="billingEmail" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="john@example.com">
                            </div>
                            <div>
                                <label for="billingAddress" class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                                <input type="text" id="billingAddress" name="billingAddress" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="123 Main Street">
                            </div>
                            <div>
                                <label for="billingCity" class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                <input type="text" id="billingCity" name="billingCity" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="New York">
                            </div>
                            <div>
                                <label for="billingState" class="block text-sm font-medium text-gray-700 mb-1">State/Province <span class="text-red-500">*</span></label>
                                <input type="text" id="billingState" name="billingState" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="NY">
                            </div>
                            <div>
                                <label for="billingZip" class="block text-sm font-medium text-gray-700 mb-1">ZIP/Postal Code <span class="text-red-500">*</span></label>
                                <input type="text" id="billingZip" name="billingZip" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="10001">
                            </div>
                            <div>
                                <label for="billingCountry" class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select id="billingCountry" name="billingCountry" class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                        <option value="US" selected>United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                        <option value="DE">Germany</option>
                                        <option value="FR">France</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <div class="w-5 h-5 flex items-center justify-center">
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="billingPhone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" id="billingPhone" name="billingPhone" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="+1 (555) 123-4567">
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-start mb-4">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" class="w-4 h-4 text-primary focus:ring-primary border-gray-300 rounded" required>
                            </div>
                            <div class="ml-3">
                                <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-primary hover:underline">Terms and Conditions</a> and <a href="#" class="text-primary hover:underline">Privacy Policy</a></label>
                                <p class="text-gray-500 text-sm">By posting this job, you agree to our platform guidelines and policies.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Navigation Buttons -->
                <div class="flex justify-between mt-8 border-t border-gray-200 pt-6">
                    <button type="button" id="backButton" class="hidden px-6 py-2 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 !rounded-button whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-5 h-5 flex items-center justify-center mr-1">
                                <i class="ri-arrow-left-line"></i>
                            </div>
                            <span>Back</span>
                        </div>
                    </button>
                    <div class="flex space-x-4 ml-auto">
                        <button type="button" id="saveAsDraftButton" class="px-6 py-2 border border-gray-300 rounded-button text-gray-700 hover:bg-gray-50 !rounded-button whitespace-nowrap">Save as Draft</button>
                        <button type="button" id="nextButton" class="px-8 py-2 bg-primary text-white rounded-button hover:bg-primary/90 !rounded-button whitespace-nowrap">
                            <div class="flex items-center">
                                <span>Next Step</span>
                                <div class="w-5 h-5 flex items-center justify-center ml-1">
                                    <i class="ri-arrow-right-line"></i>
                                </div>
                            </div>
                        </button>
                        <button type="submit" id="submitButton" class="hidden px-8 py-2 bg-primary text-white rounded-button hover:bg-primary/90 !rounded-button whitespace-nowrap">
                            <div class="flex items-center">
                                <span>Post Job</span>
                                <div class="w-5 h-5 flex items-center justify-center ml-1">
                                    <i class="ri-check-line"></i>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Tips -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tips for a Great Job Posting</h3>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <div class="w-5 h-5 flex items-center justify-center text-primary mt-0.5 mr-2">
                        <i class="ri-check-line"></i>
                    </div>
                    <span class="text-gray-600">Be specific about required skills and qualifications</span>
                </li>
                <li class="flex items-start">
                    <div class="w-5 h-5 flex items-center justify-center text-primary mt-0.5 mr-2">
                        <i class="ri-check-line"></i>
                    </div>
                    <span class="text-gray-600">Set clear expectations for deliverables and deadlines</span>
                </li>
                <li class="flex items-start">
                    <div class="w-5 h-5 flex items-center justify-center text-primary mt-0.5 mr-2">
                        <i class="ri-check-line"></i>
                    </div>
                    <span class="text-gray-600">Provide examples or references when possible</span>
                </li>
                <li class="flex items-start">
                    <div class="w-5 h-5 flex items-center justify-center text-primary mt-0.5 mr-2">
                        <i class="ri-check-line"></i>
                    </div>
                    <span class="text-gray-600">Offer competitive compensation to attract quality talent</span>
                </li>
                <li class="flex items-start">
                    <div class="w-5 h-5 flex items-center justify-center text-primary mt-0.5 mr-2">
                        <i class="ri-check-line"></i>
                    </div>
                    <span class="text-gray-600">Respond promptly to applicants to maintain engagement</span>
                </li>
            </ul>
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="font-medium text-gray-800 mb-2">Need Help?</h4>
                <p class="text-gray-600 text-sm mb-4">Our support team is available 24/7 to assist you with your job posting.</p>
                <a href="#" class="text-primary hover:underline flex items-center text-sm font-medium">
                    <div class="w-4 h-4 flex items-center justify-center mr-1">
                        <i class="ri-customer-service-2-line"></i>
                    </div>
                    <span>Contact Support</span>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <a href="#" class="text-2xl font-['Pacifico'] text-primary mb-4 inline-block">logo</a>
                    <p class="text-gray-600 mb-4">Connect with skilled professionals for your tasks or find opportunities to earn money with your skills.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary/20">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="ri-facebook-fill"></i>
                            </div>
                        </a>
                        <a href="#" class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary/20">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="ri-twitter-fill"></i>
                            </div>
                        </a>
                        <a href="#" class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary/20">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="ri-linkedin-fill"></i>
                            </div>
                        </a>
                        <a href="#" class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary hover:bg-primary/20">
                            <div class="w-4 h-4 flex items-center justify-center">
                                <i class="ri-instagram-fill"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-primary">Find Tasks</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Post a Job</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">How It Works</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Pricing</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-primary">Blog</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Help Center</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Community</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Tutorials</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary">Success Stories</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold mb-4">Subscribe</h3>
                    <p class="text-gray-600 mb-4">Get the latest news and updates directly to your inbox.</p>
                    <form class="space-y-2">
                        <div class="relative">
                            <input type="email" placeholder="Your email address" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                            <button type="submit" class="absolute right-1 top-1 px-3 py-1 bg-primary text-white rounded-button !rounded-button whitespace-nowrap">Subscribe</button>
                        </div>
                        <p class="text-xs text-gray-500">By subscribing, you agree to our Privacy Policy.</p>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 text-sm">© 2025 logo. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-600 hover:text-primary text-sm">Terms of Service</a>
                    <a href="#" class="text-gray-600 hover:text-primary text-sm">Privacy Policy</a>
                    <a href="#" class="text-gray-600 hover:text-primary text-sm">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script id="skillsInputHandler">
        document.addEventListener('DOMContentLoaded', function() {
            const skillInput = document.getElementById('skillInput');
            const skillsContainer = document.getElementById('skillsContainer');
            const skillSuggestions = document.getElementById('skillSuggestions');
            const skillsHiddenInput = document.getElementById('skills');
            const skills = [];

            function updateSkillsInput() {
                skillsHiddenInput.value = skills.join(',');
            }

            function addSkill(skillText) {
                if (skillText.trim() === '' || skills.includes(skillText.trim())) return;
                
                const skill = document.createElement('div');
                skill.className = 'flex items-center bg-primary/10 text-primary px-2 py-1 rounded-full text-sm';
                skill.innerHTML = `
                    <span>${skillText.trim()}</span>
                    <button type="button" class="ml-1 focus:outline-none">
                        <div class="w-4 h-4 flex items-center justify-center">
                            <i class="ri-close-line"></i>
                        </div>
                    </button>
                `;
                
                skill.querySelector('button').addEventListener('click', function() {
                    skill.remove();
                    const index = skills.indexOf(skillText.trim());
                    if (index > -1) {
                        skills.splice(index, 1);
                        updateSkillsInput();
                    }
                });
                
                skillsContainer.insertBefore(skill, skillInput);
                skills.push(skillText.trim());
                updateSkillsInput();
                skillInput.value = '';
            }

            skillInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    addSkill(this.value);
                }
            });

            skillInput.addEventListener('focus', function() {
                skillSuggestions.classList.remove('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!skillInput.contains(e.target) && !skillSuggestions.contains(e.target)) {
                    skillSuggestions.classList.add('hidden');
                }
            });

            const suggestionItems = skillSuggestions.querySelectorAll('div');
            suggestionItems.forEach(item => {
                item.addEventListener('click', function() {
                    addSkill(this.textContent);
                    skillSuggestions.classList.add('hidden');
                });
            });
        });
    </script>

    <script id="salaryRangeHandler">
        document.addEventListener('DOMContentLoaded', function() {
            const minSalaryHandle = document.getElementById('minSalaryHandle');
            const maxSalaryHandle = document.getElementById('maxSalaryHandle');
            const salaryRangeTrack = document.getElementById('salaryRangeTrack');
            const minSalaryInput = document.getElementById('minSalary');
            const maxSalaryInput = document.getElementById('maxSalary');
            
            const maxValue = 1000;
            let isDraggingMin = false;
            let isDraggingMax = false;
            
            function updateHandlePosition(handle, value) {
                const percentage = (value / maxValue) * 100;
                handle.style.left = `${percentage}%`;
            }
            
            function updateTrack() {
                const minVal = parseInt(minSalaryInput.value);
                const maxVal = parseInt(maxSalaryInput.value);
                const minPercentage = (minVal / maxValue) * 100;
                const maxPercentage = (maxVal / maxValue) * 100;
                
                salaryRangeTrack.style.left = `${minPercentage}%`;
                salaryRangeTrack.style.width = `${maxPercentage - minPercentage}%`;
            }
            
            function handleDrag(e, isMin) {
                const container = salaryRangeTrack.parentElement;
                const rect = container.getBoundingClientRect();
                const offsetX = e.clientX - rect.left;
                const percentage = Math.min(Math.max(offsetX / rect.width, 0), 1);
                const value = Math.round(percentage * maxValue);
                
                if (isMin) {
                    if (value < parseInt(maxSalaryInput.value)) {
                        minSalaryInput.value = value;
                        updateHandlePosition(minSalaryHandle, value);
                    }
                } else {
                    if (value > parseInt(minSalaryInput.value)) {
                        maxSalaryInput.value = value;
                        updateHandlePosition(maxSalaryHandle, value);
                    }
                }
                
                updateTrack();
            }
            
            minSalaryHandle.addEventListener('mousedown', function(e) {
                isDraggingMin = true;
                e.preventDefault();
            });
            
            maxSalaryHandle.addEventListener('mousedown', function(e) {
                isDraggingMax = true;
                e.preventDefault();
            });
            
            document.addEventListener('mousemove', function(e) {
                if (isDraggingMin) {
                    handleDrag(e, true);
                } else if (isDraggingMax) {
                    handleDrag(e, false);
                }
            });
            
            document.addEventListener('mouseup', function() {
                isDraggingMin = false;
                isDraggingMax = false;
            });
            
            minSalaryInput.addEventListener('input', function() {
                const value = parseInt(this.value);
                if (value < parseInt(maxSalaryInput.value)) {
                    updateHandlePosition(minSalaryHandle, value);
                    updateTrack();
                }
            });
            
            maxSalaryInput.addEventListener('input', function() {
                const value = parseInt(this.value);
                if (value > parseInt(minSalaryInput.value)) {
                    updateHandlePosition(maxSalaryHandle, value);
                    updateTrack();
                }
            });
            
            // Initialize positions
            updateHandlePosition(minSalaryHandle, parseInt(minSalaryInput.value));
            updateHandlePosition(maxSalaryHandle, parseInt(maxSalaryInput.value));
            updateTrack();
        });
    </script>

    <script id="peopleCounterHandler">
        document.addEventListener('DOMContentLoaded', function() {
            const decreasePeople = document.getElementById('decreasePeople');
            const increasePeople = document.getElementById('increasePeople');
            const peopleNeeded = document.getElementById('peopleNeeded');
            
            decreasePeople.addEventListener('click', function() {
                const currentValue = parseInt(peopleNeeded.value);
                if (currentValue > 1) {
                    peopleNeeded.value = currentValue - 1;
                }
            });
            
            increasePeople.addEventListener('click', function() {
                const currentValue = parseInt(peopleNeeded.value);
                peopleNeeded.value = currentValue + 1;
            });
        });
    </script>

    <script id="formStepsHandler">
        document.addEventListener('DOMContentLoaded', function() {
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const nextButton = document.getElementById('nextButton');
            const backButton = document.getElementById('backButton');
            const submitButton = document.getElementById('submitButton');
            const saveAsDraftButton = document.getElementById('saveAsDraftButton');
            
            nextButton.addEventListener('click', function() {
                // Simple validation for step 1
                const requiredFields = step1.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });
                
                if (isValid) {
                    step1.classList.add('hidden');
                    step2.classList.remove('hidden');
                    nextButton.classList.add('hidden');
                    backButton.classList.remove('hidden');
                    submitButton.classList.remove('hidden');
                    saveAsDraftButton.classList.add('hidden');
                    
                    // Update progress indicator
                    document.querySelector('.bg-primary').style.width = '100%';
                    document.querySelector('.bg-gray-200.rounded-full').classList.add('bg-primary');
                    document.querySelector('.bg-gray-200.rounded-full').classList.remove('bg-gray-200');
                    document.querySelector('.text-gray-500').classList.add('text-primary');
                    document.querySelector('.text-gray-500').classList.remove('text-gray-500');
                }
            });
            
            backButton.addEventListener('click', function() {
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
                nextButton.classList.remove('hidden');
                backButton.classList.add('hidden');
                submitButton.classList.add('hidden');
                saveAsDraftButton.classList.remove('hidden');
                
                // Update progress indicator
                document.querySelector('.bg-primary').style.width = '0%';
                document.querySelectorAll('.w-10.h-10')[1].classList.add('bg-gray-200', 'text-gray-500');
                document.querySelectorAll('.w-10.h-10')[1].classList.remove('bg-primary', 'text-white');
                document.querySelectorAll('.mt-2.text-sm.font-medium')[1].classList.add('text-gray-500');
                document.querySelectorAll('.mt-2.text-sm.font-medium')[1].classList.remove('text-primary');
            });
            
            saveAsDraftButton.addEventListener('click', function() {
                alert('Your job posting has been saved as a draft.');
            });
            
            submitButton.addEventListener('click', function(e) {
                e.preventDefault();
                // Simple validation for step 2
                const requiredFields = step2.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });
                
                if (isValid) {
                    alert('Your job has been successfully posted!');
                    // Here you would normally submit the form or make an API call
                }
            });
        });
    </script>

    <script id="paymentMethodHandler">
        document.addEventListener('DOMContentLoaded', function() {
            const creditCard = document.getElementById('creditCard');
            const paypal = document.getElementById('paypal');
            const creditCardForm = document.getElementById('creditCardForm');
            const paypalForm = document.getElementById('paypalForm');
            
            creditCard.addEventListener('change', function() {
                if (this.checked) {
                    creditCardForm.classList.remove('hidden');
                    paypalForm.classList.add('hidden');
                }
            });
            
            paypal.addEventListener('change', function() {
                if (this.checked) {
                    creditCardForm.classList.add('hidden');
                    paypalForm.classList.remove('hidden');
                }
            });
        });
    </script>

    <script id="paymentCalculationHandler">
        document.addEventListener('DOMContentLoaded', function() {
            const featured = document.getElementById('featured');
            const urgent = document.getElementById('urgent');
            const featuredFeeRow = document.getElementById('featuredFeeRow');
            const urgentFeeRow = document.getElementById('urgentFeeRow');
            const totalAmount = document.getElementById('totalAmount');
            
            function updateTotal() {
                let total = 49.99 + 9.99; // Base fee + service fee
                
                if (featured.checked) {
                    total += 29.99;
                    featuredFeeRow.classList.remove('hidden');
                } else {
                    featuredFeeRow.classList.add('hidden');
                }
                
                if (urgent.checked) {
                    total += 19.99;
                    urgentFeeRow.classList.remove('hidden');
                } else {
                    urgentFeeRow.classList.add('hidden');
                }
                
                totalAmount.textContent = `$${total.toFixed(2)}`;
            }
            
            featured.addEventListener('change', updateTotal);
            urgent.addEventListener('change', updateTotal);
            
            // Initialize
            featuredFeeRow.classList.add('hidden');
            urgentFeeRow.classList.add('hidden');
            updateTotal();
        });
    </script>

    <script id="cardFormatHandler">
        document.addEventListener('DOMContentLoaded', function() {
            const cardNumber = document.getElementById('cardNumber');
            const expiryDate = document.getElementById('expiryDate');
            const cvv = document.getElementById('cvv');
            
            cardNumber.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                let formattedValue = '';
                
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        formattedValue += ' ';
                    }
                    formattedValue += value[i];
                }
                
                e.target.value = formattedValue;
            });
            
            expiryDate.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length > 2) {
                    e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
                } else {
                    e.target.value = value;
                }
            });
            
            cvv.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        });
    </script>

    <script id="monitoringTypeHandler">
        document.addEventListener('DOMContentLoaded', function() {
            const monitoringTypes = document.querySelectorAll('input[name="monitoringType"]');
            const monitoringFrequencyContainer = document.getElementById('monitoringFrequencyContainer');
            
            function updateMonitoringOptions() {
                const selectedType = document.querySelector('input[name="monitoringType"]:checked').value;
                
                if (selectedType === 'self' || selectedType === 'admin') {
                    monitoringFrequencyContainer.classList.remove('hidden');
                } else {
                    monitoringFrequencyContainer.classList.add('hidden');
                }
            }
            
            monitoringTypes.forEach(type => {
                type.addEventListener('change', updateMonitoringOptions);
            });
            
            // Initialize
            updateMonitoringOptions();
        });
    </script>
</body>
</html>