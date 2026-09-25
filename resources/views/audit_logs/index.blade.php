<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('ประวัติการใช้งานระบบ (Audit Logs)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">เวลา</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ผู้ใช้งาน</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">การกระทำ</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">เป้าหมาย</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ข้อมูลที่เปลี่ยนแปลง</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($logs as $log)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $log->created_at->translatedFormat('d F Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $log->user->name ?? 'System' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($log->action === 'created')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">สร้าง</span>
                                        @elseif($log->action === 'updated')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">แก้ไข</span>
                                        @elseif($log->action === 'deleted')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">ลบ</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $log->action }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ class_basename($log->target_type) }} #{{ $log->target_id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        @if($log->changes)
                                            <pre class="text-xs max-w-xs overflow-x-auto whitespace-pre-wrap">{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
