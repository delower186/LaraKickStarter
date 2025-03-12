<?php

namespace App\Livewire\Blogs;

use Livewire\Component;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Tools\Permission;

class Create extends Component
{
    use WithFileUploads;

    public string $title;
    public $categories;

    public string $category;
    public string $author;
    public string $content;
    public $image;
    public string $status = "1";

    public function save()
    {
        $this->authorize(Permission::format('create','blog'), Blog::class);

        $this->validate([
            "title"=> "required|min:5",
            "category"=>"required|string",
            "content"=> "required|min:100",
            "image"=> "sometimes|required|image|mimes:png,jpg|max:2048",
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
        $blog = new Blog();

        DB::transaction(function () use ($saveLocation, $blog) {
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
        $this->authorize(Permission::format('create','blog'), Blog::class);
        return view('livewire.blogs.create');
    }

    public function mount()
    {
       $this->author = Auth::user()->name;
       $this->categories = Category::where('status','=','1')->get();
    }
}
