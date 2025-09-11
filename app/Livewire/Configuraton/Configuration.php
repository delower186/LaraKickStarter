<?php

namespace App\Livewire\Configuraton;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use App\Tools\Permission;
use App\Models\Configuration as Config;
use Illuminate\Support\Facades\File;

class Configuration extends Component
{
    use WithFileUploads;

    public $logo;
    public $logoPreview;
    public $favicon;
    public $faviconPreview;
    public string $site_name;

    public function render()
    {
        $config = Config::first();

        $this->site_name = $config->site_name;
        $this->logoPreview = asset("uploads/".$config->logo);
        $this->faviconPreview = asset($config->favicon);

        return view('livewire.configuraton.configuration');
    }

    public function updateSiteName(){
        
        $this->validate([
            "site_name" => "required|min:5",
        ]);

        $config = Config::first();

        DB::transaction(function () use ($config) {

            $config->site_name = $this->site_name;
            $config->save();
        });

        LivewireAlert::title('Success')
            ->text('Site Name updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000)
            ->show();

        return redirect()->back();
    }

    public function updateSiteLogo(){
        
        $this->validate([
            "logo"      => "required|image|mimes:png,jpg,jpeg|max:2048",
        ]);

        $config = Config::first();

        /**
         * @var mixed
         * Disk name 'uploads'
         * saved in blog folder within images folder
         * image file name @var $imageName
         */
        $logoName = "logo.". $this->logo->getClientOriginalExtension();
        $logoSaveLocation = $this->logo->storeAs("images/logo", $logoName,'uploads');

        DB::transaction(function () use ($logoSaveLocation, $config) {

            $config->logo = $logoSaveLocation;
            $config->save();
        });

        LivewireAlert::title('Success')
            ->text('Logo updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000)
            ->show();

        return redirect()->back();


    }

    public function updateSiteFavicon(){
        
        $this->validate([
            "favicon"   => "required|mimes:ico|max:2048",
        ]);

        $config = Config::first();

        $faviconName = 'favicon.ico'; // fixed name

        if(File::exists(public_path('favicon.ico'))) {
            File::delete(public_path('favicon.ico'));
        }


        // Move the uploaded file to public/
        $this->favicon->storeAs('', $faviconName, 'public_root');

        DB::transaction(function () use ($faviconName, $config) {

            $config->favicon = $faviconName;
            $config->save();
        });

        LivewireAlert::title('Success')
            ->text('Favicon updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000)
            ->show();

        return redirect()->back();
    }
}
