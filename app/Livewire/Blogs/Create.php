<?php

namespace App\Livewire\Blogs;

use Livewire\Component;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class Create extends Component implements HasMiddleware
{
    use WithFileUploads;

    public string $title;
    public $categories;

    public string $category;
    public string $author;
    public string $content;
    public $image;
    public string $status = "1";

    public static function middleware()
    {
        return[
            new Middleware('permission:create_blog', only: ['render','save']),
        ];
    }

    public function save()
    {

        $this->validate([
            "title"=> "required|min:5",
            "category"=>"required|string",
            "content"=> "required|min:100",
            "image"=> "nullable|image|mimes:png,jpg|max:2048",
            "status"=> "required",
        ]);

        /**
         * @var mixed
         * Disk name 'uploads'
         * saved in blog folder within images folder
         * image file name @var $imageName
         */
        $imageName = time() .".". $this->image->getClientOriginalExtension();
        $saveLocation = $this->image->storeAs("images/blog", $imageName,'uploads');

        DB::transaction(function () use ($saveLocation) {
            $blog = new Blog();
            $blog->user_id = Auth::user()->id;
            $blog->category_id = (int)$this->category;
            $blog->title = $this->title;
            $blog->content = $this->content;
            $blog->image = $saveLocation;
            $blog->status = $this->status;
            $blog->save();
        });

        LivewireAlert::title('Success')
        ->text('Blog created successfully!')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        return redirect()->route('blogs.index');
    }

    public function render()
    {
        return view('livewire.blogs.create');
    }

    public function mount()
    {
       $this->author = Auth::user()->name;
       $this->categories = Category::where('status','=','1')->get();
    }
}
