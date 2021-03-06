<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Unisharp\Laravelfilemanager\Events\ImageWasUploaded;
use Unisharp\Laravelfilemanager\Events\ImageIsUploading;
use Unisharp\Laravelfilemanager\Events\ImageWasRenamed;
use Unisharp\Laravelfilemanager\Events\ImageWasDeleted;
use Unisharp\Laravelfilemanager\Events\ImageIsDeleting;
use Unisharp\Laravelfilemanager\Events\FolderIsRenaming;

use App\Listeners;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        ImageWasUploaded::class => [
            UploadListener::class,
        ],
        ImageIsUploading::class => [
            UploadListener::class,
        ],
        ImageWasRenamed::class => [
            UploadListener::class,
        ],
        FolderIsRenaming::class => [
            UploadListener::class,
        ],
        ImageWasDeleted::class => [
            UploadListener::class,
        ],
        ImageIsDeleting::class => [
            UploadListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
