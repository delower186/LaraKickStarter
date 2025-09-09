<?php

namespace App\Livewire\Blogs;

use Livewire\Component;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use App\Tools\Permission;

class Edit extends Component
{
    use WithFileUploads;
    public $title;
    public $categories;
    public $category;
    public $content;
    public $image;
    public $fullPathOfOldImage;
    public $oldImage;
    public $author;
    public $status;
    public $id;

    public function mount($id)
    {
        $this->categories = Category::where('status','=','1')->get();
        $blog = Blog::findOrFail($id);
        $this->title = $blog->title;
        $this->content = $blog->content;
        $this->category = (string)$blog->category_id;
        $this->author = $blog->user->name;
        $this->fullPathOfOldImage = asset('uploads/'.$blog->image);
        $this->oldImage =$blog->image;
        $this->status = $blog->status;
        $this->id = $id;
    }

    public function update()
    {
        $this->authorize(Permission::format('edit','blog'), Blog::class);
        $this->validate([
            "title"=> "required|min:5",
            "category"=>"required|string",
            "content"=> "required|min:100",
            "image"=> "nullable|image|mimes:png,jpg|max:2048",
            "status"=> "required",
        ]);

        $blog = Blog::findOrFail($this->id);

        if($blog->title === $this->title && $blog->category_id === (int)$this->category && $blog->content === $this->content && $blog->image === $this->oldImage && $blog->status === $this->status){

            LivewireAlert::title('Nothing to Update!')
            ->text('Please change anything to update!')
            ->withConfirmButton('OK')
            ->error()
            ->show();

        }else{
            DB::transaction(function () use ($blog) {
                // $blog->user_id = Auth::user()->id;
                $blog->category_id = (int)$this->category;
                $blog->title = $this->title;
                $blog->content = $this->content;
                if($this->image){
                    /**
                     * @var mixed
                     * Disk name 'uploads'
                     * saved in blog folder within images folder
                     * image file name @var $imageName
                     */
                    // First delete old image
                    Storage::disk('uploads')->delete($this->oldImage);
                    // Save new image
                    $imageName = time() .".". $this->image->getClientOriginalExtension();
                    $saveLocation = $this->image->storeAs("images/blog", $imageName,'uploads');
                    $blog->image = $saveLocation;

                }
                $blog->status = $this->status;
                $blog->save();
            });


            LivewireAlert::title('Success')
            ->text('Blog updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

            return redirect()->back();
        }

    }

    public function render()
    {
        $this->authorize(Permission::format('edit','blog'), Blog::class);
        return view('livewire.blogs.edit');
    }
}
