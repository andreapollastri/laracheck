<?php

namespace App\Jobs;

use App\Mail\OutageOccurred;
use App\Mail\OutageResolved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SiteCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public \App\Models\Site $site,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = \Illuminate\Support\Facades\Http::get($this->site->url);
        } catch (\Exception $e) {
            $response = null;
        }

        $currentOutage = $this->site->outages()
            ->whereNull('resolved_at')
            ->first();

        if (! $response || $response->status() != 200) {
            if (! $currentOutage) {
                $this->site->outages()->create([
                    'occurred_at' => now(),
                ]);

                Mail::to(\App\Models\User::first()->email)
                    ->send(new OutageOccurred($this->site));
            }
        } else {
            if ($currentOutage) {
                $currentOutage->update([
                    'resolved_at' => now(),
                ]);

                Mail::to(\App\Models\User::first()->email)
                    ->send(new OutageResolved($this->site, $currentOutage));
            }
        }
    }
}
