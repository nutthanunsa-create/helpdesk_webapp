<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ตั้งค่า SLA (Service Level Agreement)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-bold mb-4">กำหนดระยะเวลา SLA (ชั่วโมง) แยกตามบริษัท</h3>
                    
                    <form action="{{ route('slas.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-8">
                            @php $globalIndex = 0; @endphp
                            @foreach($slas as $companyName => $companySlas)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-md font-bold text-indigo-700 mb-3 border-b pb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    บริษัท {{ $companyName }}
                                </h4>
                                
                                <div class="overflow-hidden rounded-md border border-gray-200">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-white">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">ระดับความเร่งด่วน</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">ระยะเวลา SLA (ชั่วโมง)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($companySlas as $sla)
                                            <tr>
                                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 bg-gray-50/50">
                                                    {{ $sla->name_th }} ({{ ucfirst($sla->priority) }})
                                                    <input type="hidden" name="slas[{{ $globalIndex }}][id]" value="{{ $sla->id }}">
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    <input type="number" name="slas[{{ $globalIndex }}][hours]" value="{{ $sla->hours }}" min="1" required class="block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                </td>
                                            </tr>
                                            @php $globalIndex++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                บันทึกการตั้งค่า
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
