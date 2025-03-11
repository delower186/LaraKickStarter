<?php

namespace App\Livewire\Blogs;

use Livewire\Component;
use App\Models\Blog;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Blogs extends Component
{

    use WithPagination;
    protected $queryString = ['keyword'];
    public $keyword = '';
    public $searchQuery = '';

    public function render()
    {
        // dd(auth()->user()->roles[0]->name);
        // abort_unless(auth()->user()->can('view_blog'),403,'UnAuthorized');

        $blogs = Blog::orderBy("id","DESC")
                        ->where("title","LIKE","%". $this->keyword ."%")
                        ->orWhere("content","LIKE","%". $this->keyword ."%")
                        ->paginate(10);

        return view('livewire.blogs.index', compact('blogs'));
    }

    // Ask for delete confirmation
    public function confirm($id)
    {
        LivewireAlert::title('Delete Blog')
        ->text('Are you sure you want to delete this blog?')
        ->asConfirm()
        ->onConfirm('delete', ['id' => $id])
        ->show();
    }

    public function delete($data)
    {
        if($data['value'] === false){
            return false;
        }

        DB::transaction(function () use ($data) {
            $blog = Blog::findOrFail($data['id']);
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
        return redirect()->route("blogs.index");
    }
}
