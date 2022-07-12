<?php

namespace App\Http\Livewire;

use App\Jobs\SaveImage;
use App\Models\Campus;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\SubCategory;
use App\Services\ImageService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class AddProduct extends Component
{
	use WithFileUploads;

	public $univerisities;
	public $subcategories;
	public $title;
	public $alias;
	public $alias_campus;
	public $description;
	public $subcategory_id;
	public $price;
	public $item_condition = 'used';
	public $in_stock = 'yes';
	public $venue = 'Anywhere Convenient for you';
	public $contact_info;
	public $image1;
	public $image2;

	protected $imageService;

	public function __construct()
	{
		$this->imageService = new ImageService;
	}

	public function mount()
	{


		$this->univerisities = Campus::orderBy('name')
			->where('type', Campus::UNIVERSITY)
			->get();

		$this->subcategories = SubCategory::where('category_id', Category::PRODUCTS_CATEGORY)->get();
	}

	public function addProduct()
	{
		// dd($this->image1);
		$data = 	$this->validate([
			'title' => 'required|string|min:8',
			'alias' => 'nullable|string',
			'alias_campus' => 'nullable',
			'description' => 'required|string',
			'subcategory_id' => 'required|integer',
			'price' => 'required|numeric',
			'item_condition' => 'required|string',
			'in_stock' => 'required|string',
			'venue' => 'required|string',
			'contact_info' => 'nullable|numeric',
			'image1' => 'required|image|max:2048',
			'image2' => 'nullable|image|max:2048',
		]);

		$data['user_id'] = auth()->id();
		$data['price'] = number_format($this->price);
		$data['status'] = Post::STATUS_PENDING;
		$data['contact_info'] = empty($this->contact_info) ?  auth()->user()->phone : ltrim($this->contact_info, 0);


		$product = Post::create(Arr::except($data, ['image1', 'image2']));

		$this->imageService->save($this->image1, $product->id);

		if ($this->image2) {
			$this->imageService->save($this->image2, $product->id);
		}

		return redirect()->route('home')->with('success', 'Your Post Has Been Added but is currently being reviewed and will become active very soon');
	}



	public function render()
	{
		return view('livewire.add-product');
	}
}
