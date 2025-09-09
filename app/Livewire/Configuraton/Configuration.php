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
        $this->faviconPreview = asset("uploads/".$config->favicon);

        return view('livewire.configuraton.configuration');
    }

    public function update(){
        
        $this->validate([
            "site_name"=> "required|min:5",
            "logo"=> "nullable|image|mimes:png,jpg|max:2048",
            "favicon"=> "nullable|mimes:ico|max:2048",
        ]);

    
        /**
         * @var mixed
         * Disk name 'uploads'
         * saved in blog folder within images folder
         * image file name @var $imageName
         */
        // Logo

        $logoSaveLocation ='';
        
        if($this->logo instanceof TemporaryUploadedFile){
            $logoName = "logo" .".". $this->logo->getClientOriginalExtension();

            // Path of the old file on the 'uploads' disk
            $oldFilePath = 'images/logo/' . $logoName; // adjust accordingly

            if (Storage::disk('uploads')->exists($oldFilePath)) {
                Storage::disk('uploads')->delete($oldFilePath);
            }

            $logoSaveLocation = $this->logo->storeAs("images/logo", $logoName,'uploads');
        }
        // Favicon

        $faviconSaveLocation = '';

        if($this->favicon instanceof TemporaryUploadedFile){
            $faviconName = 'favicon.ico'; // fixed name

            if(File::exists(public_path('favicon.ico'))) {
                File::delete(public_path('favicon.ico'));
            }

            $faviconSaveLocation = public_path('/favicon.ico'); // save directly in public

            // Move the uploaded file to public/
            $this->favicon->move(public_path(), $faviconName);
        }

        
        $config = Config::first();

        DB::transaction(function () use ($logoSaveLocation, $faviconSaveLocation, $config) {

            if($config->site_name != $this->site_name) {
                $config->site_name = $this->site_name;
            }

            if($logoSaveLocation && $logoSaveLocation != '') {
                $config->logo = $logoSaveLocation;
            }

            if($faviconSaveLocation && $faviconSaveLocation != '') {
                $config->favicon = $faviconSaveLocation;
            }
            
            $config->save();
        });

        LivewireAlert::title('Success')
        ->text('Configuration Updated successfully!')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        return redirect()->back();
    }
}
