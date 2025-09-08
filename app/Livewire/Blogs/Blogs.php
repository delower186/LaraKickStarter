<?php

namespace App\Livewire\Blogs;

use Livewire\Component;
use App\Models\Blog;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Tools\Permission;
use Flux\Flux;


class Blogs extends Component
{

    use WithPagination;
    protected $queryString = ['keyword'];
    public $keyword = '';
    public $searchQuery = '';

    public $blogTitle = '';
    public $blogContent = '';
    public $blogImage = '';


    public function render()
    {
        $this->authorize(Permission::format('view','blog'), Blog::class);

        $blogs = Blog::orderBy("id","DESC")
                        ->where("title","LIKE","%". $this->keyword ."%")
                        ->orWhere("content","LIKE","%". $this->keyword ."%")
                        ->paginate(10);
        return view('livewire.blogs.index', compact('blogs'));
    }

    public function show($id){
       
        $blog = Blog::findOrFail($id);
        $this->blogTitle = $blog->title;
        $this->blogContent = $blog->content;
        $this->blogImage = $blog->image;
        
        Flux::modal("show-blog")->show();
    }

    // Ask for delete confirmation
    public function confirm($id)
    {
        $this->authorize(Permission::format('delete','blog'), Blog::class);
        LivewireAlert::title('Delete Blog')
        ->text('Are you sure you want to delete this blog?')
        ->asConfirm()
        ->onConfirm('delete', ['id' => $id])
        ->show();
    }

    public function delete($data)
    {
        $this->authorize(Permission::format('delete','blog'), Blog::class);

        if($data['value'] === false){
            return false;
        }
        $blog = Blog::findOrFail($data['id']);
        DB::transaction(function () use ($blog) {

            Storage::delete($blog->image);
            Storage::disk('uploads')->delete($blog->image);
            $blog->delete();
        });


        LivewireAlert::title('Success')
        ->text('Blog deleted successfully.')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        return redirect()->route("blogs.index");
    }

    public function search()
    {
        $this->authorize(Permission::format('view','blog'), Blog::class);

        if($this->searchQuery != "") {
            $this->keyword = trim($this->searchQuery);

            LivewireAlert::title('Success')
            ->text('Search Successfull!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

        }else{
            LivewireAlert::title('Search Field is Empty!')
            ->text('"To Search Enter Search Term in the Search Box!')
            ->withConfirmButton('OK')
            ->error()
            ->show();
        }
    }

    public function refresh()
    {
        $this->authorize(Permission::format('view','blog'), Blog::class);
        return redirect()->route("blogs.index");
    }
}
