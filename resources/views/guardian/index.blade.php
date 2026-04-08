@extends('guardian.layouts.master')

@section('title', 'Academic Curator | Parent Portal')

@section('content')
    <!-- Bento Dashboard Header -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Summary Card: Attendance -->
        <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/15 flex flex-col justify-between h-40">
            <div class="flex justify-between items-start">
                <span class="label-sm font-label uppercase tracking-widest text-secondary">Attendance</span>
                <span class="material-symbols-outlined text-primary">event_available</span>
            </div>
            <div>
                <h2 class="text-4xl font-headline font-extrabold text-on-surface">98%</h2>
                <p class="text-xs text-on-surface-variant mt-1 font-medium italic">Top 5% of class</p>
            </div>
        </div>
        <!-- Summary Card: GPA -->
        <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/15 flex flex-col justify-between h-40">
            <div class="flex justify-between items-start">
                <span class="label-sm font-label uppercase tracking-widest text-secondary">Current GPA</span>
                <span class="material-symbols-outlined text-tertiary">grade</span>
            </div>
            <div>
                <h2 class="text-4xl font-headline font-extrabold text-on-surface">3.8</h2>
                <p class="text-xs text-on-surface-variant mt-1 font-medium italic">Dean's List Candidate</p>
            </div>
        </div>
        <!-- Summary Card: Finance -->
        <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/15 flex flex-col justify-between h-40">
            <div class="flex justify-between items-start">
                <span class="label-sm font-label uppercase tracking-widest text-secondary">Fees Outstanding</span>
                <span class="material-symbols-outlined text-on-secondary-fixed-variant">account_balance_wallet</span>
            </div>
            <div>
                <h2 class="text-4xl font-headline font-extrabold text-on-surface">$0.00</h2>
                <p class="text-xs text-primary font-bold mt-1 uppercase tracking-tight flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">verified</span> Settled
                </p>
            </div>
        </div>
    </section>
    
    <!-- Main Content Grid -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Center Column: Assignments & Recent Activity -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Upcoming Assignments -->
            <div class="bg-surface-container-low rounded-xl p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="headline-md font-headline text-on-surface">Upcoming Assignments</h3>
                    <button class="text-primary font-semibold text-sm flex items-center gap-1">View Calendar
                        <span class="material-symbols-outlined text-sm">arrow_forward</span></button>
                </div>
                <div class="space-y-4">
                    <div class="bg-surface-container-lowest p-5 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-lg bg-primary-container/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">functions</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-on-surface">Advanced Calculus Quiz</h4>
                                <p class="text-xs text-on-surface-variant">Mathematics &amp; Statistics</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-tertiary">Oct 24</p>
                            <p class="text-[10px] uppercase font-bold text-on-surface-variant">Tomorrow</p>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest p-5 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-lg bg-tertiary-container/10 flex items-center justify-center text-tertiary">
                                <span class="material-symbols-outlined">menu_book</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-on-surface">Historical Analysis Essay</h4>
                                <p class="text-xs text-on-surface-variant">Modern World History</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-on-surface">Oct 27</p>
                            <p class="text-[10px] uppercase font-bold text-on-surface-variant">3 Days left</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Attendance -->
            <div class="space-y-4">
                <h3 class="headline-md font-headline text-on-surface">Attendance Log</h3>
                <div class="bg-surface-container-lowest rounded-xl overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-high">
                            <tr>
                                <th class="px-6 py-4 label-sm text-secondary uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 label-sm text-secondary uppercase tracking-wider">Period</th>
                                <th class="px-6 py-4 label-sm text-secondary uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-4 label-sm text-secondary uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            <tr class="hover:bg-surface transition-colors">
                                <td class="px-6 py-4 text-sm font-medium">Oct 23, 2024</td>
                                <td class="px-6 py-4 text-sm">Morning</td>
                                <td class="px-6 py-4 text-sm">Physics</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-sm text-[10px] font-bold uppercase bg-surface-container-highest text-primary">Present</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface transition-colors">
                                <td class="px-6 py-4 text-sm font-medium">Oct 22, 2024</td>
                                <td class="px-6 py-4 text-sm">Morning</td>
                                <td class="px-6 py-4 text-sm">Economics</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-sm text-[10px] font-bold uppercase bg-tertiary-container text-on-tertiary-container">Tardy</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface transition-colors">
                                <td class="px-6 py-4 text-sm font-medium">Oct 21, 2024</td>
                                <td class="px-6 py-4 text-sm">All Day</td>
                                <td class="px-6 py-4 text-sm">General</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-sm text-[10px] font-bold uppercase bg-error-container text-on-error-container">Excused</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Right Column: Alerts & Announcements -->
        <div class="space-y-6">
            <div class="bg-[#001a42] text-white p-8 rounded-xl relative overflow-hidden">
                <!-- Abstract texture background -->
                <div class="absolute inset-0 opacity-10">
                    <div class="h-full w-full" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;">
                    </div>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-primary-fixed">campaign</span>
                        <h3 class="label-md font-label uppercase tracking-widest text-primary-fixed">Urgent Alerts</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="border-l-2 border-primary-container pl-4">
                            <h4 class="font-bold text-sm">Parent-Teacher Symposium</h4>
                            <p class="text-xs text-slate-300 mt-1 leading-relaxed">Mandatory online meeting regarding final semester exams scheduled for this Friday at 6:00 PM.</p>
                            <a class="inline-block mt-2 text-primary-fixed text-xs font-bold border-b border-primary-fixed/50" href="#">Register Link</a>
                        </div>
                        <div class="border-l-2 border-tertiary pl-4">
                            <h4 class="font-bold text-sm">Winter Sports Sign-up</h4>
                            <p class="text-xs text-slate-300 mt-1 leading-relaxed">Deadline for basketball and swimming roster registrations is October 30th.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-surface-container-high/50 p-8 rounded-xl border border-outline-variant/30">
                <h3 class="headline-sm font-headline text-on-surface mb-6">School Calendar</h3>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="bg-surface-container-lowest rounded-lg w-12 h-14 flex flex-col items-center justify-center border border-outline-variant/20">
                            <span class="text-[10px] font-bold text-secondary uppercase">Nov</span>
                            <span class="text-lg font-black text-on-surface">12</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold">Mid-Term Break</h4>
                            <p class="text-xs text-on-surface-variant">No classes. Campus closed.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 opacity-70">
                        <div class="bg-surface-container-lowest rounded-lg w-12 h-14 flex flex-col items-center justify-center border border-outline-variant/20">
                            <span class="text-[10px] font-bold text-secondary uppercase">Nov</span>
                            <span class="text-lg font-black text-on-surface">25</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold">Annual Arts Gala</h4>
                            <p class="text-xs text-on-surface-variant">Main Auditorium, 7:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
