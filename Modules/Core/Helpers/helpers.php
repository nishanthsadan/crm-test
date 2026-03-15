<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (!function_exists('module_enabled')) {
    function module_enabled(string $module): bool
    {
        return Cache::remember("module_enabled_{$module}", 300, function () use ($module) {
            try {
                $result = DB::table('modules_status')
                    ->where('module_name', $module)
                    ->value('is_enabled');
                return (bool) ($result ?? true);
            } catch (\Exception $e) {
                return true; // Default to enabled if table doesn't exist yet
            }
        });
    }
}

if (!function_exists('format_currency')) {
    function format_currency(float $amount, string $currency = 'USD'): string
    {
        $symbols = ['USD' => '$', 'EUR' => '€', 'GBP' => '£'];
        $symbol = $symbols[$currency] ?? $currency . ' ';
        return $symbol . number_format($amount, 2);
    }
}

if (!function_exists('time_ago')) {
    function time_ago($datetime): string
    {
        return \Carbon\Carbon::parse($datetime)->diffForHumans();
    }
}

if (!function_exists('priority_badge')) {
    function priority_badge(string $priority): string
    {
        $classes = [
            'low' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-red-100 text-red-800',
        ];
        $class = $classes[$priority] ?? 'bg-gray-100 text-gray-800';
        return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$class}\">" . ucfirst($priority) . "</span>";
    }
}

if (!function_exists('status_badge')) {
    function status_badge(string $status, array $config = []): string
    {
        $defaultConfig = [
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            'new' => 'bg-blue-100 text-blue-800',
            'contacted' => 'bg-yellow-100 text-yellow-800',
            'qualified' => 'bg-purple-100 text-purple-800',
            'lost' => 'bg-red-100 text-red-800',
            'converted' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'won' => 'bg-green-100 text-green-800',
            'prospect' => 'bg-blue-100 text-blue-800',
            'proposal' => 'bg-purple-100 text-purple-800',
            'negotiation' => 'bg-orange-100 text-orange-800',
        ];
        $mergedConfig = array_merge($defaultConfig, $config);
        $class = $mergedConfig[$status] ?? 'bg-gray-100 text-gray-800';
        $label = ucwords(str_replace('_', ' ', $status));
        return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$class}\">{$label}</span>";
    }
}
