@extends('admin.layouts.master')
@section('title', 'Create Tour')
@section('page-title', 'Create New Tour')

@section('content')
<div x-data="{ tab: 'general' }">
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="mr-2">
                <button @click="tab = 'general'" :class="tab === 'general' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300'" class="inline-block p-4 border-b-2 rounded-t-lg">
                    General Info
                </button>
            </li>
            <li class="mr-2">
                <button @click="tab = 'itinerary'" :class="tab === 'itinerary' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300'" class="inline-block p-4 border-b-2 rounded-t-lg">
                    Itinerary & Inclusions
                </button>
            </li>
            <li class="mr-2">
                <button @click="tab = 'media'" :class="tab === 'media' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300'" class="inline-block p-4 border-b-2 rounded-t-lg">
                    Media & SEO
                </button>
            </li>
        </ul>
    </div>

    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div x-show="tab === 'general'" class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tour Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select name="category_id" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Destination *</label>
                        <select name="destination_id" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Destination</option>
                            @foreach($destinations as $destination)
                                <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price ($) *</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sale Price ($)</label>
                        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Duration (Days) *</label>
                        <input type="number" name="duration" value="{{ old('duration') }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                        <select name="difficulty" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="moderate" {{ old('difficulty') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                            <option value="challenging" {{ old('difficulty') == 'challenging' ? 'selected' : '' }}>Challenging</option>
                            <option value="difficult" {{ old('difficulty') == 'difficult' ? 'selected' : '' }}>Difficult</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max People</label>
                        <input type="number" name="max_people" value="{{ old('max_people') }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Min People</label>
                        <input type="number" name="min_people" value="{{ old('min_people', 1) }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Short Description *</label>
                        <textarea name="short_description" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>{{ old('short_description') }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Description *</label>
                        <textarea name="description" rows="8" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 font-mono" required>{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">HTML tags allowed.</p>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'itinerary'" class="space-y-6" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-data="{ 
                days: [ { day: 1, title: '', description: '' } ] 
            }">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Itinerary Builder</h3>
                    <button type="button" @click="days.push({ day: days.length + 1, title: '', description: '' })" class="text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 font-semibold">+ Add Day</button>
                </div>

                <div class="space-y-4">
                    <template x-for="(day, index) in days" :key="index">
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between mb-2">
                                <span class="font-bold text-gray-700" x-text="'Day ' + (index + 1)"></span>
                                <button type="button" @click="days.splice(index, 1)" class="text-red-500 hover:text-red-700 text-sm" x-show="days.length > 1">Remove</button>
                            </div>
                            <input type="hidden" :name="'itinerary[' + index + '][day]'" :value="index + 1">
                            
                            <div class="grid gap-3">
                                <input type="text" :name="'itinerary[' + index + '][title]'" x-model="day.title" placeholder="Day Title (e.g. Arrival in Kathmandu)" class="w-full rounded-lg border-gray-300 text-sm">
                                <textarea :name="'itinerary[' + index + '][description]'" x-model="day.description" rows="2" placeholder="Description of activities..." class="w-full rounded-lg border-gray-300 text-sm"></textarea>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Inclusions</h3>
                        <p class="text-xs text-gray-500 mb-2">Enter each item on a new line.</p>
                        <textarea name="inclusions[]" rows="6" class="w-full rounded-lg border-gray-300" placeholder="Airport transfers&#10;Hotel accommodation&#10;Breakfast">{{ old('inclusions') ? implode("\n", old('inclusions')) : '' }}</textarea>
                        </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Exclusions</h3>
                        <p class="text-xs text-gray-500 mb-2">Enter each item on a new line.</p>
                        <textarea name="exclusions[]" rows="6" class="w-full rounded-lg border-gray-300" placeholder="International flights&#10;Lunch & Dinner&#10;Tips"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'media'" class="space-y-6" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Featured Image</h3>
                <input type="file" name="featured_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Settings</h3>
                <div class="flex items-center gap-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="featured" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-gray-700">Mark as Featured</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <label class="text-gray-700">Status:</label>
                        <select name="status" class="rounded-lg border-gray-300 text-sm">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <a href="{{ route('admin.tours.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md">Create Tour</button>
        </div>
    </form>
</div>
@endsection