@extends('admin.layouts.master')

@section('title', 'Site Settings')
@section('page-title', 'General Settings')

@section('content')
<div class="max-w-6xl" x-data="{ activeTab: '{{ $settings->keys()->first() ?? 'general' }}' }">
    
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
                    <nav class="flex flex-col">
                        @foreach($settings as $group => $groupSettings)
                            <button type="button" 
                                @click="activeTab = '{{ $group }}'"
                                :class="activeTab === '{{ $group }}' 
                                    ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600 font-medium' 
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent'"
                                class="px-4 py-3 text-left text-sm transition-colors duration-150 flex items-center capitalize">
                                
                                <span class="mr-3">
                                    @if($group === 'general') 🏠
                                    @elseif($group === 'social') 🌐
                                    @elseif($group === 'payment') 💳
                                    @elseif($group === 'seo') 🔍
                                    @elseif($group === 'email') 📧
                                    @else ⚙️
                                    @endif
                                </span>
                                {{ $group }} Settings
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>

            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="border-b border-gray-200 pb-4 mb-6 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 capitalize" x-text="activeTab + ' Settings'"></h3>
                            <p class="text-sm text-gray-500">Manage your site configuration</p>
                        </div>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Save Changes
                        </button>
                    </div>

                    @foreach($settings as $group => $groupSettings)
                        <div x-show="activeTab === '{{ $group }}'" class="space-y-6" style="display: none;">
                            @foreach($groupSettings as $setting)
                                <div>
                                    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ $setting->description ?? str_replace('_', ' ', ucfirst($setting->key)) }}
                                    </label>
                                    
                                    @if($setting->type === 'textarea')
                                        <textarea 
                                            name="{{ $setting->key }}" 
                                            id="{{ $setting->key }}" 
                                            rows="4" 
                                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                        >{{ old($setting->key, $setting->value) }}</textarea>
                                    @else
                                        <input 
                                            type="text" 
                                            name="{{ $setting->key }}" 
                                            id="{{ $setting->key }}" 
                                            value="{{ old($setting->key, $setting->value) }}"
                                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                        >
                                    @endif
                                    
                                    <p class="mt-1 text-xs text-gray-400 font-mono">Key: {{ $setting->key }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div>
@endsection