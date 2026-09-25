<!DOCTYPE html>
<html lang="th" class="h-full bg-slate-50 text-slate-800 antialiased overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการเคส {{ $case->ticket_no }} - ITDeskService</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Prompt', 'Plus Jakarta Sans', sans-serif; }
        .font-numeric { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="min-h-full flex flex-col bg-gradient-to-br from-slate-50 via-slate-100/60 to-slate-200/40 overflow-x-hidden">

    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/polymate-logo.png') }}" alt="Polymate IT Solutions" class="h-8 max-w-[140px] w-auto shrink-0 object-contain">
                    <div class="hidden sm:block">
                        <span class="text-xl font-bold tracking-tight text-slate-900 font-numeric">ITDesk<span class="text-indigo-600">Service</span></span>
                        <p class="text-xs text-slate-500 hidden sm:block">จัดการเคสแจ้งซ่อม</p>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">กลับ Dashboard</span>
                    <span class="sm:hidden">กลับ</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 min-w-0 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        <!-- Flash Success Message -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 animate-fadeIn">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800">
            <p class="text-sm font-bold mb-2">กรุณาตรวจสอบข้อมูล:</p>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Case Header Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden mb-6">
            <div class="p-5 sm:p-6 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="font-mono text-sm font-bold bg-indigo-500/30 text-indigo-200 px-3 py-1 rounded-lg">{{ $case->ticket_no }}</span>

                            <!-- Priority Badge -->
                            @if($case->priority === 'urgent')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-400/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400 animate-ping"></span>
                                ด่วนที่สุด
                            </span>
                            @elseif($case->priority === 'high')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-400/30">
                                ⚡ สูง
                            </span>
                            @elseif($case->priority === 'medium')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-sky-500/20 text-sky-300 border border-sky-400/30">
                                ปานกลาง
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-500/20 text-slate-300 border border-slate-400/30">
                                ทั่วไป
                            </span>
                            @endif

                            <!-- Status Badge -->
                            @if($case->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-sky-500/20 text-sky-300 border border-sky-400/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                                รอดำเนินการ
                            </span>
                            @elseif($case->status === 'analyzing')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-500/20 text-purple-300 border border-purple-400/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-pulse"></span>
                                กำลังสืบสภาพ และวิเคราะห์หาสาเหตุ
                            </span>
                            @elseif($case->status === 'in_progress')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-400/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                กำลังดำเนินการ
                            </span>
                            @elseif($case->status === 'resolved')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                แก้ไขแล้วเสร็จ
                            </span>
                            @elseif($case->status === 'closed')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-green-500/20 text-green-300 border border-green-400/30">
                                ปิดงาน
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-rose-500/20 text-rose-300 border border-rose-400/30">
                                ยกเลิก
                            </span>
                            @endif
                        </div>
                        <h1 class="text-lg sm:text-xl font-bold text-white">{{ $case->title }}</h1>
                        <p class="text-xs text-slate-400 mt-1">เปิดเคสเมื่อ {{ $case->created_at->translatedFormat('d M Y เวลา H:i น.') }}</p>
                    </div>

                    <!-- SLA Info -->
                    <div class="shrink-0">
                        @if(!in_array($case->status, ['resolved', 'closed', 'cancelled']) && $case->sla_due_at)
                            @if($case->is_overdue)
                            <div class="px-4 py-3 rounded-xl bg-rose-500/20 border border-rose-400/30 text-center">
                                <p class="text-[11px] uppercase tracking-wider text-rose-300 font-semibold">SLA เกินกำหนด</p>
                                <p class="text-lg font-bold text-rose-300 font-numeric mt-0.5">⚠️ Overdue</p>
                                <p class="text-[11px] text-rose-400">กำหนด {{ $case->sla_due_at->translatedFormat('d M H:i น.') }}</p>
                            </div>
                            @else
                            <div class="px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-400/20 text-center">
                                <p class="text-[11px] uppercase tracking-wider text-emerald-300 font-semibold">SLA เหลือเวลา</p>
                                <p class="text-lg font-bold text-emerald-300 font-numeric mt-0.5">{{ $case->sla_due_at->diffForHumans(['parts' => 2]) }}</p>
                                <p class="text-[11px] text-slate-400">กำหนด {{ $case->sla_due_at->translatedFormat('d M H:i น.') }}</p>
                            </div>
                            @endif
                        @elseif($case->resolved_at)
                        <div class="px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-400/20 text-center">
                            <p class="text-[11px] uppercase tracking-wider text-emerald-300 font-semibold">เสร็จสิ้นเมื่อ</p>
                            <p class="text-sm font-bold text-emerald-300 font-numeric mt-0.5">{{ $case->resolved_at->translatedFormat('d M Y') }}</p>
                            <p class="text-[11px] text-slate-400">เวลา {{ $case->resolved_at->format('H:i') }} น.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Form -->
        <form method="POST" action="{{ route('cases.update', $case) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: Case Info (2/3) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Problem Details Card -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h2 class="text-sm font-bold text-slate-900">รายละเอียดปัญหา</h2>
                        </div>
                        <div class="p-5 space-y-4">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-xs font-semibold text-slate-700 mb-1.5">หัวข้อปัญหา <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $case->title) }}" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                            </div>

                            <!-- Category & Priority -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="category" class="block text-xs font-semibold text-slate-700 mb-1.5">หมวดหมู่งาน <span class="text-rose-500">*</span></label>
                                    <select name="category" id="category" required
                                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                        @foreach(['Hardware', 'Software', 'Network', 'Access & Account', 'Printer & Peripherals', 'Other'] as $cat)
                                        <option value="{{ $cat }}" {{ old('category', $case->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="priority" class="block text-xs font-semibold text-slate-700 mb-1.5">ระดับความเร่งด่วน <span class="text-rose-500">*</span></label>
                                    <select name="priority" id="priority" required
                                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                        <option value="urgent" {{ old('priority', $case->priority) === 'urgent' ? 'selected' : '' }}>🔴 ด่วนที่สุด (Urgent)</option>
                                        <option value="high" {{ old('priority', $case->priority) === 'high' ? 'selected' : '' }}>🟠 สูง (High)</option>
                                        <option value="medium" {{ old('priority', $case->priority) === 'medium' ? 'selected' : '' }}>🔵 ปานกลาง (Medium)</option>
                                        <option value="low" {{ old('priority', $case->priority) === 'low' ? 'selected' : '' }}>⚪ ทั่วไป (Low)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-xs font-semibold text-slate-700 mb-1.5">รายละเอียดอาการเสีย / ปัญหาที่แจ้ง <span class="text-rose-500">*</span></label>
                                <textarea name="description" id="description" rows="5" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">{{ old('description', $case->description) }}</textarea>
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-xs font-semibold text-slate-700 mb-1.5">สถานที่ / ห้อง / ชั้น</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $case->location) }}"
                                    placeholder="เช่น ชั้น 3 ห้อง 302, อาคาร B"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- Resolution Notes Card -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <h2 class="text-sm font-bold text-slate-900">บันทึกการแก้ไข / Resolution Notes</h2>
                        </div>
                        <div class="p-5">
                            <textarea name="resolution_notes" id="resolution_notes" rows="4"
                                placeholder="ระบุการดำเนินการ เช่น เข้าหัวสายแลนใหม่, เปลี่ยนอุปกรณ์, ปลดล็อค User, ลง Windows ใหม่..."
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors">{{ old('resolution_notes', $case->resolution_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar (1/3) -->
                <div class="space-y-6">

                    <!-- Requester Info Card -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h2 class="text-sm font-bold text-slate-900">ข้อมูลผู้แจ้ง</h2>
                        </div>
                        <div class="p-5 space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-sm shrink-0">
                                    {{ mb_substr($case->requester_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">{{ $case->requester_name }}</p>
                                    <p class="text-xs text-slate-500">{{ $case->department }}</p>
                                </div>
                            </div>
                            @if($case->requester_phone)
                            <div class="flex items-center gap-2 text-xs text-slate-600 pl-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>{{ $case->requester_phone }}</span>
                            </div>
                            @endif
                            @if($case->requester_email)
                            <div class="flex items-center gap-2 text-xs text-slate-600 pl-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $case->requester_email }}</span>
                            </div>
                            @endif
                            @if($case->location)
                            <div class="flex items-center gap-2 text-xs text-slate-600 pl-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $case->location }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status & Assignment Card -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h2 class="text-sm font-bold text-slate-900">สถานะ & ผู้รับผิดชอบ</h2>
                        </div>
                        <div class="p-5 space-y-4">
                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">สถานะงาน</label>
                                <select name="status" id="status" required
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                    <option value="pending" {{ old('status', $case->status) === 'pending' ? 'selected' : '' }}>⏳ รอดำเนินการ</option>
                                    <option value="analyzing" {{ old('status', $case->status) === 'analyzing' ? 'selected' : '' }}>🔍 กำลังสืบสภาพ และวิเคราะห์หาสาเหตุ</option>
                                    <option value="in_progress" {{ old('status', $case->status) === 'in_progress' ? 'selected' : '' }}>🔧 กำลังดำเนินการแก้ไข</option>
                                    <option value="resolved" {{ old('status', $case->status) === 'resolved' ? 'selected' : '' }}>✅ แก้ไขเสร็จ และส่งมอบแล้ว</option>
                                    <option value="closed" {{ old('status', $case->status) === 'closed' ? 'selected' : '' }}>📁 ปิดใบงาน</option>
                                    <option value="cancelled" {{ old('status', $case->status) === 'cancelled' ? 'selected' : '' }}>❌ ยกเลิกเคส</option>
                                </select>
                            </div>

                            <!-- Assigned To -->
                            <div>
                                <label for="assigned_to" class="block text-xs font-semibold text-slate-700 mb-1.5">ช่าง / ผู้รับผิดชอบ</label>
                                <select name="assigned_to" id="assigned_to"
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                    <option value="">-- ยังไม่มอบหมาย --</option>
                                    @foreach($technicians as $tech)
                                    <option value="{{ $tech }}" {{ old('assigned_to', $case->assigned_to) === $tech ? 'selected' : '' }}>{{ $tech }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Card -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h2 class="text-sm font-bold text-slate-900">Timeline</h2>
                            </div>
                            @if($case->updated_at->gt($case->created_at->addMinute()))
                            <div class="flex items-center gap-1.5 text-right">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                </span>
                                <span class="text-[11px] font-medium text-slate-500">อัปเดตล่าสุด: {{ $case->updated_at->translatedFormat('d M Y H:i น.') }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="p-5">
@php
    $steps = [
        'pending' => [
            'label' => 'เปิดเคสแจ้งซ่อม / รอดำเนินการ', 
            'time' => $case->created_at, 
            'end_time' => null,
            'dot' => 'bg-sky-500 ring-sky-100',
            'line' => 'bg-sky-200',
            'text' => 'text-sky-700'
        ],
        'analyzing' => [
            'label' => 'กำลังสืบสภาพ และวิเคราะห์หาสาเหตุ', 
            'time' => $case->analyzing_at, 
            'end_time' => $case->in_progress_at ?? $case->resolved_at ?? $case->closed_at ?? $case->cancelled_at,
            'dot' => 'bg-purple-500 ring-purple-100',
            'line' => 'bg-purple-200',
            'text' => 'text-purple-700'
        ],
        'in_progress' => [
            'label' => 'กำลังดำเนินการแก้ไข', 
            'time' => $case->in_progress_at, 
            'end_time' => $case->resolved_at ?? $case->closed_at ?? $case->cancelled_at,
            'dot' => 'bg-amber-500 ring-amber-100',
            'line' => 'bg-amber-200',
            'text' => 'text-amber-700'
        ],
        'resolved' => [
            'label' => 'แก้ไขเสร็จ และส่งมอบแล้ว', 
            'time' => $case->resolved_at, 
            'end_time' => $case->closed_at ?? $case->cancelled_at,
            'dot' => 'bg-emerald-500 ring-emerald-100',
            'line' => 'bg-emerald-200',
            'text' => 'text-emerald-700'
        ],
        'closed' => [
            'label' => 'ปิดใบงาน', 
            'time' => $case->closed_at, 
            'end_time' => null,
            'dot' => 'bg-green-600 ring-green-100',
            'line' => 'bg-green-200',
            'text' => 'text-green-700'
        ],
    ];

    if ($case->status === 'cancelled' || $case->cancelled_at) {
        $steps['cancelled'] = [
            'label' => 'ยกเลิกเคส', 
            'time' => $case->cancelled_at, 
            'end_time' => null,
            'dot' => 'bg-rose-500 ring-rose-100',
            'line' => 'bg-rose-200',
            'text' => 'text-rose-700'
        ];
    }
@endphp
                            <div class="relative space-y-0">
                                @foreach($steps as $stepKey => $step)
                                    @php
                                        $isCurrent = $case->status === $stepKey;
                                        $hasTime = !is_null($step['time']);
                                        $isLast = $loop->last;

                                        $currentDotBg = 'bg-orange-500';
                                        $currentDotRing = 'ring-orange-100';
                                        $currentText1 = 'text-orange-600';
                                        $currentText2 = 'text-orange-500';

                                        if ($stepKey === 'closed') {
                                            $currentDotBg = 'bg-emerald-500';
                                            $currentDotRing = 'ring-emerald-100';
                                            $currentText1 = 'text-emerald-600';
                                            $currentText2 = 'text-emerald-500';
                                        } elseif ($stepKey === 'cancelled') {
                                            $currentDotBg = 'bg-rose-500';
                                            $currentDotRing = 'ring-rose-100';
                                            $currentText1 = 'text-rose-600';
                                            $currentText2 = 'text-rose-500';
                                        }
                                    @endphp
                                    
                                    <div class="flex gap-3">
                                        <div class="flex flex-col items-center">
                                            @if($isCurrent)
                                                <!-- Current Status: Blinking Dot -->
                                                <div class="relative flex items-center justify-center">
                                                    <div class="w-3 h-3 rounded-full {{ $currentDotBg }} ring-4 {{ $currentDotRing }} shrink-0 z-10 absolute animate-ping"></div>
                                                    <div class="w-3 h-3 rounded-full {{ $currentDotBg }} ring-4 {{ $currentDotRing }} shrink-0 z-10 relative"></div>
                                                </div>
                                            @elseif($hasTime)
                                                <!-- Completed Status -->
                                                <div class="w-3 h-3 rounded-full {{ $step['dot'] }} ring-4 shrink-0 z-10"></div>
                                            @else
                                                <!-- Upcoming Status -->
                                                <div class="w-3 h-3 rounded-full bg-slate-200 ring-4 ring-slate-50 shrink-0 z-10"></div>
                                            @endif
                                            
                                            @if(!$isLast)
                                                <!-- Connecting Line -->
                                                <div class="w-0.5 flex-1 {{ $hasTime || $isCurrent ? $step['line'] : 'bg-slate-100' }}"></div>
                                            @endif
                                        </div>
                                        
                                        <div class="pb-6">
                                            <p class="text-xs font-semibold {{ $isCurrent ? $currentText1 : ($hasTime ? $step['text'] : 'text-slate-400') }}">
                                                {{ $step['label'] }}
                                            </p>
                                            @if($hasTime)
                                                <div class="mt-0.5 space-y-0.5">
                                                    @if($stepKey === 'pending')
                                                        <p class="text-[11px] text-slate-500">{{ $step['time']->translatedFormat('d M Y H:i น.') }}</p>
                                                    @elseif($stepKey === 'closed')
                                                        <p class="text-[11px] text-slate-500">{{ $step['time']->translatedFormat('d M Y H:i น.') }}</p>
                                                    @elseif($stepKey === 'cancelled')
                                                        <p class="text-[11px] text-slate-500">{{ $step['time']->translatedFormat('d M Y H:i น.') }}</p>
                                                    @else
                                                        <p class="text-[11px] text-slate-500">
                                                            {{ $step['time']->translatedFormat('d M Y H:i น.') }}
                                                            @if($step['end_time'])
                                                                <span class="mx-1 text-slate-400">-</span> 
                                                                {{ $step['end_time']->translatedFormat('d M Y H:i น.') }}
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                                
                                                @if(in_array($stepKey, ['analyzing', 'in_progress', 'resolved']) && $case->assigned_to)
                                                    <p class="text-[11px] text-slate-400 mt-1">ช่าง: {{ $case->assigned_to }}</p>
                                                @endif
                                            @elseif($isCurrent)
                                                <p class="text-[11px] {{ $currentText2 }} mt-0.5">สถานะปัจจุบัน</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button type="submit" class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-md shadow-indigo-600/20 transition-all hover:shadow-lg cursor-pointer flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            บันทึกการแก้ไข
                        </button>
                        <a href="{{ route('dashboard') }}" class="w-full py-3 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            กลับหน้า Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </form>

    </main>

    <!-- Footer -->
    <footer class="mt-auto py-4 text-center text-xs text-slate-400 border-t border-slate-200/50 bg-white/40">
        <p>&copy; {{ date('Y') }} Polymate IT Solutions — ITDeskService Helpdesk System</p>
    </footer>

</body>
</html>
