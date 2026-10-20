<?php

namespace App\Filament\Widgets;

use App\Models\KnowledgeSource;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalSources = KnowledgeSource::count();

        $pendingSources = KnowledgeSource::where('status', 'pending')
            ->count();

        $processedSources = KnowledgeSource::where('status', 'processed')
            ->count();

        $totalUsers = User::count();

        return [
            Stat::make('Total Sumber Data', $totalSources)
                ->description('Seluruh sumber data terdaftar')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Menunggu Proses', $pendingSources)
                ->description('Sumber data yang menunggu')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Selesai Diproses', $processedSources)
                ->description('Sumber data berhasil diproses')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Total Pengguna', $totalUsers)
                ->description('Pengguna terdaftar di sistem')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),
        ];
    }
}
