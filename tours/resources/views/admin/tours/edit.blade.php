@extends('admin.layouts.master')
@section('title', 'Edit Tour')
@section('page-title', 'Edit: ' . $tour->title)

@section('content')
<div x-data="{ tab: 'general' }">
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="mr-2"><button @click="tab = 'general'" :class="tab === 'general' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500'" class="inline-block p-4 border-b-2 rounded-t-lg">General Info</button></li>
            <li class="mr-2"><button @click="tab = 'itinerary'" :class="tab === 'itinerary' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500'" class="inline-block p-4 border-b-2 rounded-t-lg">Itinerary</button></li>
            <li class="mr-2"><button @click="tab = 'media'" :class="tab === 'media' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500'" class="inline-block p-4 border-b-2 rounded-t-lg">Media & SEO</button></li>
        </ul>
    </div>

    <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div x-show="tab === 'general'" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tour Title</label>
                    <input type="text" name="title" value="{{ old('title', $tour->title) }}" class="w-full rounded-lg border-gray-300" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category_id" class="w-full rounded-lg border-gray-300" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $tour->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Destination</label>
                    <select name="destination_id" class="w-full rounded-lg border-gray-300">
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ $tour->destination_id == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $tour->price) }}" class="w-full rounded-lg border-gray-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sale Price ($)</label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $tour->sale_price) }}" class="w-full rounded-lg border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration (Days)</label>
                    <input type="number" name="duration" value="{{ old('duration', $tour->duration) }}" class="w-full rounded-lg border-gray-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                    <select name="difficulty" class="w-full rounded-lg border-gray-300">
                        @foreach(['easy', 'moderate', 'challenging', 'difficult'] as $diff)
                            <option value="{{ $diff }}" {{ $tour->difficulty == $diff ? 'selected' : '' }}>{{ ucfirst($diff) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max People</label>
                    <input type="number" name="max_people" value="{{ old('max_people', $tour->max_people) }}" class="w-full rounded-lg border-gray-300">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                    <textarea name="short_description" rows="3" class="w-full rounded-lg border-gray-300" required>{{ old('short_description', $tour->short_description) }}</textarea>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Description</label>
                    <textarea name="description" rows="8" class="w-full rounded-lg border-gray-300 font-mono" required>{{ old('description', $tour->description) }}</textarea>
                </div>
            </div>
        </div>

        <div x-show="tab === 'itinerary'" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6" x-cloak
             x-data="{ days: {{ json_encode($tour->itinerary ?? [['day' => 1, 'title' => '', 'description' => '']]) }} }">
            
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Itinerary Builder</h3>
                <button type="button" @click="days.push({ day: days.length + 1, title: '', description: '' })" class="text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded">+ Add Day</button>
            </div>

            <template x-for="(day, index) in days" :key="index">
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 mb-4">
                    <div class="flex justify-between mb-2">
                        <span class="font-bold text-gray-700" x-text="'Day ' + (index + 1)"></span>
                        <button type="button" @click="days.splice(index, 1)" class="text-red-500 text-sm">Remove</button>
                    </div>
                    <input type="hidden" :name="'itinerary[' + index + '][day]'" :value="index + 1">
                    <div class="grid gap-3">
                        <input type="text" :name="'itinerary[' + index + '][title]'" x-model="day.title" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Title">
                        <textarea :name="'itinerary[' + index + '][description]'" x-model="day.description" rows="2" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Description"></textarea>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="tab === 'media'" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6" x-cloak>
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Image</h3>
                @if($tour->featured_image)
                    <img src="{{ asset('storage/' . $tour->featured_image) }}" class="w-64 h-40 object-cover rounded-lg mb-4">
                @endif
                <label class="block text-sm font-medium text-gray-700 mb-2">Change Image</label>
                <input type="file" name="featured_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700">
            </div>

            <div class="border-t pt-6">
                <div class="flex items-center gap-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="featured" value="1" {{ $tour->featured ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                        <span class="ml-2 text-gray-700">Featured</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <label class="text-gray-700">Status:</label>
                        <select name="status" class="rounded-lg border-gray-300 text-sm">
                            <option value="published" {{ $tour->status == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ $tour->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ $tour->status == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <a href="{{ route('admin.tours.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md">Update Tour</button>
        </div>
    </form>
</div>
@endsection