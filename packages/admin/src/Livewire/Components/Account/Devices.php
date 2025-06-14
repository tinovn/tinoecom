<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Account;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class Devices extends Component
{
    #[Computed]
    public function sessions(): Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return DB::table('sessions')
            ->where('user_id', auth()->user()->getKey())
            ->orderBy('last_activity', 'desc')
            ->limit(3)
            ->get()->map(fn ($session) => (object) [
                'agent' => $this->createAgent($session),
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                'location' => Location::get($session->ip_address),
            ]);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.account.devices');
    }

    protected function createAgent($session): Agent
    {
        return tap(new Agent, function ($agent) use ($session): void {
            $agent->setUserAgent($session->user_agent);
        });
    }
}
