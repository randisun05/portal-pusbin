<?php

namespace App\Providers;

use App\Models\Faq;
use App\Models\Profil;
use App\Models\Pengetahuan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        View::composer(['layout.web.footer', 'layout.web.nav'], function ($view) {
            $view->with('profil', Profil::current());
        });

        View::composer('layout.partial.chat-widget', function ($view) {
            $faqs = Schema::hasTable('faqs')
                ? Faq::select('pertanyaan', 'jawaban')->get()
                : collect();

            $knowledge = Schema::hasTable('pengetahuans')
                ? Pengetahuan::active()->get(['judul', 'isi', 'kata_kunci'])
                : collect();

            $view->with('chatFaqs', $faqs);
            $view->with('chatKnowledge', $knowledge);
        });
    }
}
