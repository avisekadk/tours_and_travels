<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.weather.api_key', 'your_openweathermap_api_key');
    }

    // Get current weather for destination
    public function getCurrentWeather($latitude, $longitude)
    {
        // Cache for 1 hour
        $cacheKey = "weather_{$latitude}_{$longitude}";
        
        return Cache::remember($cacheKey, 3600, function () use ($latitude, $longitude) {
            try {
                $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    return [
                        'temperature' => round($data['main']['temp']),
                        'feels_like' => round($data['main']['feels_like']),
                        'description' => ucfirst($data['weather'][0]['description']),
                        'icon' => $data['weather'][0]['icon'],
                        'humidity' => $data['main']['humidity'],
                        'wind_speed' => round($data['wind']['speed'] * 3.6, 1),
                    ];
                }
                
                return null;
                
            } catch (\Exception $e) {
                \Log::error('Weather API error: ' . $e->getMessage());
                return null;
            }
        });
    }

    // Get weather forecast
    public function getForecast($latitude, $longitude, $days = 5)
    {
        $cacheKey = "forecast_{$latitude}_{$longitude}_{$days}";
        
        return Cache::remember($cacheKey, 3600, function () use ($latitude, $longitude, $days) {
            try {
                $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    $forecast = [];
                    
                    foreach ($data['list'] as $item) {
                        $date = date('Y-m-d', $item['dt']);
                        
                        if (!isset($forecast[$date])) {
                            $forecast[$date] = [
                                'date' => $date,
                                'temp_min' => $item['main']['temp_min'],
                                'temp_max' => $item['main']['temp_max'],
                                'description' => $item['weather'][0]['description'],
                                'icon' => $item['weather'][0]['icon'],
                            ];
                        } else {
                            $forecast[$date]['temp_min'] = min($forecast[$date]['temp_min'], $item['main']['temp_min']);
                            $forecast[$date]['temp_max'] = max($forecast[$date]['temp_max'], $item['main']['temp_max']);
                        }
                    }
                    
                    return array_values($forecast);
                }
                
                return null;
                
            } catch (\Exception $e) {
                \Log::error('Forecast API error: ' . $e->getMessage());
                return null;
            }
        });
    }
}